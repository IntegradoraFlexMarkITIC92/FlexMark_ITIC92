CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(45) NOT NULL,
  `nivelCategoria` varchar(45) NOT NULL,
  `idCatPadre` int(11) DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

INSERT INTO `categoria` (`idCategoria`, `nombreCategoria`, `nivelCategoria`, `idCatPadre`, `status`) VALUES
(1, 'Computadoras', '1', 0, 'D'),
(2, 'Laptops', '2', 1, 'D'),
(3, 'Desktops', '2', 1, 'D'),
(4, 'Monitores', '1', 0, 'D'),
(5, 'LCD', '2', 4, 'D'),
(6, 'LED', '2', 4, 'D'),
(7, 'Notebook', '2', 1, 'D'),
(8, 'HDMI', '2', 2, 'D'),
(9, 'FULL HD', '2', 2, 'D'),
(10, 'Tablets', '1', 0, 'D'),
(12, '7"', '2', 10, 'D'),
(13, '10"', '2', 10, 'D'),
(14, 'iPad', '1', 0, 'D');
CREATE TABLE `catview` (
`idCategoria` int(11)
,`nombreCategoria` varchar(45)
,`nivelCategoria` varchar(45)
,`padreID` int(11)
,`status` varchar(2)
,`NombrePadre` varchar(45)
);
CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `cliente` (`idCliente`, `nombre`, `apellido`, `titulo`, `user`, `pass`, `status`) VALUES
(1, 'Fulanito', 'Rueda', 'Sr', 'user', 'mjuyhn', 'A'),
(2, 'Juanita', 'Perez', 'Srita', 'xD', 'mjuyhn', 'A'),
(3, 'Gabriela', 'Garcia', 'Sra', 'ggarcia', '12345', 'A'),
(4, 'Carlos', 'Esquivel', 'Sr.', 'cesquivel', 'admin', 'A'),
(5, 'Karina', 'Molina', 'Srita', 'kary', 'molin', 'A'),
(6, 'Jordan', 'Ek', 'Sr', 'jordan', 'ek', 'A');

