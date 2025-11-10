-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2025 a las 05:01:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `archivo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionroles`
--

CREATE TABLE `asignacionroles` (
  `id_asignacion_rol` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignacionroles`
--

INSERT INTO `asignacionroles` (`id_asignacion_rol`, `id_usuario`, `id_rol`) VALUES
(710, 50, 1),
(711, 51, 2),
(712, 50, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `id_documentos` int(100) NOT NULL,
  `id_tipo_documento` int(100) NOT NULL,
  `numero_documento` varchar(30) NOT NULL,
  `id_unidad_procedencia` int(100) NOT NULL,
  `e_s` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `asunto` varchar(500) NOT NULL,
  `expediente` varchar(300) NOT NULL,
  `acuerdo` varchar(100) NOT NULL,
  `estado` varchar(10) NOT NULL,
  `id_usuario` int(100) NOT NULL,
  `copia` varchar(100) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_unidad_archivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`id_documentos`, `id_tipo_documento`, `numero_documento`, `id_unidad_procedencia`, `e_s`, `fecha`, `asunto`, `expediente`, `acuerdo`, `estado`, `id_usuario`, `copia`, `fechahora`, `id_unidad_archivo`) VALUES
(69, 13, 'E-001', 11, 'ENTRADA', '2025-08-23', 'Metodolog&amp;iacute;a de ciberdefensa para organizaciones', 'https://publications.iadb.org/es/metodologia-de-ciberdefensa-para-organizaciones-version-10-mejores-practicas-en-ciberseguridad', 'Publicar', '', 50, '732025230801.pdf', '2025-08-23 16:03:19', 1),
(70, 13, 'E-002', 11, 'ENTRADA', '2025-08-23', 'Guia de ciberdefensa', 'https://jid.org/publicaciones/guia-de-ciberdefensa-orientaciones-para-el-diseno-planeamiento-implantacion-y-desarrollo-de-una-ciberdefensa-militar/', 'Publicar', '', 50, '102025230847.pdf', '2025-08-23 15:43:01', 1),
(71, 13, 'E-003', 11, 'ENTRADA', '2025-08-23', 'Gu&amp;iacute;a t&amp;eacute;cnica para prueba y evaluaci&amp;oacute;n de la seguridad de la informaci&amp;oacute;n', 'https://nvlpubs.nist.gov/nistpubs/Legacy/SP/nistspecialpublication800-115.pdf', 'Publicar', '', 50, '132025230826.pdf', '2025-08-23 15:47:26', 1),
(72, 13, 'E-004', 11, 'ENTRADA', '2025-08-23', 'Metodologia de pruebas de intrusi&amp;oacute;n', 'E', 'Publicar', '', 50, '', '2025-08-23 16:03:31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL,
  `nombre_especialidad` varchar(100) NOT NULL,
  `especialidad_abreviada` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidad`, `nombre_especialidad`, `especialidad_abreviada`) VALUES
(1, '-', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expedientes_personal`
--

CREATE TABLE `expedientes_personal` (
  `id_expediente` int(11) NOT NULL,
  `id_tipo_documento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_documento` varchar(300) NOT NULL,
  `titulo_documento` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `expedientes_personal`
--

INSERT INTO `expedientes_personal` (`id_expediente`, `id_tipo_documento`, `id_usuario`, `nombre_documento`, `titulo_documento`) VALUES
(37, 1, 50, '562025230840.pdf', 'Documento de prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id_grados` int(11) NOT NULL,
  `nombre_grado` varchar(100) NOT NULL,
  `grado_abreviado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id_grados`, `nombre_grado`, `grado_abreviado`) VALUES
