-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2016 a las 03:44:28
-- Versión del servidor: 5.6.15-log
-- Versión de PHP: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloques`
--

CREATE TABLE IF NOT EXISTS `bloques` (
  `idbloque` varchar(20) COLLATE utf8_bin NOT NULL,
  `bloque` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `bloques`
--

INSERT INTO `bloques` (`idbloque`, `bloque`, `tipo`, `contenido`) VALUES
('mission', 'Mission de la Empresa', 0, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem voluptatibus architecto laudantium accusantium illum quibusdam officiis minima fugit! Vitae excepturi voluptatibus necessitatibus maiores, maxime omnis totam fuga dolor distinctio laudantium?</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE IF NOT EXISTS `categoria_producto` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `idcategoria` (`idcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `categoria_producto`
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
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE IF NOT EXISTS `imagenes` (
  `idimagen` int(11) NOT NULL AUTO_INCREMENT,
  `img` text COLLATE utf8_bin NOT NULL,
  `ruta` text COLLATE utf8_bin NOT NULL,
  `categoria` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idimagen`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`idimagen`, `img`, `ruta`, `categoria`) VALUES
(1, 'Imagen test 1', '/sinhco/uploads/images/Slider-566f1ba1b55fe1.10941682.jpg', 'Slider'),
(3, 'woot', '/sinhco/modulos/modadminslider/../../uploads/images/Slider-57201e5e9926f8.66327505.jpg', 'slider'),
(4, 'construccion010715', '/sinhco/modulos/modadminslider/../../uploads/images/Slider-57244414852528.46659308.jpg', 'slider');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`idmenu`, `menu`) VALUES
(2, 'Menu Admin'),
(3, 'Menu Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_detalle`
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
-- Volcado de datos para la tabla `menu_detalle`
--

INSERT INTO `menu_detalle` (`idmenu`, `iditem`, `itemmenu`, `vinculo`, `icono`, `orden`) VALUES
(2, 0, 'Dashboard', 'dashboard/inicio', 'dashboard', 0),
(2, 1, 'Menus', 'dashboard/adminmenu', 'list', 3),
(2, 2, 'Usuarios', 'dashboard/usuarios', 'group', 4),
(2, 3, 'Modulos', 'dashboard/modulos', 'view_module', 1),
(2, 4, 'Bloques', 'dashboard/bloques', 'picture_in_picture', 2),
(2, 5, 'Proyectos', 'dashboard/adminproyectos', 'build', 7),
(2, 6, 'Slider', 'dashboard/adminslider', 'collections', 5),
(2, 7, 'Productos', 'dashboard/adminproductos', 'add_shopping_cart', 6),
(3, 0, 'Inicio', 'inicio', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
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
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`idmodulo`, `modulo`, `tipo`, `contenido`) VALUES
('adminmenu', 'Admin Menu', 1, ''),
('adminproductos', 'Administrador de Productos', 1, ''),
('adminproyectos', 'Administrador de Proyectos', 1, ''),
('adminslider', 'Administrador de Slider', 1, ''),
('bloques', 'Administracion de Bloques', 1, ''),
('crearbloque', 'Creación de Bloque', 1, ''),
('crearmodulo', 'Creacion de Modulo', 1, ''),
('crearproyecto', 'Creacion de Proyecto', 1, ''),
('dashboard', 'Informacion', 1, ''),
('inicio', 'Inicio', 1, ''),
('login', 'login', 1, ''),
('modulos', 'Administrador de Modulos', 1, ''),
('proyectos', 'Proyectos', 1, ''),
('usuarioperfil', 'Perfil del Usuario', 1, ''),
('usuarios', 'Modulo de Usuarios', 1, ''),
('xinicio', 'Inicio', 0, '<p><a class="hide-on-med-and-down floating-btn fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="#sinhco-intro"><span><i class="material-icons">expand_more</i></span></a></p><div class="section" id="sinhco-intro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-2">Sinhco</h2><p class="center light">Especializados en el suministro e instalaci&oacute;n de obras civiles, hidr&aacute;ulicas y el&eacute;ctricas,incluyendo la comercializaci&oacute;n de equipos.</p></div><div class="row"><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">group</i></h2><h5 class="center">La Empresa</h5><p class="light">Conformada por profesionales de la ingenier&iacute;a civil, industrial, mec&aacute;nica, electr&oacute;nica y el&eacute;ctrica con m&aacute;s de 15 a&ntilde;os de experiencia en cada rama, personal t&eacute;cnico y auxiliar calificado.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">shopping_cart</i></h2><h5 class="center">Productos</h5><p class="light">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garant&iacute;as de funcionamiento e instalaci&oacute;n.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">location_on</i></h2><h5 class="center">Vis&iacute;tanos</h5><p class="light">Nuestra sede est&aacute; en San Pedro Sula, Cortes y atendemos en cualquier zona del pa&iacute;s.</p></div></div></div></div><!-- FOR CONTAINER end --><div class="parallax-container z-depth-1"><div class="section no-pad-bot"><div class="parallax"><img style="" class="fr-dii fr-draggable" src="/sinhco/recursos/recursos/img/parallax.jpg"></div></div></div><div class="section indigo-bg"><!-- FOR CONTAINER --><div class="row"><!-- SECTION TITLE --><h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3><p class="center light">Conoce nuestra variedad de productos</p></div><div class="row"><!-- SECTION CONTENT --><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/norweco.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="http://sinhco/productos"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Norweco</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/rotoplas.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Rotoplas</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/fill-rite.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Fill-Rite</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div></div></div><!-- FOR CONTAINER end --><div class="section banner z-depth-1"><div class="container"><h1 class="no-mar-bot thin">Alto control de calidad</h1><h5 class="medium">Contamos con el respaldo de los fabricantes de los equipos que suministramos.</h5><!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>--></div><div class="section"><br></div></div><div class="section" id="outro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-3">Conf&iacute;an en nosotros</h2><p class="center light"><br></p></div><div class="row"><div class="col m12"><ul class="row brand-list"><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/Gildan.png"></li><li class="col s12 m6 l3"><a href="http://google.com" target="_blank"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/collective.jpg"></a></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/colonia.png"></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/antorcha.png"></li></ul></div></div><!-- FOR CONTAINER end --><!-- Modal Structure --><div class="modal" id="modal1"><div class="modal-content no-padding"><div class="row"><div class="col s12 m12 l5 no-padding" id="product-img"><img style="" class="responsive-img fr-dii fr-draggable" src="../recursos/img/tanque.jpg"></div><div class="col s12 m12 l7 description"><span><i class="modal-action modal-close material-icons right">close</i></span><h4 class="">Tanques para Agua y Qu&iacute;micos</h4><h6 class="grey-text text-lighten-1">Almacenamiento</h6><p class="flow-text">Los tanques Rotoplas son ideales para el acopio de agua en granjas durante tiempos de sequ&iacute;a, as&iacute; como para el almacenamiento de melazas, alimentos y m&aacute;s de 300 sustancias qu&iacute;micas tales como: &aacute;cidos, cloruros y fosfatos.</p><div class="section " style="height:30px"><br></div><a class="right btn waves-effect wave-light light-blue accent-4" style="bottom: 45px; right: 24px;">Ver producto</a></div></div></div></div></div>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
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
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idproducto` int(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `precio` int(20) DEFAULT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre`, `estado`, `precio`, `descripcion`, `idproveedor`, `idcategoria`) VALUES
(14, 'asdas', 0, 0, 'aasdas', 1, 1),
(12, 'Prueba', 1, 1, 'para las cat y prov', 2, 2),
(13, 'Fosas septicas rotoplas', 0, 0, 'Para tu caquita chiquitita iita ita ita ita', 1, 4),
(9, 'werwe', 1, 1, 'Ansatsu Kyoushitsu (TV) 2nd Season 1 - Nueva temporada de esta mítica serie en la que los alumnos deben matar a su profesor para evitar que destruya el mundo y conseguir así una recompensa millonaria.', 1, 1),
(10, 'Muy bien y tu', 0, 0, 'Demasiado bien', 1, 1),
(11, 'Maule', 1, 1, 'Borrador', 2, 2),
(15, 'prueba rapida', 0, 0, 'asdas', 1, 1),
(16, 'nuevo', 1, 1, 'zS', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `categoria` varchar(80) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproveedor`),
  UNIQUE KEY `idproveedor` (`idproveedor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `nombre`, `categoria`) VALUES
(1, 'Rotoplas', 'Almacenamiento'),
(2, 'Norweco', 'Dosificadores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores_productos`
--

CREATE TABLE IF NOT EXISTS `proveedores_productos` (
  `idproveedor` int(11) NOT NULL,
  `idproductos` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `lugar` varchar(100) COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `idusuario` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre`, `lugar`, `fecha`, `contenido`, `idusuario`) VALUES
(1, 'Cambio cubierta de techo', 'Gildan Choltex', '2013-01-05', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in tempor lacus. Vivamus ut urna sit amet lacus gravida maximus. Vestibulum maximus est id metus vulputate blandit. In lorem dui, eleifend vitae laoreet tincidunt, placerat quis ex. Maecenas ornare ligula venenatis finibus sodales. In maximus est in ligula euismod, at condimentum libero molestie. Donec sit amet lobortis ligula, et rutrum sem.', 'admin'),
(2, 'Construcción de Laboratorio PDD y remodelación de Lab. Técnico', 'Gildan Hosiery', '2012-09-26', 'Nulla pellentesque porttitor massa, nec malesuada ante volutpat malesuada. Nam turpis ligula, ultricies a luctus dapibus, imperdiet non eros. Fusce consequat nisl quis posuere malesuada. Quisque suscipit ligula vitae mi efficitur molestie. Curabitur mattis ipsum neque, vitae sagittis lacus cursus posuere. Nulla porttitor mi a tortor rhoncus, id blandit velit consequat.', 'admin'),
(3, 'Construcción canales de concreto', 'Gildan Hosiery Factory', '2011-05-13', 'Pellentesque mollis maximus quam eget egestas. Pellentesque non risus orci. Maecenas mattis, massa ut imperdiet mattis, orci augue convallis risus, eu tempus augue arcu non tortor. Vestibulum porttitor mattis velit eu feugiat. Aenean neque felis, porttitor in magna sodales, consectetur euismod ligula. ', 'admin'),
(14, 'Cimentancion para Tanque contra Incendios', 'Gildan Honduras', '2015-04-08', 'undefined', 'admin'),
(15, 'sdfsd', 'fsdf', '2016-04-29', 'undefined', 'admin'),
(16, 'asd', 'sdas', '2016-04-29', 'asdasd', 'admin'),
(17, '', '', '0000-00-00', '', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_img`
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
-- Volcado de datos para la tabla `proyectos_img`
--

INSERT INTO `proyectos_img` (`idproyecto`, `idproyectoimg`, `proyectoimg`, `ruta`) VALUES
(1, 1, 'proyecto1', 'uploads/images/proyecto1.jpg'),
(2, 2, 'proyecto2', 'uploads/images/proyecto2.jpg'),
(3, 3, 'proyecto 3', 'uploads/images/proyecto3.jpg'),
(14, 4, 'proyecto 4', 'uploads/images/proyecto4.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
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
-- Estructura de tabla para la tabla `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `idslider` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idslider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Volcado de datos para la tabla `slider`
--

INSERT INTO `slider` (`idslider`, `nombre`) VALUES
(0, 'Slider Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider_img_mod`
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
-- Volcado de datos para la tabla `slider_img_mod`
--

INSERT INTO `slider_img_mod` (`idslider`, `idimagen`, `idmodulo`, `orden`) VALUES
(0, 1, 'inicio', 0),
(0, 3, 'inicio', 1),
(0, 4, 'proyectos', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_servico`
--

CREATE TABLE IF NOT EXISTS `tipo_servico` (
  `idtiposervicio` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idtiposervicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `password`, `llave`, `fecha_registro`, `estado`, `email`) VALUES
('admin', 'Administrador', '091a0c4a43015ddd2894c422b547a36b4fbaf01b63e8ce147342f107f1ad2b1314e63ebc3c1d4fee0173bdfe5d3aab4a9035e33328683b2d6fbd44af61b750dd', '7f9b72925e990e932c059e048acd053f73faf3b0d9a40be0113d324f2de8d855be2895acd504d522c36003dcde0f6780c367f58867d41990ce2ff51ff1ef9fbc', '2016-03-01 00:00:00', 1, 'javpg@outlook.com');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menu_detalle`
--
ALTER TABLE `menu_detalle`
  ADD CONSTRAINT `menu_detalle_ibfk_1` FOREIGN KEY (`idmenu`) REFERENCES `menus` (`idmenu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyectos_img`
--
ALTER TABLE `proyectos_img`
  ADD CONSTRAINT `proyectos_img_ibfk_1` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idtiposervicio`) REFERENCES `tipo_servico` (`idtiposervicio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `slider_img_mod`
--
ALTER TABLE `slider_img_mod`
  ADD CONSTRAINT `slider_img_mod_ibfk_1` FOREIGN KEY (`idslider`) REFERENCES `slider` (`idslider`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slider_img_mod_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulos` (`idmodulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `slider_img_mod_ibfk_3` FOREIGN KEY (`idimagen`) REFERENCES `imagenes` (`idimagen`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
