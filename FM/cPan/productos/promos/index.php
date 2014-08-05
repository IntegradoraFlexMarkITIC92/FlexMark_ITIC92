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

  //if para saber el tipo de usuario
  if($_SESSION["logged_adm"]==''){
    if($_SESSION["logged_autori"]==''){
      $idusu=$_SESSION["logged_user"];
    }else{
      $idusu=$_SESSION["logged_autori"];
    }
  }else{
    $idusu=$_SESSION["logged_adm"];           
  }
  //TERMINA if para saber tipo de usuario   
   
   if(!is_null($_REQUEST['nuevaPromo']) && $_REQUEST['nuevaPromo']=="ADD"){      
      //Llamo la funcion de agregar
      $descCorta=$_REQUEST['descCorta'];
      $desc=$_REQUEST['descripcion'];
      $inicio=$_REQUEST['inicio'];
      $fin=$_REQUEST['fin'];
      
      $txtProd=$_REQUEST['valProducto'];      
      $proPartes = explode(".", $txtProd);
      $idProd = $proPartes[0];

      $inicioPartes = explode("/", $inicio);
      $inicioDB = $inicioPartes[2].'-'.$inicioPartes[0].'-'.$inicioPartes[1];

      $finPartes = explode("/", $fin);
      $finDB = $finPartes[2].'-'.$finPartes[0].'-'.$finPartes[1];

      addPromo($inicioDB,$finDB,$desc,$descCorta,$idProd,$idusu);

    }

    if(!is_null($_REQUEST['STATUS']) && $_REQUEST['STATUS']!="" && !is_null($_REQUEST['IDE']) && $_REQUEST['IDE']!=""){      
      cambiarStatusPromo($_REQUEST['IDE'],$_REQUEST['STATUS']);
    }

    if(!is_null($_REQUEST['updPromo']) && $_REQUEST['updPromo']=="upd"){      
      //Llamo la funcion de actualizar  
      $descCorta=$_REQUEST['descCorta'];
      $desc=$_REQUEST['descripcion'];
      $inicio=$_REQUEST['inicio'];
      $fin=$_REQUEST['fin'];          

      $inicioPartes = explode("/", $inicio);
      $inicioDB = $inicioPartes[2].'-'.$inicioPartes[0].'-'.$inicioPartes[1];

      $finPartes = explode("/", $fin);
      $finDB = $finPartes[2].'-'.$finPartes[0].'-'.$finPartes[1];

      updPromo($inicioDB,$finDB,$desc,$descCorta,$_REQUEST["updateID"]);
    }


}

    if ($_POST["action"] == "upload") {
      $id=$_REQUEST['imgID'];

      $tamano = $_FILES["archivo"]['size'];
      $tipo = $_FILES["archivo"]['type'];
      $archivo = $_FILES["archivo"]['name'];
      $trozos = explode(".", $archivo); 
      $extension = end($trozos);
      
      if ($archivo != "") {
        
        $dirDown="../../../";
        $dirID="imgUpload/imgPromos/".$id."/";
        
        $dirValidar=$dirDown."".$dirID;                
        
        if(!is_dir($dirValidar)){
          mkdir($dirValidar, 0700);
        }

        $nombreArchivo="imgPromo_ID".$id.".".$extension;


        $destinocompleto=$dirValidar."".$nombreArchivo;
        copy($_FILES['archivo']['tmp_name'], $destinocompleto);

        $destinoBD=$dirID.$nombreArchivo;
        updateImgPromo($id,$destinoBD);
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

    <!-- Bootstrap CSS and bootstrap datepicker CSS used for styling the demo pages-->
    <link rel="stylesheet" href="/FM/requiere/datepicker/css/datepicker.css">

    <!-- Bootstrap core CSS -->
    <link href="/FM/include/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/FM/include/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/FM/css/theme.css" rel="stylesheet">

    <!-- jquery -->
    <script type="text/javascript" src="/FM/js/jquery.js"></script>

    <script type="text/javascript" src="/FM/requiere/js/script.js"></script>

    <!-- Archivo para la validacion de datos-->
    <script type="text/javascript" src="/FM/requiere/datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/FM/include/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/FM/include/js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="/FM/js/bootstrap-filestyle.min.js"> </script>   
    <script type="text/javascript">
      // When the document is ready
      
    </script>     

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    [endif]-->
  </head>

  <body role="document">
  <?php menuAdmin(); ?>
	<!--Inicia el contenido de la web de administrador-->
    <div class="container theme-showcase" role="main">	 

  <h1>Administracion de Promociones</h1>    
  <br>
	<!-- Inicia Tabla responsive-->
	<div class="table-responsive">
		<table class="table">
  		<thead>
    		<tr>
      		<!--<th>ID</th>-->
      		<th>Descripcion</th>
      		<th>Imagen</th>      		      		
      		<th>Inicia</th>
          <th>Producto</th>      		
      		<th>Termina</th>          
          <th>Status</th>
          <th>Imagenes</th>
          <th>Modificar</th>
          <th>Baja</th>          
    		</tr>
  		</thead>
  		
        <?php infoTablaPromociones();  ?>  		  
		</table>
	</div>
	<!--Termina Tabla responsive-->
	<a href='index.php?ADD=true'><button class="btn btn-primary">Nueva Promocion</button></a>   

	<!-- Aqui va<label formulario -->
    <?php 
    if(!is_null($_REQUEST['ADD']) && $_REQUEST['ADD']=="true"){
      // Aqui va la funcion..
        displayNewPromo();        
      
    }else if (!is_null($_REQUEST['ID'])) {
        displayUpdPromo($_REQUEST['ID']);

    }

    if(!is_null($_REQUEST['imgID'])){
      displayImgUploadPromo(); 
    }    

    ?>
    </div> <!-- /container -->
	<!--Termina el contenido de la web de administrador-->
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <script src="/FM/include/js/bootstrap.min.js"></script>
    <script src="/FM/include/js/docs.min.js"></script>
    <script src="/FM/js/script.js"></script>
	
  </body>
</html>
