-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2016 a las 23:14:24
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

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyectos_img`
--
ALTER TABLE `proyectos_img`
  ADD CONSTRAINT `proyectos_img_ibfk_1` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
