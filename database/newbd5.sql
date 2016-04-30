-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2016 at 07:06 AM
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
-- Table structure for table `bloques`
--

CREATE TABLE IF NOT EXISTS `bloques` (
  `idbloque` varchar(20) COLLATE utf8_bin NOT NULL,
  `bloque` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bloques`
--

INSERT INTO `bloques` (`idbloque`, `bloque`, `tipo`, `contenido`) VALUES
('mission', 'Mission de la Empresa', 0, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem voluptatibus architecto laudantium accusantium illum quibusdam officiis minima fugit! Vitae excepturi voluptatibus necessitatibus maiores, maxime omnis totam fuga dolor distinctio laudantium?</p>');

-- --------------------------------------------------------

--
-- Table structure for table `categoria_producto`
--

CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `idcategoria` (`idcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categoria_producto`
--

INSERT INTO `categoria_producto` (`idcategoria`, `nombre`) VALUES
(1, 'Almacenamiento'),
(2, 'Quimicos'),
(3, 'Biodigestores'),
(4, 'Fosas Septicas'),
(5, 'Dosificadores'),
(6, 'Pastillas Hipoclorito');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `imagenes`
--

INSERT INTO `imagenes` (`idimagen`, `img`, `ruta`, `categoria`) VALUES
(1, 'Imagen test 1', '/sinhco/uploads/images/Slider-566f1ba1b55fe1.10941682.jpg', 'Slider'),
(3, 'woot', '/sinhco/modulos/modadminslider/../../uploads/images/Slider-57201e5e9926f8.66327505.jpg', 'slider');

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
(2, 1, 'Menus', 'dashboard/adminmenu', 'list', 3),
(2, 2, 'Usuarios', 'dashboard/usuarios', 'group', 4),
(2, 3, 'Modulos', 'dashboard/modulos', 'view_module', 1),
(2, 4, 'Bloques', 'dashboard/bloques', 'picture_in_picture', 2),
(2, 5, 'Proyectos', 'dashboard/adminproyectos', 'build', 7),
(2, 6, 'Slider', 'dashboard/adminslider', 'collections', 5),
(2, 7, 'Productos', 'ashboard/adminproductos', 'add_shopping_cart', 6),
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
('adminproductos', 'Administrador de Productos', 1, ''),
('adminproyectos', 'Administrador de Proyectos', 1, ''),
('adminslider', 'Administrador de Slider', 1, ''),
('bloques', 'Administracion de Bloques', 1, ''),
('crearbloque', 'Creación de Bloque', 1, ''),
('crearproyecto', 'Creacion de Proyecto', 1, ''),
('dashboard', 'Informacion', 1, ''),
('inicio', 'Inicio', 1, ''),
('login', 'login', 1, ''),
('modulos', 'Administrador de Modulos', 1, ''),
('proyectos', 'Proyectos', 1, ''),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre`, `estado`, `precio`, `descripcion`, `idproveedor`, `idcategoria`) VALUES
(1, 'Cisterna 1700L', 1, 6000, 'Capacidad: 1700 litros', 1, 1),
(2, 'Planta purifiadora de agua', 1, 5000, 'Purifica el agua', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `categoria` varchar(80) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproveedor`),
  UNIQUE KEY `idproveedor` (`idproveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `nombre`, `categoria`) VALUES
(1, 'Rotoplas', 'Almacenamiento'),
(2, 'Norweco', 'Dosificadores');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `lugar` varchar(100) COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `idusuario` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre`, `lugar`, `fecha`, `contenido`, `idusuario`) VALUES
(1, 'Cambio cubierta de techo', 'Gildan Choltex', '2013-01-05', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in tempor lacus. Vivamus ut urna sit amet lacus gravida maximus. Vestibulum maximus est id metus vulputate blandit. In lorem dui, eleifend vitae laoreet tincidunt, placerat quis ex. Maecenas ornare ligula venenatis finibus sodales. In maximus est in ligula euismod, at condimentum libero molestie. Donec sit amet lobortis ligula, et rutrum sem.', 'admin'),
(2, 'Construcción de Laboratorio PDD y remodelación de Lab. Técnico', 'Gildan Hosiery', '2012-09-26', 'Nulla pellentesque porttitor massa, nec malesuada ante volutpat malesuada. Nam turpis ligula, ultricies a luctus dapibus, imperdiet non eros. Fusce consequat nisl quis posuere malesuada. Quisque suscipit ligula vitae mi efficitur molestie. Curabitur mattis ipsum neque, vitae sagittis lacus cursus posuere. Nulla porttitor mi a tortor rhoncus, id blandit velit consequat.', 'admin'),
(3, 'Construcción canales de concreto', 'Gildan Hosiery Factory', '2011-05-13', 'Pellentesque mollis maximus quam eget egestas. Pellentesque non risus orci. Maecenas mattis, massa ut imperdiet mattis, orci augue convallis risus, eu tempus augue arcu non tortor. Vestibulum porttitor mattis velit eu feugiat. Aenean neque felis, porttitor in magna sodales, consectetur euismod ligula. ', 'admin'),
(14, 'Cimentancion para Tanque contra Incendios', 'Gildan Honduras', '2015-04-08', 'undefined', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_img`
--

CREATE TABLE IF NOT EXISTS `proyectos_img` (
  `idproyecto` int(11) NOT NULL,
  `idproyectoimg` int(11) NOT NULL AUTO_INCREMENT,
  `proyectoimg` text COLLATE utf8_bin NOT NULL,
  `ruta` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproyecto`),
  UNIQUE KEY `idproyectoimg` (`idproyectoimg`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `proyectos_img`
--

INSERT INTO `proyectos_img` (`idproyecto`, `idproyectoimg`, `proyectoimg`, `ruta`) VALUES
(1, 1, 'proyecto1', 'uploads/images/proyecto1.jpg'),
(2, 2, 'proyecto2', 'uploads/images/proyecto2.jpg'),
(3, 3, 'proyecto 3', 'uploads/images/proyecto3.jpg'),
(14, 4, 'proyecto 4', 'uploads/images/proyecto4.jpg');

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

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`idslider`, `nombre`) VALUES
(0, 'Slider Principal');

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

--
-- Dumping data for table `slider_img_mod`
--

INSERT INTO `slider_img_mod` (`idslider`, `idimagen`, `idmodulo`, `orden`) VALUES
(0, 1, 'inicio', 0),
(0, 3, 'inicio', 1);

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
-- Constraints for table `proyectos_img`
--
ALTER TABLE `proyectos_img`
  ADD CONSTRAINT `proyectos_img_ibfk_1` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`) ON DELETE CASCADE ON UPDATE CASCADE;

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
