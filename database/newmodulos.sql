-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2016 at 10:50 PM
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
('crearmodulo', 'Creacion de Modulo', 1, ''),
('xinicio', 'Inicio', 0, '<p><a class="hide-on-med-and-down floating-btn fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="#sinhco-intro"><span><i class="material-icons">expand_more</i></span></a></p><div class="section" id="sinhco-intro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-2">Sinhco</h2><p class="center light">Especializados en el suministro e instalaci&oacute;n de obras civiles, hidr&aacute;ulicas y el&eacute;ctricas,incluyendo la comercializaci&oacute;n de equipos.</p></div><div class="row"><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">group</i></h2><h5 class="center">La Empresa</h5><p class="light">Conformada por profesionales de la ingenier&iacute;a civil, industrial, mec&aacute;nica, electr&oacute;nica y el&eacute;ctrica con m&aacute;s de 15 a&ntilde;os de experiencia en cada rama, personal t&eacute;cnico y auxiliar calificado.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">shopping_cart</i></h2><h5 class="center">Productos</h5><p class="light">Marcas reconocidas y de alta calidad, circunstancia que nos permite manejar un alto control de calidad y ofrecer a nuestros clientes garant&iacute;as de funcionamiento e instalaci&oacute;n.</p></div></div><div class="col s12 m4"><div class=""><h2 class="center light-blue-text text-accent-4"><i class="material-icons" style="font-size:54px">location_on</i></h2><h5 class="center">Vis&iacute;tanos</h5><p class="light">Nuestra sede est&aacute; en San Pedro Sula, Cortes y atendemos en cualquier zona del pa&iacute;s.</p></div></div></div></div><!-- FOR CONTAINER end --><div class="parallax-container z-depth-1"><div class="section no-pad-bot"><div class="parallax"><img style="" class="fr-dii fr-draggable" src="/sinhco/recursos/recursos/img/parallax.jpg"></div></div></div><div class="section indigo-bg"><!-- FOR CONTAINER --><div class="row"><!-- SECTION TITLE --><h3 class="light center blue-grey-text text-darken-2">Nuestros productos</h3><p class="center light">Conoce nuestra variedad de productos</p></div><div class="row"><!-- SECTION CONTENT --><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/norweco.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="http://sinhco/productos"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Norweco</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/rotoplas.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Rotoplas</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div><div class="col s12 m4 l4"><div class="card"><div class="card-image"><img class="fr-dib fr-draggable" style="" src="/sinhco/recursos/recursos/img/fill-rite.png"><a class="card-floating-btn card-fab-btn right btn-floating btn-large light-blue accent-4 z-depth-2 waves-effect wave-light" href="products.html"><span><i class="material-icons">open_in_new</i></span></a></div><div class="card-content"><h2 class="card-title">Fill-Rite</h2><p class="medium grey-text truncate">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse condimentum maximus orci at porttitor.</p></div></div></div></div></div><!-- FOR CONTAINER end --><div class="section banner z-depth-1"><div class="container"><h1 class="no-mar-bot thin">Alto control de calidad</h1><h5 class="medium">Contamos con el respaldo de los fabricantes de los equipos que suministramos.</h5><!--<a href="products.html" class="light-blue-text text-accent-4 medium">VER TODOS LOS PRODUCTOS<span><i class="fix-icon center light-blue-text text-accent-4 material-icons">navigate_next</i></span></a>--></div><div class="section"><br></div></div><div class="section" id="outro"><br></div><div class="section"><!-- FOR CONTAINER end --><div class="row"><!-- SECTION TITLE --><h2 class="light center blue-grey-text text-darken-3">Conf&iacute;an en nosotros</h2><p class="center light"><br></p></div><div class="row"><div class="col m12"><ul class="row brand-list"><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/Gildan.png"></li><li class="col s12 m6 l3"><a href="http://google.com" target="_blank"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/collective.jpg"></a></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/colonia.png"></li><li class="col s12 m6 l3"><img class="fr-dii fr-draggable" style="" src="/sinhco/recursos/recursos/img/antorcha.png"></li></ul></div></div><!-- FOR CONTAINER end --><!-- Modal Structure --><div class="modal" id="modal1"><div class="modal-content no-padding"><div class="row"><div class="col s12 m12 l5 no-padding" id="product-img"><img style="" class="responsive-img fr-dii fr-draggable" src="../recursos/img/tanque.jpg"></div><div class="col s12 m12 l7 description"><span><i class="modal-action modal-close material-icons right">close</i></span><h4 class="">Tanques para Agua y Qu&iacute;micos</h4><h6 class="grey-text text-lighten-1">Almacenamiento</h6><p class="flow-text">Los tanques Rotoplas son ideales para el acopio de agua en granjas durante tiempos de sequ&iacute;a, as&iacute; como para el almacenamiento de melazas, alimentos y m&aacute;s de 300 sustancias qu&iacute;micas tales como: &aacute;cidos, cloruros y fosfatos.</p><div class="section " style="height:30px"><br></div><a class="right btn waves-effect wave-light light-blue accent-4" style="bottom: 45px; right: 24px;">Ver producto</a></div></div></div></div></div>');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
