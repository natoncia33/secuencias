-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2017 a las 20:05:01
-- Versión del servidor: 5.5.54-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `secuencias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_lectivo`
--

CREATE TABLE IF NOT EXISTS `anio_lectivo` (
  `id_anio_lectivo` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria pk del año que se está cursando',
  `nombre_anio_lectivo` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo representa el nombre del año lectivo que se está cursando por ejemplo 2017 - 2018 o 2017',
  `estado_anio_lectivo` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Inactivo' COMMENT 'este campo representa el estado del año lectivo, si se encuentra vigente o no',
  PRIMARY KEY (`id_anio_lectivo`),
  UNIQUE KEY `nombre_anio_lectivo` (`nombre_anio_lectivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Representa el año lectivo y en que estado se encuentra' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `anio_lectivo`
--

INSERT INTO `anio_lectivo` (`id_anio_lectivo`, `nombre_anio_lectivo`, `estado_anio_lectivo`) VALUES
(2, '2018', 'Inactivo'),
(3, '2019', 'Inactivo'),
(4, '2017', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion`
--

CREATE TABLE IF NOT EXISTS `asignacion` (
  `id_asignacion` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria pk de la tabla asignación ',
  `grupo` bigint(20) NOT NULL COMMENT 'este campo representa el id del grupo que se relaciona con asignación del docente y año ',
  `docente` bigint(20) NOT NULL COMMENT 'este campo representa el id del docente que se relaciona con asignación del grupo y año',
  `anio` bigint(20) NOT NULL COMMENT 'este campo representa el id del año que se relaciona con asignación del grupo y docente',
  PRIMARY KEY (`id_asignacion`),
  UNIQUE KEY `grupo_2` (`grupo`,`docente`,`anio`),
  KEY `docente` (`docente`),
  KEY `grupo` (`grupo`),
  KEY `anio` (`anio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Representa la combinación única entre grupo, docente y año' AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `asignacion`
--

INSERT INTO `asignacion` (`id_asignacion`, `grupo`, `docente`, `anio`) VALUES
(5, 1, 5, 3),
(7, 3, 5, 3),
(24, 3, 18, 2),
(17, 6, 7, 2),
(16, 6, 8, 2),
(15, 6, 19, 2),
(22, 6, 22, 2),
(23, 7, 22, 2),
(25, 8, 28, 2),
(26, 9, 29, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE IF NOT EXISTS `avatar` (
  `id_avatar` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa llave primaria pk de la tabla avatar',
  `nombre_avatar` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo guarda el nombre del avatar',
  `img_avatar` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo guarda la dirección de la imagen',
  PRIMARY KEY (`id_avatar`),
  UNIQUE KEY `nombre_avatar` (`nombre_avatar`),
  UNIQUE KEY `img_avatar` (`img_avatar`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena imágenes de los Avatar, elegibles por usuarios' AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`id_avatar`, `nombre_avatar`, `img_avatar`) VALUES
(18, 'Niño1', '8.png'),
(19, 'Niño2', '9.png'),
(20, 'Niño3', '10.png'),
(21, 'Niña1', '11.png'),
(22, 'Niña2', '12.png'),
(23, 'Niña3', '13.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id_config` int(1) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla config',
  `tiempo_permanencia` int(11) NOT NULL COMMENT 'este campo almacena el tiempo mínimo de permanencia sin actividad o movimiento',
  `tiempo_avance_auto` int(11) NOT NULL,
  `tiempo_sin_jugar` int(11) NOT NULL COMMENT 'este campo representa la llave primaria PK de la tabla config',
  `veces_fallos` int(11) NOT NULL,
  PRIMARY KEY (`id_config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena parámetros para la configuración' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_juego`
--

CREATE TABLE IF NOT EXISTS `elementos_juego` (
  `id_elementos_juego` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla elementos_juego',
  `tipo` enum('Silaba','Palabra','Figura','Vocal') COLLATE utf8_bin NOT NULL COMMENT 'este campo representa el tipo de un elemento',
  `nombre_elemento` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre del elemento',
  `archivo` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'este campo almacena la ruta de los elementos de tipo figura',
  PRIMARY KEY (`id_elementos_juego`),
  UNIQUE KEY `tipo` (`tipo`,`nombre_elemento`),
  UNIQUE KEY `archivo` (`archivo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena el listado de elementos que permiten armar un juego' AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `elementos_juego`
--

INSERT INTO `elementos_juego` (`id_elementos_juego`, `tipo`, `nombre_elemento`, `archivo`) VALUES
(1, 'Vocal', 'A', NULL),
(2, 'Vocal', 'E', NULL),
(3, 'Vocal', 'I', NULL),
(4, 'Vocal', 'O', NULL),
(5, 'Vocal', 'U', NULL),
(6, 'Figura', 'Triángulo', 'triangulo.png'),
(7, 'Figura', 'Rectángulo', 'rectángulo.png'),
(8, 'Figura', 'Cuadrado', 'cuadrado.png'),
(9, 'Palabra', 'Círculo', ''),
(11, 'Silaba', 'ma', NULL),
(12, 'Silaba', 'me', NULL),
(13, 'Silaba', 'mi', NULL),
(14, 'Palabra', 'gfgfdg', NULL),
(15, 'Silaba', 'mo', NULL),
(16, 'Palabra', 'dfsdfdsfsdfdfdfdrer', NULL),
(19, 'Silaba', 'sa', NULL),
(20, 'Palabra', 'ggrg', NULL),
(21, 'Palabra', 'Hola', NULL),
(24, 'Silaba', 'AS', NULL),
(26, 'Figura', '1234444', '59c1dda5b2c27_1234444.jpg'),
(27, 'Palabra', 'papa', NULL),
(28, 'Silaba', 'ko', NULL),
(29, 'Palabra', 'moco', NULL),
(30, 'Palabra', 'pedro', NULL),
(31, 'Palabra', 'mamá', NULL),
(32, 'Silaba', 'lo', NULL),
(33, 'Palabra', 'papá', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elementos_reto`
--

CREATE TABLE IF NOT EXISTS `elementos_reto` (
  `id_elementos_reto` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla elementos_reto',
  `reto` bigint(20) NOT NULL COMMENT 'este campo representa el id del reto ',
  `elemento_reto` bigint(20) NOT NULL COMMENT 'este campo representa a los elementos que se encuentran dentro de un reto',
  `tipo` enum('Clave','Distractor') COLLATE utf8_bin NOT NULL DEFAULT 'Distractor' COMMENT 'este campo almacena el elemento que es clave ',
  PRIMARY KEY (`id_elementos_reto`),
  KEY `reto` (`reto`),
  KEY `elemento_reto` (`elemento_reto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena detalle de cada elemento que pertenece a un reto' AUTO_INCREMENT=86 ;

--
-- Volcado de datos para la tabla `elementos_reto`
--

INSERT INTO `elementos_reto` (`id_elementos_reto`, `reto`, `elemento_reto`, `tipo`) VALUES
(24, 4, 20, 'Distractor'),
(25, 4, 1, 'Distractor'),
(26, 4, 11, 'Clave'),
(27, 4, 8, 'Distractor'),
(28, 5, 21, 'Distractor'),
(29, 5, 1, 'Distractor'),
(30, 5, 11, 'Clave'),
(31, 5, 8, 'Distractor'),
(51, 8, 29, 'Distractor'),
(52, 8, 1, 'Clave'),
(53, 8, 11, 'Distractor'),
(54, 8, 6, 'Distractor'),
(55, 7, 27, 'Distractor'),
(56, 7, 2, 'Distractor'),
(57, 7, 28, 'Distractor'),
(58, 7, 8, 'Clave'),
(59, 9, 30, 'Distractor'),
(60, 9, 3, 'Clave'),
(61, 9, 11, 'Distractor'),
(62, 9, 8, 'Distractor'),
(67, 10, 27, 'Distractor'),
(68, 10, 1, 'Clave'),
(69, 10, 12, 'Distractor'),
(70, 10, 6, 'Distractor'),
(71, 11, 27, 'Distractor'),
(72, 11, 1, 'Distractor'),
(73, 11, 12, 'Clave'),
(74, 11, 6, 'Distractor'),
(75, 12, 33, 'Distractor'),
(76, 12, 1, 'Clave'),
(77, 12, 11, 'Distractor'),
(79, 13, 33, 'Distractor'),
(80, 13, 1, 'Clave'),
(81, 13, 32, 'Distractor'),
(83, 14, 33, 'Distractor'),
(84, 14, 1, 'Clave'),
(85, 14, 32, 'Distractor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id_grupo` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla grupo',
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre del grupo',
  PRIMARY KEY (`id_grupo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Representa un conjunto de estudiantes' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_grupo`, `nombre`) VALUES
(8, 'Cac'),
(3, 'Grupo F'),
(1, 'a'),
(9, 'preescolar'),
(6, 'primero'),
(7, 'segundo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iconos`
--

CREATE TABLE IF NOT EXISTS `iconos` (
  `id_iconos` int(11) NOT NULL AUTO_INCREMENT,
  `icono` varchar(120) COLLATE utf8_bin NOT NULL,
  `imagen_icono` varchar(120) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_iconos`),
  UNIQUE KEY `icono` (`icono`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=26 ;

--
-- Volcado de datos para la tabla `iconos`
--

INSERT INTO `iconos` (`id_iconos`, `icono`, `imagen_icono`) VALUES
(1, 'add-2', 'add-2.png'),
(2, 'add-3', 'add-3.png'),
(3, 'add', 'add.png'),
(4, 'adicionar', 'adicionar.png'),
(5, 'agenda', 'agenda.png'),
(6, 'alarm-1', 'alarm-1.png'),
(7, 'alarm-clock-1', 'alarm-clock-1.png'),
(8, 'alarm-clock', 'alarm-clock.png'),
(9, 'alarm', 'alarm.png'),
(10, 'albums', 'albums.png'),
(11, 'app', 'app.png'),
(12, 'apple', 'apple.png'),
(13, 'archive-1', 'archive-1.png'),
(14, 'archive-2', 'archive-2.png'),
(15, 'archive-3', 'archive-3.png'),
(16, 'archive', 'archive.png'),
(17, 'attachment', 'attachment.png'),
(18, 'audio', 'audio.png'),
(19, 'audiobook-1', 'audiobook-1.png'),
(20, 'audiobook', 'audiobook.png'),
(21, 'back', 'back.png'),
(22, 'battery-1', 'battery-1.png'),
(23, 'battery-2', 'battery-2.png'),
(24, 'battery-3', 'battery-3.png'),
(25, 'battery-4', 'battery-4.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insignia`
--

CREATE TABLE IF NOT EXISTS `insignia` (
  `id_insignia` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla insignia',
  `nombre_insignia` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre de la insignia ',
  `foto_insignia` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena la dirección de la imagen de la insignia',
  `aciertos` int(11) NOT NULL COMMENT 'este campo almacena el número de aciertos consecutivos para ganar una insignia ',
  PRIMARY KEY (`id_insignia`),
  UNIQUE KEY `nombre_insignia` (`nombre_insignia`,`aciertos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena los detalles de una insignia' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `insignia`
--

INSERT INTO `insignia` (`id_insignia`, `nombre_insignia`, `foto_insignia`, `aciertos`) VALUES
(5, '2', '5.png', 1),
(6, 'estrella', '6.png', 15),
(8, 'Trofeo icono', '8.png', 1),
(9, 'Insignia9', '9.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insignias_usuario`
--

CREATE TABLE IF NOT EXISTS `insignias_usuario` (
  `id_insignia_usuario` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla insignias_usuarios',
  `id_insignia` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla insignia',
  `id_usuario` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla usuario',
  PRIMARY KEY (`id_insignia_usuario`),
  KEY `id_insignia` (`id_insignia`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relación entre las tablas usuarios e insignia' AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `insignias_usuario`
--

INSERT INTO `insignias_usuario` (`id_insignia_usuario`, `id_insignia`, `id_usuario`) VALUES
(1, 5, 20),
(2, 8, 20),
(3, 9, 20),
(4, 5, 20),
(5, 8, 20),
(6, 9, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE IF NOT EXISTS `matricula` (
  `id_matricula` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria de la tabla matricula',
  `grupo` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla grupo',
  `anio` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla anio_lectivo',
  `estudiante` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla usuario',
  PRIMARY KEY (`id_matricula`),
  UNIQUE KEY `grupo_2` (`grupo`,`anio`,`estudiante`),
  KEY `estudiante` (`estudiante`),
  KEY `grupo` (`grupo`),
  KEY `anio` (`anio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena los detalles de una matricula' AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `matricula`
--

INSERT INTO `matricula` (`id_matricula`, `grupo`, `anio`, `estudiante`) VALUES
(14, 1, 2, 26),
(12, 6, 2, 12),
(7, 6, 2, 14),
(6, 6, 2, 15),
(4, 6, 2, 17),
(10, 7, 2, 11),
(9, 7, 2, 12),
(8, 7, 2, 13),
(13, 7, 2, 25),
(15, 8, 2, 26),
(16, 9, 4, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `menu_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_item_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `menu_description` text COLLATE utf8_bin NOT NULL,
  `menu_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `menu_parent_id` int(11) NOT NULL,
  `url_target` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`menu_item_id`),
  UNIQUE KEY `menu_item_name` (`menu_item_name`),
  UNIQUE KEY `menu_url` (`menu_url`,`url_target`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reto`
--

CREATE TABLE IF NOT EXISTS `reto` (
  `id_reto` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla reto',
  `nombre_reto` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre del reto',
  `estado` enum('Borrador','Publicado') COLLATE utf8_bin NOT NULL DEFAULT 'Borrador' COMMENT 'este campo almacena el estado del reto si se encuentra publicado o borrador',
  `dificultad` int(1) NOT NULL COMMENT 'este campo almacena la dificultad que tiene un reto',
  `id_secuencia` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla secuencia',
  PRIMARY KEY (`id_reto`),
  KEY `id_secuencia` (`id_secuencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena los detalles de un reto' AUTO_INCREMENT=15 ;

--
-- Volcado de datos para la tabla `reto`
--

INSERT INTO `reto` (`id_reto`, `nombre_reto`, `estado`, `dificultad`, `id_secuencia`) VALUES
(4, '4', 'Publicado', 1, 28),
(5, '5', 'Publicado', 2, 28),
(7, '', 'Publicado', 2, 35),
(8, '8', 'Publicado', 1, 35),
(9, '9', 'Publicado', 3, 35),
(10, '', 'Publicado', 2, 39),
(11, '11', 'Publicado', 2, 39),
(12, '12', 'Publicado', 1, 40),
(13, '13', 'Publicado', 1, 41),
(14, '14', 'Publicado', 1, 42);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secuencia`
--

CREATE TABLE IF NOT EXISTS `secuencia` (
  `id_secuencia` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla secuencia',
  `nombre_secuencia` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre de la secuencia',
  `asignacion` bigint(20) DEFAULT NULL COMMENT 'este campo representa a la llave primaria de la tabla asignación',
  PRIMARY KEY (`id_secuencia`),
  UNIQUE KEY `nombre_secuencia` (`nombre_secuencia`),
  KEY `usuario` (`asignacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena los detalles de una secuencia' AUTO_INCREMENT=43 ;

--
-- Volcado de datos para la tabla `secuencia`
--

INSERT INTO `secuencia` (`id_secuencia`, `nombre_secuencia`, `asignacion`) VALUES
(3, 'd', 5),
(4, 'df', 5),
(5, 'gg', 5),
(6, 'fdf', 5),
(7, 'f', 5),
(17, 'fg', 5),
(18, 'jjhghhh', 5),
(28, '1', 7),
(31, 'qq', 5),
(33, 'op', 16),
(34, 'mnn', 16),
(35, 'Secuencia Vocales', 17),
(39, 'adfgadfg', 22),
(40, 'Primero', 25),
(41, 'vocales', 26),
(42, 'Voca', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_reto`
--

CREATE TABLE IF NOT EXISTS `seguimiento_reto` (
  `id_seguimiento_reto` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla seguimiento_reto',
  `reto` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla reto',
  `usuario` bigint(20) NOT NULL COMMENT 'este campo representa la llave primaria de la tabla usuarios',
  `aprobado` enum('SI','NO') COLLATE utf8_bin DEFAULT NULL COMMENT 'este campo almacena el estado de aprobado',
  `fecha` date NOT NULL COMMENT 'este campo almacena el resultado del reto jugado',
  `h_inicio` time NOT NULL COMMENT 'este campo almacena la hora de inicio del reto jugado',
  `h_fin` time NOT NULL COMMENT 'este campo almacena la hora de fin del reto jugado',
  `marcado` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el elemento que selecciona el estudiante en un reto',
  PRIMARY KEY (`id_seguimiento_reto`),
  KEY `reto` (`reto`),
  KEY `usuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena le seguimiento de un reto respecto a un usuario' AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `seguimiento_reto`
--

INSERT INTO `seguimiento_reto` (`id_seguimiento_reto`, `reto`, `usuario`, `aprobado`, `fecha`, `h_inicio`, `h_fin`, `marcado`) VALUES
(4, 4, 20, 'SI', '2017-11-02', '12:23:40', '12:24:24', '26'),
(8, 4, 20, 'SI', '2017-11-02', '12:24:59', '12:25:05', '26'),
(9, 5, 20, 'SI', '2017-11-02', '12:25:09', '12:25:15', '30'),
(10, 4, 20, NULL, '2017-11-04', '08:46:56', '00:00:00', ''),
(11, 4, 20, NULL, '2017-11-04', '08:47:05', '00:00:00', ''),
(12, 4, 20, NULL, '2017-11-04', '08:56:44', '00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuarios` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'este campo representa la llave primaria PK de la tabla usuarios',
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el nombre de profesor, estudiante o administrador',
  `apellido1` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el primer apellido del profesor, estudiante o administrador ',
  `apellido2` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'este campo almacena el segundo apellido del profesor, estudiante o administrador',
  `nuip` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el número único de identificación personal del profesor, estudiante o administrador',
  `email` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena el email del profesor, estudiante o administrador',
  `clave` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'este campo almacena la clave del profesor, estudiante o administrador',
  `f_nacimiento` date NOT NULL COMMENT 'este campo almacena la fecha de nacimiento del profesor, estudiante o administrador',
  `tipo` enum('docente','admin','estudiante') COLLATE utf8_bin NOT NULL DEFAULT 'estudiante' COMMENT 'este campo almacena el tipo, si es profesor, estudiante o administrador',
  `avatar` bigint(20) DEFAULT NULL COMMENT 'este campo representa la llave primaria de la tabla avatar',
  `puntos` int(11) NOT NULL COMMENT 'este campo almacena los puntos que obtiene el estudiante ',
  `estado` enum('Activo','Inactivo') COLLATE utf8_bin NOT NULL DEFAULT 'Activo' COMMENT 'este campo almacena el estado en el que se encuentra el usuario',
  `ultimo_inicio` datetime NOT NULL COMMENT 'este campo almacena la fecha y hora del ultimo inicio del estudiante',
  PRIMARY KEY (`id_usuarios`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nuip` (`nuip`),
  KEY `avatar` (`avatar`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Almacena todos los detalles de un usuario' AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre`, `apellido1`, `apellido2`, `nuip`, `email`, `clave`, `f_nacimiento`, `tipo`, `avatar`, `puntos`, `estado`, `ultimo_inicio`) VALUES
(5, 'Docente', 'Homero', '', '12345678', 'doc@gmail.com', 'cd3f81d5e8926fc6bef450b843fe07c4bf447009', '2017-07-01', 'docente', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(7, 'ProfeJairo', 'Gonzalez', 'Osorio', '1085325214', 'profejairo@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '1993-05-18', 'docente', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(8, 'ProfeMarcos', 'Rosero', 'Portillo', '1085325213', 'profemarcos@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '1993-06-18', 'docente', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(9, 'esteban', 'legarda', 'maigual', '95112915444', 'esteban@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-07-11', 'estudiante', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(10, 'andres', 'calpa', 'lopez', '95112915124', 'andres@gmail.com', '2ff8fb61e8568a98feabba994c7d3a188c3ea0c9', '2000-09-14', 'estudiante', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(11, 'david', 'benavides', 'calvache', '95112915678', 'david@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-08-12', 'estudiante', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(12, 'luis', 'paredez', 'trujillo', '961129175674', 'luis@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-08-13', 'estudiante', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(13, 'fernando', 'suarez', 'arias', '95072815345', 'fernando@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-05-13', 'estudiante', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(14, 'maurico', 'villota', 'coral', '95231456782', 'mauricio@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-08-07', 'estudiante', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(15, 'alejandro', 'santacruz', 'mosquera', '95345623555', 'alejandro@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '2000-03-31', 'estudiante', 20, 0, 'Activo', '0000-00-00 00:00:00'),
(17, 'juan', 'burbano', 'chaves', '95234561333', 'juan@gmail.com', 'ee06bf8bfebe408f1954466bb64ba4d6497629d3', '2000-06-05', 'estudiante', 20, 0, 'Activo', '0000-00-00 00:00:00'),
(18, 'Jairo Andres', 'Gonzalez', '', '1085325500', 'jairogonzalezoso@gmail.com', '2d9b1ec56b464dad9dcfe29975adfbecf19e68df', '1995-12-21', 'docente', 18, 0, 'Activo', '0000-00-00 00:00:00'),
(19, 'ProfeAndres', 'Chaves', 'Legarda', '1085325215', 'profeandres@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '1994-11-29', 'docente', 20, 0, 'Activo', '0000-00-00 00:00:00'),
(20, 'admin', 'admin', 'admin', '1085123456', 'admin@gmail.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', '2017-09-17', 'admin', 18, 4, 'Activo', '0000-00-00 00:00:00'),
(22, 'Sebastian Camilo', 'Anganoy', '', '1085325246', 'sebas@gmail.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '1995-12-21', 'docente', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(24, 'Angie', 'Revelo', '', '24625649', 'angie@gmail.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '1995-11-01', 'estudiante', 22, 0, 'Activo', '0000-00-00 00:00:00'),
(25, 'aleja', 'bacca', '', '12435435435', 'aleja@gmail.com', '601f1889667efaebb33b8c12572835da3f027f78', '2010-06-07', 'estudiante', 22, 0, 'Activo', '0000-00-00 00:00:00'),
(26, 'Steven', 'Bolaños', '', '1085455455', 'steven@gmail.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '1995-01-01', 'estudiante', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(28, 'ProfesorAndres', 'Cacied', '', '1085555555', 'and@gmail.com', '91928327a2dd15b75d99fef04d98b0fe1f21dc51', '1997-01-01', 'docente', 19, 0, 'Activo', '0000-00-00 00:00:00'),
(29, 'Fernando', 'Suarez', 'Burbano', '10859623811', 'fercho@gmail.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '1995-02-16', 'docente', 20, 0, 'Activo', '0000-00-00 00:00:00'),
(30, 'daniel ', 'erazo', 'santander', '1088737311', 'dani@gmail.com', 'f0f8e902ca7a41c634c5c8247d4b94f2c9b351fb', '1995-12-04', 'estudiante', 19, 0, 'Activo', '0000-00-00 00:00:00');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion`
--
ALTER TABLE `asignacion`
  ADD CONSTRAINT `asignacion_ibfk_1` FOREIGN KEY (`docente`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_3` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignacion_ibfk_4` FOREIGN KEY (`anio`) REFERENCES `anio_lectivo` (`id_anio_lectivo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `elementos_reto`
--
ALTER TABLE `elementos_reto`
  ADD CONSTRAINT `elementos_reto_ibfk_1` FOREIGN KEY (`elemento_reto`) REFERENCES `elementos_juego` (`id_elementos_juego`) ON UPDATE CASCADE,
  ADD CONSTRAINT `elementos_reto_ibfk_2` FOREIGN KEY (`reto`) REFERENCES `reto` (`id_reto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `insignias_usuario`
--
ALTER TABLE `insignias_usuario`
  ADD CONSTRAINT `insignias_usuario_ibfk_4` FOREIGN KEY (`id_insignia`) REFERENCES `insignia` (`id_insignia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `insignias_usuario_ibfk_5` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id_grupo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`estudiante`) REFERENCES `usuarios` (`id_usuarios`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matricula_ibfk_3` FOREIGN KEY (`anio`) REFERENCES `anio_lectivo` (`id_anio_lectivo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `reto`
--
ALTER TABLE `reto`
  ADD CONSTRAINT `reto_ibfk_1` FOREIGN KEY (`id_secuencia`) REFERENCES `secuencia` (`id_secuencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `secuencia`
--
ALTER TABLE `secuencia`
  ADD CONSTRAINT `secuencia_ibfk_1` FOREIGN KEY (`asignacion`) REFERENCES `asignacion` (`id_asignacion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguimiento_reto`
--
ALTER TABLE `seguimiento_reto`
  ADD CONSTRAINT `seguimiento_reto_ibfk_1` FOREIGN KEY (`reto`) REFERENCES `reto` (`id_reto`),
  ADD CONSTRAINT `seguimiento_reto_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id_usuarios`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`avatar`) REFERENCES `avatar` (`id_avatar`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
