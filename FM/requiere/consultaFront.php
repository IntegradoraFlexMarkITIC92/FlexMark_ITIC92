<?php
/*  =======================================================================================   */
/*  ====================   Archivos requeridos para el funcionamiento  ====================   */
/*  =======================================================================================   */
include("conn.php"); 
include("estados.php"); 
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
/*  =================  Funcion para realizar consulta a las promociones  ==================   */
/*  =======================================================================================   */
function showPromos(){	
	echo('<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">');
		$conCount= mysql_query('SELECT count(1) as Contador FROM promocion where status="A" AND fin >= "'.date("Y-m-d").'"');
		if($infoCount=mysql_fetch_array($conCount)){
			if($infoCount["Contador"]!=0){
				echo('<ol class="carousel-indicators">');
				for ($i=0; $i < $infoCount["Contador"]; $i++) { 
					if($i==0){
						echo('<li data-target="#carousel-example-generic" data-slide-to="'.$i.'" class="active"></li>');
					}else{
						echo('<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li>');
					}
				}
				echo('</ol>');
				echo('<div class="carousel-inner">');
					$conPromos = mysql_query('SELECT * FROM promocion where status="A" AND fin >= "'.date("Y-m-d").'"');
					$i=0;
					while($infoPromos=mysql_fetch_array($conPromos)){					
						if($i==0){
							echo('<div class="item active">
	              				<center><img src="/FM/'.$infoPromos["img"].'" alt="Img Pre"></center>
	              				<div class="carousel-caption">
	    							<h1>'.$infoPromos["descripcion"].'</h1>
	    							<h3>'.$infoPromos["descripcionCorta"].'</h3>
	  							</div>
	            			</div>');
						}else{
							echo('<div class="item">
	              				<center><img src="/FM/'.$infoPromos["img"].'" alt="Img Pre"></center>
	              				<div class="carousel-caption">
	    							<h1>'.$infoPromos["descripcion"].'</h1>
	    							<h3>'.$infoPromos["descripcionCorta"].'</h3>
	  							</div>
	            			</div>');
						}
						$i++;					
					}

				echo('</div>');	
			}else{
			echo('<ol class="carousel-indicators">');
				echo('<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>');
			echo('</ol>');
			echo('<div class="carousel-inner">');
				echo('<div class="item active">
              				<center><img src="/FM/imgUpload/imgPruebas/BelAir-Pascua2014.jpg" alt="Img Pre"></center>
              				<div class="carousel-caption">
    							<h1>Flex Mark</h1>
    							<h3>Buenas</h3>
  							</div>
            			</div>');
				echo('</div>');
			}
		
		echo('<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          		<span class="glyphicon glyphicon-chevron-left"></span>
        	</a>
        	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          		<span class="glyphicon glyphicon-chevron-right"></span>
        	</a>');
	}

	echo('</div>');
}


/*  =======================================================================================   */
/*  ====================  Funcion para realizar el login de back-end   ====================   */
/*  =======================================================================================   */
function login($user,$pass,$url){			
	$conClie= mysql_query("SELECT idCliente, count(1) as exist FROM cliente where user='$user' and pass='$pass' and status='A'");
	while($logi=mysql_fetch_array($conClie)){		
		if($logi['exist']==1){			
			$idCliente=$logi['idCliente'];			
			$_SESSION["logged_cliente"] = $idCliente;				
			header("Location: ".$url."");
		}else{
			echo("Error de login");
		}			
	}
}

/*  =======================================================================================   */
/*  ======================  Funcion para agregar un cliente   =============================   */
/*  =======================================================================================   */
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

/*  =======================================================================================   */
/*  ====================  Funcion para agregar un nuevo cliente   ========================   */
/*  =======================================================================================   */
function addConfCliente($nombre,$apellido,$titulo,$user,$pass){
	$consulta=("insert into cliente value (0,'$nombre','$apellido','$titulo','$user','$pass','A')");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  =================  Funcion para modificar la informacion del cliente   ================   */
/*  =======================================================================================   */
function displayCliente(){
	$cliente = $_SESSION["logged_cliente"];
	$conClie = mysql_query("SELECT * FROM cliente WHERE idCliente='$cliente'");
	while ($infoCliente = mysql_fetch_array($conClie)) {
		
		echo('<form role="form" name="formUpdCliente" style="width:400px; margin: 0 auto;">');		

			echo('<input value="'.$infoCliente["nombre"].'" type="text" name="nombre" placeholder="Nombre Usuario" class="form-control" ><br>
			<input value="'.$infoCliente["apellido"].'" type="text" name="apellido" placeholder="Apellido Usuario" class="form-control" ><br>
			<input value="'.$infoCliente["titulo"].'" type="text" name="titulo" placeholder="Titulo" class="form-control" ><br>
			<input value="'.$infoCliente["user"].'" type="text" disabled name="user" placeholder="Usuario" class="form-control" ><br>
			<input type="password" name="pass" placeholder="Password" class="form-control" ><br>
			<input type="hidden" name="updCli" value="">');		

			echo('<button class="btn btn-primary" onclick="updCliente()">Actualizar</button>');

		echo('</form>');
	}
}

function updateCliente($nom, $ape, $tit, $pass){
	if($pass!=""){
		$consulta = ("UPDATE cliente SET nombre='$nom', apellido='$ape', titulo='$tit', pass='$pass' WHERE idCliente='".$_SESSION["logged_cliente"]."' ");		
	}else{
		$consulta = ("UPDATE cliente SET nombre='$nom', apellido='$ape', titulo='$tit' WHERE idCliente='".$_SESSION["logged_cliente"]."' ");
	}
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");
}

/*  =======================================================================================   */
/*  ===============================  Tabla de Datos facturacion  ==========================   */
/*  =======================================================================================   */
function infoTablaDF(){
	$conDatos= mysql_query("SELECT idDatosFacturacion, RFC, estado, status FROM datosfacturacion WHERE idCliente='".$_SESSION["logged_cliente"]."'");
	while ($infoDatos=mysql_fetch_array($conDatos)) {
		echo('			
			<tr>			   			   
			   <td>'.$infoDatos["RFC"].'</td>
			   <td>'.$infoDatos["estado"].'</td>
			   <td>'.$infoDatos["status"].'</td>
			   <td><a href="index.php?ID='.$infoDatos["idDatosFacturacion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoDatos["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoDatos["idDatosFacturacion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoDatos["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoDatos["idDatosFacturacion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

/*  ===============================     Formulario para nuevos Datos envio     ==========================   */
function displayNewRFC(){	
	echo('<form role="form" name="formNuevoRFC" style="width:400px; margin: 0 auto;">');		

		echo('<input type="text" required name="razonSocial" placeholder="Razon Social" class="form-control" ><br>
		<input type="text" required name="rfc" placeholder="RFC" class="form-control" ><br>
		<input type="text" required name="dir" placeholder="Direccion" class="form-control" ><br>
		<input type="text" required name="municipio" placeholder="Municipio" class="form-control" ><br>');
		estadosList();
		echo('<input type="text" required name="cp" placeholder="Codigo Postal" class="form-control" ><br>
		<input type="hidden" name="nuevo" value="">');		

		echo('<button class="btn btn-primary" onclick="addNewRFC()">Agregar</button>');

	echo('</form>');
}

/*  ===============================     Agregar nuevos Datos envio     ==========================   */
function addRFC($rs, $rfc, $dir, $muni, $edo, $cp){
	$consulta = ("INSERT into datosfacturacion values (0, '$rs', '$rfc', '$dir', '$cp','$muni', '$edo', 'Mexico','A' , '".$_SESSION["logged_cliente"]."' )");	
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");	
}

/*  ===============================     Formulario para acutalizar Datos envio     ==========================   */
function displayUpdRFC($id){		
	echo('<form role="form" name="formEnvio" style="width:400px; margin: 0 auto;">');		
		$conDatos = mysql_query("SELECT * FROM datosfacturacion WHERE idDatosFacturacion='$id'");
		while ($infoDatos = mysql_fetch_array($conDatos)) {			
			echo('<input type="text" value="'.$infoDatos["razonSocial"].'" required name="razonSocial" placeholder="Razon Social" class="form-control" ><br>
			<input type="text" value="'.$infoDatos["RFC"].'" required name="rfc" placeholder="RFC" class="form-control" ><br>
			<input type="text" value="'.$infoDatos["direccion"].'" required name="dir" placeholder="Direccion" class="form-control" ><br>
			<input type="text" value="'.$infoDatos["municipio"].'" required name="municipio" placeholder="Municipio" class="form-control" ><br>');
			estadosListUp($infoDatos["estado"]);
			echo('<input type="text" value="'.$infoDatos["cp"].'" required name="cp" placeholder="Codigo Postal" class="form-control" ><br>
			<input type="hidden" name="idUpd" value="'.$infoDatos["idDatosFacturacion"].'">
			<input type="hidden" name="upd" value="">');		

			echo('<button class="btn btn-primary" onclick="updRFC()">Agregar</button>');	
		}

	echo('</form>');	
}

/*  ===============================     Actualizar Datos envio     ==========================   */
function updRFC($idDir, $rs, $rfc, $dir, $muni, $edo, $cp){
	$consulta = ("UPDATE datosfacturacion set razonSocial='$rs', RFC='$rfc', direccion='$dir', cp='$cp', municipio='$muni', estado='$edo' WHERE idDatosFacturacion='$idDir' ");
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");	
}

/*  ===============================     Cambiar el status de Datos envio     ==========================   */
function cambiarStatusRFC($id,$status){
	$consulta=("UPDATE datosfacturacion set status='$status' where idDatosFacturacion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}


/*  =======================================================================================   */
/*  ===============================     Tabla de Datos envio     ==========================   */
/*  =======================================================================================   */
function infoTablaDireccion(){
	$conDatos= mysql_query("SELECT idDireccion, direccion, estado, status FROM direccionCliente WHERE idCliente='".$_SESSION["logged_cliente"]."'");
	while ($infoDatos=mysql_fetch_array($conDatos)) {
		echo('			
			<tr>			   			   
			   <td>'.$infoDatos["direccion"].'</td>
			   <td>'.$infoDatos["estado"].'</td>
			   <td>'.$infoDatos["status"].'</td>
			   <td><a href="index.php?ID='.$infoDatos["idDireccion"].'"><button type="button" class="btn btn-warning">Modificar</button></a></td>');
		if($infoDatos["status"]=="A"){
			   echo('<td><a href="index.php?STATUS=D&IDE='.$infoDatos["idDireccion"].'"><button type="button" class="btn btn-danger">Baja</button></a></td>');
		}else if($infoDatos["status"]=="D"){
			   echo('<td><a href="index.php?STATUS=A&IDE='.$infoDatos["idDireccion"].'"><button type="button" class="btn btn-primary">Alta</button></a></td>');
		}
			echo('<tr>');
	}
}

/*  ===============================     Formulario para nuevos Datos envio     ==========================   */
function displayNewEnvio(){	
	echo('<form role="form" name="formNuevoEnvio" style="width:400px; margin: 0 auto;">');		

		echo('<input type="text" required name="direccion" placeholder="Direccion de Envio" class="form-control" ><br>
		<input type="text" required name="calle" placeholder="Calle" class="form-control" ><br>
		<input type="text" required name="muni" placeholder="Municipio" class="form-control" ><br>
		<input type="text" name="delegacion" placeholder="Delegacion" class="form-control" ><br>');
		estadosList();
		echo('<input type="text" required name="cp" placeholder="Codigo Postal" class="form-control" ><br>
		<input type="hidden" name="nuevoEnvio" value="">');		

		echo('<button class="btn btn-primary" onclick="addDirEnvio()">Agregar</button>');

	echo('</form>');
}

/*  ===============================     Agregar nuevos Datos envio     ==========================   */
function addEnvio($dir, $calle, $muni, $dele, $edo, $cp){
	$consulta = ("INSERT into direccioncliente values (0, '$dir', '$calle', '$muni', '$dele', '$edo', 'Mexico', '$cp', '".$_SESSION["logged_cliente"]."','A' )");	
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");	
}

/*  ===============================     Formulario para acutalizar Datos envio     ==========================   */
function displayUpdEnvio($id){		
	echo('<form role="form" name="formEnvio" style="width:400px; margin: 0 auto;">');		
		$conDatos = mysql_query("SELECT * FROM direccioncliente WHERE idDireccion='$id'");
		while ($infoDatos = mysql_fetch_array($conDatos)) {			
			echo('<input type="text" value ="'.$infoDatos["direccion"].'" required name="direccion" placeholder="Direccion de Envio" class="form-control" ><br>
			<input type="text" value ="'.$infoDatos["calle"].'" required name="calle" placeholder="Calle" class="form-control" ><br>
			<input type="text" value ="'.$infoDatos["municipio"].'" required name="muni" placeholder="Municipio" class="form-control" ><br>
			<input type="text" value ="'.$infoDatos["delegacion"].'" name="delegacion" placeholder="Delegacion" class="form-control" ><br>');
			estadosListUp($infoDatos["estado"]);
			echo('<input type="text" value ="'.$infoDatos["cp"].'" required name="cp" placeholder="Codigo Postal" class="form-control" ><br>
			<input type="hidden" name="idUPD" value ="'.$infoDatos["idDireccion"].'">
			<input type="hidden" name="upd" value="">');		

			echo('<button class="btn btn-primary" onclick="updDirEnvio()">Actualizar</button>');			
		}

	echo('</form>');	
}

/*  ===============================     Actualizar Datos envio     ==========================   */
function updEnvio($idDir, $dir, $calle, $muni, $delegacion, $edo, $cp){
	$consulta = ("UPDATE direccioncliente set direccion='$dir', calle='$calle', municipio='$muni', delegacion='$delegacion', estado='$edo', cp='$cp' WHERE idDireccion='$idDir' ");		
	@mysql_query($consulta) or die ("No se puede ejecutar la acccion añadir el cliente".$consulta);
	header("Location: ./index.php");	
}

/*  ===============================     Cambiar el status de Datos envio     ==========================   */
function cambiarStatus($id,$status){
	$consulta=("UPDATE direccioncliente set status='$status' where idDireccion='$id'");
	@mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);	
	header("Location: ./index.php");	
}
function categotiasView(){
	$conDatos = mysql_query("SELECT * FROM categoria WHERE nivelCategoria='1' ");
	while ($infoDatos = mysql_fetch_array($conDatos)) {
		echo('<div class="col-xs-5 col-md-3">
				<div class="thumbnail">								
    				<a href="index.php?ctp='.$infoDatos["idCategoria"].'" class="thumbnail">');                				
        			if($infoDatos["imgUrl"]==NULL){
						echo('<img src="/FM/imgUpload/noimage.jpg'.$infoDatos["imgUrl"].'" value="'.$infoDatos["idCategoria"].'" alt="img..">');
					}else{
        				echo('<img src="/FM/'.$infoDatos["imgUrl"].'" value="'.$infoDatos["idCategoria"].'" alt="img..">');
        			}
    				echo('</a>
    				<div class="caption">');									
							echo('<p>'.$infoDatos["nombreCategoria"].'</p>');
				    echo('</div>
    			</div>
		</div>');
	}
}

function catHijas($idPadre){	
	$conDatos = mysql_query("SELECT * FROM categoria WHERE idCatPadre='$idPadre' ");
	while ($infoDatos = mysql_fetch_array($conDatos)) {
		echo('<div class="col-xs-5 col-md-3">
				<div class="thumbnail">								
    				<a href="./pdc/index.php?scth='.$infoDatos["idCategoria"].'" class="thumbnail">');
					if($infoDatos["imgUrl"]==NULL){
						echo('<img src="/FM/imgUpload/noimage.jpg'.$infoDatos["imgUrl"].'" value="'.$infoDatos["idCategoria"].'" alt="img..">');
					}else{
        				echo('<img src="/FM/'.$infoDatos["imgUrl"].'" value="'.$infoDatos["idCategoria"].'" alt="img..">');
        			}
    				echo('</a> 
    				<div class="caption">');									
							echo('<p>'.$infoDatos["nombreCategoria"].'</p>');
				    echo('</div>
    			</div>
		</div>');
	}
}

function prodView($idCat){	 
  	$conProd = mysql_query("SELECT idProducto, descripcionCorta, precio FROM producto WHERE idCategoria='$idCat'");
  		while ($infoDatos = mysql_fetch_array($conProd)) {
  			echo('
  			<div class="row">
  				<div class="col-md-2">
  					<a href="view.php?pctd='.$infoDatos["idProducto"].'">');                				
			  			$conURL = mysql_query("SELECT url from imgproductos where idProducto='".$infoDatos['idProducto']."' AND predeterminada='S'");
			  			$infoUrl = mysql_fetch_array($conURL);
			  			if($infoUrl["url"]==NULL){
			  				echo('<img class="img-thumbnail" src="/FM/imgUpload/noimage.jpg" alt="no image">	');
			  			}else{
			  				echo('<img class="img-thumbnail" src="/FM/'.$infoUrl["url"].'" alt="no image">	');
			  			}		  					
		  			echo('</a>
		  		</div>
		  		<div class="col-md-6">
		  			<a href="view.php?pctd='.$infoDatos["idProducto"].'">
		  				<h3>'.$infoDatos["descripcionCorta"].'</h3>
		  			</a>
		  		</div>
		  		<div class="col-md-4">
		  			<h4> $'.$infoDatos["precio"].'</h4>');
		  			if($_SESSION["logged_cliente"]){
		  				echo('<button type="button" class="btn btn-warning">Comprar</button>');
		  			}
	  			echo('</div>
	  		</div>
	  		<hr>');
  			}	  			  					
}

function infoProducto($idProd){
	$conProducto = mysql_query("SELECT * FROM producto WHERE idProducto='$idProd'");
	while ($infoProducto = mysql_fetch_array($conProducto)) {
		echo('
			<h1 class="page-header">'.$infoProducto["descripcionCorta"].'</h1>
		');	
	}	
}