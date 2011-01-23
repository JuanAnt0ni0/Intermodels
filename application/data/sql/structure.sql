-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-11-2010 a las 14:08:19
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `intermodels`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) DEFAULT NULL,
  `titulo` varchar(60) NOT NULL,
  `contenido` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_photo`
--

CREATE TABLE IF NOT EXISTS `evento_photo` (
  `evento_id` bigint(20) NOT NULL DEFAULT '0',
  `photo_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`evento_id`,`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE IF NOT EXISTS `galeria` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) DEFAULT NULL,
  `titulo` varchar(60) NOT NULL,
  `contenido` text NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria_photo`
--

CREATE TABLE IF NOT EXISTS `galeria_photo` (
  `galeria_id` bigint(20) NOT NULL DEFAULT '0',
  `photo_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`galeria_id`,`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE IF NOT EXISTS `modelo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) DEFAULT NULL,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `nacimiento` date NOT NULL,
  `estatura` mediumint(9) NOT NULL,
  `peso` mediumint(9) NOT NULL,
  `ojos` varchar(30) NOT NULL,
  `cabello` varchar(30) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `sexo` enum('Hombre','Mujer') DEFAULT NULL,
  `pecho` mediumint(9) DEFAULT NULL,
  `cintura` mediumint(9) DEFAULT NULL,
  `cadera` mediumint(9) DEFAULT NULL,
  `torax` mediumint(9) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1003 ;

--
-- Volcar la base de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`id`, `album_id`, `nombres`, `apellidos`, `telefono`, `email`, `nacimiento`, `estatura`, `ojos`, `cabello`, `sexo`, `pecho`, `cintura`, `cadera`, `torax`, `status`, `created_at`, `updated_at`) VALUES
(1001, 5544304417241454913, 'Marga', 'MartÃ­n Diaz', '0000000', 'mail@mail.com', '1993-04-03', 163, 'Marrones', 'CastaÃ±o', 'Mujer', 86, 60, 90, 0, 1, '2010-11-27 18:52:45', '2010-11-27 18:52:46'),
(1002, 5544307439257712993, 'Alvaro', 'Iserte BeltrÃ¡n', '0000000', 'mail@mail.com', '1991-04-03', 176, 'Azul Verde', 'Moreno', 'Hombre', 0, 0, 0, 90, 1, '2010-11-27 19:04:29', '2010-11-27 19:04:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_photo`
--

CREATE TABLE IF NOT EXISTS `modelo_photo` (
  `modelo_id` bigint(20) NOT NULL DEFAULT '0',
  `photo_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`modelo_id`,`photo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `modelo_photo`
--

INSERT INTO `modelo_photo` (`modelo_id`, `photo_id`, `created_at`, `updated_at`) VALUES
(1001, 1001, '2010-11-27 18:58:50', '2010-11-27 18:58:50'),
(1001, 1002, '2010-11-27 18:59:16', '2010-11-27 18:59:16'),
(1001, 1003, '2010-11-27 18:59:36', '2010-11-27 18:59:36'),
(1001, 1004, '2010-11-27 19:00:12', '2010-11-27 19:00:12'),
(1002, 1005, '2010-11-27 19:05:03', '2010-11-27 19:05:03'),
(1002, 1006, '2010-11-27 19:05:26', '2010-11-27 19:05:26'),
(1002, 1007, '2010-11-27 19:06:00', '2010-11-27 19:06:00'),
(1002, 1008, '2010-11-27 19:06:22', '2010-11-27 19:06:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(60) DEFAULT NULL,
  `photo_id` varchar(20) DEFAULT NULL,
  `original` varchar(100) DEFAULT NULL,
  `thumbnail_1` varchar(100) DEFAULT NULL,
  `thumbnail_2` varchar(100) DEFAULT NULL,
  `thumbnail_3` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1009 ;

--
-- Volcar la base de datos para la tabla `photos`
--

INSERT INTO `photos` (`id`, `descripcion`, `photo_id`, `original`, `thumbnail_1`, `thumbnail_2`, `thumbnail_3`, `created_at`, `updated_at`) VALUES
(1001, 'MartÃ­n Diaz, Marga', '5544305977074974562', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFU6UGg_2I/AAAAAAAAACw/0Yxsq--Q-7Y/1web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFU6UGg_2I/AAAAAAAAACw/0Yxsq--Q-7Y/s72/1web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFU6UGg_2I/AAAAAAAAACw/0Yxsq--Q-7Y/s144/1web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFU6UGg_2I/AAAAAAAAACw/0Yxsq--Q-7Y/s288/1web.jpg', '2010-11-27 18:58:50', '2010-11-27 18:58:50'),
(1002, 'MartÃ­n Diaz, Marga', '5544306084443610370', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVAkFMXQI/AAAAAAAAAC0/vBE3mm9DXBk/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVAkFMXQI/AAAAAAAAAC0/vBE3mm9DXBk/s72/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVAkFMXQI/AAAAAAAAAC0/vBE3mm9DXBk/s144/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVAkFMXQI/AAAAAAAAAC0/vBE3mm9DXBk/s288/2web.jpg', '2010-11-27 18:59:15', '2010-11-27 18:59:15'),
(1003, 'MartÃ­n Diaz, Marga', '5544306172507487442', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVFsJQfNI/AAAAAAAAAC4/07zhOU-xP7M/3web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVFsJQfNI/AAAAAAAAAC4/07zhOU-xP7M/s72/3web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVFsJQfNI/AAAAAAAAAC4/07zhOU-xP7M/s144/3web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFVFsJQfNI/AAAAAAAAAC4/07zhOU-xP7M/s288/3web.jpg', '2010-11-27 18:59:36', '2010-11-27 18:59:36'),
(1004, 'MartÃ­n Diaz, Marga', '5544306330521078050', 'http://lh5.ggpht.com/_Qrt_0kzRaa0/TPFVO4yoiSI/AAAAAAAAAC8/fItGZARw3K4/4web.jpg', 'http://lh5.ggpht.com/_Qrt_0kzRaa0/TPFVO4yoiSI/AAAAAAAAAC8/fItGZARw3K4/s72/4web.jpg', 'http://lh5.ggpht.com/_Qrt_0kzRaa0/TPFVO4yoiSI/AAAAAAAAAC8/fItGZARw3K4/s144/4web.jpg', 'http://lh5.ggpht.com/_Qrt_0kzRaa0/TPFVO4yoiSI/AAAAAAAAAC8/fItGZARw3K4/s288/4web.jpg', '2010-11-27 19:00:12', '2010-11-27 19:00:12'),
(1005, 'Iserte BeltrÃ¡n, Alvaro', '5544307585641441122', 'http://lh6.ggpht.com/_Qrt_0kzRaa0/TPFWX8epZ2I/AAAAAAAAADE/hrYOlVpryK4/1web.jpg', 'http://lh6.ggpht.com/_Qrt_0kzRaa0/TPFWX8epZ2I/AAAAAAAAADE/hrYOlVpryK4/s72/1web.jpg', 'http://lh6.ggpht.com/_Qrt_0kzRaa0/TPFWX8epZ2I/AAAAAAAAADE/hrYOlVpryK4/s144/1web.jpg', 'http://lh6.ggpht.com/_Qrt_0kzRaa0/TPFWX8epZ2I/AAAAAAAAADE/hrYOlVpryK4/s288/1web.jpg', '2010-11-27 19:05:03', '2010-11-27 19:05:03'),
(1006, 'Iserte BeltrÃ¡n, Alvaro', '5544307679211897922', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFWdZDlREI/AAAAAAAAADI/lFU5AsVPQbk/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFWdZDlREI/AAAAAAAAADI/lFU5AsVPQbk/s72/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFWdZDlREI/AAAAAAAAADI/lFU5AsVPQbk/s144/2web.jpg', 'http://lh4.ggpht.com/_Qrt_0kzRaa0/TPFWdZDlREI/AAAAAAAAADI/lFU5AsVPQbk/s288/2web.jpg', '2010-11-27 19:05:26', '2010-11-27 19:05:26'),
(1007, 'Iserte BeltrÃ¡n, Alvaro', '5544307823301238770', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWlx1KH_I/AAAAAAAAADM/q_2_WC-HKLY/3web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWlx1KH_I/AAAAAAAAADM/q_2_WC-HKLY/s72/3web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWlx1KH_I/AAAAAAAAADM/q_2_WC-HKLY/s144/3web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWlx1KH_I/AAAAAAAAADM/q_2_WC-HKLY/s288/3web.jpg', '2010-11-27 19:06:00', '2010-11-27 19:06:00'),
(1008, 'Iserte BeltrÃ¡n, Alvaro', '5544307921303674674', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWre6wnzI/AAAAAAAAADQ/9muUAWTr_wA/4web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWre6wnzI/AAAAAAAAADQ/9muUAWTr_wA/s72/4web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWre6wnzI/AAAAAAAAADQ/9muUAWTr_wA/s144/4web.jpg', 'http://lh3.ggpht.com/_Qrt_0kzRaa0/TPFWre6wnzI/AAAAAAAAADQ/9muUAWTr_wA/s288/4web.jpg', '2010-11-27 19:06:22', '2010-11-27 19:06:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(32) NOT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `telefono`, `email`, `password`, `admin`, `status`, `created_at`, `updated_at`) VALUES
(1001, 'Admin', 'Admin', '0000000', 'info@intermodels.es', '63a9f0ea7bb98050796b649e85481845', 1, 1, '2010-11-27 18:47:21', '2010-11-27 18:47:21');

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `evento_photo`
--
ALTER TABLE `evento_photo`
  ADD CONSTRAINT `evento_photo_evento_id_evento_id` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`);

--
-- Filtros para la tabla `galeria_photo`
--
ALTER TABLE `galeria_photo`
  ADD CONSTRAINT `galeria_photo_galeria_id_galeria_id` FOREIGN KEY (`galeria_id`) REFERENCES `galeria` (`id`);

--
-- Filtros para la tabla `modelo_photo`
--
ALTER TABLE `modelo_photo`
  ADD CONSTRAINT `modelo_photo_modelo_id_modelo_id` FOREIGN KEY (`modelo_id`) REFERENCES `modelo` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
