<?php 
error_reporting(0);
session_start();
include("requiere/consultaFront.php");
include("requiere/menusFront.php");
?>
<?php
  
  if(!is_null($_REQUEST['nuevaCli']) && $_REQUEST['nuevaCli']=="ADD"){      
    //Llamo la funcion de actualizar            
    $nombre=$_REQUEST['nombre'];
    $apellido=$_REQUEST['apellido'];
    $titulo=$_REQUEST['titulo'];
    $user=$_REQUEST['user'];
    $pass=$_REQUEST['pass'];    

    addConfCliente($nombre,$apellido,$titulo,$user,$pass);
  }

  if($_REQUEST["op"]=="Out"){
    session_destroy(); // destruyo la sesión 
    header("Location: /FM/index.php");
  }

  if($_REQUEST["conn"]=="now"){
    $u=$_REQUEST["user"];
    $p=$_REQUEST["pass"];
    login($u,$p);  
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

    <title>
      <?php       
        getTitle();
      ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="include/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="include/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="include/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="include/js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="/FM/js/jquery.js"></script>   
    <script type="text/javascript" src="/FM/js/bootstrap-filestyle.min.js"> </script>

    <!-- jquery -->
    <script type="text/javascript" src="/FM/js/jquery.js"></script>   

    <!--javascript modal-->
    <script type="text/javascript">
      $(document).ready(function(){
        $("#registrar").click(function(){
          $('#modal_id2').modal('show');
        });        
      });      
      //$('#modal_id2').modal({ backdrop: 'static', keyboard: true });
    </script>
    <!--javascript modal-->  

    <script type="text/javascript" src="/FM/requiere/js/scriptFront.js"></script>  

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
  <?php menuFront(); ?>
    
	<!--Inicia el contenido de la web de administrador-->
    <div class="container theme-showcase" role="main">
	
	<!--Inicia carousel-->
	<?php 
    /*$hoy=(date("Y-m-d"));
    echo("Hoy es dia= ".$hoy);*/
    showPromos(); ?>
	<!--Termina carousel-->

  <!-- inicia cuadro modal acceso usaurios -->
  <div class="modal fade" id="modal_id2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">Registro De Clientes.</h4>
        </div>
        <div class="modal-body">
          <!--Aqui va la funcion de registro a clientes-->
          <?php displayNewClientes();  ?>
          <!--Aqui va la funcion de registro a clientes-->
        </div>
        <div class="modal-footer">
                  
        </div>
      </div>
    </div>
  </div>
  <!-- termina cuadro modal acceso usaurios -->

  </div> <!-- /container -->
	<!--Termina el contenido de la web de administrador-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
    <script src="/FM/include/js/bootstrap.min.js"></script>
    <script src="/FM/include/js/docs.min.js"></script>
	
  </body>
</html>
