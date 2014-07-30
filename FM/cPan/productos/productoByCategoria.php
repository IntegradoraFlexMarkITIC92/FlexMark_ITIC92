<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
  </head>

  <body>    
    <script src="/FM/js/script.js"></script>
	
  </body>
</html>

<?php
error_reporting(0);
include("../../requiere/conn.php");
if(isset($_POST["idSubCategoria"]) && $_POST["idSubCategoria"]!= 0){
	$idSubCat=$_POST["idSubCategoria"];
	$opciones='<p>Seleccione</p> <br>';
	$consulta= mysql_query("SELECT idProducto, descripcion FROM producto WHERE idCategoria='$idSubCat' ");		
	while ($infoPro=mysql_fetch_array($consulta)) {
		$opciones.='<p>'.$infoPro["idProducto"].'.- '.$infoPro["descripcion"].'</p><br><br>';
	}
	echo($opciones)	;
}
?>