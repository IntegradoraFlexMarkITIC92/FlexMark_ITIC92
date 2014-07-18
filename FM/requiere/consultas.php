<?php
include("conn.php"); 
include("estados.php"); 
?>

<?php
//Funcion para obtener el Title de la BD
function getTitle(){
	$conTitle=mysql_query("SELECT title FROM confgral WHERE idConfiguracion='1' AND status='A'"); 
      while($Dato=mysql_fetch_array($conTitle)){
        echo($Dato['title']);
      }      
}

//Funcion para el login de Admin
function login($user,$pass){	
	$conUser= mysql_query("SELECT count(1) AS OK, idEmpleado, idNivel, nombre, apellido FROM empleado WHERE user='$user' AND pass='$pass' AND status='A' ");
	while($logi=mysql_fetch_array($conUser)){
		if($logi['OK']==1){
			//echo("Se logeo ".$logi['nombre']." ".$logi['apellido']." con ID: ".$logi['idEmpleado']);
			$op=$logi['idNivel'];
			$idusu=$logi['idEmpleado'];

			switch($op){				
				case 1:$_SESSION["logged_adm"] = $idusu;
						$parametro="index.php";	
				break;

				case 2:$_SESSION["logged_vtas"] = $idusu;
						$parametro="index.php";	
				break;

				case 3:$_SESSION["logged_almacen"] = $idusu;
						$parametro="index.php";	
				break;
			}			
		}else{
			echo("Error de login");
		}			
	}	
}


