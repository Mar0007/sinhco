-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2016 a las 01:35:13
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
  `descripcion` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `bloques`
--

INSERT INTO `bloques` (`idbloque`, `bloque`, `tipo`, `contenido`, `descripcion`) VALUES
('mission', 'Mission de la Empresa', 0, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem voluptatibus architecto laudantium accusantium illum quibusdam officiis minima fugit! Vitae excepturi voluptatibus necessitatibus maiores, maxime omnis totam fuga dolor distinctio laudantium?</p>', '');

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
  `descripcion` varchar(140) COLLATE utf8_bin NOT NULL,
  `alineacion` varchar(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idimagen`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=95 ;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`idimagen`, `img`, `ruta`, `categoria`, `descripcion`, `alineacion`) VALUES
(7, 'Techo panelit', '/sinhco/modulos/modcrearproyecto/../../uploads/images/Proyecto-573dea5a35cb91.35945046.jpg', 'Proyecto', 'se cambio el 20/20/20', ''),
(8, 'Too many friends', '/sinhco/modulos/modcrearproyecto/../../uploads/images/Proyecto-573ded910b7443.52964273.jpg', 'Proyecto', 'Sencillo', ''),
(11, 'Los simpsons', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Productos-574637d437f075.25671228.png', 'Producto', '', ''),
(19, 'Capacitores', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-57433be6ccb3f4.10430856.jpg', 'Producto', 'Pines', ''),
(20, 'Circuito Paralelo', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-57433c026c0792.21006893.jpg', 'Producto', 'Funcionamiento', ''),
(22, 'Encender Led', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-57433cf4f01178.09141305.jpg', 'Producto', 'Usando un switch', ''),
(23, 'Too many friends', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-57433f4408f827.91910213.jpg', 'Producto', 'sencillo', ''),
(24, 'B3', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-57433f5e2dd7b8.39351844.jpg', 'Producto', 'EP', ''),
(25, 'm,,,,,,', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Productos-574636b4ac8d10.89761340.png', 'Producto', '', ''),
(29, 'asdasd', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-5743f8e5ef4f15.91735548.jpg', 'Producto', '', ''),
(33, '', '/sinhco/modulos/modeditslider/../../uploads/images/Slider-5743fda1c72021.88071148.jpg', 'Slider', '', ''),
(34, 'Bobinasssse', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Productos-574c8b11b737e4.80029599.jpg', 'Producto', '', ''),
(35, 'Montando', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-5743fe379f6f32.38327154.jpg', 'Producto', '', ''),
(45, 'dasdsada', '/sinhco/modulos/modeditslider/../../uploads/images/Slider-57463824e16926.85516951.png', 'Slider', '', ''),
(49, 'sdfsd', '/sinhco/modulos/modeditslider/../../uploads/images/Slider-5744a1e7ca0886.42346015.jpg', 'Slider', '', ''),
(90, '', '/sinhco/modulos/modadminslider/../../uploads/images/Slider-57463ee74d9e13.59770217.png', 'Slider', '', ''),
(91, 'sds', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-5746435013eaf6.25126289.png', 'Productos', '', ''),
(92, 'Sky', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-574644b8aabfa1.67495118.png', 'Productos', '', ''),
(93, '', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-574644c90c5034.28878975.png', 'Productos', '', ''),
(94, '', '/sinhco/modulos/modcrearproductos/../../uploads/images/productos/Producto-574644f0b96480.02145990.png', 'Productos', '', '');

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
  `submenus` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idmenu`,`iditem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `menu_detalle`
--

INSERT INTO `menu_detalle` (`idmenu`, `iditem`, `itemmenu`, `vinculo`, `icono`, `orden`, `submenus`) VALUES
(2, 0, 'Dashboard', 'dashboard/inicio', 'dashboard', 0, ''),
(2, 1, 'Menus', 'dashboard/adminmenu', 'list', 3, ''),
(2, 2, 'Usuarios', 'dashboard/usuarios', 'group', 4, ''),
(2, 3, 'Modulos', 'dashboard/modulos', 'view_module', 1, ''),
(2, 4, 'Bloques', 'dashboard/bloques', 'picture_in_picture', 2, ''),
(2, 5, 'Proyectos', 'dashboard/adminproyectos', 'build', 7, ''),
(2, 6, 'Slider', 'dashboard/adminslider', 'collections', 5, ''),
(2, 7, 'Productos', 'dashboard/adminproductos', 'add_shopping_cart', 6, ''),
(3, 0, 'Inicio', 'inicio', '', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE IF NOT EXISTS `modulos` (
  `idmodulo` varchar(20) COLLATE utf8_bin NOT NULL,
  `modulo` varchar(100) COLLATE utf8_bin NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idmodulo`),
  UNIQUE KEY `idmodulo` (`idmodulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `modulos`
--

INSERT INTO `modulos` (`idmodulo`, `modulo`, `tipo`, `contenido`, `descripcion`) VALUES
('adminmenu', 'Admin Menu', 1, '', ''),
('adminproductos', 'Administrador de Productos', 1, '', ''),
('adminproyectos', 'Administrador de Proyectos', 1, '', ''),
('adminslider', 'Administrador de Slider', 1, '', ''),
('bloques', 'Administracion de Bloques', 1, '', ''),
('crearbloque', 'Creación de Bloque', 1, '', ''),
('crearmodulo', 'Creacion de Modulo', 1, '', ''),
('crearproducto', 'crea productos', 1, '', ''),
('crearproyecto', 'Creacion de Proyecto', 1, '', ''),
('dashboard', 'Informacion', 1, '', ''),
('editslider', '', 1, '', ''),
('inicio', 'Inicio', 1, '', ''),
('login', 'login', 1, '', ''),
('modulos', 'Administrador de Modulos', 1, '', ''),
('productos', 'Productos', 1, '', ''),
('proyectos', 'Proyectos', 1, '', ''),
('proyectview', '', 1, '', ''),
('usuarioperfil', 'Perfil del Usuario', 1, '', ''),
('usuarios', 'Modulo de Usuarios', 1, '', ''),
('xinicio', 'Inicio', 0, '<p><a class="hide-on-med-and-down floating-btn fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="#sinhco-intro"><span><i class="material-icons">expand_more</i></span></a></p><div class="section" id="sinhco-intro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-2">Sinhco</h2><p class="center light">Especializados en el suministro e instalaci&oacute;n de obras civiles, hidr&aacute;ulicas y el&eacute;ctricas,incluyendo la comercializaci&oacute;n de equipos.</p></div><div class="row"><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">group</i></h2><h5 class="center">La Empresa</h5><p class="light">Conformada por profesionales de la ingenier&iacute;a civil, industrial, mec&aacute;nica, electr&oacute;nica y el&eacute;ctrica con m&aacute;s de 15 a&ntilde;os de experiencia en cada rama, personal t&eacute;cnico y auxiliar calificado.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">shopping_cart</i></h2><h5 class="center">Productos</h5><p class="light">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garant&iacute;as de funcionamiento e instalaci&oacute;n.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">location_on</i></h2><h5 class="center">Vis&iacute;tanos</h5><p class="light">Nuestra sede est&aacute; en San Pedro Sula, Cortes y atendemos en cualquier zona del pa&iacute;s.</p></div></div></div></div><!-- FOR CONTAINER end --><div class="parallax-container z-depth-1"><div class="section no-pad-bot"><div class="parallax"><img style="" class="fr-dii fr-draggable" src="/sinhco/recursos/recursos/img/parallax.jpg"></div></div></div><div class="section indigo-bg"><!-- FOR CONTAINER --><div class="row"><!-- SECTION TITLE --><h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3><p class="center light">Conoce nuestra variedad de productos</p></div><div class="row"><!-- SECTION CONTENT --><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/norweco.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="http://sinhco/productos"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Norweco</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/rotoplas.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Rotoplas</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/fill-rite.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Fill-Rite</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div></div></div><!-- FOR CONTAINER end --><div class="section banner z-depth-1"><div class="container"><h1 class="no-mar-bot thin">Alto control de calidad</h1><h5 class="medium">Contamos con el respaldo de los fabricantes de los equipos que suministramos.</h5><!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>--></div><div class="section"><br></div></div><div class="section" id="outro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-3">Conf&iacute;an en nosotros</h2><p class="center light"><br></p></div><div class="row"><div class="col m12"><ul class="row brand-list"><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/Gildan.png"></li><li class="col s12 m6 l3"><a href="http://google.com" target="_blank"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/collective.jpg"></a></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/colonia.png"></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/antorcha.png"></li></ul></div></div><!-- FOR CONTAINER end --><!-- Modal Structure --><div class="modal" id="modal1"><div class="modal-content no-padding"><div class="row"><div class="col s12 m12 l5 no-padding" id="product-img"><img style="" class="responsive-img fr-dii fr-draggable" src="../recursos/img/tanque.jpg"></div><div class="col s12 m12 l7 description"><span><i class="modal-action modal-close material-icons right">close</i></span><h4 class="">Tanques para Agua y Qu&iacute;micos</h4><h6 class="grey-text text-lighten-1">Almacenamiento</h6><p class="flow-text">Los tanques Rotoplas son ideales para el acopio de agua en granjas durante tiempos de sequ&iacute;a, as&iacute; como para el almacenamiento de melazas, alimentos y m&aacute;s de 300 sustancias qu&iacute;micas tales como: &aacute;cidos, cloruros y fosfatos.</p><div class="section " style="height:30px"><br></div><a class="right btn waves-effect wave-light light-blue accent-4" style="bottom: 45px; right: 24px;">Ver producto</a></div></div></div></div></div>', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=65 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `nombre`, `estado`, `precio`, `descripcion`, `idproveedor`, `idcategoria`) VALUES
(61, 'Productos', NULL, NULL, 'Venta de productos', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_img`
--

CREATE TABLE IF NOT EXISTS `productos_img` (
  `idproducto` int(11) NOT NULL,
  `idimagen` int(11) NOT NULL,
  PRIMARY KEY (`idimagen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `productos_img`
--

INSERT INTO `productos_img` (`idproducto`, `idimagen`) VALUES
(59, 11),
(58, 16),
(61, 19),
(61, 20),
(61, 22),
(60, 23),
(60, 24),
(59, 25),
(61, 34),
(58, 78),
(58, 79),
(58, 80),
(58, 81),
(58, 82),
(58, 83),
(58, 84),
(58, 85),
(58, 86),
(58, 87),
(58, 88),
(58, 89),
(60, 91),
(64, 92),
(64, 93),
(64, 94);

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
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `lugar` varchar(25) COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idproyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre`, `lugar`, `fecha`, `contenido`) VALUES
(30, 'En el nombre de madre se encierrra la mas alta exp', 'Universidad Catolica de H', '2015-10-20', 'Descripcion del producto'),
(36, 'Cambio de Cubierta de Techoasdasd', 'Gildan Choltexasdasd', '2016-01-05', 'Aqui hay rascacielos\r\nasdadasdasdasd'),
(41, 'Reforma Agraria de vacas ', 'Donde hay vacas', '2016-05-18', 'La vaca y el pollito'),
(44, 'Este es un proyecto', '', '0000-00-00', 'Este sigue siendo el mismo proyecto'),
(45, 'Holis ', 'ayer', '0000-00-00', ''),
(46, 'Holis2', 'lala', '0000-00-00', 'LLL'),
(47, 'Alcantarillado sanitario', 'Gildan', '2016-05-10', 'Proyecto finalizado'),
(48, 'Proyecto #48', 'AQUI', '0000-00-00', 'Para comparar imagene');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_img`
--

CREATE TABLE IF NOT EXISTS `proyectos_img` (
  `idproyecto` int(11) NOT NULL,
  `idimagen` int(11) NOT NULL,
  PRIMARY KEY (`idimagen`),
  KEY `idproyecto` (`idproyecto`),
  KEY `idimagen` (`idimagen`),
  KEY `idproyecto_2` (`idproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `proyectos_img`
--

INSERT INTO `proyectos_img` (`idproyecto`, `idimagen`) VALUES
(30, 126),
(36, 7),
(36, 121),
(41, 5),
(41, 6),
(41, 9),
(46, 8);

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
(0, 33, 'crearproducto', 2),
(0, 45, 'adminproductos', 0),
(0, 90, 'adminslider', 1);

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
  `apellido` varchar(100) COLLATE utf8_bin NOT NULL,
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

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellido`, `password`, `llave`, `fecha_registro`, `estado`, `email`) VALUES
('admin', 'Administrador', '', '091a0c4a43015ddd2894c422b547a36b4fbaf01b63e8ce147342f107f1ad2b1314e63ebc3c1d4fee0173bdfe5d3aab4a9035e33328683b2d6fbd44af61b750dd', '7f9b72925e990e932c059e048acd053f73faf3b0d9a40be0113d324f2de8d855be2895acd504d522c36003dcde0f6780c367f58867d41990ce2ff51ff1ef9fbc', '2016-03-01 00:00:00', 1, 'javpg@outlook.com');

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
  ADD CONSTRAINT `proyectos_img_ibfk_1` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`);

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
