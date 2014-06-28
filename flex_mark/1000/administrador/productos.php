<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>Panel administrador productos.</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Flex Mark</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
		  <li><a href="#">Inicio</a></li>
		    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Productoss<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li class="active"><a href="#">Administrar productos</a></li>
                <li><a href="#">Productos en oferta</a></li>
                <li><a href="#">Productos agotados</a></li>
                <!--<li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>-->
              </ul>
            </li>
            <!--<li class="active"><a href="#">Productos.</a></li>-->
            <li><a href="#about">Clientes</a></li>
            <!--<li><a href="#contact">Contact</a></li>-->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">configuracion <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
				<li><a href="#">Colores Tienda</a></li>
                <li><a href="#">Informacion Tienda</a></li>
                <li><a href="#">Slider Promociones Tienda</a></li>
                <!--<li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>-->
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	<!--Inicia el contenido de la web de administrador-->
    <div class="container theme-showcase" role="main">
	
	<!--Inicia carousel-->
			<!--<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="item active">
            <img data-src="holder.js/1140x500/auto/#777:#555/text:Primera imagen." alt="First slide">
          </div>
          <div class="item">
            <img data-src="holder.js/1140x500/auto/#666:#444/text:Segunda imagen." alt="Second slide">
          </div>
          <div class="item">
            <img data-src="holder.js/1140x500/auto/#555:#333/text:Tercera imagen." alt="Third slide">
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>-->
	<!--Termina carousel-->
	
	<!-- Inicia Tabla responsive-->
	<div class="table-responsive">
		<table class="table">
		<thead>
		<tr>
		<th>#</th>
		<th>Productos</th>
		<th>Stock</th>
		<th>Detalles</th>
		<th>Precio</th>
		<th>Moneda</th>
		<th>Modificar</th>
		<th>Agotado</th>
		</tr>
		</thead>
		<tbody>
		<tr>
		<td>1</td>
		<td>Galletas</td>
		<td>4</td>
		<td>Las mas ricas.</td>
		<td>8</td>
		<td>USD</td>
		<td><button type="button" class="btn btn-warning">Modificar</button></td>
		<td><button type="button" class="btn btn-danger">Agotado</button></td>
		</tr>
		<tr>
		<td>2</td>
		<td>Sabritas</td>
		<td>9</td>
		<td>No puedes comer solo una.</td>
		<td>8</td>
		<td>MXN</td>
		<td><button type="button" class="btn btn-warning">Modificar</button></td>
		<td><button type="button" class="btn btn-danger">Agotado</button></td>
		</tr>
		</tbody>
		</table>
	</div>
	<!--Termina Tabla responsive-->
	
	<!--Inicia Formulario Add 1-->
	<form role="form" style="width:400px; margin: 0 auto;">
        <h1>Nuevo Producto</h1>
			<div class="text">*</div>        
        <div class="required-field-block">
            <input type="text" placeholder="Producto" class="form-control">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
        </div>
        
		<div class="form-group">
                            <select id="pref-perpage" class="form-control">
								<option selected="selected" value="2">Stock</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
								<div class="text">*</div>
                        </div>
		
		<div class="required-field-block">
            <input type="text" placeholder="Detalles" class="form-control">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
        </div>
		
		<div class="required-field-block">
            <input type="text" placeholder="Precio" class="form-control">
            <div class="required-icon">
                <div class="text">*</div>
            </div>
        </div>
		
<div class="form-group">
                            <select id="pref-perpage" class="form-control">
								<option selected="selected" value="2">Moneda</option>
                                <option value="3">USD</option>
                                <option value="4">MXN</option>
                            </select>                                
                        </div>
        
        <button class="btn btn-primary">Agregar</button>
    </form>
	<!--Termina Formulario Add 1-->

    </div> <!-- /container -->
	<!--Termina el contenido de la web de administrador-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
	
  </body>
</html>
