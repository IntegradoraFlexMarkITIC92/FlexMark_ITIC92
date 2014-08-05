-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2014 a las 04:22:11
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `flexmark`
--
CREATE DATABASE IF NOT EXISTS `flexmark` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `flexmark`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(45) NOT NULL,
  `nivelCategoria` varchar(45) NOT NULL,
  `idCatPadre` int(11) DEFAULT NULL,
  `status` varchar(2) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombreCategoria`, `nivelCategoria`, `idCatPadre`, `status`) VALUES
(1, 'Computadoras', '1', 0, 'A'),
(2, 'Laptop', '2', 1, 'A'),
(3, 'Desktop', '2', 1, 'A'),
(4, 'Monitores', '1', 0, 'A'),
(5, 'LCD', '2', 4, 'A'),
(6, 'LED', '2', 4, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombre`, `apellido`, `titulo`, `user`, `pass`, `status`) VALUES
(1, 'Fulanito', 'Rueda', 'Sr', 'user', 'mjuyhn', 'A'),
(2, 'Juanita', 'Perez', 'Srita', 'xD', 'mjuyhn', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confgral`
--

CREATE TABLE IF NOT EXISTS `confgral` (
  `idConfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `logo` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `iva` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idConfiguracion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `confgral`
--

INSERT INTO `confgral` (`idConfiguracion`, `logo`, `title`, `iva`, `status`) VALUES
(1, 'NULL', 'flexMark', 16, 'A'),
(2, 'NULL', 'flexApp', 16, 'D'),
(3, 'NULL', 'flexApp 2.0', 16, 'A'),
(4, 'NULL', 'flex', 10, 'D'),
(5, 'NULL', 'flexus', 11, 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosfacturacion`
--

CREATE TABLE IF NOT EXISTS `datosfacturacion` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `depto`
--

CREATE TABLE IF NOT EXISTS `depto` (
  `idDepto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idDepto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `depto`
--

INSERT INTO `depto` (`idDepto`, `nombre`, `status`) VALUES
(1, 'Ventas', 'A'),
(2, 'Almacen', 'A'),
(3, 'Compras', 'A'),
(4, 'Sistemas', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccioncliente`
--

CREATE TABLE IF NOT EXISTS `direccioncliente` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`idEmpleado`, `nombre`, `apellido`, `user`, `pass`, `status`, `idDepto`, `idNivel`, `idEmpresa`) VALUES
(1, 'Administrador', 'Empresa', 'admin', 'frtgbv', 'A', 1, 1, 1),
(2, 'Edwin', 'Barea', 'ebarea', 'frtgbv', 'A', 4, 1, 1),
(3, 'Mario', 'Campos', 'mcampos', 'frtgbv', 'A', 4, 1, 1),
(4, 'Zein', 'Huerta', 'zhuerta', 'frtgbv', 'A', 4, 1, 1),
(5, 'Angel', 'Polanco', 'apolanco', 'frtgbv', 'A', 4, 1, 1),
(6, 'Enrique', 'Puga', 'epuga', 'frtgbv', 'A', 4, 1, 1),
(7, 'Ventas', 'Empresa', 'vempresa', 'frtgbv', 'A', 1, 2, 1),
(8, 'Almacen', 'Empresa', 'aempresa', 'frtgbv', 'A', 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `idConfiguracion` int(11) NOT NULL,
  `idEmpresaFacturacion` int(11) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  KEY `fk_empresas_confGral` (`idConfiguracion`),
  KEY `fk_empresas_empresaFacturacion` (`idEmpresaFacturacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombre`, `direccion`, `idConfiguracion`, `idEmpresaFacturacion`) VALUES
(1, 'flexMark', 'Av Bonampak y Av Colosio, frente a la audi', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresafacturacion`
--

CREATE TABLE IF NOT EXISTS `empresafacturacion` (
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

--
-- Volcado de datos para la tabla `empresafacturacion`
--

INSERT INTO `empresafacturacion` (`idEmpresaFacturacion`, `razonSocial`, `RFC`, `direccion`, `cp`, `municipio`, `estado`, `pais`, `status`) VALUES
(1, 'flexMark SA de CV', 'XEXX010101000', 'Blvd Kukulcan', '77500', 'Benito Juarez', 'Quintana Roo', 'Mexico', 'A'),
(2, 'Frontera Sur SA de CV', 'XEXX010101000', 'Frontera Cun', '77500', 'Benito Juarez', 'Quintana Roo', 'Mexico', 'D'),
(3, 'Operadora de Hoteles de Lujo SA de CV', 'OHL060929NQ7', 'BLVD KUKULCAN KM 20.5 ZH', '77500', 'Benito Juarez', 'Jalisco', 'Mexico', 'D'),
(4, 'mi Razon SA', 'XEXX010101001', 'BLVD KUKULCAN KM 20.5 AV ZH', '77517', 'Benito JuarÃ©z', 'MichoacÃ¡n', 'Mexico', 'D'),
(5, 'amex Post', 'XEXX010101000', 'Bexo Gay', '77500', 'Benito Juarez', 'Estado de MÃ©xico', 'Mexico', 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formaspago`
--

CREATE TABLE IF NOT EXISTS `formaspago` (
  `idformasPago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `cuenta` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  `idCliente` int(11) NOT NULL,
  PRIMARY KEY (`idformasPago`),
  KEY `fk_formasPago_cliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE IF NOT EXISTS `nivel` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`idNivel`, `nombre`, `status`) VALUES
(1, 'admin', 'A'),
(2, 'ventas', 'A'),
(3, 'almacen', 'A'),
(4, 'cliente', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `decripcion Corta` varchar(45) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `descripcion`, `decripcion Corta`, `rutaImg`, `noParte`, `precio`, `existencia`, `exentoIVA`, `rangoMedioMayoreo`, `precioMedioMayoreo`, `rangoMayoreo`, `precioMayoreo`, `status`, `idCategoria`, `idEmpleado`) VALUES
(1, 'Sony Vaio con 4 Gb en RAM 250', 'Sony Vaio X1q', '/imgs/Laptop/imgID01.png', 'XEXX0101', 6200, 100, 'N', 30, 6050, 50, 5800, 'A', 2, 1),
(2, 'Lenovo B450 con 4 Gb en RAM 320', 'Lenovo B450', '/imgs/Laptop/imgID02.png', 'XEXX0101', 6100, 120, 'N', 30, 6000, 50, 5500, 'A', 2, 1),
(3, 'LCD 19" bla bla bla bla', 'Acer B321', '/imgs/LCD/imgID03.png', 'XEXX0101', 2100, 90, 'N', 10, 2000, 30, 1800, 'A', 5, 1),
(4, 'LED 19" BENQ VLA ', 'BENQ 87', '/imgs/LED/imgID04.png', 'XEXX0101', 1200, 100, 'N', 30, 1100, 50, 1000, 'A', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promocion`
--

CREATE TABLE IF NOT EXISTS `promocion` (
  `idPromocion` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `status` varchar(2) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `descripcionCorta` varchar(45) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  PRIMARY KEY (`idPromocion`),
  KEY `fk_promo_productos` (`idProducto`),
  KEY `fk_promo_empleados` (`idEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciapedido`
--

CREATE TABLE IF NOT EXISTS `referenciapedido` (
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocambio`
--

CREATE TABLE IF NOT EXISTS `tipocambio` (
  `idtipoCambio` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(45) NOT NULL,
  `valorPesos` double NOT NULL,
  `fechaAlta` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`idtipoCambio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipocambio`
--

INSERT INTO `tipocambio` (`idtipoCambio`, `moneda`, `valorPesos`, `fechaAlta`, `status`) VALUES
(1, 'Dolar', 12, '2014-06-26', 'D'),
(2, 'Dolar', 12.5, '2014-06-27', 'D'),
(3, 'Dolar', 12.5, '2014-06-28', 'A');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosfacturacion`
--
ALTER TABLE `datosfacturacion`
  ADD CONSTRAINT `fk_datosfacturacion_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

--
-- Filtros para la tabla `direccioncliente`
--
ALTER TABLE `direccioncliente`
  ADD CONSTRAINT `fk_direccioncliente_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_depto` FOREIGN KEY (`idDepto`) REFERENCES `depto` (`idDepto`),
  ADD CONSTRAINT `fk_empleado_empresa` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `fk_empleado_nivel` FOREIGN KEY (`idNivel`) REFERENCES `nivel` (`idNivel`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresas_confGral` FOREIGN KEY (`idConfiguracion`) REFERENCES `confgral` (`idConfiguracion`),
  ADD CONSTRAINT `fk_empresas_empresaFacturacion` FOREIGN KEY (`idEmpresaFacturacion`) REFERENCES `empresafacturacion` (`idEmpresaFacturacion`);

--
-- Filtros para la tabla `formaspago`
--
ALTER TABLE `formaspago`
  ADD CONSTRAINT `fk_formasPago_cliente` FOREIGN KEY (`idCliente`) REFERENCES `direccioncliente` (`idDireccion`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_tipoCambio` FOREIGN KEY (`idtipoCambio`) REFERENCES `tipocambio` (`idtipoCambio`),
  ADD CONSTRAINT `fk_pedido_usuarios` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `fk_producto_empleados` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`);

--
-- Filtros para la tabla `promocion`
--
ALTER TABLE `promocion`
  ADD CONSTRAINT `fk_promo_empleados` FOREIGN KEY (`idEmpleado`) REFERENCES `empleado` (`idEmpleado`),
  ADD CONSTRAINT `fk_promo_productos` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `referenciapedido`
--
ALTER TABLE `referenciapedido`
  ADD CONSTRAINT `fk_rP_Pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `fk_rP_Producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);
