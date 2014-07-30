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
		$conCount= mysql_query('SELECT count(1) as Contador FROM promocion where status="A" AND fin >= "2014-07-30"');
		if($infoCount=mysql_fetch_array($conCount)){
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
				$conPromos = mysql_query('SELECT * FROM promocion where status="A" AND fin >= "2014-07-30"');
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
	$conUser= mysql_query("SELECT count(1) AS OK, idEmpleado, idNivel, nombre, apellido FROM empleado WHERE user='$user' AND pass='$pass' AND status='A' ");
	while($logi=mysql_fetch_array($conUser)){
		if($logi['OK']==1){
			//echo("Se logeo ".$logi['nombre']." ".$logi['apellido']." con ID: ".$logi['idEmpleado']);
			$op=$logi['idNivel'];
			$idusu=$logi['idEmpleado'];

			switch($op){				
				case 1:$_SESSION["logged_adm"] = $idusu;
						$parametro="index.php";	
				break;

				case 2:$_SESSION["logged_vtas"] = $idusu;
						$parametro="index.php";	
				break;

				case 3:$_SESSION["logged_almacen"] = $idusu;
						$parametro="index.php";	
				break;
			}			
		}else{
			echo("Error de login");
		}			
	}	
}