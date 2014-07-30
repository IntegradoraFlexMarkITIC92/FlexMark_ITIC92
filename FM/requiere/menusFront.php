<?php
include("conn.php"); 
//  ================= Funcion que crea el menu del Front =========================
function menuFront(){ ?>	

	    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	    	<div class="container">
	        	<div class="navbar-header">
	          		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            		<span class="sr-only">xD</span>
	            		<span class="icon-bar"></span>
	            		<span class="icon-bar"></span>
	            		<span class="icon-bar"></span>
	          		</button> 
	          		<?php 
	          		$conEmp= mysql_query("SELECT idConfiguracion FROM empresa WHERE idEmpresa='1'");
			  		while ($infoEmp=mysql_fetch_array($conEmp)) {
			  			$idConfiguracion=$infoEmp["idConfiguracion"];
			  			$conConf=mysql_query("SELECT logo FROM confgral WHERE idConfiguracion='$idConfiguracion'");
			  			while ($infoConf=mysql_fetch_array($conConf)) {
			  				$ruta=$infoConf["logo"];
			  			}
			  		}
	          		?>
	          		<a class="navbar-brand" href="#"><img src=<?php echo('"/FM/'.$ruta.'"');?> height="120%" width="100%"></a>
	        	</div>
	        	<div class="navbar-collapse collapse">
	          		<ul class="nav navbar-nav"><li><a href="/FM/index.php">Inicio</a></li>
	  		      		<li class="dropdown">
	              			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Mi cuenta<span class="caret"></span></a>
	              			<ul class="dropdown-menu" role="menu">
	                			<li class="active"><a href="/FM/cPan/productos/">Administrar productos</a></li>
	                			<li><a href="/FM/cPan/productos/cat/">Categorias</a></li>
	                			<li><a href="/FM/cPan/productos/promos/">Promociones</a></li>
	              			</ul>
	            		</li>
	            		<li class="dropdown">
	              			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pedidos<span class="caret"></span></a>
	                		<ul class="dropdown-menu" role="menu">
	                  			<li><a href="/FM/cPan/confG/">Empresa</a></li>	
	                  			<li><a href="/FM/cPan/confG/General/">General</a></li>
	                  			<li><a href="/FM/cPan/confG/DF">Datos Facturacion</a></li>	                  
	                  			<li><a href="#">Tipo de Cambio</a></li>
	                		</ul>
	             		</li>
	          		</ul>

	          		<?php if (($_SESSION["logged_cliente"])){ ?>

		          		<ul class="nav pull-right">
	          				<li class="dropdown" id="menuUser">
	            				<a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogout">
	            					<?php
	            					$conNom = mysql_query('SELECT nombre, apellido FROM cliente where idCliente="'.$_SESSION["logged_cliente"].' " ');
	            					if($infoCli=mysql_fetch_array($conNom)){
	            						echo('<span class="glyphicon glyphicon-user"></span>');
	            						echo("&nbsp &nbsp".$infoCli["nombre"]." ".$infoCli["apellido"]);
	            					}
	            					?>
	            				</a>
	            				<div class="dropdown-menu" style="padding:17px;">
	              					<form class="form-signin" role="form" name="logout" id="formLogout">	              						
	        							<center><a href="index.php?op=Out">LogOut</a></center>
	              					</form>
	            				</div>
	          				</li>
	        	  		</ul>
	        	  	<?php }else{ ?>

		          		<ul class="nav pull-right">
	          				<li class="dropdown" id="menuLogin">
	            				<a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login</a>
	            				<div class="dropdown-menu" style="padding:17px;">
	              					<form class="form-signin" role="form" name="login" id="formLogin">
	              						<h3 class="form-signin-heading"> Acceso </h3>
	                					<input type="input" name="user" class="form-control" placeholder="Usuario" required autofocus><br>
	        							<input type="password" name="pass" class="form-control" placeholder="Contraseña" required><br>         							
	        							<input type="hidden" name="conn" value="">
	        							<button class="btn btn-primary btn-block" type="submit" onclick="validarCliente()">Iniciar Sesion</button>
	              					</form>
	            				</div>
	          				</li>	          					          				
	        	  		</ul>
	        	  		<ul class="nav pull-right">
	        	  			<li class="dropdown" id="registrar">
	          					<button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal_id2">Registro Clientes</button>
	          				</li>
	        	  		</ul>
	        	  	<?php } ?>

	      		</div>
	    	</div>
	    </div>	    

<?php

}
//======================================== Termina funcion menuFront() =================================

?>