CREATE TABLE `confgral` (
  `idConfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `iva` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idConfiguracion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

INSERT INTO `confgral` (`idConfiguracion`, `logo`, `title`, `iva`, `status`) VALUES
(1, 'imgUpload/imgLogos/1/imgLogo_ID1.jpg', 'flexMarks', 16, 'D'),
(2, 'imgUpload/imgLogos/2/imgLogo_ID2.jpg', 'flexApp', 16, 'D'),
(3, 'imgUpload/imgLogos/3/imgLogo_ID3.jpg', 'flexApp 2.0', 16, 'A'),
(4, 'imgUpload/imgLogos/4/imgLogo_ID4.jpg', 'flex', 10, 'D'),
(5, 'imgUpload/imgLogos/5/imgLogo_ID5.png', 'flexus', 11, 'D'),
(6, 'imgUpload/imgLogos/6/imgLogo_ID6.jpg', 'Amado', 16, 'D'),
(7, 'imgUpload/imgLogos/7/imgLogo_ID7.png', 'Flex 3.0', 16, 'A');

CREATE TABLE `datosfacturacion` (
  `idDatosFacturacion` int(11) NOT NULL,
  `razonSocial` varchar(45) NOT NULL,
  `RFC` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idCliente` int(11) NOT NULL,
  PRIMARY KEY (`idDatosFacturacion`),
  KEY `fk_datosfacturacion_cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `depto` (
  `idDepto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idDepto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `depto` (`idDepto`, `nombre`, `status`) VALUES
(1, 'Ventas', 'A'),
(2, 'Almacen', 'A'),
(3, 'Compras', 'A'),
(4, 'Sistema', 'A'),
(5, 'Test', 'A');

CREATE TABLE `direccioncliente` (
  `idDireccion` int(11) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `calle` varchar(45) DEFAULT NULL,
  `municipio` varchar(45) NOT NULL,
  `delegacion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idDireccion`),
  KEY `fk_direccioncliente_cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `empleado` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idDepto` int(11) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  PRIMARY KEY (`idEmpleado`),
  KEY `fk_empleado_depto` (`idDepto`),
  KEY `fk_empleado_nivel` (`idNivel`),
  KEY `fk_empleado_empresa` (`idEmpresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

INSERT INTO `empleado` (`idEmpleado`, `nombre`, `apellido`, `user`, `pass`, `status`, `idDepto`, `idNivel`, `idEmpresa`) VALUES
(1, 'Administrador', 'Empresa', 'admin', 'frtgbv', 'A', 1, 1, 1),
(2, 'Edwin', 'Barea', 'ebarea', 'admin', 'A', 4, 1, 1),
(3, 'Mario', 'Campos', 'mcampos', 'frtgbv', 'A', 4, 1, 1),
(4, 'Zein', 'Huerta', 'zhuerta', 'frtgbv', 'A', 4, 1, 1),
(5, 'Angel', 'Polanco', 'apolanco', 'frtgbv', 'A', 4, 1, 1),
(6, 'Enrique', 'Puga', 'epuga', 'frtgbv', 'A', 4, 1, 1),
(7, 'Ventas', 'Empresa', 'vempresa', 'frtgbv', 'A', 1, 2, 1),
(8, 'Almacen', 'Empresa', 'aempresa', 'frtgbv', 'A', 2, 2, 1),
(9, 'Juan Antonio', 'Perez', 'jperez', 'user', 'A', 1, 2, 1);

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `idConfiguracion` int(11) NOT NULL,
  `idEmpresaFacturacion` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  KEY `fk_empresas_confGral` (`idConfiguracion`),
  KEY `fk_empresas_empresaFacturacion` (`idEmpresaFacturacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `empresa` (`idEmpresa`, `nombre`, `direccion`, `idConfiguracion`, `idEmpresaFacturacion`) VALUES
(1, 'flexMark Solution', 'Av Bonampak y Av Colosio, frente a mi casa', 7, 1);

CREATE TABLE `empresafacturacion` (
  `idEmpresaFacturacion` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(45) NOT NULL,
  `RFC` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `municipio` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idEmpresaFacturacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `empresafacturacion` (`idEmpresaFacturacion`, `razonSocial`, `RFC`, `direccion`, `cp`, `municipio`, `estado`, `pais`, `status`) VALUES
(1, 'flexMark SA de CV', 'XEXX010101000', 'Blvd Kukulcan', '77500', 'Benito Juarez', 'Quintana Roo', 'Mexico', 'A'),
(2, 'Frontera Sur SA de CV', 'XEXX010101000', 'Frontera Cun', '77500', 'Benito Juarez', 'Quintana Roo', 'Mexico', 'D'),
(3, 'Operadora de Hoteles de Lujo SA de CV', 'OHL060929NQ7', 'BLVD KUKULCAN KM 20.5 ZH', '77500', 'Benito Juarez', 'Jalisco', 'Mexico', 'D'),
(4, 'mi Razon SA', 'XEXX010101001', 'BLVD KUKULCAN KM 20.5 AV ZH', '77517', 'Benito JuarÃ©z', 'MichoacÃ¡n', 'Mexico', 'D'),
(5, 'amex Post', 'XEXX010101000', 'Bexo Gay', '77500', 'Benito Juarez', 'Estado de MÃ©xico', 'Mexico', 'D');

CREATE TABLE `formaspago` (
  `idformasPago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `cuenta` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idCliente` int(11) NOT NULL,
  PRIMARY KEY (`idformasPago`),
  KEY `fk_formasPago_cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `nivel` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

INSERT INTO `nivel` (`idNivel`, `nombre`, `status`) VALUES
(1, 'admin', 'A'),
(2, 'ventas', 'A'),
(3, 'almacen', 'A'),
(4, 'cliente', 'A'),
(5, 'Testing', 'A');

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechaPedido` date NOT NULL,
  `statusPago` varchar(45) NOT NULL,
  `subtotal` double NOT NULL,
  `IVA` double NOT NULL,
  `total` double NOT NULL,
  `descuento` double DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idtipoCambio` int(11) NOT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `fk_pedido_usuarios` (`idCliente`),
  KEY `fk_pedido_tipoCambio` (`idtipoCambio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `descripcionCorta` varchar(45) NOT NULL,
  `rutaImg` varchar(45) DEFAULT NULL,
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
  `idEmpleado` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `fk_producto_categoria` (`idCategoria`),
  KEY `fk_producto_empleados` (`idEmpleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

INSERT INTO `producto` (`idProducto`, `descripcion`, `descripcionCorta`, `rutaImg`, `noParte`, `precio`, `existencia`, `exentoIVA`, `rangoMedioMayoreo`, `precioMedioMayoreo`, `rangoMayoreo`, `precioMayoreo`, `status`, `idCategoria`, `idEmpleado`) VALUES
(1, 'Sony Vaio con 4 Gb en RAM 250', 'Sony Vaio X1q', '/imgs/Laptop/imgID01.png', 'XEXX0101', 6200, 100, 'N', 30, 6050, 50, 5800, 'A', 2, 1),
(2, 'Lenovo B450 con 4 Gb en RAM 320', 'Lenovo B450', '/imgs/Laptop/imgID02.png', 'XEXX0101', 6100, 120, 'N', 30, 6000, 50, 5500, 'A', 2, 1),
(3, 'LCD 19" bla bla bla bla', 'Acer B321', '/imgs/LCD/imgID03.png', 'XEXX0101', 2100, 90, 'N', 10, 2000, 30, 1800, 'A', 5, 1),
(4, 'LED 19" BENQ VLA ', 'BENQ 87', '/imgs/LED/imgID04.png', 'XEXX0101', 1200, 100, 'N', 30, 1100, 50, 1000, 'A', 6, 1),
(5, 'Asus Color Blanca con 500Gb en HDD, 4GB en RAM, 14", Procesador Intel Core i3', 'Asus', 'NULL', 'aq12ws', 6000, 60, 'N', 5800, 20, 5500, 35, 'A', 3, 2),
(6, 'Lenovo Color Negra con 320Gb en HDD, 2GB en RAM, 14", Procesador Intel Dual Celeron 1.8GHz', 'Lenovo', 'NULL', 'lopoa', 5000, 120, 'S', 4900, 40, 4500, 60, 'A', 2, 6);

CREATE TABLE `promocion` (
  `idPromocion` int(11) NOT NULL AUTO_INCREMENT,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `status` varchar(2) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `descripcionCorta` varchar(45) NOT NULL,
  `img` varchar(60) DEFAULT NULL,
  `idProducto` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  PRIMARY KEY (`idPromocion`),
  KEY `fk_promo_productos` (`idProducto`),
  KEY `fk_promo_empleados` (`idEmpleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `promocion` (`idPromocion`, `inicio`, `fin`, `status`, `descripcion`, `descripcionCorta`, `img`, `idProducto`, `idEmpleado`) VALUES
(1, '2014-07-26', '2014-07-28', 'A', 'Bel Air Cancun', 'Resort & SPA', 'imgUpload/imgPromos/1/imgPromo_ID1.jpg', 2, 2),
(2, '2014-07-30', '2014-07-31', 'A', 'Intel Cerelon Dual Core', 'xxx', 'imgUpload/imgPromos/2/imgPromo_ID2.jpg', 1, 2),
(3, '2014-07-29', '2014-07-31', 'A', 'AMD Feo', 'vvvv', 'imgUpload/imgPromos/3/imgPromo_ID3.jpg', 2, 2),
(4, '2014-07-29', '2014-07-30', 'A', 'Cabos Para Descubir', 'Bel Air Cancun', 'imgUpload/imgPromos/4/imgPromo_ID4.jpg', 6, 2);

CREATE TABLE `referenciapedido` (
  `idreferenciaPedido` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` double NOT NULL,
  `total` double NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `descuento` double DEFAULT NULL,
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  PRIMARY KEY (`idreferenciaPedido`),
  KEY `fk_rP_Pedido` (`idPedido`),
  KEY `fk_rP_Producto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `tipocambio` (
  `idtipoCambio` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(45) NOT NULL,
  `valorPesos` double NOT NULL,
  `fechaAlta` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idtipoCambio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `tipocambio` (`idtipoCambio`, `moneda`, `valorPesos`, `fechaAlta`, `status`) VALUES
(1, 'Dolar', 12, '2014-06-26', 'D'),
(2, 'Dolar', 12.5, '2014-06-27', 'D'),
(3, 'Dolar', 12.5, '2014-06-28', 'A');
DROP TABLE IF EXISTS `catview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `catview` AS select `categoria`.`idCategoria` AS `idCategoria`,`categoria`.`nombreCategoria` AS `nombreCategoria`,`categoria`.`nivelCategoria` AS `nivelCategoria`,`categoria`.`idCatPadre` AS `padreID`,`categoria`.`status` AS `status`,(select `categoria`.`nombreCategoria` from `categoria` where (`categoria`.`idCategoria` = `padreID`)) AS `NombrePadre` from `categoria`;


ALTER TABLE `datosfacturacion`
  ADD CONSTRAINT `fk_datosfacturacion_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

ALTER TABLE `direccioncliente`
  ADD CONSTRAINT `fk_direccioncliente_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_depto` FOREIGN KEY (`idDepto`) REFERENCES `depto` (`idDepto`),
  ADD CONSTRAINT `fk_empleado_empresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `fk_empleado_nivel` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`idNivel`);

ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresas_confGral` FOREIGN KEY (`idConfiguracion`) REFERENCES `confgral` (`idConfiguracion`),
  ADD CONSTRAINT `fk_empresas_empresaFacturacion` FOREIGN KEY (`idEmpresaFacturacion`) REFERENCES `empresafacturacion` (`idEmpresaFacturacion`);

ALTER TABLE `formaspago`
  ADD CONSTRAINT `fk_formasPago_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

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