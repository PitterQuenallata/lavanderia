-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2024 a las 23:01:05
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
-- Estructura de tabla para la tabla `categorias_prendas`
--

CREATE TABLE `categorias_prendas` (
  `id_categoria_prenda` int(11) NOT NULL,
  `nombre_categoria_prenda` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_prendas`
--

INSERT INTO `categorias_prendas` (`id_categoria_prenda`, `nombre_categoria_prenda`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'jeans', '2024-11-27 07:50:28', '2024-11-27 08:05:47'),
(2, 'Camisas', '2024-11-27 07:50:28', '2024-11-27 07:50:28'),
(4, 'chaquetas', '2024-11-27 08:14:34', '2024-11-27 08:14:34');

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
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `apellido_cliente` varchar(50) NOT NULL,
  `telefono_cliente` varchar(15) NOT NULL,
  `direccion_cliente` text DEFAULT NULL,
  `email_cliente` varchar(100) DEFAULT NULL,
  `dni_cliente` varchar(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `apellido_cliente`, `telefono_cliente`, `direccion_cliente`, `email_cliente`, `dni_cliente`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Juan', 'Pérez', '123456789', 'Calle Principal 123', 'juan.perez@email.com', '12345678', '2024-11-27 09:24:51', '2024-11-27 09:24:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id_color` int(11) NOT NULL,
  `nombre_color` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id_color`, `nombre_color`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Rojo', '2024-11-27 09:23:37', '2024-11-27 09:23:37'),
(2, 'Azul', '2024-11-27 09:23:37', '2024-11-27 09:23:37'),
(4, 'verde', '2024-11-27 09:25:39', '2024-11-27 09:25:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lavados`
--

CREATE TABLE `lavados` (
  `id_lavado` int(11) NOT NULL,
  `descripcion_lavado` varchar(100) NOT NULL,
  `tipo_lavado` enum('básico','premium','especial') NOT NULL DEFAULT 'básico',
  `costo_lavado` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lavados`
--

INSERT INTO `lavados` (`id_lavado`, `descripcion_lavado`, `tipo_lavado`, `costo_lavado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Lavado Básico', 'básico', 10.00, '2024-11-27 09:23:46', '2024-11-27 09:23:46'),
(2, 'Lavado Premium', 'premium', 20.00, '2024-11-27 09:23:46', '2024-11-27 09:23:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int(11) NOT NULL,
  `nombre` enum('QR','Efectivo') NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id_metodo_pago`, `nombre`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'QR', '2024-11-28 19:46:38', '2024-11-28 19:46:38'),
(2, 'Efectivo', '2024-11-28 19:46:38', '2024-11-28 19:46:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id_orden` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `numero_orden` text NOT NULL,
  `fecha_recepcion_orden` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega_orden` timestamp NULL DEFAULT NULL,
  `estado_orden` int(11) NOT NULL DEFAULT 0,
  `monto_total_orden` decimal(10,2) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id_orden`, `id_cliente`, `id_usuario`, `id_pago`, `numero_orden`, `fecha_recepcion_orden`, `fecha_entrega_orden`, `estado_orden`, `monto_total_orden`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(14, 1, 1, 27, 'ORD-6748e62d57787', '2024-11-28 04:00:00', '2024-11-30 04:00:00', 0, 260.00, '2024-11-28 21:52:45', '2024-11-28 21:52:45'),
(15, 1, 1, 28, 'ORD-6748e7e163c9b', '2024-11-28 04:00:00', '2024-11-27 04:00:00', 0, 200.00, '2024-11-28 22:00:01', '2024-11-28 22:00:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_prendas`
--

CREATE TABLE `ordenes_prendas` (
  `id_orden` int(11) NOT NULL,
  `id_prenda` int(11) NOT NULL,
  `id_color` int(11) DEFAULT NULL,
  `id_lavado` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `planchado` tinyint(1) DEFAULT 0,
  `ojal` int(5) DEFAULT NULL,
  `manualidad` text DEFAULT NULL,
  `observacion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_detalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_prendas`
--

INSERT INTO `ordenes_prendas` (`id_orden`, `id_prenda`, `id_color`, `id_lavado`, `cantidad`, `planchado`, `ojal`, `manualidad`, `observacion`, `fecha_creacion`, `fecha_actualizacion`, `id_detalle`) VALUES
(14, 3, 2, 2, 3, 0, 2, 'sin doblar', NULL, '2024-11-28 21:52:45', '2024-11-28 21:52:45', 3),
(14, 3, 2, 1, 20, 0, 3, 'sin doblar', NULL, '2024-11-28 21:52:45', '2024-11-28 21:52:45', 4),
(15, 1, 2, 1, 20, 0, 5, 'No', NULL, '2024-11-28 22:00:01', '2024-11-28 22:00:01', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_metodo_pago` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Completado','Cancelado') NOT NULL,
  `estado_notificacion` enum('Enviado','No Enviado') DEFAULT 'No Enviado',
  `detalle` text DEFAULT NULL,
  `remitente_nombre` varchar(100) DEFAULT NULL,
  `remitente_banco` varchar(100) DEFAULT NULL,
  `remitente_documento` varchar(50) DEFAULT NULL,
  `remitente_cuenta` varchar(50) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_metodo_pago`, `monto`, `estado`, `estado_notificacion`, `detalle`, `remitente_nombre`, `remitente_banco`, `remitente_documento`, `remitente_cuenta`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(27, 2, 4.00, 'Pendiente', 'No Enviado', 'Pago inicial de la orden', NULL, NULL, NULL, NULL, '2024-11-28 21:52:45', '2024-11-28 21:52:45'),
(28, 2, 200.00, 'Completado', 'No Enviado', 'Pago inicial de la orden', NULL, NULL, NULL, NULL, '2024-11-28 22:00:01', '2024-11-28 22:00:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prendas`
--

CREATE TABLE `prendas` (
  `id_prenda` int(11) NOT NULL,
  `id_categoria_prenda` int(11) NOT NULL,
  `descripcion_prenda` varchar(255) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prendas`
--

INSERT INTO `prendas` (`id_prenda`, `id_categoria_prenda`, `descripcion_prenda`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 1, 'jeans slim fitt', '2024-11-27 07:50:36', '2024-11-27 08:28:22'),
(3, 2, 'Camisa Formal', '2024-11-27 07:50:36', '2024-11-27 07:50:36');

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
(1, 'diegoa', 'muriela', 'colodroa', 'admin', '789456123', 'views/assets/media/avatars/usuarios/admin/395.jpg', 'diego@email.com', '$2a$07$azybxcags23425sdg23sde9Sczn9l3QeLCqG2x31FveZjFNtYBr9a', 1, 'administrador', '2024-11-28 16:21:29', '2024-11-21 22:48:02', '2024-11-28 16:21:29'),
(2, 'pitter', 'quenallata', 'quispe', 'pquenallata', '79128536', 'views/assets/media/avatars/usuarios/pquenallata/775.jpg', 'pquenallata@gmail.com', '$2a$07$azybxcags23425sdg23sdemfC0c36zEVPKLDMP7sTYYm6xar3895u', 1, 'promotor', '2024-11-27 23:38:33', '2024-11-22 16:46:34', '2024-11-27 23:38:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias_prendas`
--
ALTER TABLE `categorias_prendas`
  ADD PRIMARY KEY (`id_categoria_prenda`);

--
-- Indices de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  ADD PRIMARY KEY (`id_categoria_producto`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `lavados`
--
ALTER TABLE `lavados`
  ADD PRIMARY KEY (`id_lavado`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `fk_orden_cliente` (`id_cliente`),
  ADD KEY `fk_orden_usuario` (`id_usuario`),
  ADD KEY `fk_orden_pago` (`id_pago`);

--
-- Indices de la tabla `ordenes_prendas`
--
ALTER TABLE `ordenes_prendas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_prenda` (`id_prenda`),
  ADD KEY `id_color` (`id_color`),
  ADD KEY `id_lavado` (`id_lavado`),
  ADD KEY `fk_id_orden` (`id_orden`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD PRIMARY KEY (`id_prenda`),
  ADD KEY `id_categoria_prenda` (`id_categoria_prenda`);

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
-- AUTO_INCREMENT de la tabla `categorias_prendas`
--
ALTER TABLE `categorias_prendas`
  MODIFY `id_categoria_prenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categorias_productos`
--
ALTER TABLE `categorias_productos`
  MODIFY `id_categoria_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lavados`
--
ALTER TABLE `lavados`
  MODIFY `id_lavado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ordenes_prendas`
--
ALTER TABLE `ordenes_prendas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `prendas`
--
ALTER TABLE `prendas`
  MODIFY `id_prenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `fk_orden_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orden_pago` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orden_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes_prendas`
--
ALTER TABLE `ordenes_prendas`
  ADD CONSTRAINT `fk_id_orden` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_prendas_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordenes_prendas_ibfk_2` FOREIGN KEY (`id_prenda`) REFERENCES `prendas` (`id_prenda`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordenes_prendas_ibfk_3` FOREIGN KEY (`id_color`) REFERENCES `colores` (`id_color`) ON DELETE SET NULL,
  ADD CONSTRAINT `ordenes_prendas_ibfk_4` FOREIGN KEY (`id_lavado`) REFERENCES `lavados` (`id_lavado`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_metodo_pago` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prendas`
--
ALTER TABLE `prendas`
  ADD CONSTRAINT `prendas_ibfk_1` FOREIGN KEY (`id_categoria_prenda`) REFERENCES `categorias_prendas` (`id_categoria_prenda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_productos` (`id_categoria_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