//Funcion que consulta datos de la empresa
function infoTablaEmpresa(){
	$conEmpresa= mysql_query("SELECT * FROM empresa");
	while ($infoEmp=mysql_fetch_array($conEmpresa)) {
		$idEF=$infoEmp['idEmpresaFacturacion'];
		$conEmpFac= mysql_query("SELECT razonSocial, estado FROM empresafacturacion WHERE idEmpresaFacturacion=$idEF");
		while ($infoEmpFac=mysql_fetch_array($conEmpFac)) {
			$rzEmpresa=$infoEmpFac['razonSocial'];
			$edoEmpresa=$infoEmpFac['estado'];
		}
		echo('
				<tr>				   
				   <td>'.$infoEmp["nombre"].'</td>
				   <td>'.$rzEmpresa.'</td>
				   <td>'.$edoEmpresa.'</td>
				   <td>'.$infoEmp["idConfiguracion"].'</td>				   
				   <td><a href="index.php?ID=1"><button type="button" class="btn btn-warning">Modificar</button></a></td>				   
				<tr>
			');
	}
}

//Funcion que consulte los datos de la empresa
function formInfoEmp($idEmp){
	$conEmpresa= mysql_query("SELECT * FROM empresa WHERE idEmpresa='$idEmp'");
	while ($infoEmp=mysql_fetch_array($conEmpresa)) {		
		
		echo('<form role="form" name="formEmpresaEdit" style="width:400px; margin: 0 auto;">');
		
		echo('<h3>Datos de la Empresa</h3>');

	    echo('<div class="required-field-block">
	      <input type="text" name="nombreEmpresa" placeholder="Nombre Comercial" class="form-control" value="'.$infoEmp["nombre"].'"><br>
	      <input type="text" name="direccionEmpresa" placeholder="Direccion Comercial" class="form-control" value="'.$infoEmp["direccion"].'"><br>
	    </div>');

		echo('<h3>Razon Social Predeterminada</h3>');

	    $conEmpFac=mysql_query("SELECT idEmpresaFacturacion, razonSocial FROM empresafacturacion");
	    echo('<div class="form-group">
	    	<select name="razonSocialEmpresa" id="pref-perpage" class="form-control">
	    	');
	    	while ($infoEmpFac=mysql_fetch_array($conEmpFac)) {
	    		if($infoEmpFac["idEmpresaFacturacion"]==$infoEmp["idEmpresaFacturacion"]){
	    			echo('<option selected="selected" value="'.$infoEmpFac["idEmpresaFacturacion"].'">'.$infoEmpFac["razonSocial"].'</option>');
	    		}else{
	    			echo('<option value="'.$infoEmpFac["idEmpresaFacturacion"].'">'.$infoEmpFac["razonSocial"].'</option>');
	    		}
	    	}
            echo('</select>        	
        </div>
        <input type="hidden" name="UPD" value="">'
        );		

	    echo('<button class="btn btn-primary" onclick="update()">Actualizar</button>');

	    echo('</form>	');

	    echo('<form role="form" name="formEmpresaFact" style="width:400px; margin: 0 auto;">');

	    echo('<h3>Datos de la Configuracion Gral</h3>');

	    $conConf=mysql_query("SELECT * FROM confgral WHERE idConfiguracion='".$infoEmp['idConfiguracion']."'");
	    while ($infoGral=mysql_fetch_array($conConf)) {

			echo('<div class="required-field-block">
		      <input type="text" disabled placeholder="Logo" class="form-control" value="'.$infoGral["logo"].'"><br>	
		      <input type="text" disabled placeholder="title Navegador" class="form-control" value="'.$infoGral["title"].'"><br>
		      <input type="text" disabled placeholder="IVA" class="form-control" value="'.$infoGral["iva"].'"><br>
		    </div>');
	    }	    

	    echo('<a href="/FM/cPan/confG/DF/"><button type="button" class="btn btn-warning">Editar</button></a>');
	    
	    echo('</form>	');
	}
}

// Actualizacion de empresa y seleccion de razon Social
function actualizaEmpresa($nombreEmpresa,$direccionEmpresa,$razonSocialEmpresa){
	$consulta=("update empresa set nombre='$nombreEmpresa',direccion='$direccionEmpresa', idEmpresaFacturacion='$razonSocialEmpresa' where idEmpresa='1' ");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

// Funcion que trae tpdas las empresas de Facturacion
function infoTablaFacturacion(){

	$conEF= mysql_query("SELECT * FROM empresafacturacion");
	while ($infoEF=mysql_fetch_array($conEF)) {
		echo('			
			<tr>			   
			   <td>'.$infoEF["razonSocial"].'</td>
			   <td>'.$infoEF["RFC"].'</td>
			   <td>'.$infoEF["direccion"].'</td>
			   <td>'.$infoEF["cp"].'</td>				   
			   <td>'.$infoEF["municipio"].'</td>
			   <td>'.$infoEF["estado"].'</td>
			   <td>'.$infoEF["pais"].'</td>
			   <td>'.$infoEF["status"].'</td>
			   <td><a href="index.php?ID='.$infoEF["idEmpresaFacturacion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoEF["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoEF["idEmpresaFacturacion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoEF["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoEF["idEmpresaFacturacion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

function displayNew(){
	echo('<form role="form" name="formNueva" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nueva Empresa Para Facturacion</h3>');

		echo('<input type="text" name="razonSocial" placeholder="Razon Social" class="form-control" ><br>
		<input type="text" name="rfc" placeholder="RFC" class="form-control" ><br>
		<input type="text" name="direccion" placeholder="Direccion" class="form-control" ><br>					
		<input type="text" name="cp" placeholder="Codigo Postal" class="form-control" ><br>
		<input type="text" name="municipio" placeholder="Municipio" class="form-control" ><br>');
		estadosList();
		echo('<input type="text" disabled class="form-control" value="México"><br>	    
	    <input type="hidden" name="nuevaRS" value="">
		');

		echo('<button class="btn btn-primary" onclick="addRS()">Agregar</button>');

	    echo('</form>	');
}

function addEmpresaFactuacion($rz,$rfc,$dir,$cp,$municipio,$estado){
	$consulta=("insert into empresafacturacion value (0,'$rz','$rfc','$dir','$cp','$municipio','$estado','Mexico','A')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

function cambiarStatus($idEF,$status){
	$consulta=("update empresafacturacion set status='$status' where idEmpresaFacturacion='$idEF'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}


function displayUpdateEF($idEF){
	echo('<form role="form" name="formUpdate" style="width:400px; margin: 0 auto;">');
		echo('<h3>Edite la datos de la empresa</h3>');

		$conEF= mysql_query("SELECT * FROM empresafacturacion WHERE idEmpresaFacturacion='$idEF'");
		while ($infoEF=mysql_fetch_array($conEF)) {

			echo('<input type="text" name="razonSocial" placeholder="Razon Social" class="form-control" value="'.$infoEF["razonSocial"].'" ><br>
			<input type="text" name="rfc" placeholder="RFC" class="form-control" value="'.$infoEF["RFC"].'" ><br>
			<input type="text" name="direccion" placeholder="Direccion" class="form-control" value="'.$infoEF["direccion"].'" ><br>					
			<input type="text" name="cp" placeholder="Codigo Postal" class="form-control" value="'.$infoEF["cp"].'" ><br>
			<input type="text" name="municipio" placeholder="Municipio" class="form-control" value="'.$infoEF["municipio"].'" ><br>');
			estadosListUp($infoEF["estado"]);
			echo('<input type="text" disabled class="form-control" value="México"><br>	    
			<input type="hidden" name="updateID" value="'.$idEF.'">
		    <input type="hidden" name="updateRS" value="">
			');

		}

		echo('<button class="btn btn-primary" onclick="updateRSo()">Agregar</button>');

	    echo('</form>	');
}

// Funcion para actualizar empresa de facturacion
function updateEmpresaFactuacion($idEF,$rz,$rfc,$dir,$cp,$municipio,$estado){
	$consulta=("update empresafacturacion set razonSocial='$rz', RFC='$rfc', direccion='$dir', cp='$cp', municipio='$municipio',estado='$estado' where idEmpresaFacturacion='$idEF'");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

// Funcion que trae tpdas las configuracion de la aplicacion
function infoTablaConfG(){

	$conCG= mysql_query("SELECT * FROM confgral");
	while ($infoCG=mysql_fetch_array($conCG)) {
		echo('			
			<tr>			   
			   <td>'.$infoCG["logo"].'</td>
			   <td>'.$infoCG["title"].'</td>
			   <td>'.$infoCG["iva"].'</td>			   
			   <td>'.$infoCG["status"].'</td>
			   <td><a href="index.php?ID='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoCG["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoCG["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

//Muestra formulario para nueva configuracion
function displayNewConf(){
	echo('<form role="form" name="formNuevaConf" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nueva Configuracion</h3>');

		echo('<input type="text" name="logo" placeholder="Seleccione Una Imagen" class="form-control" ><br>
		<input type="text" name="titlee" placeholder="Titulo en Navegador" class="form-control" ><br>
		<input type="text" name="iva" placeholder="IVA de aplicacion" class="form-control" ><br>
		<input type="hidden" name="nuevaCG" value="">');		

		echo('<button class="btn btn-primary" onclick="addConf()">Agregar</button>');

	    echo('</form>	');
}


//Agregar nueva configuracion
function addConfGral($logo,$title,$iva){
	$consulta=("insert into confgral value (0,'$logo','$title','$iva','A')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

//Muestra formulario para actualizar configuracion
function displayUpdateCG($idCG){
	echo('<form role="form" name="formUpdateConf" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Configuracion</h3>');
		$conUC= mysql_query("SELECT * FROM confgral WHERE idConfiguracion='$idCG'");
		while ($infoCG=mysql_fetch_array($conUC)) {

			echo('<input type="text" name="logo" placeholder="Seleccione Una Imagen" class="form-control" value="'.$infoCG["logo"].'"><br>
			<input type="text" name="titlee" placeholder="Titulo en Navegador" class="form-control" value="'.$infoCG["title"].'"><br>
			<input type="text" name="iva" placeholder="IVA de aplicacion" class="form-control" value="'.$infoCG["iva"].'"><br>
			<input type="hidden" name="updateID" value="'.$idCG.'">
			<input type="hidden" name="updateCG" value="">');				

		}

		echo('<button class="btn btn-primary" onclick="updateConG()">Actualizar</button>');

	echo('</form>	');
}


// Funcion para actualizar la configuracion
function updateConfG($id,$logo,$title,$iva){
	$consulta=("update confgral set logo='$logo', title='$title', iva='$iva' where idConfiguracion='$id'");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

function cambiarStatusConf($id,$status){
	$consulta=("update confgral set status='$status' where idConfiguracion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

// =================== Productos ============================
// Funcion que trae tpdas las configuracion de la aplicacion
function infoTablaCat(){

	$conCat= mysql_query("SELECT * FROM catview");
	while ($infoCat=mysql_fetch_array($conCat)) {
		echo('			
			<tr>			   
			   <td>'.$infoCat["nombreCategoria"].'</td>
			   <td>'.$infoCat["nivelCategoria"].'</td>
			   <td>'.$infoCat["NombrePadre"].'</td>			   
			   <td>'.$infoCat["status"].'</td>
			   <td><a href="index.php?ID='.$infoCat["idConfiguracion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoCat["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoCat["idConfiguracion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoCat["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoCat["idConfiguracion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}


######################################################################### Polanco Administracion usuarios########################

###Empleados###

//insertamos en la base de datos (1)
function addConfEmpleado($nombre,$apellido,$user,$pass,$status,$idDepto,$idNivel,$idEmpresa){
	$consulta=("insert into empleado value (0,'$nombre','$apellido','$user','$pass','A','$idDepto','$idNivel','$idEmpresa')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
	#echo($consulta);
}

//Formulario Agrega un nuevo empleado (2)
		function displayNewEmpleado(){
	echo('<form role="form" name="formNuevoEmpleado" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Empleado</h3>');
		
		echo('<input type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" ><br>
		<input type="text" name="apellido" placeholder="Apellido Usuario" class="form-control" ><br>
		<input type="text" name="user" placeholder="Usuario" class="form-control" ><br>
		<input type="password" name="pass" placeholder="Password" class="form-control" ><br>
		<input type="text" name="idDepto" placeholder="Departamento" class="form-control" ><br>
		<input type="text" name="idNivel" placeholder="Nivel De Usuario" class="form-control" ><br>
		<input type="text" name="idEmpresa" placeholder="Empresa" class="form-control" ><br>
		<input type="hidden" name="nuevaEM" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfEmpleado()">Agregar</button>');

	    echo('</form>	');
}

//Cambiar el estatus del empleado de activo a inactivo o de inactivo a activo (3)
	function cambiarStatusEmple ($idEmpl, $statusEmp){
	$consultaEmp=("update empleado set status='$statusEmp' where idEmpleado='$idEmpl'");
	@mysql_query($consultaEmp) or die ("No se puede ejecutar la consulta".$consultaEmp);
	header("Location: ./index.php");
}

//Funcion para actualizar la configuracion del objeto empleado (4)
	function updateEmpl($idEmpl,$nombre,$apellido,$user,$pass,$statusEmp,$idDepto,$idNivel,$idEmpresa){
	$consultaEmp=("update empleado set nombre='$nombre', apellido='$apellido', user='$user', pass='$pass', status='A', idDepto='$idDepto', idNivel='$idNivel', idEmpresa='$idEmpresa' WHERE idEmpleado='$idEmpl'");
	@mysql_query($consultaEmp)or die ("No se puede ejecutar la accion".$consultaEmp);
	header("Location: ./index.php");
	#echo($consultaEmp);
}

//Funcion para el formulario donde se actualiza la configuracion del empleado (5)
	function displayUpdateEmple($idEm){
	echo('<form role="form" name="formUpdateEmpl" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Empleado</h3>');
		$conEmpl= mysql_query("SELECT * FROM empleado WHERE idEmpleado='$idEm'");
		while ($infoEmpl=mysql_fetch_array($conEmpl)) {

			echo('<input type="text" name="nombre" placeholder="Nombre empleado" class="form-control" value="'.$infoEmpl["nombre"].'"><br>
			<input type="text" name="apellido" placeholder="Apellido empleado" class="form-control" value="'.$infoEmpl["apellido"].'"><br>
			<input type="text" name="user" placeholder="Usuario empleado" class="form-control" value="'.$infoEmpl["user"].'"><br>
			<input type="password" name="pass" placeholder="Password empleado" class="form-control" value="'.$infoEmpl["pass"].'"><br>
			<input type="text" name="idDepto" placeholder="Departamento usuario" class="form-control" value="'.$infoEmpl["idDepto"].'"><br>
			<input type="text" name="idNivel" placeholder="Nivel usuario" class="form-control" value="'.$infoEmpl["idNivel"].'"><br>
			<input type="text" name="idEmpresa" placeholder="Empresa usuario" class="form-control" value="'.$infoEmpl["idEmpresa"].'"><br>				
			<input type="hidden" name="updateIdEm" value="'.$idEm.'">
			<input type="hidden" name="updateEM" value="">');				

		}

		echo('<button class="btn btn-primary" onclick="updateEmple()">Actualizar</button>');

	echo('</form>	');
}

//Consulta la base de datos para traer todos los datos que esta contiene (6)
	function infoTablaEmpleado(){
	$conEmpleado= mysql_query("SELECT * FROM empleado");
	while ($infoEmpleado=mysql_fetch_array($conEmpleado)) {
		echo('			
			<tr>			   
			   <td>'.$infoEmpleado["nombre"].'</td>
			   <td>'.$infoEmpleado["apellido"].'</td>
			   <td>'.$infoEmpleado["user"].'</td>			   
			   <td>'.$infoEmpleado["pass"].'</td>
			   <td>'.$infoEmpleado["status"].'</td>
			   <td>'.$infoEmpleado["idDepto"].'</td>
			   <td>'.$infoEmpleado["idNivel"].'</td>
			   <td>'.$infoEmpleado["idEmpresa"].'</td>
			   <td><a href="index.php?ID='.$infoEmpleado["idEmpleado"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoEmpleado["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoEmpleado["idEmpleado"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoEmpleado["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoEmpleado["idEmpleado"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

###Empleados###

###Departamentos###

//Insertamos en la base de datos la informacion de la tabla deptoc(1)
	function addConfDepartamento($nombre,$status){
	$consulta=("insert into depto value (0,'$nombre','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir departamento".$consulta);
	header("Location: ./index.php");
	}
	
	//Formulario Agrega un nuevo Departamento (2)
		function displayNewDepartamento(){
	echo('<form role="form" name="formNuevoDepartamento" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Departamento.</h3>');
		
		echo('<input type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" ><br>
		<input type="hidden" name="nuevaDepto" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfDepartamento()">Agregar</button>');

	    echo('</form>	');
}

	//Cambiar el estatus del departamento de activo a inactivo o de inactivo a activo (3)
	function cambiarStatusDepartamento ($idDep, $statusDep){
	$consultaDepa=("update depto set status='$statusDep' where idDepto='$idDep'");
	@mysql_query($consultaDepa) or die ("No se puede ejecutar la consulta".$consultaDepa);
	header("Location: ./index.php");
	}


	//Funcion para actualizar la configuracion del objeto Departamento (4)
	function updateDepartamento($idDep,$nombre,$statusDep){
	$consultaDepa=("update depto set nombre='$nombre', status='A' WHERE idDepto='$idDep'");
	@mysql_query($consultaDepa)or die ("No se puede ejecutar la accion".$consultaDepa);
	header("Location: ./index.php");
}

//Funcion para el formulario donde se actualiza la configuracion del empleado (5)
	function displayUpdateDepartamento($idDe){
	echo('<form role="form" name="formUpdateDepartamento" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Departamento.</h3>');
		$conDepto= mysql_query("SELECT * FROM depto WHERE idDepto='$idDe'");
		while ($infoDepto=mysql_fetch_array($conDepto)) {

			echo('<input type="text" name="nombre" placeholder="Nombre Departamento" class="form-control" value="'.$infoDepto["nombre"].'"><br>				
			<input type="hidden" name="updateIdDep" value="'.$idDe.'">
			<input type="hidden" name="updateDE" value="">');				

		}

		echo('<button class="btn btn-primary" onclick="updateDepar()">Actualizar</button>');

	echo('</form>	');
}


//Consulta la base de datos para traer toda la informacion de la tabla depto(6)
	function infoTablaDepartamento(){
	$conDepartamento= mysql_query("SELECT * FROM depto");
	while ($infoDepartamento=mysql_fetch_array($conDepartamento)) {
		echo('			
			<tr>			   
			   <td>'.$infoDepartamento["nombre"].'</td>
			   <td>'.$infoDepartamento["status"].'</td>
			   <td><a href="index.php?ID='.$infoDepartamento["idDepto"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoDepartamento["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoDepartamento["idDepto"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoDepartamento["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoDepartamento["idDepto"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
	}

###Departamentos###


###Niveles###

//Insertamos en la base de datos la informacion de la tabla Niveles(1)
	function addConfNiveles($nombre,$status){
	$consulta=("insert into nivel value (0,'$nombre','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir departamento".$consulta);
	header("Location: ./index.php");
	}
	
	//Formulario Agrega un nuevo Niveles (2)
		function displayNewNiveles(){
	echo('<form role="form" name="formNuevoNiveles" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Nivel.</h3>');
		
		echo('<input type="text" name="nombre" placeholder="Nombre Nivel" class="form-control" ><br>
		<input type="hidden" name="nuevaNive" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfNiveles()">Agregar</button>');

	    echo('</form>	');
}

	//Cambiar el estatus del Niveles de activo a inactivo o de inactivo a activo (3)
	function cambiarStatusNiveles ($idNiv, $statusNiv){
	$consultaDepa=("update nivel set status='$statusNiv' where idNivel='$idNiv'");
	@mysql_query($consultaDepa) or die ("No se puede ejecutar la consulta".$consultaDepa);
	header("Location: ./index.php");
	}


	//Funcion para actualizar la configuracion del objeto Niveles (4)
	function updateNiveles($idNiv,$nombre,$statusNiv){
	$consultaDepa=("update nivel set nombre='$nombre', status='A' WHERE idNivel='$idNiv'");
	@mysql_query($consultaDepa)or die ("No se puede ejecutar la accion".$consultaDepa);
	header("Location: ./index.php");
}

//Funcion para el formulario donde se actualiza la configuracion del Niveles (5)
	function displayUpdateNiveles($idNi){
	echo('<form role="form" name="formUpdateNiveles" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Nivel.</h3>');
		$conNiv= mysql_query("SELECT * FROM nivel WHERE idNivel='$idNi'");
		while ($infoNivele=mysql_fetch_array($conNiv)) {

			echo('<input type="text" name="nombre" placeholder="Nombre Departamento" class="form-control" value="'.$infoNivele["nombre"].'"><br>				
			<input type="hidden" name="updateIdNiv" value="'.$idNi.'">
			<input type="hidden" name="updateNI" value="">');				

		}

		echo('<button class="btn btn-primary" onclick="updateNive()">Actualizar</button>');

	echo('</form>	');
}


//Consulta la base de datos para traer toda la informacion de la tabla Niveles(6)
	function infoTablaNiveles(){
	$conNiveles= mysql_query("SELECT * FROM nivel");
	while ($infoNiveles=mysql_fetch_array($conNiveles)) {
		echo('			
			<tr>			   
			   <td>'.$infoNiveles["nombre"].'</td>
			   <td>'.$infoNiveles["status"].'</td>
			   <td><a href="index.php?ID='.$infoNiveles["idNivel"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoNiveles["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoNiveles["idNivel"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoNiveles["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoNiveles["idNivel"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
	}

###Niveles###

######################################################################### Polanco Administracion usuarios########################



?>