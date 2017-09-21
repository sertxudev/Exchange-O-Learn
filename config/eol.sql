-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 21-09-2017 a las 23:49:38
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `time`) VALUES
(1, 'Entregar trabajo Ofimática', 'Hay que entregar el trabajo de ofimática sobre access el próximo día 29 de Mayo.', '2017-09-21'),
(2, 'Examen Tema 5 de Inglés', 'El profesor ha puesto el examen de inglés el día 5 de Júnio, además ese mismo día hay que entregar la redacción de la página 42.', '2017-11-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `owner` int(11) UNSIGNED NOT NULL,
  `url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `time` date NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mails`
--

DROP TABLE IF EXISTS `mails`;
CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_to` int(11) UNSIGNED NOT NULL,
  `id_from` int(11) UNSIGNED NOT NULL,
  `subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `isread` tinyint(1) NOT NULL DEFAULT '0',
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mails`
--

INSERT INTO `mails` (`id`, `id_to`, `id_from`, `subject`, `text`, `date`, `isread`, `important`, `status`) VALUES
(1, 2, 7, 'Hello World', 'Este es un mail de prueba', '2017-06-16 21:45:30', 0, 0, 1),
(2, 2, 7, 'Hello World2', 'Este es un mail de prueba2', '2017-06-17 21:45:30', 1, 0, 1),
(3, 2, 7, 'Hello World', 'Este es un mail de prueba', '2017-06-16 12:45:30', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` int(11) UNSIGNED NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(22) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#333',
  `background` varchar(22) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#32fea8',
  `type` int(1) UNSIGNED NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `surname`, `color`, `background`, `type`, `status`) VALUES
(1, 'root', '99adc231b045331e514a516b4b7680f588e3823213abe901738bc3ad67b2f6fcb3c64efb93d18002588d3ccc1a49efbae1ce20cb43df36b38651f11fa75678e8', 'root', 'root', '#333', '#32fea8', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
