-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2024 a las 23:45:33
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
CREATE DATABASE IF NOT EXISTS `crm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crm`;
-- --------------------------------------------------------

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

--
-- Volcado de datos para la tabla `detalle_daño`
--

INSERT INTO `detalle_daño` (`id_detalle_daño`, `id_daño`, `pasos_solucion`) VALUES
(1, 1, 'Si el dispositivo está congelado pero aún responde, intenta cerrar todas las aplicaciones y procesos abiertos.'),
(2, 1, 'Si el dispositivo muestra una pantalla azul o está congelado, intenta reiniciarlo presionando y manteniendo el botón de encendido/apagado.'),
(3, 1, 'Si el problema comenzó después de instalar un nuevo software o programa, intenta desinstalarlo.'),
(4, 2, 'Reinicia la computadora en modo seguro, presionando la tecla F8 antes de que Windows se cargue por completo. Esto hará que se cargue lo necesario para eliminar el malware.'),
(5, 2, 'Utiliza un software antivirus confiable y actualizado para realizar un escaneo completo del sistema en busca de malware.'),
(6, 2, 'Una vez que el escaneo esté completo, sigue las instrucciones del antivirus para eliminar cualquier malware detectado. '),
(7, 3, 'Por lo general los archivos o datos eliminados en su mayor medida se pueden encontrar y recuperar en la papelera de reciclaje.'),
(8, 3, 'Si los datos o archivos ya fueron eliminados en su totalidad, debe descargar un software de recuperación de datos confiable y actualizado como: Recuva, EaseUS Data Recovery Wizard, TestDisk, etc.'),
(9, 3, 'Una vez descargado e instalado el software de recuperación de datos, debe seguir las instrucciones proporcionadas por el programa para realizar un escaneo completo del dispositivo.'),
(10, 4, 'Identificar los programas que estén haciendo interferencia, si no logran ser identificados debe cerrar todos los programas que no sean esenciales para la tarea que este realizando.'),
(11, 4, 'Reinicie la computadora, esto puede resolver problemas temporales de interferencia entre programas.'),
(12, 4, 'Asegúrese de que los programas estén instalados en un sistema que cumpla con los requisitos mínimos de hardware y software'),
(13, 5, 'Revisa las conexiones físicas y verifica que los dispositivos estén correctamente conectados a los puertos correspondientes.'),
(14, 5, 'Asegúrate de que haya una buena señal Wi-Fi en el área donde estás intentando conectarte. Puedes probar acercarte al enrutador para mejorar la señal o en su defecto reiniciarlo.'),
(15, 5, 'Prueba conectando el dispositivo a otro puerto USB de tu computadora.'),
(16, 6, 'Asegúrate de que el dispositivo esté ubicado en un lugar bien ventilado y que no esté obstruido por objetos que puedan bloquear las rejillas de ventilación.'),
(17, 6, 'Utiliza aire comprimido o un cepillo suave para limpiar las rejillas de ventilación y lo ventiladores para eliminar el polvo y la suciedad.'),
(18, 6, 'Revisa la carga del procesador verificando si hay programas o procesos que estén utilizando demasiados recursos que esten influyendo en el sobrecalentamiento.'),
(19, 7, 'Asegúrate de que el cable de alimentación esté correctamente enchufado tanto a la toma de corriente como a tu dispositivo (computadora, monitor, etc).'),
(20, 7, 'Si tienes acceso a otra fuente de alimentación compatible con tu dispositivo, intenta usarla para descartar si el problema está en la fuente de alimentación actual.'),
(21, 7, 'Inspecciona los cables de alimentación en busca de posibles cortocircuitos o daños visibles verificando que no haya ningún daño evidente en el cable.'),
(22, 8, 'Revisa la lista de aplicaciones instaladas en el dispositivo y desinstala aquellas que no utilices regularmente o que ocupen mucho espacio en disco.'),
(23, 8, 'Si el dispositivo tiene la capacidad de expandir el almacenamiento mediante tarjetas de memoria, discos duros externos o servicios de almacenamiento en la nube, considera mover archivos grandes o poco utilizados.'),
(24, 8, 'Si el dispositivo tiene almacenamiento limitado y continúa experimentando problemas de espacio, considera la posibilidad de actualizar el disco duro a una unidad de estado sólido (SSD).');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nitc` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nitc`, `nombre`, `direccion`, `telefono`) VALUES
(12345, 'google', 'Estados-Unidos', '3110852930');

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
(2, 'Inactivo');

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
(917, 'kys672BMjlhh#s%hDMoA', 12345, 1, '2024-03-02', '2025-03-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas`
--

CREATE TABLE `llamadas` (
  `id_llamada` int(11) NOT NULL,
  `documento` int(12) NOT NULL,
  `id_cat` int(10) NOT NULL,
  `id_daño` int(10) NOT NULL,
  `id_est` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id_pre` int(10) NOT NULL,
  `id_daño` int(10) NOT NULL,
  `precio` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id_pre`, `id_daño`, `precio`) VALUES
(1, 1, 10000),
(2, 2, 20000),
(3, 3, 30000),
(4, 4, 40000),
(5, 5, 50000),
(6, 6, 60000),
(7, 7, 70000),
(8, 8, 80000);

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
(1, 'Usuario'),
(2, 'Admin'),
(3, 'Empleados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(100) NOT NULL,
  `id_llamada` int(11) NOT NULL,
  `id_riesgo` int(10) NOT NULL,
  `tecnico_a` int(10) NOT NULL,
  `id_precio` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_daño`
--

CREATE TABLE `tipo_daño` (
  `id_daño` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_daño`
--

INSERT INTO `tipo_daño` (`id_daño`, `nombre`) VALUES
(1, 'Pantalla azul o de congelamiento'),
(2, 'Infección de Malware'),
(3, 'Perdida de datos'),
(4, 'Interferencia entre programas'),
(5, 'Problemas de conectividad'),
(6, 'Problemas de temperatura'),
(7, 'Problemas de alimentación'),
(8, 'Problemas de almacenamiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trigger_usuarios`
--

CREATE TABLE `trigger_usuarios` (
  `documento` int(12) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `telefono` int(11) NOT NULL,
  `date` date NOT NULL,
  `user_action` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trigger_usuarios`
--

INSERT INTO `trigger_usuarios` (`documento`, `correo`, `password`, `telefono`, `date`, `user_action`) VALUES
(1105610405, 'jdmolina504@misena.edu.co', '$2y$10$IAU0raEutK2B23laBrlZQOVzbzT25JxLIGwe3GnNyx0q6DHS7.kHS', 357864121, '2024-03-01', 'root@localhost'),
(44354653, 'cesar@gmail.com', '$2y$10$z20I3Mah5/uOSM4WE5l9lup7fd39CywwlYqW0X69wi3Txi8/RHTfu', 546543, '2024-03-01', 'root@localhost'),
(6564, '665hgf', '$2y$10$AghRZIB6gSGm1HiMCzCvI.jNoTx8lo9HY..QaCuE6fMwzvrESbq8e', 66565, '2024-03-01', 'root@localhost'),
(432264, 'cesar@misena', '$2y$10$J9RYSjRKYQzOWhd4y07Nzu.2qxTtgxZjdrrW7WDLrucZsJMa3ATxa', 554456, '2024-03-02', 'root@localhost'),
(1105610405, 'jdmolina504@misena.edu.co', '$2y$10$IAU0raEutK2B23laBrlZQOVzbzT25JxLIGwe3GnNyx0q6DHS7.kHS', 357864121, '2024-03-01', 'root@localhost'),
(44354653, 'cesar@gmail.com', '$2y$10$z20I3Mah5/uOSM4WE5l9lup7fd39CywwlYqW0X69wi3Txi8/RHTfu', 546543, '2024-03-01', 'root@localhost'),
(6564, '665hgf', '$2y$10$AghRZIB6gSGm1HiMCzCvI.jNoTx8lo9HY..QaCuE6fMwzvrESbq8e', 66565, '2024-03-01', 'root@localhost'),
(432264, 'cesar@misena', '$2y$10$J9RYSjRKYQzOWhd4y07Nzu.2qxTtgxZjdrrW7WDLrucZsJMa3ATxa', 554456, '2024-03-02', 'root@localhost'),
(477376, 'gfb@fgbrt', '$2y$10$Q0AQSmH1xM.8Hts7oeonau9GXhhXAIPldikUUJhI0n6rIhI22gO3q', 54634635, '2024-03-21', 'root@localhost'),
(865488787, '656554@bfg', '$2y$10$mDSPNE5IAsOh1PX82AnB2eP8VO5Q/WVT8A9vEXzoVXr1zPMCNwi2y', 6746, '2024-03-21', 'root@localhost');

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
  `id_tip_usu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`documento`, `nombre`, `correo`, `password`, `pin`, `telefono`, `direccion`, `nitc`, `id_tip_usu`) VALUES
(544536534, 'Ana Paul', 'tecnelectrics@gmail.com', '$2y$10$JxS7WQNHhghKjaizEF6igeicoTkYo.UczI1aa9jajXd5GXdnAmIwq', 6535, '3202174961', 'mz casa 145445', 12345, 1),
(654789123, 'santiago', 'santiago@misena', '$2y$10$VSbHEFu/n3X7yN42zNlgm.DLtQre8Q5mKS/O/u0wAMNpRH7cVYYnq', 987654, '311804567', 'mz-casa-11', 12345, 1),
(1104544454, 'brayan', 'brayan@misena', '$2y$10$HImeOt.1u8kVSfQSzd4By.gRY.YMaRuCkIwzoAgdCI37agwsFqbi6', 12345, '3202174961', 'mz-casa-14', 12345, 2);

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `Trigger_usuarios` AFTER DELETE ON `usuario` FOR EACH ROW INSERT INTO trigger_usuarios (documento, correo, password, telefono, date, user_action) 
    VALUES (OLD.documento, OLD.correo, OLD.password, OLD.telefono, CURDATE(), CURRENT_USER())
$$
DELIMITER ;

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
  ADD KEY `documento` (`documento`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_est` (`id_est`),
  ADD KEY `id_daño` (`id_daño`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id_pre`),
  ADD KEY `id_daño` (`id_daño`);

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
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_llamada` (`id_llamada`),
  ADD KEY `id_riesgo` (`id_riesgo`),
  ADD KEY `tecnico_a` (`tecnico_a`),
  ADD KEY `id_precio` (`id_precio`);

--
-- Indices de la tabla `tipo_daño`
--
ALTER TABLE `tipo_daño`
  ADD PRIMARY KEY (`id_daño`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `nitc` (`nitc`),
  ADD KEY `id_tip_usu` (`id_tip_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_daño`
--
ALTER TABLE `detalle_daño`
  MODIFY `id_detalle_daño` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=918;

--
-- AUTO_INCREMENT de la tabla `llamadas`
--
ALTER TABLE `llamadas`
  MODIFY `id_llamada` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id_pre` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `riesgos`
--
ALTER TABLE `riesgos`
  MODIFY `id_riesgo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_tip_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_daño`
--
ALTER TABLE `tipo_daño`
  MODIFY `id_daño` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `llamadas_ibfk_1` FOREIGN KEY (`documento`) REFERENCES `usuario` (`documento`),
  ADD CONSTRAINT `llamadas_ibfk_2` FOREIGN KEY (`id_cat`) REFERENCES `categoria` (`id_cat`),
  ADD CONSTRAINT `llamadas_ibfk_3` FOREIGN KEY (`id_est`) REFERENCES `estado` (`id_est`),
  ADD CONSTRAINT `llamadas_ibfk_4` FOREIGN KEY (`id_daño`) REFERENCES `tipo_daño` (`id_daño`);

--
-- Filtros para la tabla `precios`
--
ALTER TABLE `precios`
  ADD CONSTRAINT `precios_ibfk_1` FOREIGN KEY (`id_daño`) REFERENCES `tipo_daño` (`id_daño`);

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_llamada`) REFERENCES `llamadas` (`id_llamada`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_riesgo`) REFERENCES `riesgos` (`id_riesgo`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`tecnico_a`) REFERENCES `usuario` (`id_tip_usu`),
  ADD CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`id_precio`) REFERENCES `precios` (`id_pre`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`nitc`) REFERENCES `empresa` (`nitc`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_tip_usu`) REFERENCES `roles` (`id_tip_usu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
