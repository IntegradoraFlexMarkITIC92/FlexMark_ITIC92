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
function login($user,$pass){			
	$conClie= mysql_query("SELECT idCliente, count(1) as exist FROM cliente where user='$user' and pass='$pass' and status='A'");
	while($logi=mysql_fetch_array($conClie)){		
		if($logi['exist']==1){			
			$idCliente=$logi['idCliente'];			
			$_SESSION["logged_cliente"] = $idCliente;	
			header("Location: /FM/index.php");
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