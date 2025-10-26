-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2025 a las 19:15:52
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

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `estado`) VALUES
(1, 'Turismo', 1),
(2, 'Gastronomía', 1),
(3, 'Eventos', 1),
(4, 'Consejos de viaje', 1),
(5, 'Novedades del hotel', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` longtext NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1=No leído, 2=Leído'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `slug` varchar(200) NOT NULL,
  `categorias` varchar(100) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `titulo`, `descripcion`, `foto`, `slug`, `categorias`, `id_categoria`, `estado`, `fecha`, `id_usuario`) VALUES
(1, 'Bienvenidos al Blog de StarHotelHub', 'Primer post de prueba para verificar integraciones.', 'blog1.jpg', 'bienvenidos-blog', NULL, 5, 1, '2025-09-23 22:07:40', 23),
(2, '5 destinos imperdibles para tus próximas vacaciones', 'Descubre los lugares más espectaculares para visitar este año. Desde playas paradisíacas hasta ciudades llenas de historia, ¡prepara tus maletas y vive experiencias únicas!', 'turismo1.jpg', '5-destinos-imperdibles-para-tus-pr-ximas-vacaciones', '1', 1, 1, '2025-09-23 22:07:42', 23),
(3, 'Top 10 platillos que debes probar en nuestro hotel', 'Una guía de los sabores que no puedes perderte en StarHotelHub: ensaladas frescas, platos fuertes exquisitos y postres que harán vibrar tu paladar.', 'gastronomia1.jpg', 'top-10-platillos-que-debes-probar-en-nuestro-hotel', '2', 2, 1, '2025-09-18 01:08:47', 23),
(4, 'Organiza tu boda soñada en StarHotelHub', 'Conoce nuestros paquetes de bodas y eventos especiales. Disfruta de un lugar exclusivo, atención personalizada y servicios de lujo para que ese día sea inolvidable.', 'eventos1.jpg', 'organiza-tu-boda-soñada', NULL, 3, 1, '2025-09-18 00:44:27', 23),
(5, '10 tips para viajar ligero y cómodo', 'Aprende a empacar eficientemente y disfrutar al máximo tus viajes sin preocuparte por el exceso de equipaje. Consejos prácticos para ahorrar tiempo y estrés en tus vacaciones.', 'consejos1.jpg', '10-tips-viajar-ligero', NULL, 4, 1, '2025-09-18 00:44:27', 23),
(6, 'Renovación de la piscina y área de spa', 'Estamos felices de anunciar la renovación completa de nuestra piscina y área de spa. Disfruta de un espacio moderno, cómodo y lleno de relajación y bienestar.', 'novedades1.jpg', 'renovacion-piscina-spa', NULL, 5, 1, '2025-09-18 00:44:27', 23),
(7, 'Cómo elegir la habitación perfecta para tu estancia', 'Te damos los mejores consejos para seleccionar la habitación que se adapte a tus necesidades: vistas, comodidad, servicios adicionales y ubicación dentro del hotel.', 'turismo2.jpg', 'elegir-habitacion-perfecta', NULL, 1, 1, '2025-09-18 00:44:27', 23),
(8, 'Bebidas exóticas que debes probar en nuestro bar', 'Descubre cocteles únicos y bebidas refrescantes creadas por nuestros expertos bartenders. Cada sorbo es una experiencia inolvidable de sabor y creatividad.', 'gastronomia2.jpg', 'bebidas-exoticas-bar', NULL, 2, 1, '2025-09-18 00:44:27', 23),
(9, 'Cómo organizar un evento corporativo exitoso', 'Aprende a planear tu evento empresarial en nuestro hotel: desde salas equipadas hasta catering personalizado y atención profesional en cada detalle.', 'eventos2.jpg', 'organizar-evento-corporativo', NULL, 3, 1, '2025-09-18 00:44:27', 23),
(10, 'Guía para viajar con niños sin estrés', 'Tips esenciales para disfrutar de tus vacaciones en familia. Actividades para niños, recomendaciones de seguridad y consejos para mantener a todos felices.', 'consejos2.jpg', 'viajar-con-ninos', NULL, 4, 1, '2025-09-18 00:44:27', 23),
(11, 'Nuevos menús de temporada en nuestro restaurante', 'Presentamos platos frescos y creativos inspirados en la temporada actual. Ingredientes locales y de alta calidad para una experiencia gastronómica única.', 'novedades2.jpg', 'nuevos-menus-temporada', NULL, 5, 1, '2025-09-18 00:44:27', 23),
(12, 'Escapadas románticas para parejas', 'Descubre nuestros paquetes especiales para parejas, con cenas privadas, habitaciones con vista y actividades pensadas para momentos románticos inolvidables.', 'turismo3.jpg', 'escapadas-romanticas', NULL, 1, 1, '2025-09-18 00:44:27', 23),
(13, 'Postres que te harán volver por más', 'Dulces y postres artesanales que combinan sabor y presentación. Desde tortas hasta helados gourmet, cada opción es un deleite para los sentidos.', 'gastronomia3.jpg', 'postres-para-volver', NULL, 2, 1, '2025-09-18 00:44:27', 23),
(14, 'Celebra tu cumpleaños con nosotros', 'Hacemos que tu día especial sea único: decoración personalizada, catering exclusivo y sorpresas que harán de tu cumpleaños un recuerdo imborrable.', 'eventos3.jpg', 'celebra-cumpleanos', NULL, 3, 1, '2025-09-18 00:44:27', 23),
(15, 'Consejos para descansar mejor durante tu viaje', 'Descubre técnicas y recomendaciones para dormir mejor, aprovechar al máximo tu estancia y regresar a casa renovado y relajado.', 'consejos3.jpg', 'dormir-mejor-viaje', NULL, 4, 1, '2025-09-18 00:44:27', 23),
(16, 'Ampliación de nuestras instalaciones de gimnasio', '¡Entrena sin límites! Presentamos nuestras nuevas áreas de gimnasio con equipos de última generación para mantener tu rutina durante tus vacaciones.', 'novedades3.jpg', 'ampliacion-gimnasio', NULL, 5, 1, '2025-09-18 00:44:27', 23),
(17, 'Rutas turísticas cerca del hotel', 'Explora los alrededores de StarHotelHub con rutas a pie, en bici o excursiones cortas que te permitirán conocer la cultura y naturaleza local.', 'turismo4.jpg', 'rutas-turisticas-cerca', NULL, 1, 1, '2025-09-18 00:44:27', 23),
(18, 'Cenas temáticas para disfrutar en familia', 'Cada semana presentamos cenas especiales con temáticas divertidas, menús variados y actividades para toda la familia. ¡Una experiencia gastronómica única!', 'gastronomia4.jpg', 'cenas-tematicas-familia', NULL, 2, 1, '2025-09-18 00:44:27', 23),
(19, 'Organiza un retiro de bienestar en nuestro hotel', 'Ideal para empresas o grupos de amigos que buscan relajación y crecimiento personal. Actividades de mindfulness, yoga y alimentación saludable garantizan un retiro inolvidable.', 'eventos4.jpg', 'retiro-bienestar-hotel', NULL, 3, 1, '2025-09-18 00:44:27', 23),
(20, 'Consejos para evitar el jet lag', 'Aprende a minimizar los efectos del cambio de horario con recomendaciones de alimentación, sueño y actividades para mantener tu energía durante el viaje.', 'consejos4.jpg', 'evitar-jet-lag', NULL, 4, 1, '2025-09-18 00:44:27', 23),
(21, 'Nueva terraza panorámica con vista al atardecer', 'Disfruta de nuestra renovada terraza con vistas espectaculares y un ambiente único para relajarte, tomar fotos y disfrutar de bebidas al atardecer.', 'novedades4.jpg', 'nueva-terrace-panoramica', NULL, 5, 1, '2025-09-30 22:58:00', 23);

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
(1, 'Habitacion Deluxe', 0, 3, 'habitacion-deluxe', '1.jpg', NULL, 'PRIMERA HABITACION PARA PRUEBAS', 'wifi', 260000.00, 1, '2025-09-24 19:51:50'),
(2, 'Habitacion Doble', 2, 2, 'habitacion-doble', '20250909172928_Doble.jpg', NULL, 'Nuestra cómoda habitación doble, decorada en tonos marrones, es perfecta para parejas o dos huéspedes. Cuenta con una confortable cama doble vestida con sábanas frescas y almohadas mullidas, garantizando un descanso reparador. Disfrute de un baño privado con ducha y artículos de aseo gratuitos, un televisor de pantalla plana con canales por cable y aire acondicionado individual. Amplio espacio de guardarropas para sus pertenencias. Manténgase conectado con nuestro Wi-Fi gratuito.', 'Baño privado totalmente equipado.\r\n\r\nAire acondicionado y calefacción para tu confort.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nRopa de cama de alta calidad y servicio de limpieza diario.\r\n\r\nDesayuno incluido para empezar el día con energía (según plan).', 90000.00, 1, '2025-01-03 01:18:55'),
(3, 'Habitacion Triple', 3, 3, 'habitacion-triple-0', '20250909172728_TrheeRoom.jpg', NULL, 'La opción perfecta para viajar en grupo o en familia. Nuestra habitación triple está pensada para ofrecer comodidad y amplitud a tres huéspedes, garantizando una estancia práctica y acogedora.', 'Una cama matrimonial + una cama individual.\n\nTres camas individuales, según preferencia y disponibilidad.\n\n???? Incluye:\n\nBaño privado con todas las comodidades.\n\nAire acondicionado y calefacción.\n\nConexión Wi-Fi gratuita y TV de pantalla plana.\n\nArmario amplio y escritorio auxiliar.\n\nServicio de limpieza diario y ropa de cama premium.\n\nDesayuno incluido (dependiendo del plan).\n\n???? Ideal para familias, amigos o compañeros de viaje que buscan compartir el mismo espacio sin renunciar al confort y la privacidad.', 120000.00, 1, '2025-09-15 23:41:10'),
(4, 'Habitación Doble – 2 Camas Matrimoniales\r\n', 4, 4, 'habitación-doble-2-camas-matrimoniales-0', '20250909173257_Doble para 4 personas.jpg', NULL, 'Pensada para quienes viajan en familia o en grupo, esta habitación ofrece dos cómodas camas matrimoniales, garantizando el descanso de hasta cuatro huéspedes en un espacio moderno y acogedor.\r\nLa opción perfecta para familias o amigos que desean compartir la experiencia de viaje con el máximo confort y practicidad.', 'Baño privado totalmente equipado con artículos de cortesía.\r\n\r\nAire acondicionado y calefacción para tu comodidad.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nArmario amplio y escritorio auxiliar.\r\n\r\nRopa de cama de alta calidad y servicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 480000.00, 1, '2025-09-01 19:31:49'),
(5, ' Habitación Sencilla ', 5, 1, 'habitación-sencilla-0', '20250909173651_Habitacion Sencilla.jpg', NULL, 'Ideal para quienes viajan solos, nuestra habitación sencilla ofrece un ambiente práctico y confortable, pensado para garantizar el mejor descanso con todos los servicios esenciales. Perfecta para viajes de negocios, escapadas cortas o estancias individuales.', 'Cama individual cómoda y equipada con ropa de cama de calidad.\r\n\r\nBaño privado con artículos de aseo de cortesía.\r\n\r\nAire acondicionado y calefacción regulables.\r\n\r\nConexión Wi-Fi gratuita y TV de pantalla plana.\r\n\r\nEscritorio auxiliar y armario práctico.\r\n\r\nServicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 80000.00, 1, '2025-07-11 08:12:35'),
(6, 'Habitación Familiar ', 6, 5, 'habitación-familiar-0', '20250909174735_Habitacion Familiar.jpg', NULL, 'La opción perfecta para compartir momentos únicos en familia. Nuestra habitación familiar está diseñada para ofrecer amplitud, comodidad y practicidad, con capacidad de hasta 4 o 5 huéspedes, según configuración. Una cama matrimonial + dos camas individuales.', 'Baño privado equipado con artículos de cortesía.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nConexión Wi-Fi de alta velocidad y TV de pantalla plana.\r\n\r\nArmario amplio y escritorio auxiliar.\r\n\r\nRopa de cama premium y servicio de limpieza diario.\r\n\r\nDesayuno incluido (según plan).', 500000.00, 1, '2025-04-17 21:37:02'),
(7, ' Habitación Presidencial', 7, 2, 'habitación-presidencial-0', '20250909175128_Madame-Butterfly-Peralada-Suite.jpg', NULL, 'Capacidad: Hasta 2 personas (ideal para parejas o ejecutivos).\r\nLa máxima expresión de lujo y exclusividad en StarHotelHub. Nuestra Habitación Presidencial está diseñada para huéspedes que buscan vivir una experiencia inigualable, combinando amplitud, elegancia y servicios de categoría premium.', 'Cama King Size con ropa de cama de lujo.\r\n\r\nSala privada con mobiliario elegante y zona de estar.\r\n\r\nJacuzzi o tina de hidromasaje para momentos de relajación.\r\n\r\nBaño de lujo equipado con amenidades exclusivas.\r\n\r\nMinibar, cafetera premium y detalles VIP.\r\n\r\nWi-Fi de alta velocidad y múltiples pantallas de TV.\r\n\r\nServicio de limpieza preferencial y atención personalizada.', 1400000.00, 1, '2025-04-28 16:28:54'),
(8, ' Junior Suite ', 8, 2, 'junior-suite', '20250909180017_vincci-resort-costa-golf_1000_560_1679_1440149927.jpg', NULL, 'Nuestra Junior Suite es el equilibrio perfecto entre elegancia y comodidad. Ofrece un espacio más amplio que una habitación estándar, con detalles modernos y un ambiente acogedor para garantizar una experiencia superior.', ' Distribución:\r\n\r\n1 cama King Size o Queen Size.\r\n\r\nSala pequeña con zona de estar.\r\n\r\n Servicios incluidos:\r\n\r\nBaño privado con detalles exclusivos.\r\n\r\nMinibar y cafetera.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nWi-Fi de alta velocidad.\r\n\r\nTV de pantalla plana.\r\n\r\nEscritorio auxiliar y armario amplio.\r\n\r\nDesayuno incluido.\r\n\r\n Descripción:', 720000.00, 1, '2025-02-09 00:45:21'),
(9, ' Suite Ejecutiva ', 9, 2, 'suite-ejecutiva', '20250909180256_Suite ejecutiva.jpg', NULL, 'La Suite Ejecutiva está diseñada para quienes buscan comodidad y eficiencia en sus viajes de negocios o escapadas en pareja. Ofrece un espacio elegante, con todas las facilidades para combinar descanso y productividad.', ' Distribución:\r\n\r\n1 cama King Size.\r\n\r\nSala privada con zona de estar y escritorio amplio.\r\n\r\n Servicios incluidos:\r\n\r\nBaño privado de lujo con artículos exclusivos.\r\n\r\nEscritorio ergonómico y espacio de trabajo.\r\n\r\nMinibar y cafetera premium.\r\n\r\nAire acondicionado y calefacción.\r\n\r\nWi-Fi de alta velocidad.\r\n\r\nTV de pantalla plana.\r\n\r\nServicio de limpieza preferencial.\r\n\r\nDesayuno incluido y servicio a la habitación.', 880000.00, 1, '2025-07-04 15:44:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `num_transaccion` varchar(100) NOT NULL,
  `cod_reserva` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `metodo` varchar(50) NOT NULL,
  `facturacion` varchar(100) NOT NULL,
  `id_habitacion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `id_reserva`, `monto`, `num_transaccion`, `cod_reserva`, `fecha_ingreso`, `fecha_salida`, `descripcion`, `metodo`, `facturacion`, `id_habitacion`, `id_usuario`, `id_empleado`, `estado`, `fecha_pago`) VALUES