(1, 'Usuario', 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ip_autorizadas`
--

CREATE TABLE `ip_autorizadas` (
  `id_ip_autorizada` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ip_autorizadas`
--

INSERT INTO `ip_autorizadas` (`id_ip_autorizada`, `ip`) VALUES
(7, '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lanzadores`
--

CREATE TABLE `lanzadores` (
  `id_lanzadores` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `estado` int(100) NOT NULL,
  `random` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lanzadores`
--

INSERT INTO `lanzadores` (`id_lanzadores`, `nombre`, `estado`, `random`, `datetime`) VALUES
(4, 'activos', 3, 0, '2025-06-26 18:05:52'),
(5, 'casos', 41, 0, '2024-03-15 02:54:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `tipo_log` varchar(300) NOT NULL,
  `accion_log` varchar(300) NOT NULL,
  `pagina_log` varchar(100) NOT NULL,
  `ip_log` varchar(20) NOT NULL,
  `usuario_log` varchar(100) NOT NULL,
  `fechaHora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol_log` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id_log`, `tipo_log`, `accion_log`, `pagina_log`, `ip_log`, `usuario_log`, `fechaHora`, `rol_log`) VALUES
(2571, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Ceroday', '2025-08-23 17:52:31', 'Administrador'),
(2572, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Ceroday', '2025-08-23 17:52:46', 'Capturista'),
(2573, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Ceroday', '2025-08-23 17:54:17', 'Administrador'),
(2574, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Ceroday', '2025-08-23 17:58:34', 'Administrador'),
(2575, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Ceroday', '2025-08-23 17:59:10', 'Administrador');

--
-- Disparadores `logs`
--
DELIMITER $$
CREATE TRIGGER `actualizar` BEFORE INSERT ON `logs` FOR EACH ROW UPDATE lanzadores SET estado = round( rand()*100000) WHERE nombre='logs'
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion_rol` varchar(150) NOT NULL,
  `id_tipo_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion_rol`, `id_tipo_rol`) VALUES
(1, 'Administrador', 'Administrador', 1),
(2, 'Capturista', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id_tipo_documento` int(100) NOT NULL,
  `tipo_documento` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id_tipo_documento`, `tipo_documento`) VALUES
(3, 'Memorándum'),
(5, 'Oficio'),
(13, 'Bibliografía'),
(14, 'Internet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento_expediente`
--

CREATE TABLE `tipo_documento_expediente` (
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento_expediente`
--

INSERT INTO `tipo_documento_expediente` (`id_tipo`, `nombre`) VALUES
(1, 'docs1'),
(2, 'docs2'),
(3, 'docs3'),
(4, 'docs4'),
(5, 'docs5'),
(6, 'docs6'),
(7, 'docs7'),
(8, 'docs8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_rol`
--

CREATE TABLE `tipo_rol` (
  `id_tipo_rol` int(11) NOT NULL,
  `nombre_tipo_rol` varchar(20) NOT NULL,
  `clave_tipo_rol` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_rol`
--

INSERT INTO `tipo_rol` (`id_tipo_rol`, `nombre_tipo_rol`, `clave_tipo_rol`) VALUES
(1, 'Sistema', 's'),
(2, 'FIsico', 'f');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(200) NOT NULL,
  `abreviatura_unidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `nombre_unidad`, `abreviatura_unidad`) VALUES
(1, 'Departamento de ventas', 'Ventas'),
(10, 'Departamento de contabilidad', 'Contabilidad'),
(11, 'Recurso público en internet', 'Internet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_grado` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `matricula` varchar(20) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `foto_usuario` varchar(100) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `estado_usuario` int(11) NOT NULL,
  `intentos_usuario` int(11) NOT NULL,
  `random` int(11) NOT NULL,
  `tiempo` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_grado`, `id_especialidad`, `matricula`, `nombre_usuario`, `foto_usuario`, `id_rol`, `id_unidad`, `usuario`, `password`, `pin`, `estado_usuario`, `intentos_usuario`, `random`, `tiempo`) VALUES
(50, 1, 1, '0x21', 'Ceroday', '592025220832.png', 1, 1, '5eac42abcdb075d5636c707f2ebfb0fbf87cf390cabc2ce7982707de4762349a', '$2y$10$pvTA0wAKV/QKF6M5zprrQuOIalhrlCigpuXv7CMPnXkh.p369cQru', '', 1, 0, 1, '2025-08-23 17:52:43'),
(51, 1, 1, 'SOP3465744', 'Cyra', '252025220830.jpg', 2, 1, 'aa4b9dd70541f0f5f58a8a87dde9cdd9d90e06bf18ce77b14ee06116ea895d72', '$2y$10$frf9GILIb8Z4Ur.vvy6AkemzXbrzva9I219SxpzUH.JiEVKruPbuW', '', 0, 0, 0, '2025-08-22 07:00:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionroles`
--
ALTER TABLE `asignacionroles`
  ADD PRIMARY KEY (`id_asignacion_rol`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`id_documentos`),
  ADD KEY `id_tipo_documento` (`id_tipo_documento`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_unidad_archivo` (`id_unidad_archivo`),
  ADD KEY `id_unidad_procedencia` (`id_unidad_procedencia`) USING BTREE;

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `expedientes_personal`
--
ALTER TABLE `expedientes_personal`
  ADD PRIMARY KEY (`id_expediente`),
  ADD KEY `id_tipo_documento` (`id_tipo_documento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id_grados`);

--
-- Indices de la tabla `ip_autorizadas`
--
ALTER TABLE `ip_autorizadas`
  ADD PRIMARY KEY (`id_ip_autorizada`);

--
-- Indices de la tabla `lanzadores`
--
ALTER TABLE `lanzadores`
  ADD PRIMARY KEY (`id_lanzadores`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD KEY `id_tipo_rol` (`id_tipo_rol`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `tipo_documento_expediente`
--
ALTER TABLE `tipo_documento_expediente`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tipo_rol`
--
ALTER TABLE `tipo_rol`
  ADD PRIMARY KEY (`id_tipo_rol`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_grado` (`id_grado`),
  ADD KEY `id_especialidad` (`id_especialidad`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_unidad` (`id_unidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacionroles`
--
ALTER TABLE `asignacionroles`
  MODIFY `id_asignacion_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=713;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documentos` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `expedientes_personal`
--
ALTER TABLE `expedientes_personal`
  MODIFY `id_expediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id_grados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ip_autorizadas`
--
ALTER TABLE `ip_autorizadas`
  MODIFY `id_ip_autorizada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `lanzadores`
--
ALTER TABLE `lanzadores`
  MODIFY `id_lanzadores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2576;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id_tipo_documento` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_documento_expediente`
--
ALTER TABLE `tipo_documento_expediente`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_rol`
--
ALTER TABLE `tipo_rol`
  MODIFY `id_tipo_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacionroles`
--
ALTER TABLE `asignacionroles`
  ADD CONSTRAINT `asignacionroles_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asignacionroles_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD CONSTRAINT `documentos_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipodocumento` (`id_tipo_documento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documentos_ibfk_2` FOREIGN KEY (`id_unidad_procedencia`) REFERENCES `unidades` (`id_unidad`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documentos_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `documentos_ibfk_6` FOREIGN KEY (`id_unidad_archivo`) REFERENCES `unidades` (`id_unidad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `expedientes_personal`
--
ALTER TABLE `expedientes_personal`
  ADD CONSTRAINT `expedientes_personal_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `expedientes_personal_ibfk_2` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento_expediente` (`id_tipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`id_tipo_rol`) REFERENCES `tipo_rol` (`id_tipo_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grados`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id_unidad`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_4` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
