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
   
   if(!is_null($_REQUEST['nuevaCG']) && $_REQUEST['nuevaCG']=="ADD"){      
      //Llam2o la funcion de actualizar            
      $logo='NULL' ;
      $title=$_REQUEST['titlee'];
      $iva=$_REQUEST['iva'];
           
      addConfGral($logo,$title,$iva);

    }

    if(!is_null($_REQUEST['STATUS']) && $_REQUEST['STATUS']!="" && !is_null($_REQUEST['IDE']) && $_REQUEST['IDE']!=""){      
      cambiarStatusConf($_REQUEST['IDE'],$_REQUEST['STATUS']);
    }

    if(!is_null($_REQUEST['updateCG']) && $_REQUEST['updateCG']=="update"){    
      //Llamo la funcion de actualizar 
      $title=$_REQUEST['titlee'];
      $iva=$_REQUEST['iva'];
      $id=$_REQUEST['updateID'];           
      
      if(isset($_REQUEST['idDefault'])){
        actualizaConfDefault($id);
      }

      updateConfG($id,$title,$iva);

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
        $dirID="imgUpload/imgLogos/".$id."/";
        
        $dirValidar=$dirDown."".$dirID;                
        
        if(!is_dir($dirValidar)){
          mkdir($dirValidar, 0700);
        }

        $nombreArchivo="imgLogo_ID".$id.".".$extension;


        $destinocompleto=$dirValidar."".$nombreArchivo;
        copy($_FILES['archivo']['tmp_name'], $destinocompleto);

        $destinoBD=$dirID.$nombreArchivo;
        updateDirLogo($id,$destinoBD);
      }
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

    <script type="text/javascript" src="/FM/js/jquery.js"></script>
    <script type="text/javascript" src="/FM/js/bootstrap-filestyle.min.js"> </script>

    <!-- jquery -->    
    <script type="text/javascript">
      $(document).ready(function(){
        $("#categoriaPadre").change(function(){
          var idCategoriaPadre = $("#categoriaPadre").val();          
          $.ajax({
            url:"subCategorias.php",
            type:"POST",
            data:"idCategoriaPadre="+idCategoriaPadre,
            success: function(opciones){
              $("#subCategoria").html(opciones);
            }
          })
        });
      });
                        
      </script>


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

  <h1>Configuracion General de la Aplicacion</h1>    
  <br>
	<!-- Inicia Tabla responsive-->
	<div class="table-responsive">
		<table class="table">
  		<thead>
    		<tr>
      		<!--<th>ID</th>-->
      		<th>Ruta Logo</th>
      		<th>Title</th>      		      		
      		<th>IVA</th>          
          <th>Status</th>
          <th>Logo</th>
          <th>Modificar</th>
          <th>Baja</th>
    		</tr>
  		</thead>
  		
        <?php infoTablaConfG();  ?>  		  
		</table>
	</div>
	<!--Termina Tabla responsive-->
	<a href='index.php?ADD=true'><button class="btn btn-primary">Nueva Config</button></a>
	<!-- Aqui va el formulario -->
    <?php 
    if(!is_null($_REQUEST['ADD']) && $_REQUEST['ADD']=="true"){
      // Aqui va la funcion..
        displayNewConf();
    }else if (!is_null($_REQUEST['ID'])) {
        displayUpdateCG($_REQUEST['ID']);
        
    }

    if (!is_null($_REQUEST['imgID'])) {
        displayImgUpload();
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
