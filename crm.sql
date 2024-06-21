-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2024 a las 18:13:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crm`
--

CREATE DATABASE IF NOT EXISTS `crm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `crm`;

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_cat` int(11) NOT NULL,
  `tip_cat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_cat`, `tip_cat`) VALUES
(1, 'Hardware'),
(2, 'Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_daño`
--

CREATE TABLE `detalle_daño` (
  `id_detalle_daño` int(10) NOT NULL,
  `id_daño` int(10) NOT NULL,
  `pasos_solucion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ticket`
--

CREATE TABLE `detalle_ticket` (
  `id_detalle_ticket` int(10) NOT NULL,
  `id_ticket` varchar(150) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `documento` int(12) DEFAULT NULL,
  `id_riesgo` int(10) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `descripcion_detalle` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nitc` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nitc`, `nombre`, `direccion`, `telefono`, `id_estado`) VALUES
(1234567, 'GOOGLE', 'ee.uu', '3254789654', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_est` int(11) NOT NULL,
  `tip_est` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_est`, `tip_est`) VALUES
(1, 'Activo'),
(2, 'Desactivado'),
(3, 'Esperando'),
(4, 'En proceso'),
(5, 'Solucionado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `codigo` int(11) NOT NULL,
  `licencia` varchar(100) NOT NULL,
  `nitc` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_inicial` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`codigo`, `licencia`, `nitc`, `estado`, `fecha_inicial`, `fecha_final`) VALUES
(927, 'k2xSwgJptQVj4Efezs3o', 1234567, 1, '2024-06-21', '2025-06-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas`
--

CREATE TABLE `llamadas` (
  `id_llamada` int(11) NOT NULL,
  `id_ticket` varchar(100) DEFAULT NULL,
  `documento` int(12) NOT NULL,
  `id_daño` int(10) NOT NULL,
  `id_est` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `id_empleado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riesgos`
--

CREATE TABLE `riesgos` (
  `id_riesgo` int(10) NOT NULL,
  `tip_riesgo` varchar(30) NOT NULL,
  `tiempo_atent` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `riesgos`
--

INSERT INTO `riesgos` (`id_riesgo`, `tip_riesgo`, `tiempo_atent`) VALUES
(1, 'Alto', 'Entre 1 y 3 días hábiles'),
(2, 'Medio', 'Entre 5 y 7 días hábiles'),
(3, 'Bajo', 'Entre 8 y 10 días hábiles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_tip_usu` int(11) NOT NULL,
  `tip_usu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_tip_usu`, `tip_usu`) VALUES
(1, 'Admin'),
(2, 'Cliente'),
(3, 'Empleados'),
(4, 'Tecnico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_daño`
--

CREATE TABLE `tipo_daño` (
  `id_daño` int(10) NOT NULL,
  `nombredano` varchar(100) NOT NULL,
  `foto` longblob NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `id_categoria` int(10) NOT NULL,
  `id_riesgos` int(10) NOT NULL,
  `nitc` int(10) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `documento` int(12) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `pin` int(10) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `nitc` int(10) DEFAULT NULL,
  `id_tip_usu` int(10) NOT NULL,
  `id_estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indices de la tabla `detalle_daño`
--
ALTER TABLE `detalle_daño`
  ADD PRIMARY KEY (`id_detalle_daño`),
  ADD KEY `detalle_daño_ibfk_1` (`id_daño`);

--
-- Indices de la tabla `detalle_ticket`
--
ALTER TABLE `detalle_ticket`
  ADD PRIMARY KEY (`id_detalle_ticket`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`nitc`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_est`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `nitc` (`nitc`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `llamadas`
--
ALTER TABLE `llamadas`
  ADD PRIMARY KEY (`id_llamada`),
  ADD KEY `id_est` (`id_est`);

--
-- Indices de la tabla `riesgos`
--
ALTER TABLE `riesgos`
  ADD PRIMARY KEY (`id_riesgo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_tip_usu`);

--
-- Indices de la tabla `tipo_daño`
--
ALTER TABLE `tipo_daño`
  ADD PRIMARY KEY (`id_daño`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_riesgos` (`id_riesgos`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `nitc` (`nitc`),
  ADD KEY `id_tip_usu` (`id_tip_usu`),
  ADD KEY `id_estado` (`id_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_daño`
--
ALTER TABLE `detalle_daño`
  MODIFY `id_detalle_daño` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `detalle_ticket`
--
ALTER TABLE `detalle_ticket`
  MODIFY `id_detalle_ticket` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=928;

--
-- AUTO_INCREMENT de la tabla `llamadas`
--
ALTER TABLE `llamadas`
  MODIFY `id_llamada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `riesgos`
--
ALTER TABLE `riesgos`
  MODIFY `id_riesgo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_tip_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_daño`
--
ALTER TABLE `tipo_daño`
  MODIFY `id_daño` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_daño`
--
ALTER TABLE `detalle_daño`
  ADD CONSTRAINT `detalle_daño_ibfk_1` FOREIGN KEY (`id_daño`) REFERENCES `tipo_daño` (`id_daño`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`nitc`) REFERENCES `empresa` (`nitc`),
  ADD CONSTRAINT `licencia_ibfk_2` FOREIGN KEY (`estado`) REFERENCES `estado` (`id_est`);

--
-- Filtros para la tabla `llamadas`
--
ALTER TABLE `llamadas`
  ADD CONSTRAINT `llamadas_ibfk_3` FOREIGN KEY (`id_est`) REFERENCES `estado` (`id_est`);

--
-- Filtros para la tabla `tipo_daño`
--
ALTER TABLE `tipo_daño`
  ADD CONSTRAINT `tipo_daño_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `tipo_daño_ibfk_2` FOREIGN KEY (`id_riesgos`) REFERENCES `riesgos` (`id_riesgo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`nitc`) REFERENCES `empresa` (`nitc`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_tip_usu`) REFERENCES `roles` (`id_tip_usu`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_est`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
