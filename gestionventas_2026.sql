-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-10-2026 a las 16:13:31
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestionventas_2026`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `precio` double NOT NULL,
  `stock` double NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_rubro` bigint NOT NULL,
  `id_proveedor` bigint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_id_rubro` (`id_rubro`),
  KEY `fk_id_proveedor` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `id_rubro`, `id_proveedor`) VALUES
(1, '101', 'iPhone SE', 'Procesador: A13 Bionic | Almacenamiento:128 GB | Cámaras 7 Mp / 12 Mp| Pantalla:4,7 IPS Retina', 74999, 30, 'iPhone-SE-Black.jpg', 1, 0),
(2, '102', 'Motorola Moto G100', 'Procesador: Octa-Core (3,2 GHz) | Almacenamiento: 128 GB | Cámaras: 13 Mp / 64+16+2 Mp+ToF | Pantalla: 6,7 FHD+ LTPS', 74999, 11, 'Motorola-Moto-G100.jpg', 1, 0),
(3, '103', 'iPhone 11 Pro', 'Procesador: Chip A13 Bionic | Almacenamiento: 256 GB | Cámaras: 12 Mp / 12 Mp (Triple) | Pantalla: 5,8 Super Retina XDR - OLED Multi - Touch', 232899, 25, 'Iphone-11-Pro.jpg', 1, 0),
(4, '201', 'Samsung Galaxy A72', 'Procesador: Octa - Core(2, 3 GHz / 1, 8 GHz) | Almacenamiento: 128 GB | Cámaras: 32 Mp / 64 + 12 + 5 + 8 Mp | Pantalla: 6,7 FHD+ SuperAmoled', 66999, 12, 'Samsung-Galaxy-A72.jpg', 1, 0),
(5, '202', 'iPhone 11 Pro MAX', 'Procesador: Chip A13 Bionic | Almacenamiento: 256 GB | Cámaras: 12 Mp / 12 Mp (Triple) | Pantalla: 5,8 Super Retina XDR - OLED Multi - Touch', 249899, 30, 'Iphone-11-Pro-Max.jpg', 1, 0),
(6, '203', 'Motorola Moto G9 Plus', 'Procesador: Octa - Core(2, 2 GHz) | Almacenamiento: 128 GB | Cámaras: 16\nMp / 64 + 8 + 2 + 2 Mp | Pantalla: 6,81 FHD+ LTPS', 42999, 30, 'Motorola-Moto-G9-Plus.jpg', 1, 0),
(8, '205', 'LG K22', 'Procesador: Quad - Core(1, 3 GHz) | Almacenamiento: 32 GB | Cámaras: 5 Mp / 13 + 2 Mp | Pantalla: 6,2 HD+ IPS LCD', 15499, 35, 'LG-K22.jpg', 1, 0),
(9, '206', 'Samsung Galaxy A21s', 'Procesador: Octa-Core (2,0 GHz) | almacenamiento: 128 GB | Cámaras: 13 Mp / 48+8+2+2 Mp | Pantalla: 6,5 HD + -TFT LCD', 29999, 30, 'Samsung-Galaxy-A21s.jpg', 1, 0),
(10, '301', 'LG Velvet', 'Procesador: Octa - Core(2, 8 GHz / 1, 8 GHz) | Almacenamiento: 128 GB | Cámaras: 16 Mp / 48 + 8 + 5 Mp | Pantalla: 6,8 FHD+ P-OLED', 69999, 14, 'LG-Velvet.jpg', 1, 0),
(11, '302', 'Samsung Galaxy A32', 'Procesador: Octa-Core (2,0 GHz / 1,8 GHz) | Almacenamiento: 128 GB | Cámaras: 20 Mp / 64+8+5+5 Mp | Pantalla: 6,4 FHD + SuperAmoled', 40999, 45, 'Samsung-Galaxy-A32.jpg', 1, 0),
(12, '303', 'Alcatel 1V Plus', 'Procesador: Octa - Core(4 x1, 8 GHz, 4 x1, 5 GHz) | Almacenamiento: 32 GB | Cámaras: 5 Mp / 13 + 5 Mp | Pantalla: 6,22 HD+ - TFT-IPSLCD', 15999, 32, 'Alcatel-1V-Plus.jpg', 1, 0),
(13, '304', 'Samsung Galaxy A51', 'Procesador: Octa-Core (2,3 GHz / 1,7 GHz) | Almacenamiento: 128 GB | Cámaras: 32 Mp / 48 Mp | Pantalla: 6,5 FHD + SuperAmoled', 40999, 23, 'Samsung-Galaxy-A51.jpg', 1, 0),
(15, '1', '1', '1', 1, 0, '1', 0, 0),
(20, '7', '7', '7', 7, 0, '1085.jpg', 0, 0),
(21, '8', '8', '8', 8, 0, '8', 0, 0),
(23, '10', '10', '10', 10, 0, '10', 0, 0),
(24, '11', '11', '11', 11, 0, '11', 0, 0),
(25, '12', '12', '12', 12, 0, '21', 0, 0),
(26, '13', '13', '13', 13, 0, '13', 0, 0),
(27, '15', '15', '15', 15, 0, '15', 0, 0),
(28, '20', '20', '20                    ', 20, 0, '20', 0, 0),
(29, '12', '12', 'aaa', 12, 0, '12', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cuit` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `iva` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'cliente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `direccion`, `cuit`, `iva`, `email`, `telefono`, `usuario`, `password`, `rol`) VALUES
(1, 'José', 'De San Martín', 'Yapeyú 1778', '20-17781850-5', 'Res. Inscripto', 'sanmartin@hotmail.com', '341 4254521', 'josesanmartin', '$2y$12$aC1xF5gwrv00tDNLi.nf9OEQiqwyEQJyT6vNLAING3KFSh6p58I/W', 'cliente'),
(2, 'Manuel', 'Belgrano', 'Rosario 1770', '20-17701820-5', 'Monotributo', 'manuelbelgrano@gmail.com', '3476 625876', 'manuelbelgrano', '$2y$12$Jdu3Jg7g1qCj5ZTkipUN0Ox4FoZEsx92qkJHchZ9pvDb9.HfvWDCm', 'invitado'),
(3, 'Juana', 'Azurduy', 'Sucre 1780', '27-17801862-0', 'Cons. Final', 'juanitaazur862@live.com', '341 5418563', 'juanaazurduy', '$2y$12$WzeKVXb9D1j5wmBVCLj76uoZ0GcwVX.19EKTeMPA5LUvFgyxb/0jW', 'invitado'),
(4, 'Gregoria', 'Matorras', 'Orense 1738', '23-17381813-1', 'Resp. Inscripto', 'matorras.g.813@gmail.com', '342 6325498', 'gregoriamatorras', '$2y$12$FLFt1uEFKt1s0Oz6RIJ/NOlk90YF72LxGhd.oPDt5V5dPvJpUA6UC', 'invitado'),
(5, 'Administrador', NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '$2y$12$ppGqFv0ZmZVFXWsWvZUlx.J9KtWocvg06Cw5ifglI578k0mCjyl/a', 'admin'),
(6, 'Domingo', 'Sarmiento', NULL, NULL, NULL, NULL, NULL, 'dsarmiento', '$2y$12$iNdAqJhqV3l3uAGFeX1XueLUAsBxl1ZMWCBB/xrf1GUT7/YNc48tS', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
