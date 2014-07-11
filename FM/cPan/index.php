<?php 
error_reporting(0);
session_start();
//include("requiere/conn.php");
include("../requiere/consultas.php");

if($_REQUEST["conn"]=="now"){
  $u=$_REQUEST["user"];
  $p=$_REQUEST["pass"];
  login($u,$p);  
}

if (($_SESSION["logged_adm"])){
  header("Location: ./confG/index.php");
}

if (($_SESSION["logged_vtas"])){
  header("Location: ./confG/index.php?ID=2");
}

if (($_SESSION["logged_almacen"])){
  header("Location: ./confG/index.php?ID=3");
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
    <link rel="icon" href="./favicon.ico">

    <title> <?php getTitle(); ?> </title>

    <!-- Bootstrap core CSS -->
    <link href="../include/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">

    <!-- Archivo para la validacion de datos-->
    <script type="text/javascript" src="/FM/requiere/js/script.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../include/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../include/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" name='login'>
        <h2 class="form-signin-heading">
          <center>
            <img src="/FM/include/img/logoID1.jpg" height="55%" width="60%"><br><br>
            Acceso al Sistema
          </center>
        </h2>
        <input type="input" name="user" class="form-control" placeholder="User" required autofocus>
        <input type="password" name="pass" class="form-control" placeholder="Password" required> 
        <input type="hidden" name="conn" value=''>       
        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="validar()">Iniciar Sesion</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
