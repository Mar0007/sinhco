-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2016 at 02:06 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bd5`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria_producto`
--

CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `idcategoria` (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `idimagen` int(11) NOT NULL AUTO_INCREMENT,
  `img` text COLLATE utf8_bin NOT NULL,
  `ruta` text COLLATE utf8_bin NOT NULL,
  `categoria` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idimagen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`idmenu`, `menu`) VALUES
(2, 'Menu Admin'),
(3, 'Menu Principal');

-- --------------------------------------------------------

--
-- Table structure for table `menu_detalle`
--

CREATE TABLE IF NOT EXISTS `menu_detalle` (
  `idmenu` int(11) NOT NULL,
  `iditem` int(11) NOT NULL,
  `itemmenu` varchar(50) COLLATE utf8_bin NOT NULL,
  `vinculo` text COLLATE utf8_bin NOT NULL,
  `icono` varchar(30) COLLATE utf8_bin NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`idmenu`,`iditem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_detalle`
--

INSERT INTO `menu_detalle` (`idmenu`, `iditem`, `itemmenu`, `vinculo`, `icono`, `orden`) VALUES
(2, 0, 'Dashboard', 'dashboard/inicio', 'dashboard', 0),
(2, 1, 'Menus', 'dashboard/adminmenu', 'list', 1),
(2, 2, 'Usuarios', 'dashboard/usuarios', 'group', 2),
(3, 0, 'Inicio', 'inicio', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
  `idmodulo` varchar(20) COLLATE utf8_bin NOT NULL,
  `modulo` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idmodulo`),
  UNIQUE KEY `idmodulo` (`idmodulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `modulos`
--

INSERT INTO `modulos` (`idmodulo`, `modulo`, `tipo`, `contenido`) VALUES
('adminmenu', 'Admin Menu', 1, ''),
('dashboard', 'Informacion', 1, ''),
('inicio', 'Inicio', 1, ''),
('login', 'login', 1, ''),
('usuarioperfil', 'Perfil del Usuario', 1, ''),
('usuarios', 'Modulo de Usuarios', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text COLLATE utf8_bin NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `fecha` datetime NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tags` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idnoticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  PRIMARY KEY (`idproducto`),
  UNIQUE KEY `idproveedor` (`idproveedor`),
  UNIQUE KEY `idcategoria` (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` int(11) NOT NULL,
  `categoria` varchar(80) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproveedor`),
  UNIQUE KEY `idproveedor` (`idproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `idservicio` int(11) NOT NULL AUTO_INCREMENT,
  `idtiposervicio` int(11) NOT NULL,
  `servicio` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idservicio`),
  UNIQUE KEY `idtiposervicio` (`idtiposervicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `idslider` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idslider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slider_img_mod`
--

CREATE TABLE IF NOT EXISTS `slider_img_mod` (
  `idslider` int(11) NOT NULL,
  `idimagen` int(11) NOT NULL,
  `idmodulo` varchar(20) COLLATE utf8_bin NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`idslider`,`idimagen`,`idmodulo`),
  KEY `idmodulo` (`idmodulo`),
  KEY `idimagen` (`idimagen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_servico`
--

CREATE TABLE IF NOT EXISTS `tipo_servico` (
  `idtiposervicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idtiposervicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idusuario` varchar(50) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(128) COLLATE utf8_bin NOT NULL,
  `llave` varchar(128) COLLATE utf8_bin NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `idusuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `password`, `llave`, `fecha_registro`, `estado`, `email`) VALUES
('admin', 'Administrador', '091a0c4a43015ddd2894c422b547a36b4fbaf01b63e8ce147342f107f1ad2b1314e63ebc3c1d4fee0173bdfe5d3aab4a9035e33328683b2d6fbd44af61b750dd', '7f9b72925e990e932c059e048acd053f73faf3b0d9a40be0113d324f2de8d855be2895acd504d522c36003dcde0f6780c367f58867d41990ce2ff51ff1ef9fbc', '2016-03-01 00:00:00', 1, 'javpg@outlook.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD CONSTRAINT `menu_detalle_ibfk_1` FOREIGN KEY (`idmenu`) REFERENCES `menus` (`idmenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`idproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idcategoria`) REFERENCES `categoria_producto` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idtiposervicio`) REFERENCES `tipo_servico` (`idtiposervicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `slider_img_mod`
--
ALTER TABLE `slider_img_mod`
  ADD CONSTRAINT `slider_img_mod_ibfk_1` FOREIGN KEY (`idslider`) REFERENCES `slider` (`idslider`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slider_img_mod_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulos` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slider_img_mod_ibfk_3` FOREIGN KEY (`idimagen`) REFERENCES `imagenes` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
