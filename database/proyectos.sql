-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2016 a las 00:14:41
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
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_bin NOT NULL,
  `contenido` text COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`idproyecto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`idproyecto`, `nombre`, `contenido`, `fecha`) VALUES
(1, 'Cambio cubierta de techo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in tempor lacus. Vivamus ut urna sit amet lacus gravida maximus. Vestibulum maximus est id metus vulputate blandit. In lorem dui, eleifend vitae laoreet tincidunt, placerat quis ex. Maecenas ornare ligula venenatis finibus sodales. In maximus est in ligula euismod, at condimentum libero molestie. Donec sit amet lobortis ligula, et rutrum sem.', '2013-01-05'),
(2, 'Construcción de Laboratorio PDD y remodelación de Lab. Técnico', 'Nulla pellentesque porttitor massa, nec malesuada ante volutpat malesuada. Nam turpis ligula, ultricies a luctus dapibus, imperdiet non eros. Fusce consequat nisl quis posuere malesuada. Quisque suscipit ligula vitae mi efficitur molestie. Curabitur mattis ipsum neque, vitae sagittis lacus cursus posuere. Nulla porttitor mi a tortor rhoncus, id blandit velit consequat.', '2012-09-26'),
(3, 'Construcción canales de concreto', 'Pellentesque mollis maximus quam eget egestas. Pellentesque non risus orci. Maecenas mattis, massa ut imperdiet mattis, orci augue convallis risus, eu tempus augue arcu non tortor. Vestibulum porttitor mattis velit eu feugiat. Aenean neque felis, porttitor in magna sodales, consectetur euismod ligula. ', '2011-05-13');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
