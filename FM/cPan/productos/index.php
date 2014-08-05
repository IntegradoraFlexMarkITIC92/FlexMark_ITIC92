<?php 
error_reporting(0);
session_start();
include("../../requiere/consultas.php");
include("../../requiere/menus.php");

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
   
   if(!is_null($_REQUEST['nuevoProd']) && $_REQUEST['nuevoProd']=="ADD"){      
      //Llamo la funcion de agregar
      $descCorta=$_REQUEST['descripcionCorta'];
      $desc=$_REQUEST['descripcion'];
      $parte=$_REQUEST['noParte'];
      $precio=$_REQUEST['precio'];
      $exist=$_REQUEST['existencia'];
      $rMM=$_REQUEST['rangoMM'];
      $pMM=$_REQUEST['precioMM'];
      $rM=$_REQUEST['rangoMayoreo'];
      $pM=$_REQUEST['precioMayoreo'];
      $subCat=$_REQUEST['subCategoria']; 
      if(isset($_REQUEST['iva'])){
        $iva="S";
      }else{
        $iva="N";
      }           
      
      addProducto($descCorta,$desc,$parte,$precio,$exist,$rMM,$pMM,$rM,$pM,$subCat,$iva,$idusu);

    }

    if(!is_null($_REQUEST['STATUS']) && $_REQUEST['STATUS']!="" && !is_null($_REQUEST['IDE']) && $_REQUEST['IDE']!=""){      
      cambiarStatusPro($_REQUEST['IDE'],$_REQUEST['STATUS']);
    }

    if(!is_null($_REQUEST['updProd']) && $_REQUEST['updProd']=="upd"){      
      //Llamo la funcion de actualizar            
      $descCorta=$_REQUEST['descripcionCorta'];
      $desc=$_REQUEST['descripcion'];
      $parte=$_REQUEST['noParte'];
      $precio=$_REQUEST['precio'];
      $exist=$_REQUEST['existencia'];
      $rMM=$_REQUEST['rangoMM'];
      $pMM=$_REQUEST['precioMM'];
      $rM=$_REQUEST['rangoMayoreo'];
      $pM=$_REQUEST['precioMayoreo'];
      $subCat=$_REQUEST['subCategoria']; 
      $idProd=$_REQUEST['updateID'];
      if(isset($_REQUEST['iva'])){
        $iva="S";
      }else{
        $iva="N";
      }           
      
      updProducto($descCorta,$desc,$parte,$precio,$exist,$rMM,$pMM,$rM,$pM,$subCat,$iva,$idProd);
    }


}

    if ($_POST["action"] == "upload") {
      
      $id=$_REQUEST['imgID'];      
      $contador = count($_FILES["imagenesProducto"]["name"]);

      $conNumImagenes = mysql_query("SELECT count(1) AS total FROM imgproductos WHERE idProducto='$id'");
      $infoNI= mysql_fetch_array($conNumImagenes);
      $imagenesBD = $infoNI["total"];

      $total = $imagenesBD + $contador;
      
      if($_FILES["imagenesProducto"]["name"][0]!="" and $total <= 6){
        //echo("Subiste ".$contador." archivos<br>");

        $dirDown="../../";
        $dirID="imgUpload/imgProductos/".$id."/";
        
        $dirValidar=$dirDown."".$dirID;                
        
        if(!is_dir($dirValidar)){
          mkdir($dirValidar, 0700);
        }

        for ($i=0; $i < $contador ; $i++) { 
          //echo("Nombre de ".$i." = ".$_FILES["imagenesProducto"]["name"][$i]."<br>");
          $tamano = $_FILES["imagenesProducto"]['size'][$i];
          $tipo = $_FILES["imagenesProducto"]['type'][$i];
          $archivo = $_FILES["imagenesProducto"]['name'][$i];
          $trozos = explode(".", $archivo); 
          $extension = end($trozos);

          $iBD = 0;
          $iBD = $i + $imagenesBD;

          $nombreArchivo="imgProd_".$iBD."_ID".$id.".".$extension;

          $destinocompleto=$dirValidar."".$nombreArchivo;
          copy($_FILES['imagenesProducto']['tmp_name'][$i], $destinocompleto);
          
          $destinoBD=$dirID.$nombreArchivo;
          updateImgProducto($id,$destinoBD);


        }

      }else{
        $total = 6 - $imagenesBD ;
        if($total==0){
          $error_img = "Solo se permiten subir 6 imagenes por producto<br><br>";
        }else{
          $error_img = "Solo puedes subir ".$total." imagenes para este producto<br><br>";          
        }
      }

      /*for ($i=0; $i < $contador ; $i++) { 
        echo("Nombre de ".$i." = ".$_FILES["imagenesProducto"]["name"][$i]."<br>");
      }*/
    
    }

    if(!is_null($_REQUEST['thum']) && !is_null($_REQUEST['imgID']) ){      
      $idImg = $_REQUEST['thum'];
      $conURL = mysql_query("SELECT url FROM imgproductos WHERE idImgProducto='$idImg'");
      $infoID = mysql_fetch_array($conURL);

      unlink("../../".$infoID["url"]);

      $consulta=("DELETE FROM imgproductos WHERE idImgProducto='$idImg'");
      echo($consulta);
      @mysql_query($consulta) or die("No se puede ejecutar la consulta ".$consulta);
      header("Location: ./index.php?imgID=".$_REQUEST['imgID']."");

      //echo("URL a eliminar= ".$infoID["url"]);
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
    <script type="text/javascript" src="/FM/js/jquery.js"></script> 
    <script type="text/javascript">
      $(document).ready(function(){
        $i=0;
        $("#mas").click(function(){
          //alert("Agregas otra");                    
          $i=$i+1;
          $("#mas").before('<input name="archivos[]" id="archivo" type="file" class="filestyle" data-buttonName="btn-primary">  ');
          //$("#archivo").before('<input name="archivo'+$i+'" id="archivo'+$i+'" type="file" class="filestyle" data-buttonName="btn-primary">  ');
        });

         $("#categoriaPadre").change(function(){
          $.ajax({
            url:"subCategorias.php",
            type: "POST",
            data:"idCategoriaPadre="+$("#categoriaPadre").val(),
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
    [endif]-->
  </head>

  <body role="document">
  <?php menuAdmin(); ?>
	<!--Inicia el contenido de la web de administrador-->
    <div class="container theme-showcase" role="main">	 

  <h1>Administracion de Productos</h1>    
  <br>
	<!-- Inicia Tabla responsive-->
	<div class="table-responsive">
		<table class="table">
  		<thead>
    		<tr>
      		<!--<th>ID</th>-->
      		<th>Descripcion</th>
      		<th>Existencia</th>      		      		
      		<th>Precio</th>
          <th>Precio Medio</th>      		
      		<th>Precio Mayoreo</th>          
          <th>Status</th>
          <th>Imagenes</th>
          <th>Modificar</th>
          <th>Baja</th>          
    		</tr>
  		</thead>
  		
        <?php infoTablaPrdocutos();  ?>  		  
		</table>
	</div>
	<!--Termina Tabla responsive-->
	<a href='index.php?ADD=true'><button class="btn btn-primary">Nuevo Producto</button></a>
	<!-- Aqui va el formulario -->
    <?php 
    if(!is_null($_REQUEST['ADD']) && $_REQUEST['ADD']=="true"){
      // Aqui va la funcion..
        displayNewPro();        
    }else if (!is_null($_REQUEST['ID'])) {
        displayUpdPro($_REQUEST['ID']);
    }

    if(!is_null($_REQUEST['imgID'])){ 
      displayImgProductos($_REQUEST['imgID']); 
      displayImgUploadProductos($error_img); 

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
