<?php
include("../../requiere/consultas.php");
	if(isset($_POST["idCategoriaPadre"]) && $_POST["idCategoriaPadre"]!= 0){
		$idCatPadre=$_POST["idCategoriaPadre"];
		$opciones='<option selected="selected" value="">Seleccione Subcategoria..</option>';
		$consulta= mysql_query("SELECT idCategoria, nombreCategoria FROM categoria WHERE idCatPadre='$idCatPadre' ");		
		while ($infoCat=mysql_fetch_array($consulta)) {
			$opciones.='<option value='.$infoCat["idCategoria"].'>'.$infoCat["nombreCategoria"].'</option>';
		}		
		echo($opciones);
	}else{
		$opciones='<option selected="selected" value="">Seleccione una Categoria..</option>';
	}

?>