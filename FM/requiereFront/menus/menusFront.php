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
	          		<a class="navbar-brand" href="index.php"><img src=<?php echo('"/FM/'.$ruta.'"');?> height="120%" width="100%"></a>
	        	</div>	        		          	

	          		<?php if (($_SESSION["logged_cliente"])){ ?>

                        <ul class="nav navbar-top-links navbar-right">                                                       
                            <li class="dropdown">                                
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php 
                                    
                                        $conNom = mysql_query('SELECT nombre, apellido FROM cliente where idCliente="'.$_SESSION["logged_cliente"].' " ');
                                        if($infoCli=mysql_fetch_array($conNom)){
                                            echo('<span class="glyphicon glyphicon-user"></span>');
                                            echo("&nbsp &nbsp".$infoCli["nombre"]." ".$infoCli["apellido"]);
                                        }
                                    
                                    ?>                                    
                                </a>                                
                                <ul class="dropdown-menu dropdown-messages">
                                    <li>
                                        <a href="/FM/my-account/me/"><span class="glyphicon glyphicon-wrench"></span> Editar Perfil</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="index.php?op=Out"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                                    </li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                            <!-- /.dropdown -->
                        </ul>

		          		<!-- <ul class="nav pull-right">
	          				<li class="dropdown" id="menuUser">
	            				<a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogout">
	            					<?php
	            					#$conNom = mysql_query('SELECT nombre, apellido FROM cliente where idCliente="'.$_SESSION["logged_cliente"].' " ');
	            					#if($infoCli=mysql_fetch_array($conNom)){
	            						#echo('<span class="glyphicon glyphicon-user"></span>');
	            						#echo("&nbsp &nbsp".$infoCli["nombre"]." ".$infoCli["apellido"]);
	            					#}
	            					?>
	            				</a>
	            				<div class="dropdown-menu" style="padding:17px;">
	              					<form class="form-signin" role="form" name="logout" id="formLogout">	              						
	        							<center><a href="index.php?op=Out">LogOut</a></center>
	              					</form>
	            				</div>
	          				</li>
	        	  		</ul> -->

	        	  	<?php }else{ ?>

		          		<ul class="nav navbar-top-links navbar-right">
	          				<li class="dropdown" id="menuLogin">
	            				<a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin"><span class="glyphicon glyphicon-user"></span></a>
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
                        <div class="navbar-collapse collapse">
    	        	  		<ul class="nav navbar-top-links navbar-right">
    	        	  			<li class="dropdown" id="registrar">
    	          					<a class="dropdown-toggle" href="#" id="registrar" data-toggle="dropdown" id="navLogin">Registrar</a>
    	          				</li>
    	        	  		</ul>
                        </div>
	        	  	<?php } ?>
	    	</div>
	    </div>	    

<?php

}

?>

<?php 

//======================================== Termina funcion menuFront() =================================

function nav($active){ ?>
	
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.php">
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
            <a class="navbar-brand" href="index.php"><img src=<?php echo('"/FM/'.$ruta.'"');?> height="150%" width="80%"></a>
            </a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">                
                                        
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php 
                                    
                        $conNom = mysql_query('SELECT nombre, apellido FROM cliente where idCliente="'.$_SESSION["logged_cliente"].' " ');
                        if($infoCli=mysql_fetch_array($conNom)){
                            echo('<span class="glyphicon glyphicon-user"></span>');
                            echo("&nbsp".$infoCli["nombre"]." ".$infoCli["apellido"]);
                            echo('&nbsp<span class="fa fa-caret-down"> </span>');
                        }
                                    
                    ?>                    
                </a>
                <ul class="dropdown-menu dropdown-messages">                    
                    <!-- <li class="divider"></li> -->
                    <li>
                        <a href="index.php?op=Out"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->

        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!-- Aqui esta el buscador de productos-->
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <!-- Aqui esta el buscador de producos -->
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                        
                    <li>
                        <a <?php if($active=="categoria"){ echo('class="active"'); } ?> href="#"><i class="fa fa-sitemap fa-fw"></i>Productos por Categoria</a>
                    </li>

                    <li>
                        <a <?php if($active=="perfil"){ echo('class="active"'); } ?>  href="#"><i class="fa fa-wrench fa-fw"></i> Mi perfil<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/FM/my-account/me/index.php">Editar Perfil</a>
                            </li>
                            <li>
                                <a href="/FM/my-account/facturas/index.php">Datos de Facturacion</a>
                            </li>
                            <li>
                                <a href="/FM/my-account/envios/index.php">Datos de Envio</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>                    
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

<?php 

}

?>