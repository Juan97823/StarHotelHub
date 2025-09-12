-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-09-2025 a las 06:14:26
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
-- Base de datos: `starhotelhub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `num_identidad` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `whatsapp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descripcion` longtext NOT NULL,
  `foto` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categorias` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria_habitaciones`
--

CREATE TABLE `galeria_habitaciones` (
  `id` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `id_habitacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitaciones`
--

CREATE TABLE `habitaciones` (
  `id` int(11) NOT NULL,
  `estilo` varchar(200) NOT NULL,
  `numero` int(11) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `servicios` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habitaciones`
--

INSERT INTO `habitaciones` (`id`, `estilo`, `numero`, `capacidad`, `slug`, `foto`, `video`, `descripcion`, `servicios`, `precio`, `estado`, `fecha`) VALUES
(1, 'Habitacion Deluxe', 10, 3, 'habitacion-deluxe', '1.jpg', NULL, 'PRIMERA HABITACION PARA PRUEBAS', '', 130000.00, 1, '2025-09-09 14:03:56'),
(2, 'Habitacion Doble', 0, 2, 'habitacion-doble-0', '20250909172928_Doble.jpg', NULL, 'Nuestra cómoda habitación doble, decorada en tonos marrones, es perfecta para parejas o dos huéspedes. Cuenta con una confortable cama doble vestida con sábanas frescas y almohadas mullidas, garantizando un descanso reparador. Disfrute de un baño privado con ducha y artículos de aseo gratuitos, un televisor de pantalla plana con canales por cable y aire acondicionado individual. Amplio espacio de guardarropas para sus pertenencias. Manténgase conectado con nuestro Wi-Fi gratuito.', 'Baño privado totalmente equipado.\r\n\r\nAire acondicionado y calefacción para tu confort.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nRopa de cama de alta calidad y servicio de limpieza diario.\r\n\r\nDesayuno incluido para empezar el día con energía (según plan).', 90000.00, 1, '2025-09-09 15:29:28'),
(3, 'Habitacion Triple', 0, 3, 'habitacion-triple-0', '20250909172728_TrheeRoom.jpg', NULL, 'La opción perfecta para viajar en grupo o en familia. Nuestra habitación triple está pensada para ofrecer comodidad y amplitud a tres huéspedes, garantizando una estancia práctica y acogedora.', 'Una cama matrimonial + una cama individual.\r\n\r\nTres camas individuales, según preferencia y disponibilidad.\r\n\r\n???? Incluye:\r\n\r\nBaño privado con todas las comodidades.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nArmario amplio y escritorio auxiliar.\r\n\r\nServicio de limpieza diario y ropa de cama premium.\r\n\r\nDesayuno incluido (dependiendo del plan).\r\n\r\n???? Ideal para familias, amigos o compañeros de viaje que buscan compartir el mismo espacio sin renunciar al confort y la privacidad.', 120000.00, 1, '2025-09-09 15:27:28'),
(4, '✨ Habitación Doble – 2 Camas Matrimoniales ✨', 0, 4, 'habitación-doble-2-camas-matrimoniales-0', '20250909173257_Doble para 4 personas.jpg', NULL, 'Pensada para quienes viajan en familia o en grupo, esta habitación ofrece dos cómodas camas matrimoniales, garantizando el descanso de hasta cuatro huéspedes en un espacio moderno y acogedor.\r\nLa opción perfecta para familias o amigos que desean compartir la experiencia de viaje con el máximo confort y practicidad.', 'Baño privado totalmente equipado con artículos de cortesía.\r\n\r\nAire acondicionado y calefacción para tu comodidad.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nArmario amplio y escritorio auxiliar.\r\n\r\nRopa de cama de alta calidad y servicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 480000.00, 1, '2025-09-09 15:32:57'),
(5, '✨ Habitación Sencilla ✨', 0, 1, 'habitación-sencilla-0', '20250909173651_Habitacion Sencilla.jpg', NULL, 'Ideal para quienes viajan solos, nuestra habitación sencilla ofrece un ambiente práctico y confortable, pensado para garantizar el mejor descanso con todos los servicios esenciales. Perfecta para viajes de negocios, escapadas cortas o estancias individuales.', 'Cama individual cómoda y equipada con ropa de cama de calidad.\r\n\r\nBaño privado con artículos de aseo de cortesía.\r\n\r\nAire acondicionado y calefacción regulables.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nEscritorio auxiliar y armario práctico.\r\n\r\nServicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 80000.00, 1, '2025-09-09 15:36:51'),
(6, 'Habitación Familiar 👨‍👩‍👧‍👦', 0, 5, 'habitación-familiar-0', '20250909174735_Habitacion Familiar.jpg', NULL, 'La opción perfecta para compartir momentos únicos en familia. Nuestra habitación familiar está diseñada para ofrecer amplitud, comodidad y practicidad, con capacidad de hasta 4 o 5 huéspedes, según configuración. Una cama matrimonial + dos camas individuales.', 'Baño privado equipado con artículos de cortesía.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nConexión Wi-Fi de alta velocidad y TV de pantalla plana.\r\n\r\nArmario amplio y escritorio auxiliar.\r\n\r\nRopa de cama premium y servicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 500000.00, 1, '2025-09-09 15:47:35'),
(7, '✨ Habitación Presidencial ✨', 0, 2, 'habitación-presidencial-0', '20250909175128_Madame-Butterfly-Peralada-Suite.jpg', NULL, 'Capacidad: Hasta 2 personas (ideal para parejas o ejecutivos).\r\nLa máxima expresión de lujo y exclusividad en StarHotelHub. Nuestra Habitación Presidencial está diseñada para huéspedes que buscan vivir una experiencia inigualable, combinando amplitud, elegancia y servicios de categoría premium.', 'Cama King Size con ropa de cama de lujo.\r\n\r\nSala privada con mobiliario elegante y zona de estar.\r\n\r\nJacuzzi o tina de hidromasaje para momentos de relajación.\r\n\r\nBaño de lujo equipado con amenidades exclusivas.\r\n\r\nMinibar, cafetera premium y detalles VIP.\r\n\r\nWi-Fi de alta velocidad y múltiples pantallas de TV.\r\n\r\nServicio de limpieza preferencial y atención personalizada.', 1400000.00, 1, '2025-09-09 15:51:28'),
(8, '✨ Junior Suite ✨', 0, 2, 'junior-suite-0', '20250909180017_vincci-resort-costa-golf_1000_560_1679_1440149927.jpg', NULL, 'Nuestra Junior Suite es el equilibrio perfecto entre elegancia y comodidad. Ofrece un espacio más amplio que una habitación estándar, con detalles modernos y un ambiente acogedor para garantizar una experiencia superior.', '🛏️ Distribución:\r\n\r\n1 cama King Size o Queen Size.\r\n\r\nSala pequeña con zona de estar.\r\n\r\n🌟 Servicios incluidos:\r\n\r\nBaño privado con detalles exclusivos.\r\n\r\nMinibar y cafetera.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nWi-Fi de alta velocidad.\r\n\r\nTV de pantalla plana.\r\n\r\nEscritorio auxiliar y armario amplio.\r\n\r\nDesayuno incluido.\r\n\r\n💫 Descripción:', 720000.00, 1, '2025-09-09 16:00:17'),
(9, '✨ Suite Ejecutiva ✨', 0, 2, 'suite-ejecutiva-0', '20250909180256_Suite ejecutiva.jpg', NULL, 'La Suite Ejecutiva está diseñada para quienes buscan comodidad y eficiencia en sus viajes de negocios o escapadas en pareja. Ofrece un espacio elegante, con todas las facilidades para combinar descanso y productividad.', '🛏️ Distribución:\r\n\r\n1 cama King Size.\r\n\r\nSala privada con zona de estar y escritorio amplio.\r\n\r\n🌟 Servicios incluidos:\r\n\r\nBaño privado de lujo con artículos exclusivos.\r\n\r\nEscritorio ergonómico y espacio de trabajo.\r\n\r\nMinibar y cafetera premium.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nWi-Fi de alta velocidad.\r\n\r\nTV de pantalla plana.\r\n\r\nServicio de limpieza preferencial.\r\n\r\nDesayuno incluido y servicio a la habitación.', 880000.00, 1, '2025-09-12 02:52:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `num_transaccion` varchar(50) NOT NULL,
  `cod_reserva` varchar(50) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descripcion` text NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `metodo` int(11) NOT NULL,
  `facturacion` text NOT NULL,
  `id_habitacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `monto`, `num_transaccion`, `cod_reserva`, `fecha_ingreso`, `fecha_salida`, `fecha_reserva`, `descripcion`, `estado`, `metodo`, `facturacion`, `id_habitacion`, `id_usuario`) VALUES
(3, 300000.00, '451231', '254778', '2025-09-01', '2025-09-24', '2025-09-04 12:40:23', 'Reserva con llegada a las 8 pm', 1, 1, '1', 1, 26),
(4, 300000.00, '5161200', '213215', '2025-07-01', '2025-09-01', '2025-09-03 21:31:48', '', 1, 1, '', 1, 26),
(5, 300000.00, '5161266', '213219', '2025-04-01', '2025-04-16', '2025-09-03 21:33:23', '', 1, 0, '', 2, 26),
(100, 200000.00, 'TX100', 'RES100', '2025-09-10', '2025-09-11', '2025-09-10 05:00:00', 'Reserva de prueba hoy', 1, 1, '', 1, 26),
(101, 150000.00, 'TX101', 'RES101', '2025-09-09', '2025-09-10', '2025-09-09 05:00:00', 'Reserva prueba -1 día', 1, 1, '', 2, 26),
(102, 180000.00, 'TX102', 'RES102', '2025-09-08', '2025-09-09', '2025-09-08 05:00:00', 'Reserva prueba -2 días', 1, 1, '', 3, 26),
(103, 220000.00, 'TX103', 'RES103', '2025-09-07', '2025-09-08', '2025-09-07 05:00:00', 'Reserva prueba -3 días', 1, 1, '', 4, 26),
(104, 250000.00, 'TX104', 'RES104', '2025-09-06', '2025-09-07', '2025-09-06 05:00:00', 'Reserva prueba -4 días', 1, 1, '', 5, 26),
(105, 300000.00, 'TX105', 'RES105', '2025-09-05', '2025-09-06', '2025-09-05 05:00:00', 'Reserva prueba -5 días', 1, 1, '', 6, 26),
(106, 350000.00, 'TX106', 'RES106', '2025-09-04', '2025-09-05', '2025-09-04 05:00:00', 'Reserva prueba -6 días', 1, 1, '', 7, 26),
(107, 400000.00, 'TX107', 'RES107', '2025-09-03', '2025-09-04', '2025-09-03 05:00:00', 'Reserva prueba -7 días', 1, 1, '', 8, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `NombreRol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `NombreRol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `subtitulo` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sliders`
--

INSERT INTO `sliders` (`id`, `titulo`, `subtitulo`, `url`, `foto`, `estado`) VALUES
(1, 'Descubre el mundo, una estancia a la vez', 'Encuentra el hotel perfecto en cualquier destino y reserva en segundos, sin complicaciones.', 'http://localhost/starhotelhub/Habitaciones', 'slider1.jpg', 1),
(2, ' Tu escapada soñada empieza aquí', 'Ofertas exclusivas en miles de hoteles. Elige, reserva y relájate.', 'http://localhost/starhotelhub/Habitaciones', 'slider2.jpg', 1),
(3, ' Hospédate como mereces', 'Hoteles seleccionados para ti, con el mejor precio garantizado y cancelación flexible.', 'http://localhost/starhotelhub/Habitaciones', 'slider3.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave` varchar(150) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `rol` int(11) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `clave`, `token`, `verify`, `rol`, `foto`, `estado`, `fecha`) VALUES
(23, 'Juan', 'Juanesab423@gmail.com', '$2y$10$le84w2Y0t5zYH8BTJ7zmFu/nLppj7ugkwopl/o/6s4KjJWXFQh6dq', NULL, 0, 1, NULL, 1, '2025-09-09 22:37:13'),
(25, 'Empleado', 'Empleado@gmail.com', '$2y$10$13KGtawbenSpE81bbt3S..MRqB.0pjrb78JVY9UzUTMLrc/LaZn16', NULL, 0, 2, NULL, 1, '2025-09-03 00:55:49'),
(26, 'Sofia Salamanca', 'Salamancas648@gmail.com', '$2y$10$hEjwn2u5zkqjw.gOPYpD9etgUVMAl2jySl.Od0.6Apbb85E7TbKw.', NULL, 0, 3, NULL, 1, '2025-09-05 20:14:18'),
(27, 'William Alfonso', 'Hwilliamac@gmail.com', '$2y$10$ruCR//vCKHBe0xv6MizxGuFBT/F6ZfOhdtxuT.0NR9o8tX3MFkSjO', NULL, 0, 3, NULL, 1, '2025-09-09 23:39:13'),
(28, 'Sebastian', 'Sebastian@gmail.com', '$2y$10$pEiGczFoVj5lPv2.yTsCsu0WaLg6KNE0RpDYPaciakdOBh02n9cuO', NULL, 0, 3, NULL, 1, '2025-09-10 16:23:19'),
(29, 'Cliente ', 'Cliente@gmail.com', '$2y$10$jCDwEZ0NdVHcH9etSGvVSezN6wkFnojMkyGoJUdeyjZ1bDvsB6SD6', NULL, 0, 3, NULL, 1, '2025-09-12 03:09:55'),
(30, 'Juan Bernal', 'Juanestebanalfonsobernal@gmail.com', '$2y$10$m4MR553aJpWUEtQihY6DJuqjOBW.XfOMIrnmwwShxNtYz9nJuB1ky', NULL, 0, 3, NULL, 1, '2025-09-11 17:41:25'),
(31, 'Juan', 'Juanesab230403@gmail.com', '$2y$10$IpwnQ1ImUmybbBzCMAGEle/LgUk.2aywbY7GrQMRT..PFSGhd0VVi', NULL, 0, 3, NULL, 1, '2025-09-12 03:27:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `galeria_habitaciones`
--
ALTER TABLE `galeria_habitaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_habitacion` (`id_habitacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `galeria_habitaciones`
--
ALTER TABLE `galeria_habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `galeria_habitaciones`
--
ALTER TABLE `galeria_habitaciones`
  ADD CONSTRAINT `galeria_habitaciones_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
