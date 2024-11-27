-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2024 a las 03:36:59
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
-- Base de datos: `lavanderia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

CREATE TABLE `categorias_productos` (
  `id_categoria_producto` int(11) NOT NULL,
  `nombre_categoria_producto` varchar(100) NOT NULL,
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`id_categoria_producto`, `nombre_categoria_producto`, `fecha_actualizacion`, `fecha_creacion`) VALUES
(1, 'detergentes', '2024-11-23 23:48:20', '2024-11-23 21:32:51'),
(2, 'Suavizantes', '2024-11-23 21:32:51', '2024-11-23 21:32:51'),
(3, 'Herramientas', '2024-11-23 21:32:51', '2024-11-23 21:32:51'),
(4, 'Material de Empaque', '2024-11-23 21:32:51', '2024-11-23 21:32:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria_producto` int(11) NOT NULL,
  `descripcion_producto` varchar(255) NOT NULL,
  `unidad_medida_producto` varchar(50) NOT NULL,
  `stock_producto` int(11) DEFAULT 0,
  `precio_producto` decimal(10,2) NOT NULL,
  `estado_producto` tinyint(1) DEFAULT 1,
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria_producto`, `descripcion_producto`, `unidad_medida_producto`, `stock_producto`, `precio_producto`, `estado_producto`, `fecha_actualizacion`, `fecha_creacion`) VALUES
(1, 1, 'Detergente líquido industrial', 'Litros', 100, 5.50, 1, '2024-11-23 21:32:58', '2024-11-23 21:32:58'),
(2, 2, 'Suavizante perfumado', 'Litros', 50, 3.25, 1, '2024-11-23 21:32:58', '2024-11-23 21:32:58'),
(3, 3, 'Cepillo para lavado de prendas', 'Unidades', 25, 8.75, 1, '2024-11-23 21:32:58', '2024-11-23 21:32:58'),
(4, 4, 'Bolsas plásticas de empaque', 'Unidades', 500, 0.15, 1, '2024-11-23 21:32:58', '2024-11-23 21:32:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(255) NOT NULL,
  `nit_ci_proveedor` int(11) NOT NULL,
  `telefono_proveedor` varchar(255) NOT NULL,
  `direccion_proveedor` varchar(255) NOT NULL,
  `email_proveedor` text NOT NULL,
  `date_created_proveedor` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated_proveedor` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`, `nit_ci_proveedor`, `telefono_proveedor`, `direccion_proveedor`, `email_proveedor`, `date_created_proveedor`, `date_updated_proveedor`) VALUES
(2, 'yoitoki', 552547, '72171914', 'DIR, TERCER ANIILLO INTERNO.. B/El Carmen calle 2 casa 2 zona Alto San Pedro , Santa Cruz de la Sierra, Bolivia', 'Yoitoki.bolivia@gmail.com', '2024-09-17 21:03:37', '2024-11-18 03:32:47'),
(3, 'saltore s.a', 2542424, '69050394', 'Av. Trompillo # 457, Santa Cruz', 'ventas.trompillo@saltore.com.bo', '2024-09-17 21:05:08', '2024-11-18 02:37:23'),
(4, 'sunrise s.l.r', 7584, '77660197', 'AV. Prolongación Beni # 7880 entre 8vo y 9no anillo Zona norte Barrio potrerito Santa Crus de la Sierra - Bolivia', 'edmundo.farel@autopartsunrise.com', '2024-09-17 22:23:37', '2024-11-18 02:37:55'),
(6, 'consucruz', 45555121, '75517782', 'Av. Banzer N.2100 / Av. Grigota Esq. Barientos, Santa Cruz de la Sierra, Bolivia', 'info@cosucruz.com', '2024-11-18 02:28:49', '2024-11-18 02:38:17'),
(7, 'damato s.a', 2147483647, '71471228', 'calle francisco pizarro, cochabamba, bolivia', 'jcpomasil@damatosrl.com', '2024-11-18 03:08:37', '2024-11-18 03:33:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `apellido_paterno_usuario` varchar(50) NOT NULL,
  `apellido_materno_usuario` varchar(50) NOT NULL,
  `user_usuario` varchar(50) NOT NULL,
  `telefono_usuario` varchar(15) NOT NULL,
  `foto_usuario` varchar(255) DEFAULT NULL,
  `email_usuario` varchar(100) DEFAULT NULL,
  `password_usuario` varchar(255) NOT NULL,
  `estado_usuario` tinyint(1) DEFAULT 1,
  `rol_usuario` enum('administrador','promotor','secretaria') NOT NULL DEFAULT 'secretaria',
  `ultimo_login_usuario` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `apellido_paterno_usuario`, `apellido_materno_usuario`, `user_usuario`, `telefono_usuario`, `foto_usuario`, `email_usuario`, `password_usuario`, `estado_usuario`, `rol_usuario`, `ultimo_login_usuario`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'juan', 'perez', 'gómez', 'admin', '789456123', 'views/assets/media/avatars/usuarios/admin/772.jpg', 'juanperez@example.com', '$2a$07$azybxcags23425sdg23sde9Sczn9l3QeLCqG2x31FveZjFNtYBr9a', 1, 'administrador', '2024-11-24 23:26:40', '2024-11-21 22:48:02', '2024-11-24 23:26:40'),
(2, 'pitter', 'quenallata', 'quispe', 'pquenallata', '79128536', 'views/assets/media/avatars/usuarios/pquenallata/775.jpg', 'pquenallata@gmail.com', '$2a$07$azybxcags23425sdg23sdejXNkI6.Ib0xhO3BygJpBu2RvCY9qZb2', 1, 'administrador', '2024-11-23 10:44:02', '2024-11-22 16:46:34', '2024-11-23 10:44:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id_categoria_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria_producto` (`id_categoria_producto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `id_categoria_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_productos` (`id_categoria_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
