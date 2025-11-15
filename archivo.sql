-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2025 a las 01:16:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
(710, 1, 1),
(715, 52, 1),
(717, 1, 2),
(718, 34, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `case_tipo`
--

CREATE TABLE `case_tipo` (
  `id_case_tipo` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `case_tipo`
--

INSERT INTO `case_tipo` (`id_case_tipo`, `tipo`, `codigo`) VALUES
(1, 'Sitios Apócrifos', 'sa'),
(2, 'D.O. en redes', 'do'),
(3, 'Militares en redes Sociales', 'mrs'),
(4, 'Ciberataques', 'ca'),
(5, 'Otros', 'ot'),
(6, 'Tendencias', 'td'),
(7, 'Infografias', 'if');

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
  `expediente` varchar(50) NOT NULL,
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
(66, 1, 'A00001', 4, 'ENTRADA', '2025-11-13', 'Prueba n&amp;uacute;mero 1', 'A1', 'Archivar', '', 1, '172025141144.pdf', '2025-11-14 05:18:44', 2),
(67, 2, 'A00002', 1, 'ENTRADA', '2025-11-11', 'Archivo de prueba 02', 'A02', 'Archivar', '', 1, '162025141132.pdf', '2025-11-14 05:19:32', 2),
(68, 3, 'A0003', 1, 'ENTRADA', '2025-11-14', 'Archivo de prueba 03', 'A03', 'Archivar', '', 1, '', '2025-11-14 05:20:10', 2);

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
(1, 'Hacker etíco', 'H.E.'),
(2, 'Tecnologias', 'TIC'),
(3, 'Barrendero', 'B'),
(4, 'Policarpio', 'Police');

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
(35, 5, 1, '272025111009.pdf', 'Secundario'),
(36, 5, 1, '872025111014.pdf', 'Basico'),
(37, 1, 1, '422025141108.pdf', 'Archivo de prueba');

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
(1, 'St', 'St'),
(2, 'Ct', 'Ct'),
(3, 'Tt', 'Tt'),
(4, 'Dt', 'Dt'),
(7, 'Cc', 'Cc');

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
(1, '192.168.128.30'),
(2, '192.168.128.80'),
(3, '192.168.128.60'),
(4, '192.168.128.20'),
(5, '192.168.180.241'),
(6, '192.168.190.22'),
(7, '127.0.0.1'),
(9, '192.168.190.250');

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
(4, 'activos', 32, 0, '2025-10-27 18:25:18'),
(5, 'casos', 41, 0, '2024-03-15 02:54:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `tipo_log` varchar(100) NOT NULL,
  `accion_log` varchar(100) NOT NULL,
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
(3181, 'CRUD', 'Elimino el usuario:María la del barrio', '/archivo/Usuarios/delete_usuario', '127.0.0.1', 'Cer0day', '2025-11-14 05:14:46', 'Administrador'),
(3182, 'CRUD', 'Actualizo el usuario matricula:12345', '/archivo/Usuarios/update_usuario', '127.0.0.1', 'Cer0day', '2025-11-14 05:15:07', 'Administrador'),
(3183, 'CRUD', 'Asigno un rol al usuario id:34', '/archivo/Usuarios/insert_rol', '127.0.0.1', 'Cer0day', '2025-11-14 05:15:16', 'Administrador'),
(3184, 'CRUD', 'Registró el documento:A00001', '/archivo/Archivo/insertDocumento', '127.0.0.1', 'Cer0day', '2025-11-14 05:18:44', 'Administrador'),
(3185, 'CRUD', 'Registró el documento:A00002', '/archivo/Archivo/insertDocumento', '127.0.0.1', 'Cer0day', '2025-11-14 05:19:32', 'Administrador'),
(3186, 'CRUD', 'Registró el documento:A0003', '/archivo/Archivo/insertDocumento', '127.0.0.1', 'Cer0day', '2025-11-14 05:20:10', 'Administrador'),
(3187, 'CRUD', 'Agregó una foto', '/archivo/Usuarios/insert_documento', '127.0.0.1', 'Cer0day', '2025-11-14 05:27:08', 'Administrador'),
(3188, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Cer0day', '2025-11-14 16:39:12', 'Administrador'),
(3189, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Cer0day', '2025-11-14 18:36:52', 'Administrador'),
(3190, 'CRUD', 'Inicio de session', '/archivo/Validacion/grabarRol', '127.0.0.1', 'Cer0day', '2025-11-14 19:17:25', 'Administrador');

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
(1, 'Oficio'),
(2, 'Memo'),
(3, 'Otro');

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
(1, 'Estudios'),
(2, 'Cursos'),
(3, 'Familia'),
(4, 'X1'),
(5, 'X2'),
(6, 'X3'),
(7, '\r\nX4'),
(8, 'X5');

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
(1, 'Centro de Cocina', 'CEC'),
(2, 'Compa&amp;ntilde;&amp;iacute;a de rescate', 'CIA de Rescate'),
(4, 'Direcci&amp;oacute;n de turismo', 'D.T.'),
(10, 'CEM', 'Centro medico');

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
(1, 7, 1, 'X-0000003', 'Cer0day', '962025240727.png', 1, 2, 'fb9580b46711e44215ebe01366635c3d000e3917d2eaa096149e598fdb3fc398', '$2y$10$KT8Lt4JAl/kjGGQJvCohHOwOHvIgrD0cOElERyeLl5JQTFHJMntq2', '', 1, 0, 1, '2025-11-14 18:36:50'),
(34, 4, 1, '12345', 'Ana de Armas', '722025111038.jpg', 1, 1, '4801998543270887907ffd3319a374cf535f2f4c3d01f5fa701677c1fda036c8', '$2y$10$pKOAITKSwKj/Xp.yCXlkL.nnqir8WZQMNzDYGAexAEvtlw9QFU1yq', '1f0320540d7ef8f91cabd0b8808bb3f08b1fc58bef7d3b9942e02462f3d1c4bb', 0, 0, 1, '2025-11-14 05:15:07'),
(52, 1, 1, 'C00000003', 'Conchita de Jesus', '572025111017.jpg', 1, 1, 'cadafb04258b75fc9f71281c8cf4c0c37cf735d0ca631c4d90469554283068f3', '$2y$10$wHiXAXHtQE/EYD2cvngxke4lepIp6hXl.Kwi6SHUK93K5I4Ecerye', '', 3, 0, 0, '2025-10-29 00:37:27');

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
-- Indices de la tabla `case_tipo`
--
ALTER TABLE `case_tipo`
  ADD PRIMARY KEY (`id_case_tipo`);

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
  MODIFY `id_asignacion_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=719;

--
-- AUTO_INCREMENT de la tabla `case_tipo`
--
ALTER TABLE `case_tipo`
  MODIFY `id_case_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `id_documentos` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3191;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `id_tipo_documento` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

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
