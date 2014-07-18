<?php 
error_reporting(0);
session_start();
include("../../../requiere/consultas.php");
include("../../../requiere/menus.php");

if (!isset($_SESSION["logged_adm"])){
    die("<head>
        <title>Error</title>        
      </head>
      <body>        
          <center>
          <h1 id='logo'>FlexMark.. </h1>
          <h1>Por favor <a href='../index.php'>Inicia sesion</a></h1>
          </center>        
      </body>");
}else{  
    if($_REQUEST["op"]=="logout"){
         session_destroy(); // destruyo la sesión 
           header("Location: /FM/cPan/");
   }
   
   if(!is_null($_REQUEST['nuevaRS']) && $_REQUEST['nuevaRS']=="ADD"){      
      //Llamo la funcion de actualizar            
      $rz=$_REQUEST['razonSocial'];
      $rfc=$_REQUEST['rfc'];
      $dir=$_REQUEST['direccion'];
      $cp=$_REQUEST['cp'];
      $municipio=$_REQUEST['municipio'];
      $estado=$_REQUEST['estadosList'];
      
      addEmpresaFactuacion($rz,$rfc,$dir,$cp,$municipio,$estado);

    }

    if(!is_null($_REQUEST['STATUS']) && $_REQUEST['STATUS']!="" && !is_null($_REQUEST['IDE']) && $_REQUEST['IDE']!=""){      
      cambiarStatus($_REQUEST['IDE'],$_REQUEST['STATUS']);
    }

    if(!is_null($_REQUEST['updateRS']) && $_REQUEST['updateRS']=="update"){      
      //Llamo la funcion de actualizar            
      $rz=$_REQUEST['razonSocial'];
      $rfc=$_REQUEST['rfc'];
      $dir=$_REQUEST['direccion'];
      $cp=$_REQUEST['cp'];
      $municipio=$_REQUEST['municipio'];
      $estado=$_REQUEST['estadosList'];
      $id=$_REQUEST['updateID'];
      
      updateEmpresaFactuacion($id,$rz,$rfc,$dir,$cp,$municipio,$estado);

    }


}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/FM/include/favicon.ico">

    <title> <?php echo("Panel "); getTitle(); ?> </title>

    <!-- Bootstrap core CSS -->
    <link href="/FM/include/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/FM/include/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/FM/css/theme.css" rel="stylesheet">

    <!-- Archivo para la validacion de datos-->
    <script type="text/javascript" src="/FM/requiere/js/script.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/FM/include/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/FM/include/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
  <?php menuAdmin(); ?>
	<!--Inicia el contenido de la web de administrador-->
    <div class="container theme-showcase" role="main">	 

  <h1>Datos de Facturacion</h1>    
  <br>
	<!-- Inicia Tabla responsive-->
	<div class="table-responsive">
		<table class="table">
  		<thead>
    		<tr>
      		<!--<th>ID</th>-->
      		<th>Razon Social</th>
      		<th>RFC</th>      		      		
      		<th>Direccion</th>
          <th>Codigo Postal</th>      		
      		<th>Municipio</th>
          <th>Estado</th>
          <th>Pais</th>
          <th>Status</th>
          <th>Modificar</th>
          <th>Baja</th>
    		</tr>
  		</thead>
  		
        <?php infoTablaFacturacion();  ?>  		  
		</table>
	</div>
	<!--Termina Tabla responsive-->
	<a href='index.php?ADD=true'><button class="btn btn-primary">Nueva Empresa</button></a>
	<!-- Aqui va el formulario -->
    <?php 
    if(!is_null($_REQUEST['ADD']) && $_REQUEST['ADD']=="true"){
      // Aqui va la funcion..
        displayNew();
    }else if (!is_null($_REQUEST['ID'])) {
        displayUpdateEF($_REQUEST['ID']);
    }

    ?>
    </div> <!-- /container -->
	<!--Termina el contenido de la web de administrador-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/FM/include/js/bootstrap.min.js"></script>
    <script src="/FM/include/js/docs.min.js"></script>
	
  </body>
</html>