(24, 5, 0.00, '', NULL, NULL, NULL, NULL, 'pendiente', 'Pago sin factura', NULL, NULL, NULL, 1, '2025-10-10 13:33:33');

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
  `id_usuario` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `monto`, `num_transaccion`, `cod_reserva`, `fecha_ingreso`, `fecha_salida`, `fecha_reserva`, `descripcion`, `estado`, `metodo`, `facturacion`, `id_habitacion`, `id_usuario`, `id_empleado`) VALUES
(5, 1350000.00, '5161266', '213219', '2025-04-01', '2025-04-16', '2025-09-19 04:11:27', '', 1, 1, '', 2, 26, NULL),
(6, 90000.00, 'TX101', 'RES101', '2025-09-09', '2025-09-10', '2025-10-16 04:06:44', 'Reserva prueba -1 día', 1, 1, '', 2, 26, NULL),
(7, 120000.00, 'TX102', 'RES102', '2025-09-08', '2025-09-09', '2025-09-19 04:11:54', 'Reserva prueba -2 días', 1, 1, '', 3, 26, NULL),
(8, 480000.00, 'TX103', 'RES103', '2025-09-07', '2025-09-08', '2025-09-19 04:12:08', 'Reserva prueba -3 días', 1, 1, '', 4, 26, NULL),
(9, 80000.00, 'TX104', 'RES104', '2025-09-06', '2025-09-07', '2025-09-19 04:12:19', 'Reserva prueba -4 días', 1, 1, '', 5, 26, NULL),
(10, 500000.00, 'TX105', 'RES105', '2025-09-05', '2025-09-06', '2025-09-19 04:12:27', 'Reserva prueba -5 días', 1, 1, '', 6, 26, NULL),
(11, 1400000.00, 'TX106', 'RES106', '2025-09-04', '2025-09-05', '2025-09-19 04:12:50', 'Reserva prueba -6 días', 1, 1, '', 7, 26, NULL),
(12, 400000.00, 'TX107', 'RES107', '2025-09-03', '2025-09-04', '2025-09-28 15:35:39', 'Reserva prueba -7 días', 1, 1, '', 8, 26, NULL),
(13, 130000.00, 'TX100', 'RES100', '2025-09-10', '2025-09-11', '2025-09-19 04:13:01', 'Reserva de prueba hoy', 1, 1, '', 1, 26, NULL),
(14, 960000.00, '', '', '2025-09-18', '2025-09-20', '2025-09-28 15:34:56', '', 1, 0, '', 4, 28, NULL),
(16, 8800000.00, '', '', '2025-09-20', '2025-09-30', '2025-09-28 15:35:04', '', 1, 0, '', 9, 31, NULL),
(17, 6160000.00, '', '', '2025-09-23', '2025-09-30', '2025-09-28 15:35:09', '', 1, 0, '', 9, 28, NULL),
(18, 1760000.00, '', '', '2025-09-24', '2025-09-26', '2025-09-28 15:35:18', '', 1, 0, '', 9, 26, NULL),
(19, 1500000.00, '', '', '2025-09-24', '2025-09-27', '2025-09-28 15:35:23', '', 1, 0, '', 6, 26, NULL),
(20, 80000.00, '', '', '2025-09-24', '2025-09-25', '2025-09-28 15:35:27', '', 1, 0, '', 5, 26, NULL),
(115, 500000.00, '', '', '2025-09-28', '2025-09-29', '2025-09-28 17:23:31', '12', 1, 0, '', 6, 36, NULL),
(176, 90000.00, '', '', '2025-10-15', '2025-10-16', '2025-10-16 04:06:53', '', 2, 1, '', 2, 26, NULL),
(177, 90000.00, '', '', '2025-10-23', '2025-10-24', '2025-10-23 19:19:33', '', 1, 1, '', 2, 26, NULL);

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
  `registrado_por` int(11) DEFAULT NULL,
  `verify` int(11) NOT NULL DEFAULT 0,
  `rol` int(11) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `clave`, `token`, `registrado_por`, `verify`, `rol`, `foto`, `estado`, `fecha`) VALUES
