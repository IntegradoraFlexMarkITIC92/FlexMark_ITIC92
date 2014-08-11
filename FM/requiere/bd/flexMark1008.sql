CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombreCategoria` varchar(45) NOT NULL,
  `nivelCategoria` varchar(45) NOT NULL,
  `idCatPadre` int(11) DEFAULT NULL,
  `status` varchar(2) NOT NULL
  ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `confgral` (
  `idConfiguracion` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `logo` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `iva` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
  ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `datosfacturacion` (
  `idDatosFacturacion` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `razonSocial` varchar(45) NOT NULL,
  `RFC` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `depto` (
  `idDepto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
  ) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `direccioncliente` (
  `idDireccion` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `direccion` varchar(45) NOT NULL,
  `calle` varchar(45) DEFAULT NULL,
  `municipio` varchar(45) NOT NULL,
  `delegacion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `empleado` (
  `idEmpleado` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idDepto` int(11) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `idConfiguracion` int(11) NOT NULL,
  `idEmpresaFacturacion` int(11) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `empresafacturacion` (
  `idEmpresaFacturacion` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `razonSocial` varchar(45) NOT NULL,
  `RFC` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `formaspago` (
  `idformasPago` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `cuenta` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idCliente` int(11) NOT NULL
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `imgproductos` (
  `idImgProducto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `url` varchar(85) NOT NULL,
  `predeterminada` varchar(1) DEFAULT NULL,
  `idProducto` int(11) NOT NULL
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `nivel` (
  `idNivel` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `pedido` (
  `idPedido` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fechaPedido` date NOT NULL,
  `statusPago` varchar(45) NOT NULL,
  `subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `total` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idtipoCambio` int(11) NOT NULL
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `descripcionCorta` varchar(45) NOT NULL,
  `noParte` varchar(45) DEFAULT NULL,
  `precio` double NOT NULL,
  `existencia` int(11) NOT NULL,
  `exentoIVA` varchar(2) NOT NULL DEFAULT 'N',
  `rangoMedioMayoreo` int(11) NOT NULL,
  `precioMedioMayoreo` double NOT NULL,
  `rangoMayoreo` int(11) NOT NULL,
  `precioMayoreo` double NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'A',
  `idCategoria` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `promocion` (
  `idPromocion` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `status` varchar(2) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `descripcionCorta` varchar(45) NOT NULL,
  `img` varchar(60) DEFAULT NULL,
  `idProducto` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `referenciapedido` (
  `idreferenciaPedido` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cantidad` double NOT NULL,
  `total` double NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `descuento` double DEFAULT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `tipocambio` (
  `idtipoCambio` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `moneda` varchar(45) NOT NULL,
  `valorPesos` double NOT NULL,
  `fechaAlta` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB;


ALTER TABLE `datosfacturacion`
  ADD CONSTRAINT `fk_datosfacturacion_cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

ALTER TABLE `direccioncliente`
  ADD CONSTRAINT `fk_direccioncliente_cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_depto` FOREIGN KEY (`idDepto`) REFERENCES `depto` (`idDepto`),
  ADD CONSTRAINT `fk_empleado_empresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `fk_empleado_nivel` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`idNivel`);

ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresas_confGral` FOREIGN KEY (`idConfiguracion`) REFERENCES `confgral` (`idConfiguracion`),
  ADD CONSTRAINT `fk_empresas_empresaFacturacion` FOREIGN KEY (`idEmpresaFacturacion`) REFERENCES `empresafacturacion` (`idEmpresaFacturacion`);

ALTER TABLE `formaspago`
  ADD CONSTRAINT `fk_formasPago_cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

ALTER TABLE `imgproductos`
  ADD CONSTRAINT `fk_img_productos` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_tipoCambio` FOREIGN KEY (`idtipoCambio`) REFERENCES `tipocambio` (`idtipoCambio`),
  ADD CONSTRAINT `fk_pedido_usuarios` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_producto_empleados` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`);

ALTER TABLE `promocion`
  ADD CONSTRAINT `fk_promo_empleados` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`),
  ADD CONSTRAINT `fk_promo_productos` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

ALTER TABLE `referenciapedido`
  ADD CONSTRAINT `fk_rP_Pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `fk_rP_Producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

-- Insert table confgral
INSERT INTO confgral VALUES ('0','imgUpload/imgLogos/your-logo.jpg','flexMark online','16','A');

-- insert table empresafacturacion
INSERT INTO empresafacturacion VALUES ('0','Tu Razon Social SA de CV','XEXX010101000','Tu direccion','00000','Tu Municipio','Tu estado','Mexico','A');

-- insert table empresa
INSERT INTO empresa VALUES ('0','flexMark','Tu direccion','1','1');

-- Insert table Depto

INSERT INTO depto VALUES ('0','Ventas','A');
INSERT INTO depto VALUES ('0','Almacen','A');
INSERT INTO depto VALUES ('0','Compras','A');
INSERT INTO depto VALUES ('0','Sistemas','A');

-- Insert table Nivel
INSERT INTO nivel VALUES ('0','admin','A');
INSERT INTO nivel VALUES ('0','ventas','A');
INSERT INTO nivel VALUES ('0','almacen','A');
INSERT INTO nivel VALUES ('0','cliente','A');

-- Insert table Empleados
INSERT INTO empleado VALUES ('0','Administrador','Empresa','admin','flexmark','A','1','1','1');
INSERT INTO empleado VALUES ('0','Edwin','Barea','ebarea','admin','A','4','1','1');

-- Insert Cliente
INSERT INTO cliente VALUES ('0','Nombre Cliente','Apellido','Sr','flex','mark','A');
