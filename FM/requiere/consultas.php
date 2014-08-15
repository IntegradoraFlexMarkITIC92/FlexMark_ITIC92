<?php
/*  =======================================================================================   */
/*  ====================   Archivos requeridos para el funcionamiento  ====================   */
/*  =======================================================================================   */
include("conn.php"); 
include("estados.php"); 
include("subirArchivo.php");
?>

<?php

/*  =======================================================================================   */
/*  ====================   Funcion para obtener el title de la pagina  ====================   */
/*  =======================================================================================   */
function getTitle(){
	$conEmp= mysql_query("SELECT idConfiguracion FROM empresa WHERE idEmpresa='1'");
	while ($infoEmp=mysql_fetch_array($conEmp)) {
		$idConfiguracion=$infoEmp["idConfiguracion"];
		$conTitle=mysql_query("SELECT title FROM confgral WHERE idConfiguracion='$idConfiguracion'"); 
      	while($Dato=mysql_fetch_array($conTitle)){
        	echo($Dato['title']);
      	}      
    }
}

/*  =======================================================================================   */
/*  ====================  Funcion para realizar el login de back-end   ====================   */
/*  =======================================================================================   */
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
			#echo("Error de login");
		}			
	}	
}

/*  =======================================================================================   */
/*  ====================  Tabla de Datos de la empresa   ====================   */
/*  =======================================================================================   */
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

/*  ====================   Formulario para editar la informacion de la empresa  ====================   */
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

	    echo('<a href="/FM/cPan/confG/General/"><button type="button" class="btn btn-warning">Editar</button></a>');
	    
	    echo('</form>	');
	}
}

