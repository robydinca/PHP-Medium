-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 172.21.0.2
-- Tiempo de generación: 06-11-2023 a las 19:07:05
-- Versión del servidor: 8.1.0
-- Versión de PHP: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `exam_u2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `login` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` int NOT NULL,
  `nombre` char(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido1` char(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido2` char(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` char(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`login`, `password`, `salt`, `nombre`, `apellido1`, `apellido2`, `avatar`) VALUES
('root', '9c5ea673add4749f0679526b38bda3f6190b7f934eca95ce18417e053f46b295', -715075, 'Robert', 'sdadsadsa', 'Dinca', './imagenes/root'),
('rootsdadsaads', '339afd427d43f942d4429b93d7367b2e71de0c9e1b9576cb5ceae8b80f727715', -323995, 'Robert', 'sdadsadsa', 'Dinca', './imagenes/rootsdadsaads');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;