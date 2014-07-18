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
			echo("Error de login");
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
		}		
		echo('<button class="btn btn-primary" onclick="updateConG()">Actualiza</button>');
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
			echo('<input type="text" name="nombre" placeholder="Nombre de Categoria" class="form-control" value='.$infoCate["nombreCategoria"].' ><br>
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
			   echo('<td><button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-sm">Subir</button></td>');			   
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
		<input type="text" name="precioMayoreo" placeholder="Precio Mayoreo" class="form-control" ><br>
		<input type="checkbox" name="iva" value=""> Exento de IVA <br><br>
		<input type="hidden" name="nuevoProd" value="">');

		echo('<button class="btn btn-primary" onclick="addProd()">Agregar</button>');

	    echo('</form>	');
}

/*  ====================  Funcion para agregar un nuevo producto   ====================   */




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
			<input type="text" name="precioMayoreo" value="'.$infoProd["precioMayoreo"].'" placeholder="Precio Mayoreo" class="form-control" ><br>
			<input type="checkbox" name="iva" value="'.$infoProd["exentoIVA"].'"> Exento de IVA <br><br>
			<input type="hidden" name="nuevoProd" value="">');
			echo('<input type="hidden" name="updateID" value="'.$infoProd[""].'">');
		}
		echo('<button class="btn btn-primary" onclick="addProd()">Agregar</button>');

	    echo('</form>	');
}

/*  ====================  Funcion para actualizar en la BD la informacion de un producto    ====================   */



/*  ====================  Funcion para cambiar el status de un producto   ====================   */
function cambiarStatusPro($idEF,$status){
	$consulta=("update producto set status='$status' where idProducto='$idEF'");
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

?>