/*  ====================  Funcion para actualizar en BD la informacion de la empresa   ====================   */
function actualizaEmpresa($nombreEmpresa,$direccionEmpresa,$razonSocialEmpresa){
	$consulta=("update empresa set nombre='$nombreEmpresa',direccion='$direccionEmpresa', idEmpresaFacturacion='$razonSocialEmpresa' where idEmpresa='1' ");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

function actualizaConfDefault($idConfD){	
	$consulta=("UPDATE empresa SET idConfiguracion='$idConfD' WHERE idEmpresa='1'");
	@mysql_query($consulta);	
}

/*  =======================================================================================   */
/*  ====================  Tabla de empresas de facturacion   ====================   */
/*  =======================================================================================   */
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

/*  ====================  Formulario para una nueva empresa de facturacion   ====================   */


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

/*  ====================  Funcion para agregar una nueva empresa de facturacion   ====================   */

function addEmpresaFactuacion($rz,$rfc,$dir,$cp,$municipio,$estado){
	$consulta=("insert into empresafacturacion value (0,'$rz','$rfc','$dir','$cp','$municipio','$estado','Mexico','A')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar los datos de una empresa de facturacion   ====================   */

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

/*  ====================  Funcion para actualizar en la BD la informacion de una empresa de facturacion   ====================   */

function updateEmpresaFactuacion($idEF,$rz,$rfc,$dir,$cp,$municipio,$estado){
	$consulta=("update empresafacturacion set razonSocial='$rz', RFC='$rfc', direccion='$dir', cp='$cp', municipio='$municipio',estado='$estado' where idEmpresaFacturacion='$idEF'");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

/*  ====================  Funcion para cambiar el status de una empresa de facturacion   ====================   */

function cambiarStatus($idEF,$status){
	$consulta=("update empresafacturacion set status='$status' where idEmpresaFacturacion='$idEF'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}



/*  =======================================================================================   */
/*  ====================  Tabla de configuracion general   ====================   */
/*  =======================================================================================   */
function infoTablaConfG(){

	$conCG= mysql_query("SELECT * FROM confgral");
	while ($infoCG=mysql_fetch_array($conCG)) {
		echo('			
			<tr>			   
			   <td>'.$infoCG["logo"].'</td>
			   <td>'.$infoCG["title"].'</td>
			   <td>'.$infoCG["iva"].'</td>			   
			   <td>'.$infoCG["status"].'</td>
			   <td><a href="index.php?imgID='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-success">Subir</button></a></td>
			   <td><a href="index.php?ID='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoCG["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoCG["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoCG["idConfiguracion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}


/*  ====================  Formulario para una nueva configuracion general   ====================   */
function displayNewConf(){
	echo('<form role="form" name="formNuevaConf" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nueva Configuracion</h3>');

		//echo('<input type="text" name="logo" placeholder="Seleccione Una Imagen" class="form-control" ><br>
		echo('<input type="text" name="titlee" placeholder="Titulo en Navegador" class="form-control" ><br>
		<input type="text" name="iva" placeholder="IVA de aplicacion" class="form-control" ><br>
		<input type="hidden" name="nuevaCG" value="">');		

		echo('<button class="btn btn-primary" onclick="addConf()">Agregar</button>');

	    echo('</form>	');
}


/*  ====================  Funcion para agregar una nueva configuracion general   ====================   */
function addConfGral($logo,$title,$iva){
	$consulta=("insert into confgral value (0,'$logo','$title','$iva','A')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar la informacion de una configuracion general   ====================   */
function displayUpdateCG($idCG){
	echo('<form role="form" name="formUpdCG" action="" method="post" enctype="multipart/form-data" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Configuracion</h3>');
		$conUC= mysql_query("SELECT * FROM confgral WHERE idConfiguracion='$idCG'");
		while ($infoCG=mysql_fetch_array($conUC)) {

			echo('
			<input type="text" name="titlee" placeholder="Titulo en Navegador" class="form-control" value="'.$infoCG["title"].'"><br>
			<input type="text" name="iva" placeholder="IVA de aplicacion" class="form-control" value="'.$infoCG["iva"].'"><br>			
			<input type="hidden" name="updateID" value="'.$idCG.'">
			<input type="hidden" name="updateCG" value="">');	

			$conDefault=mysql_query("SELECT idConfiguracion FROM empresa WHERE idEmpresa='1'");
			if($idDefault=mysql_fetch_array($conDefault)){
				if($idDefault["idConfiguracion"] == $infoCG["idConfiguracion"]){
					echo('<input type="checkbox" checked="checked" name="idDefault" value=""> Configuracion por Default <br><br>');
				}else{
					echo('<input type="checkbox" name="idDefault" value=""> Configuracion por Default <br><br>');
				}
			}

		}		
		echo('<button class="btn btn-primary" onclick="updateConG()">Actualizar</button>');
	echo('</form>	');
		 	
}


/*  ====================  Funcion para actualizar en la BD la informacion de una configuracion general   ====================   */
function updateConfG($id,$title,$iva){
	$consulta=("update confgral set title='$title', iva='$iva' where idConfiguracion='$id'");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

/*  ====================  Funcion para cambiar el status de una configuracion general   ====================   */
function cambiarStatusConf($id,$status){
	$consulta=("update confgral set status='$status' where idConfiguracion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}


/*  ====================  Formulario para subir el logo de la empresa   ====================   */

function displayImgUpload(){
	echo('<form role="form" name="formImg" action="" method="post" enctype="multipart/form-data" style="width:400px; margin: 0 auto;">');
	echo('
		<!-- <input type="file" class="filestyle" data-input="false"> -->
		<input name="archivo" id="archivo" type="file" class="filestyle" data-buttonName="btn-primary">
		<input name="enviar" class="btn btn-primary" type="submit" id="enviar" value="Upload File" />
		<input name="action" type="hidden" value="upload">
		');
	echo("</form>");

}

/*  ====================  Funcion para actualizar la informacion en la BD de la ruta de la imagen   ====================   */
function updateDirLogo($id,$url){
	$consulta=("UPDATE confgral set logo='$url' WHERE idConfiguracion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ====================  Tabla de categoria de productos  ====================   */
/*  =======================================================================================   */
function infoTablaCat(){

	$conCat= mysql_query("SELECT * FROM catview");
	while ($infoCat=mysql_fetch_array($conCat)) {
		echo('			
			<tr>			   
			   <td>'.$infoCat["nombreCategoria"].'</td>');
			   if($infoCat["nivelCategoria"]==1){
			   		echo('<td>Categoria</td>');
			   	}else{
			   		echo('<td>SubCategoria</td>');
			   	}
			   echo('<td>'.$infoCat["NombrePadre"].'</td>			   
			   <td>'.$infoCat["status"].'</td>
			   <td><a href="index.php?imgID='.$infoCat["idCategoria"].'"><button type="button" class="btn btn-success">Subir</button></a></td>
			   <td><a href="index.php?ID='.$infoCat["idCategoria"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoCat["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoCat["idCategoria"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoCat["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoCat["idCategoria"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

/*  ====================  Formulario para una nueva categoria de productos   ====================   */
function displayNewCat(){
	echo('<form role="form" name="formNuevaCat" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nueva informacion</h3>');

		echo('<input type="text" name="nombre" placeholder="Nombre de Categoria" class="form-control" ><br>
		<select name="nivelCategoria" id="x" class="form-control">
		    <option selected="selected" value="">Seleccione.. </option>
		    <option value="1">Categoria</option>
		    <option value="2">SubCategoria</option>
	    </select><br>
	    <div id="categoriasPadre" style="display: none;">');
		$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
		echo('<select name="catPadre" id="pref-perpage" class="form-control">
		<option selected="selected" value="0">Seleccione.. </option>');
		while ($infoCat=mysql_fetch_array($conCat)) {			
			    echo('<option value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
		}
		echo('</select><br>
		</div>');  		
		echo('<input type="hidden" name="nuevaCat" value="">');		

		echo('<button class="btn btn-primary" onclick="addCategoria()">Agregar</button>');

	    echo('</form>	');
}



/*  ====================  Funcion para agregar una nueva categoria de productos   ====================   */
function addCate($nombre,$cat,$catPadre){
	$consulta=("insert into categoria value (0,'$nombre','$cat','$catPadre','A')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar los datos de una categoria   ====================   */
function displayUpdCat($idCat){
	echo('<form role="form" name="formUpdCat" style="width:400px; margin: 0 auto;">');
		echo('<h3>Actualizar informacion</h3>');
		$conCate= mysql_query("SELECT * FROM categoria WHERE idCategoria='$idCat'");		
		while ($infoCate=mysql_fetch_array($conCate)) {			
			echo('<input type="text" name="nombre" placeholder="Nombre de Categoria" class="form-control" value="'.$infoCate["nombreCategoria"].'" ><br>
			<select name="nivelCategoria" id="x" class="form-control">
			    <option value="">Seleccione.. </option>');
			if($infoCate["nivelCategoria"]==1){
				echo('<option selected="selected" value="1">Categoria</option>
			    <option value="2">SubCategoria</option>');
			    echo('</select><br>');
			}else{
				echo('<option value="1">Categoria</option>
			    <option selected="selected" value="2">SubCategoria</option>');
				echo('</select><br>');
				echo('<div id="categoriasPadre">');
				$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
				echo('<select name="catPadre" id="pref-perpage" class="form-control">
				<option value="0">Seleccione.. </option>');
				while ($listCat=mysql_fetch_array($conCat)) {			
					    if($listCat["idCategoria"]==$infoCate["idCatPadre"]){
					    	echo('<option selected="selected" value="'.$listCat["idCategoria"].'">'.$listCat["nombreCategoria"].'</option>');
						}else{
							echo('<option value="'.$listCat["idCategoria"].'">'.$listCat["nombreCategoria"].'</option>');
						}
				}
				echo('</select><br>
				</div>'); 
			}			    
		    		    
		} 		
		echo('<input type="hidden" name="updCat" value="">');	
		echo('<input type="hidden" name="updateID" value="'.$idCat.'">');

		echo('<button class="btn btn-primary" onclick="updCategoria()">Actualizar</button>');

	    echo('</form>	');
}

/*  ====================  Funcion para actualizar en la BD la informacion de una categoria   ====================   */
function updCate($id,$nombre,$cat,$catPadre){
	$consulta=("update categoria set nombreCategoria='$nombre', nivelCategoria='$cat', idCatPadre='$catPadre' where idCategoria='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}


/*  ====================  Funcion para cambiar el status de una empresa de facturacion   ====================   */
function cambiarStatusCat($id,$status){
	$consulta=("update categoria set status='$status' where idCategoria='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

/*  ====================  Formulario para subir imagen de la categoria   ====================   */
function displayImgCategoria(){
	echo('<form role="form" name="formImg" action="" method="post" enctype="multipart/form-data" style="width:400px; margin: 0 auto;">');
	echo('		
		<input name="archivo" id="archivo" type="file" class="filestyle" data-buttonName="btn-primary">
		<input name="enviar" class="btn btn-primary" type="submit" id="enviar" value="Upload File" />
		<input name="action" type="hidden" value="upload">
		');
	echo("</form>");

}

/*  ====================  Funcion para actualizar la informacion en la BD de la ruta de la imagen   ====================   */
function updateDirCat($id,$url){
	$consulta=("UPDATE categoria set imgUrl='$url' WHERE idCategoria='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ====================  Tabla de productos   ====================   */
/*  =======================================================================================   */
function infoTablaPrdocutos(){

	$conPRO= mysql_query("SELECT idProducto, descripcionCorta, existencia, precio, precioMedioMayoreo, precioMayoreo, status FROM producto");
	while ($infoPro=mysql_fetch_array($conPRO)) {
		echo('			
			<tr>			   
			   <td>'.$infoPro["descripcionCorta"].'</td>
			   <td>'.$infoPro["existencia"].'</td>
			   <td>'.$infoPro["precio"].'</td>
			   <td>'.$infoPro["precioMedioMayoreo"].'</td>				   
			   <td>'.$infoPro["precioMayoreo"].'</td>
			   <td>'.$infoPro["status"].'</td>');
			   echo('<td><a href="index.php?imgID='.$infoPro["idProducto"].'"><button type="button" class="btn btn-success">Subir</button></a></td>');			   
			   echo('<td><a href="index.php?ID='.$infoPro["idProducto"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoPro["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoPro["idProducto"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoPro["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoPro["idProducto"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}	
}

/*  ====================  Formulario para un nuevo producto   ====================   */
function displayNewPro(){
	echo('<form role="form" name="formNuevoPro" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Producto</h3>');

		echo('<input type="text" name="descripcionCorta" placeholder="Descripcion del Titulo" class="form-control" ><br>
		<textarea name="descripcion" placeholder="Escriba sus comentarios" class="form-control"></textarea><br>			
		<input type="text" name="noParte" placeholder="Numero de Parte" class="form-control" ><br>
		<input type="text" name="precio" placeholder="Precio del Producto" class="form-control" ><br>
		<input type="text" name="existencia" placeholder="Existencia del Producto" class="form-control" ><br>		
		<input type="text" name="rangoMM" placeholder="Rango Medio Mayoreo" class="form-control" ><br>
		<input type="text" name="precioMM" placeholder="Precio Medio Mayoreo" class="form-control" ><br>
		<input type="text" name="rangoMayoreo" placeholder="Rango Mayoreo" class="form-control" ><br>
		<input type="text" name="precioMayoreo" placeholder="Precio Mayoreo" class="form-control" ><br>');
		$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
		echo('<select name="categoriaPadre" id="categoriaPadre" class="form-control">
		<option selected="selected" value="0">Seleccione.. </option>');
		while ($infoCat=mysql_fetch_array($conCat)) {			
			    echo('<option value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
		}
		echo('</select><br>');	
		echo('<select name="subCategoria" id="subCategoria" class="form-control">
			 <option selected="selected" value="">Seleccione..</option>
			 </select>
			 <br>');	
		echo('<input type="checkbox" name="iva" value=""> Exento de IVA <br><br>
		<input type="hidden" name="nuevoProd" value="">');				

		echo('<button class="btn btn-primary" onclick="addPro()">Agregar</button>');

	    echo('</form>	');
}

/*  ====================  Funcion para agregar un nuevo producto   ====================   */

function addProducto($descCorta,$desc,$parte,$precio,$exist,$rMM,$pMM,$rM,$pM,$subCat,$iva,$idusu){	
	$consulta=("insert into producto value (0,'$desc','$descCorta','$parte','$precio','$exist','$iva','$rMM','$pMM','$rM','$pM','A','$subCat','$idusu')");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}


/*  ====================  Formulario para editar los datos de un nuevo producto   ====================   */
function displayUpdPro($idPro){
	echo('<form role="form" name="formNuevoPro" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar informacion del Producto</h3>');
		$conProd= mysql_query("SELECT * FROM producto WHERE idProducto='$idPro'");				
		while ($infoProd=mysql_fetch_array($conProd)) {
			echo('<input type="text" name="descripcionCorta" value="'.$infoProd["descripcionCorta"].'" placeholder="Descripcion del Titulo" class="form-control" ><br>
			<textarea name="descripcion" placeholder="Escriba sus comentarios" class="form-control">'.$infoProd["descripcion"].'</textarea><br>			
			<input type="text" name="noParte" value="'.$infoProd["noParte"].'" placeholder="Numero de Parte" class="form-control" ><br>
			<input type="text" name="precio" value="'.$infoProd["precio"].'" placeholder="Precio del Producto" class="form-control" ><br>
			<input type="text" name="existencia" value="'.$infoProd["existencia"].'" placeholder="Existencia del Producto" class="form-control" ><br>		
			<input type="text" name="rangoMM" value="'.$infoProd["rangoMedioMayoreo"].'" placeholder="Rango Medio Mayoreo" class="form-control" ><br>
			<input type="text" name="precioMM" value="'.$infoProd["precioMedioMayoreo"].'" placeholder="Precio Medio Mayoreo" class="form-control" ><br>
			<input type="text" name="rangoMayoreo" value="'.$infoProd["rangoMayoreo"].'" placeholder="Rango Mayoreo" class="form-control" ><br>
			<input type="text" name="precioMayoreo" value="'.$infoProd["precioMayoreo"].'" placeholder="Precio Mayoreo" class="form-control" ><br>');
			
			$conPadre = mysql_query("SELECT idCatPadre FROM categoria where idCategoria=".$infoProd['idCategoria']." ");
			$infoPadre = mysql_fetch_array($conPadre);			

			$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
			echo('<select name="categoriaPadre" id="categoriaPadre" class="form-control">
			<option selected="selected" value="0">Seleccione.. </option>');
			while ($infoCat=mysql_fetch_array($conCat)) {	
				if($infoCat["idCategoria"]==$infoPadre["idCatPadre"]){
			    	echo('<option selected="selected" value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
				}else{
					echo('<option value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
				}
			}
			echo('</select><br>');				
			$conCatHijas = mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE idCatPadre=".$infoPadre['idCatPadre']." ");			
			echo('<select name="subCategoria" id="subCategoria" class="form-control">
			 	<option selected="selected" value="">Seleccione..</option>');
				while($infoHijas = mysql_fetch_array($conCatHijas)){
					if($infoProd["idCategoria"]==$infoHijas["idCategoria"]){
				    	echo('<option selected="selected" value="'.$infoHijas["idCategoria"].'">'.$infoHijas["nombreCategoria"].'</option>');
					}else{
						echo('<option value="'.$infoHijas["idCategoria"].'">'.$infoHijas["nombreCategoria"].'</option>');
					}
				}
			echo('</select>
			<br>');		
			if($infoProd["exentoIVA"]=="S"){
				echo('<input type="checkbox" name="iva" checked="checked" value="'.$infoProd["exentoIVA"].'"> Exento de IVA <br><br>');
			}else{
				echo('<input type="checkbox" name="iva" value="'.$infoProd["exentoIVA"].'"> Exento de IVA <br><br>');
			}
			echo('<input type="hidden" name="updProd" value="">');
			echo('<input type="hidden" name="updateID" value="'.$infoProd["idProducto"].'">');
		}
		echo('<button class="btn btn-primary" onclick="updPro()">Actualizar</button>');

	    echo('</form>	');
}

/*  ====================  Funcion para actualizar en la BD la informacion de un producto    ====================   */
function updProducto($descCorta,$desc,$parte,$precio,$exist,$rMM,$pMM,$rM,$pM,$subCat,$iva,$idProd){	
	$consulta=("update producto set descripcion='$desc', descripcionCorta='$descCorta', noParte='$parte', precio='$precio', existencia='$exist',exentoIVA='$iva', rangoMedioMayoreo='$rMM', precioMedioMayoreo='$pMM', rangoMayoreo='$rM',precioMayoreo='$pM', idCategoria='$subCat' WHERE idProducto='$idProd'");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}



/*  ====================  Funcion para cambiar el status de un producto   ====================   */
function cambiarStatusPro($idEF,$status){
	$consulta=("update producto set status='$status' where idProducto='$idEF'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

/*  ====================  Formulario para subir el imagenes de los productos   ====================   */

function displayImgUploadProductos($error){	
	echo("<br><br>");
	echo('<div class="panel panel-default">
  	<div class="panel-body">');
	echo('<form role="form" name="upload" id="upload" action="" method="post" enctype="multipart/form-data" style="width:400px; margin: 0 auto;">');
	echo('<h3>Agregar imagenes del producto</h3><br>');
	echo('		
		<input name="imagenesProducto[]" multiple id="archivo" type="file" class="filestyle" data-iconName="glyphicon-inbox" data-buttonName="btn-success" data-input="false"><br>');
		echo($error);
		echo('<input name="enviar" class="btn btn-primary" type="submit" id="enviar" value="Upload File" />
		<input name="action" type="hidden" value="upload">
		');		
	echo("</form><br><br>");	
	echo('</div>
	</div>');		

}

function displayImgProductos($idProd){
	echo("<br><br>");
	echo('<div class="panel panel-default">
  	<div class="panel-body">');	
		echo('<div class="row">');

				$conDC = mysql_query("SELECT descripcionCorta FROM producto WHERE idProducto='$idProd'");
				$infoDC = mysql_fetch_array($conDC);

				echo('<h3>Imagenes del producto <u><mark>'.$infoDC["descripcionCorta"].'</mark></u> </h3><br>');

				$conImg= mysql_query("SELECT * FROM imgproductos WHERE idProducto = '$idProd' ORDER BY predeterminada DESC");
				while($infoImg = mysql_fetch_array($conImg)){
					echo('<div class="col-xs-4 col-md-2">
							<div class="thumbnail">
								<a href="index.php?thum='.$infoImg["idImgProducto"].'&imgID='.$idProd.'"> <span class="glyphicon glyphicon-remove"></span> </a>
                				<a href="#" class="thumbnail">                				
                    				<img src="/FM/'.$infoImg["url"].'" value="'.$infoImg["idImgProducto"].'" alt="img..">                    			
                				</a> 
                				<div class="caption">');
									if($infoImg["predeterminada"]=="S"){
        								echo('<p>Imagen Predeterminada</p>');
        							}else{
        								echo('<p>Establecer Predeterminada</p>
        								<p><a href="index.php?default='.$infoImg["idImgProducto"].'&imgID='.$idProd.'" class="btn btn-primary" role="button">Aceptar</a></p>');
        							}        							
							    echo('</div>
                			</div>
            		</div>');
				}				
		echo('</div>');
	echo("<br><br>");
	echo('</div>
	</div>');
}

/*  ====================  Funcion para actualizar la informacion en la BD de la ruta de la imagen   ====================   */
function updateImgProducto($id,$url){
	$consulta=("INSERT INTO imgproductos values ('0','$url',NULL,'$id')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ====================  Tabla de promociones   ====================   */
/*  =======================================================================================   */
function infoTablaPromociones(){

	$conPROMO= mysql_query("SELECT * FROM promocion");
	while ($infoPromo=mysql_fetch_array($conPROMO)) {
		echo('			
			<tr>			   			
			   <td>'.$infoPromo["descripcion"].'</td>
			   <td>'.$infoPromo["img"].'</td>
			   <td>'.$infoPromo["inicio"].'</td>
			   <td>'.$infoPromo["idProducto"].'</td>				   
			   <td>'.$infoPromo["fin"].'</td>
			   <td>'.$infoPromo["status"].'</td>');
			   echo('<td><a href="index.php?imgID='.$infoPromo["idPromocion"].'"><button type="button" class="btn btn-success">Subir</button></a></td>');			   
			   echo('<td><a href="index.php?ID='.$infoPromo["idPromocion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoPromo["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoPromo["idPromocion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoPromo["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoPromo["idPromocion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}	
}


/*  ====================  Formulario para un nueva promocion   ====================   */
function displayNewPromo(){
	echo('<form role="form" name="formNuevoPromo" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nueva Promocion</h3>');

		echo('<input type="text" name="descripcion" placeholder="Titulo Principal" class="form-control" ><br>
		<textarea name="descCorta" placeholder="Descripcion secundaria" class="form-control"></textarea><br>					
		<div class="hero-unit">
        	<input type="text" name="inicio" class="form-control" placeholder="Inicio de la Promocion" value="" id="dpd1"><br>
            <input type="text" name="fin" class="form-control" placeholder="Fin de la Promocion" value="" id="dpd2"><br>
        </div>
        <input type="text" name="producto" id="producto" disabled placeholder="Producto de Promocion" class="form-control" ><br>
        <input type="hidden" name="valProducto" value="" id="valProducto">');        
		
		$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
		echo('<select name="categoriaPadre" id="categoriaPadre" class="form-control">
		<option selected="selected" value="0">Seleccione.. </option>');
		while ($infoCat=mysql_fetch_array($conCat)) {			
			    echo('<option value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
		}
		echo('</select><br>');	
		echo('<select name="subCategoria" id="subCategoria" class="form-control">
			<option selected="selected" value="">Seleccione..</option>
			</select>
			<br>');			

		echo('<div id="miModelo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    		<div class="modal-dialog modal-lg">
      			<div class="modal-content">
        			<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        				<h4 class="modal-title">Modal title</h4>
      				</div>
      				<div id="modelBody" class="modal-body">
        				
      				</div>
      				<div class="modal-footer">        				
        				<button type="button" class="btn btn-primary">Save changes</button>
      				</div>
      			</div>
    		</div>
  		</div>');

		echo('<input type="hidden" name="nuevaPromo" value="">');				

		echo('<button class="btn btn-primary" onclick="addPromo()">Agregar</button>');

	    echo('</form>	');	    	    
}

/*  ====================  Funcion para agregar un nueva promocion   ====================   */
function addPromo($inicio,$fin,$descripcion,$descripcionCorta,$idProd,$idEmpleado){
	$consulta=("insert into promocion value (0,'$inicio','$fin','A','$descripcion','$descripcionCorta','NULL','$idProd','$idEmpleado')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");
}
/*  ====================  Formulario para editar los datos de un nueva promocion   ====================   */
function displayUpdPromo($id){
	echo('<form role="form" name="formNuevoPromo" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar los dats de la promocion</h3>');
		$conPromo = mysql_query("SELECT * FROM promocion WHERE idPromocion='$id'");
		while($infoPromo = mysql_fetch_array($conPromo)){
			echo('<input type="text" value="'.$infoPromo["descripcion"].'" name="descripcion" placeholder="Titulo Principal" class="form-control" ><br>
			<textarea name="descCorta" placeholder="Descripcion secundaria" class="form-control">'.$infoPromo["descripcionCorta"].'</textarea><br>');

			$inicioPartes = explode("-", $infoPromo["inicio"]);
			$mostrarInicio = $inicioPartes[1]."/".$inicioPartes[2]."/".$inicioPartes[0];

			$finPartes = explode("-", $infoPromo["fin"]);
			$mostrarFin = $finPartes[1]."/".$finPartes[2]."/".$finPartes[0];

			echo('<div class="hero-unit">
	        	<input type="text" name="inicio" class="form-control" placeholder="Inicio de la Promocion" value="'.$mostrarInicio.'" id="dpd1"><br>
	            <input type="text" name="fin" class="form-control" placeholder="Fin de la Promocion" value="'.$mostrarFin.'" id="dpd2"><br>
	        </div>
	        <input type="text" name="producto" id="producto" disabled placeholder="Producto de Promocion" class="form-control" ><br>
	        <input type="hidden" name="valProducto" value="" id="valProducto">');        
			
			$conCat= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE nivelCategoria='1' ");
			echo('<select name="categoriaPadre" id="categoriaPadre" class="form-control">
			<option selected="selected" value="0">Seleccione.. </option>');
			while ($infoCat=mysql_fetch_array($conCat)) {			
				    echo('<option value="'.$infoCat["idCategoria"].'">'.$infoCat["nombreCategoria"].'</option>');
			}
			echo('</select><br>');	
			echo('<select name="subCategoria" id="subCategoria" class="form-control">
				<option selected="selected" value="">Seleccione..</option>
				</select>
				<br>');			

			echo('<div id="miModelo" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    		<div class="modal-dialog modal-lg">
	      			<div class="modal-content">
	        			<div class="modal-header">
	        				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        				<h4 class="modal-title">Modal title</h4>
	      				</div>
	      				<div id="modelBody" class="modal-body">
	        				
	      				</div>
	      				<div class="modal-footer">        				
	        				<button type="button" class="btn btn-primary">Save changes</button>
	      				</div>
	      			</div>
	    		</div>
	  		</div>');
			echo('<input type="hidden" name="updateID" value="'.$infoPromo["idPromocion"].'">');
			echo('<input type="hidden" name="updPromo" value="">');				
			echo('<button class="btn btn-primary" onclick="updPromocion()">Actualizar</button>');
		}

	echo('</form>	');	    	    
}

/*  ====================  Funcion para actualizar en la BD la informacion de una promocion    ====================   */
function updPromo($inicioDB,$finDB,$desc,$descCorta,$idPromo){
	$consulta = ("UPDATE promocion set inicio='$inicioDB', fin='$finDB', descripcion='$desc', descripcionCorta='$descCorta' WHERE idPromocion='$idPromo' ");	
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

/*  ====================  Funcion para cambiar el status de una promocion   ====================   */
function cambiarStatusPromo($idEF,$status){
	$consulta=("update promocion set status='$status' where idPromocion='$idEF'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

/*  ====================  Formulario para subir el imagenes de las promociones   ====================   */
function displayImgUploadPromo(){

	echo('<form role="form" name="formImg" action="" method="post" enctype="multipart/form-data" style="width:400px; margin: 0 auto;">');
	echo('
		<!-- <input type="file" class="filestyle" data-input="false"> -->
		<input name="archivo" id="archivo" type="file" class="filestyle" data-buttonName="btn-primary">
		<input name="enviar" class="btn btn-primary" type="submit" id="enviar" value="Upload File" />
		<input name="action" type="hidden" value="upload">
		');
	echo("</form>");

}

/*  ====================  Funcion para actualizar la informacion en la BD de la ruta de la imagen   ====================   */
function updateImgPromo($id,$url){
	$consulta=("UPDATE promocion set img='$url' WHERE idPromocion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);
	header("Location: ./index.php");
}



########################################## Polanco Administracion usuarios#############################################

###Empleados###
/*  =======================================================================================   */
/*  ====================  Tabla de empleados   ====================   */
/*  =======================================================================================   */
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

/*  ====================  Formulario para un nuevo empleado   ====================   */
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

	echo('</form>');
}

/*  ====================  Funcion para agregar un nuevo empleado   ====================   */
function addConfEmpleado($nombre,$apellido,$user,$pass,$status,$idDepto,$idNivel,$idEmpresa){
	$consulta=("insert into empleado value (0,'$nombre','$apellido','$user','$pass','A','$idDepto','$idNivel','$idEmpresa')");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}

/*  ====================  Formulario para editar los datos de un empleado   ====================   */
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

/*  ====================  Funcion para actualizar en la BD la informacion de un empleado   ====================   */
function updateEmpl($idEmpl,$nombre,$apellido,$user,$pass,$statusEmp,$idDepto,$idNivel,$idEmpresa){
	$consultaEmp=("update empleado set nombre='$nombre', apellido='$apellido', user='$user', pass='$pass', status='A', idDepto='$idDepto', idNivel='$idNivel', idEmpresa='$idEmpresa' WHERE idEmpleado='$idEmpl'");
	@mysql_query($consultaEmp)or die ("No se puede ejecutar la accion".$consultaEmp);
	header("Location: ./index.php");
	#echo($consultaEmp);
}

/*  ====================  Funcion para cambiar el status de un empleado   ====================   */
function cambiarStatusEmple ($idEmpl, $statusEmp){
	$consultaEmp=("update empleado set status='$statusEmp' where idEmpleado='$idEmpl'");
	@mysql_query($consultaEmp) or die ("No se puede ejecutar la consulta".$consultaEmp);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ====================  Tabla de departamentos   ====================   */
/*  =======================================================================================   */
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

/*  ====================  Formulario para un nuevo departamento   ====================   */

	//Formulario Agrega un nuevo Departamento (2)
function displayNewDepartamento(){
	echo('<form role="form" name="formNuevoDepartamento" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Departamento.</h3>');

		echo('<input type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" ><br>
		<input type="hidden" name="nuevaDepto" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfDepartamento()">Agregar</button>');

	echo('</form>	');
}

/*  ====================  Funcion para agregar un nuevo departamentos   ====================   */
function addConfDepartamento($nombre,$status){
	$consulta=("insert into depto value (0,'$nombre','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir departamento".$consulta);
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar los datos de un departamento   ====================   */
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
/*  ====================  Funcion para actualizar en la BD la informacion de un departamento   ====================   */
function updateDepartamento($idDep,$nombre,$statusDep){
	$consultaDepa=("update depto set nombre='$nombre', status='A' WHERE idDepto='$idDep'");
	@mysql_query($consultaDepa)or die ("No se puede ejecutar la accion".$consultaDepa);
	header("Location: ./index.php");
}

/*  ====================  Funcion para cambiar el status de un departamento   ====================   */
function cambiarStatusDepartamento ($idDep, $statusDep){
	$consultaDepa=("update depto set status='$statusDep' where idDepto='$idDep'");
	@mysql_query($consultaDepa) or die ("No se puede ejecutar la consulta".$consultaDepa);
	header("Location: ./index.php");
}


/*  =======================================================================================   */
/*  ====================  Tabla de Niveles   ====================   */
/*  =======================================================================================   */
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

/*  ====================  Formulario para un nuevo nivel   ====================   */
function displayNewNiveles(){
	echo('<form role="form" name="formNuevoNiveles" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Nivel.</h3>');
		
		echo('<input type="text" name="nombre" placeholder="Nombre Nivel" class="form-control" ><br>
		<input type="hidden" name="nuevaNive" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfNiveles()">Agregar</button>');

	echo('</form>	');
}

/*  ====================  Funcion para agregar un nuevo nivel   ====================   */
function addConfNiveles($nombre,$status){
	$consulta=("insert into nivel value (0,'$nombre','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir departamento".$consulta);
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar los datos de un nivel   ====================   */
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

/*  ====================  Funcion para actualizar en la BD la informacion de un nivel   ====================   */
function updateNiveles($idNiv,$nombre,$statusNiv){
	$consultaDepa=("update nivel set nombre='$nombre', status='A' WHERE idNivel='$idNiv'");
	@mysql_query($consultaDepa)or die ("No se puede ejecutar la accion".$consultaDepa);
	header("Location: ./index.php");
}

/*  ====================  Funcion para cambiar el status de un nivel   ====================   */
function cambiarStatusNiveles ($idNiv, $statusNiv){
	$consultaDepa=("update nivel set status='$statusNiv' where idNivel='$idNiv'");
	@mysql_query($consultaDepa) or die ("No se puede ejecutar la consulta".$consultaDepa);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ==============================  Tabla de Clientes   ====================================  */
/*  =======================================================================================   */
function infoTablaClientes(){
	$conClientes= mysql_query("SELECT * FROM cliente");
	while ($infoClientes=mysql_fetch_array($conClientes)) {
		echo('			
			<tr>			   
			   <td>'.$infoClientes["nombre"].'</td>
			   <td>'.$infoClientes["apellido"].'</td>
			   <td>'.$infoClientes["titulo"].'</td>
			   <td>'.$infoClientes["user"].'</td>
			   <td>'.$infoClientes["pass"].'</td>
			   <td>'.$infoClientes["status"].'</td>
			   <td><a href="index.php?ID='.$infoClientes["idCliente"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoClientes["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoClientes["idCliente"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoClientes["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoClientes["idCliente"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

/*  ====================  Formulario para un nuevo cliente   ====================   */
function displayNewClientes(){	
	echo('<form role="form" name="formNuevoCliente" style="width:400px; margin: 0 auto;">');
		echo('<h3>Nuevo Cliente</h3>');

		echo('<input type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" ><br>
		<input type="text" name="apellido" placeholder="Apellido Usuario" class="form-control" ><br>
		<input type="text" name="titulo" placeholder="Titulo" class="form-control" ><br>
		<input type="text" name="user" placeholder="Usuario" class="form-control" ><br>
		<input type="password" name="pass" placeholder="Password" class="form-control" ><br>
		<input type="hidden" name="nuevaCli" value="">');		

		echo('<button class="btn btn-primary" onclick="addConfCliente()">Agregar</button>');

	echo('</form>');
}

/*  ====================  Funcion para agregar un nuevo cliente   ====================   */
function addConfCliente($nombre,$apellido,$titulo,$user,$pass){
	$consulta=("insert into cliente value (0,'$nombre','$apellido','$titulo','$user','$pass','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");
}

/*  ====================  Formulario para editar los datos de un cliente   ====================   */
function displayUpdateCliente($idCl){
	echo('<form role="form" name="formUpdateClie" style="width:400px; margin: 0 auto;">');
		echo('<h3>Editar Cliente</h3>');
		$conClien= mysql_query("SELECT * FROM cliente WHERE idCliente='$idCl'");
		while ($infoClien=mysql_fetch_array($conClien)) {

			echo('<input type="text" name="nombre" placeholder="Nombre empleado" class="form-control" value="'.$infoClien["nombre"].'"><br>
			<input type="text" name="apellido" placeholder="Apellido empleado" class="form-control" value="'.$infoClien["apellido"].'"><br>
			<input type="text" name="titulo" placeholder="Titulo Usuario" class="form-control" value="'.$infoClien["titulo"].'"><br>
			<input type="text" name="user" placeholder="Usuario empleado" class="form-control" value="'.$infoClien["user"].'"><br>
			<input type="password" name="pass" placeholder="Password empleado" class="form-control" value="'.$infoClien["pass"].'"><br>						
			<input type="hidden" name="updateIdCli" value="'.$idCl.'">
			<input type="hidden" name="updateCli" value="">');				

		}

		echo('<button class="btn btn-primary" onclick="updateCliente()">Actualizar</button>');

	echo('</form>	');
}

/*  ====================  Funcion para actualizar en la BD la informacion de un cliente   ====================   */
function updateClientes($idCli,$nombre,$apellido,$titulo,$user,$pass){
	$consultaClien=("update cliente set nombre='$nombre', apellido='$apellido', titulo='$titulo', user='$user', pass='$pass', status='A' WHERE idCliente='$idCli'");
	@mysql_query($consultaClien)or die ("No se puede ejecutar la accion".$consultaClien);
	header("Location: ./index.php");
}

/*  ====================  Funcion para cambiar el status de un cliente   ====================   */
function cambiarStatusCliente ($idCli, $statusClie){
	$consultaClie=("update cliente set status='$statusClie' where idCliente='$idCli'");
	@mysql_query($consultaClie) or die ("No se puede ejecutar la consulta".$consultaClie);
	header("Location: ./index.php");
}

/* ============================Prueba paginacion empleados ======================= */
function infoTablaPaginar(){


	//primero obtenemos el parametro que nos dice en que pagina estamos
        $page = 1; //inicializamos la variable $page a 1 por default
        if(array_key_exists('pg', $_GET)){
            $page = $_GET['pg']; //si el valor pg existe en nuestra url, significa que estamos en una pagina en especifico.
        }
        //ahora que tenemos en que pagina estamos obtengamos los resultados:
        // a) el numero de registros en la tabla
        $mysqli = new mysqli("localhost","root","","flexmark");
        if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
      }


        $conteo_query =  $mysqli->query("SELECT COUNT(*) as conteo FROM empleado");
        $conteo = "";
        if($conteo_query){
          while($obj = $conteo_query->fetch_object()){ 
            $conteo =$obj->conteo; 
          }
        }
        $conteo_query->close(); 
        unset($obj); 
        
        //ahora dividimos el conteo por el numero de registros que queremos por pagina.
        $max_num_paginas = intval($conteo/5); //en esto caso 5
      
        // ahora obtenemos el segmento paginado que corresponde a esta pagina
        $segmento = $mysqli->query("SELECT *  FROM empleado LIMIT ".(($page-1)*5).", 5 ");

        //ya tenemos el segmento, ahora le damos output.
        
  
        if($segmento){
          
          while($obj2 = $segmento->fetch_object())
          {
             echo '<tr>
                         <td>'.$obj2->nombre.'</td>
                         <td>'.$obj2->apellido.'</td>
                         <td>'.$obj2->user.'</td>
                         <td>'.$obj2->pass.'</td>
                         <td>'.$obj2->status.'</td>
                         <td>'.$obj2->idDepto.'</td>
                         <td>'.$obj2->idNivel.'</td>
                         <td>'.$obj2->idEmpresa.'</td>
                         <td><a href="index.php?ID='.$obj2->idCliente.'"><button type="button" class="btn btn-warning">Modificar</button></a></td>
                         <td>faltabotonaltabaja</td>
                         '; 
          }
          echo '<tr><br/><br/>';
      }
  
        //ahora viene la parte importante, que es el paginado
        //recordemos que $max_num_paginas fue previamente calculado.
        for($i=0; $i<$max_num_paginas;$i++){
           echo '<a href="prueba.php?pg='.($i+1).'">'.($i+1).'</a> | ';
        }
}

?>