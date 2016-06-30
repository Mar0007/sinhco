-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2016 at 10:06 PM
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
  `descripcion` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idbloque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `bloques`
--

INSERT INTO `bloques` (`idbloque`, `bloque`, `tipo`, `contenido`, `descripcion`) VALUES
('footer', 'Pie de Pagina', 0, '<div class="light-blue darken-4"><div class="container center"><div class="row"><a class="" href="index.html"><img class="logo-footer responsive-img fr-dii fr-draggable" src="/uploads/static/sinhco-white.png"></a><p class="grey-text text-lighten-4">Brindando soluciones reales y pr&aacute;cticas.</p><a class="grey-text text-lighten-4" href="#!"><img class="responsive-img fr-dii fr-draggable" src="/uploads/static/facebook.png"></a>&nbsp; <a class="grey-text text-lighten-4" href="#!"><img class="responsive-img fr-dii fr-draggable" src="/uploads/static/twitter.png"></a>&nbsp; <a class="grey-text text-lighten-4" href="#!"><img class="responsive-img fr-dii fr-draggable" src="/uploads/static/instagram.png"></a></div></div></div>', 'Contenido estatico del pie de la pagina');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
