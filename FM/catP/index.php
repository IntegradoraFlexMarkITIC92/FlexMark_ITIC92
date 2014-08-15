<?php 
error_reporting(0);
session_start();
include("../requiere/consultaFront.php");
include("../requiereFront/menus/menusFront.php");
  

    if($_REQUEST["op"]=="Out"){
         session_destroy(); // destruyo la sesión 
           header("Location: /FM/");
   }  

   if($_REQUEST["conn"]=="now"){
    $u=$_REQUEST["user"];
    $p=$_REQUEST["pass"];
    $url=$_REQUEST["uD"];
    login($u,$p,$url); 
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

    <title> <?php echo("Perfil "); getTitle(); ?> </title>

    <!-- ########################### AQUI EMPIEZA TODO ###################################-->
    <!-- Bootstrap core CSS -->
    <link href="/FM/includeFront/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/FM/includeFront/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/FM/includeFront/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- El bueno -->
    <link href="/FM/includeFront/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/FM/includeFront/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <!-- Imagenes -->
    <link href="/FM/includeFront/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- ########################### AQUI ACABA TODO #######################################-->
          
    <!-- Validacion usuario-->
    <script src="/FM/requiere/js/scriptFront.js"></script>

    <!-- jquery -->
    <script type="text/javascript" src="/FM/js/jquery.js"></script>

    <!--javascript modal-->
    <script type="text/javascript">
      $(document).ready(function(){
        
      });      
    </script>
    <!--javascript modal--> 

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- <script src="/FM/include/js/ie-emulation-modes-warning.js"></script> -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--  <script src="/FM/include/js/ie10-viewport-bug-workaround.js"></script> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
    <div id="wrapper">
      
      <?php nav("null"); ?>

      <div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <!--Inicia el contenido de la web de administrador-->
            <h1 class="page-header">Categorias</h1>                        
            <?php
            if(!is_null($_REQUEST['ctp'])){
              catHijas($_REQUEST['ctp']);
            }else{              
              categotiasView();
            }
            ?>
          </div>
          <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->                        
      </div>
     <!-- /#page-wrapper -->	            

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- jQuery Version 1.11.0 -->
    <script src="/FM/includeFront/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/FM/includeFront/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript importante-->
    <script src="/FM/includeFront/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/FM/includeFront/js/sb-admin-2.js"></script>

    <!-- Morris Charts JavaScript graficas-->
    <script src="/FM/includeFront/js/plugins/morris/raphael.min.js"></script>
    <script src="/FM/includeFront/js/plugins/morris/morris.min.js"></script>
    <script src="/FM/includeFront/js/plugins/morris/morris-data.js"></script>    
	
  </body>
</html>