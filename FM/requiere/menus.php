<?php
include("conn.php"); 
//  ================= Funcion que crea el menu Administrativo =========================
function menuAdmin(){ ?>	

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
	          <ul class="nav navbar-nav"><li><a href="#">Inicio</a></li>
	  		      <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productos<span class="caret"></span></a>
	              <ul class="dropdown-menu" role="menu">
	                <li class="active"><a href="/FM/cPan/productos/">Administrar productos</a></li>
	                <li><a href="/FM/cPan/productos/cat/">Categorias</a></li>
	                <li><a href="/FM/cPan/productos/promos/">Promociones</a></li>
	              </ul>
	            </li>
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuracion<span class="caret"></span></a>
	                <ul class="dropdown-menu" role="menu">
	                  <li><a href="/FM/cPan/confG/">Empresa</a></li>	
	                  <li><a href="/FM/cPan/confG/General/">General</a></li>
	                  <li><a href="/FM/cPan/confG/DF">Datos Facturacion</a></li>	                  
	                  <li><a href="#">Tipo de Cambio</a></li>
	                </ul>
	             </li>
	             <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<span class="caret"></span></a>
	                <ul class="dropdown-menu" role="menu">
	                  <li><a href="/FM/cPan/usuarios/">Administracion</a></li>	
	                  <li><a href="/FM/cPan/usuarios/deptos/">Deptos</a></li>
	                  <li><a href="/FM/cPan/usuarios/nivel/">Niveles</a></li>	                  
	                </ul>
	             </li>
	             <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Clientes<span class="caret"></span></a>
	                <ul class="dropdown-menu" role="menu">
	                  <li><a href="/FM/cPan/clientes/">Administracion</a></li>	
	                  <li><a href="/FM/cPan/clientes/dir/">Deptos</a></li>
	                  <li><a href="/FM/cPan/clientes/fact/">Niveles</a></li>	                  
	                </ul>
	             </li>
	          </ul>
	      </div>
	    </div>
	    </div>


<?php

}
//======================================== Termina funcion menuAdmin() =================================

?>