(23, 'Juan', 'Juanesab423@gmail.com', '$2y$10$Ue7srPRjHHeGIr4n3nDdyOecjvHePSGCc9qv5/0OGZ0s7GMWsJpqS', NULL, NULL, 0, 1, NULL, 1, '2025-10-16 04:05:12'),
(25, 'Empleado', 'Empleado@gmail.com', '$2y$10$13KGtawbenSpE81bbt3S..MRqB.0pjrb78JVY9UzUTMLrc/LaZn16', NULL, NULL, 0, 2, NULL, 1, '2025-09-23 21:33:17'),
(26, 'Sofia Salamanca', 'Salamancas648@gmail.com', '$2y$10$hEjwn2u5zkqjw.gOPYpD9etgUVMAl2jySl.Od0.6Apbb85E7TbKw.', NULL, NULL, 0, 3, NULL, 1, '2025-09-05 20:14:18'),
(27, 'William Alfonso', 'Hwilliamac@gmail.com', '$2y$10$ruCR//vCKHBe0xv6MizxGuFBT/F6ZfOhdtxuT.0NR9o8tX3MFkSjO', NULL, 25, 0, 3, NULL, 1, '2025-09-24 20:18:49'),
(28, 'Sebastian', 'Sebastian@gmail.com', '$2y$10$pEiGczFoVj5lPv2.yTsCsu0WaLg6KNE0RpDYPaciakdOBh02n9cuO', NULL, 25, 0, 3, NULL, 1, '2025-09-30 22:57:46'),
(29, 'Cliente ', 'Cliente@gmail.com', '$2y$10$2CzvZA9gpQGXcjNuzJ6V1.q2ycvJwDKc8qBEIvwwF/3ggShMVnZ3q', NULL, 25, 0, 3, NULL, 1, '2025-09-17 12:19:40'),
(30, 'Juan Bernal', 'Juanestebanalfonsobernal@gmail.com', '$2y$10$m4MR553aJpWUEtQihY6DJuqjOBW.XfOMIrnmwwShxNtYz9nJuB1ky', NULL, NULL, 0, 3, NULL, 1, '2025-09-24 19:24:00'),
(31, 'Juan', 'Juanesab230403@gmail.com', '$2y$10$IpwnQ1ImUmybbBzCMAGEle/LgUk.2aywbY7GrQMRT..PFSGhd0VVi', NULL, NULL, 0, 3, NULL, 1, '2025-09-24 18:47:47'),
(33, 'Sebastian', 'juan12332@gmail.com', '$2y$10$LUmKX/JwssbIB9fgS5FeeOCcK6XZMYlCrrl6ysAzyADwuyoR5MJcK', NULL, NULL, 0, 3, NULL, 1, '2025-09-19 13:55:18'),
(34, 'Jose', 'juan1243@gmail.com', '$2y$10$kHzJrO12v1kYTNAhZqN8NeCX4U.DDg4eph3eSintLf2tTX0a4ComC', NULL, NULL, 0, 3, NULL, 1, '2025-09-24 19:23:43'),
(35, 'Juan', 'Juanesab42322@gmail.com', '$2y$10$h4kuZkBylzFsSXafy9JwxO5Fivo8jnuM1UUCYn15Vb.TuaxpWiJz6', NULL, NULL, 0, 3, NULL, 1, '2025-09-19 14:56:16'),
(36, 'William Alfonso', 'Hwliiam@gmail.com', '$2y$10$OwpFV3HpqQpaRym06Mvf8.t2cZK8LUvKRdstL3v1x1DO9h.IZOz4.', NULL, NULL, 0, 3, NULL, 1, '2025-09-19 19:11:12'),
(37, 'William Alfonso', '1234@gmail.com', '$2y$10$0PVwPFBT4Bi1KxgRx30aR.2WQ7M2XcLBLqqN2pQZRIqjcil5dBgXe', NULL, NULL, 0, 3, NULL, 0, '2025-09-24 15:56:44'),
(38, 'Juan', 'juan123@gmail.com', '$2y$10$G5JWF6femdJl4OIO29do1uWF7/Otw.CTm3zV3RPi7LxYYewMFKXBy', NULL, NULL, 0, 3, NULL, 1, '2025-09-28 15:41:09'),
(39, 'William Alfonso', 'Hwliiamac@gmail.com', '$2y$10$8R9lr.jbddieRtrtFK2NoeCNyZxNN0ZZberoI1woGM99JoK9N0cHG', NULL, NULL, 0, 3, NULL, 1, '2025-10-09 15:18:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `correo` (`correo`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `estado` (`estado`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pago_reserva` (`id_reserva`),
  ADD KEY `fk_pago_usuario` (`id_usuario`),
  ADD KEY `fk_pago_habitacion` (`id_habitacion`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_habitacion` (`id_habitacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `reservas_ibfk_3` (`id_empleado`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_ibfk_1` (`rol`),
  ADD KEY `usuarios_ibfk_2` (`registrado_por`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pago_habitacion` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id`),
  ADD CONSTRAINT `fk_pago_reserva` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id`),
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_habitacion`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
