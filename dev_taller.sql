-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 11:45 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_taller`
--

-- --------------------------------------------------------

--
-- Table structure for table `archivos_wo`
--

CREATE TABLE IF NOT EXISTS `archivos_wo` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(500) NOT NULL,
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `catalogo_garantias`
--

CREATE TABLE IF NOT EXISTS `catalogo_garantias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `idus` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `claves_precio`
--

CREATE TABLE IF NOT EXISTS `claves_precio` (
  `id` int(11) NOT NULL,
  `bajo_a` decimal(10,2) NOT NULL,
  `alto_a` decimal(10,2) NOT NULL,
  `bajo_b` decimal(10,2) NOT NULL,
  `alto_b` decimal(10,2) NOT NULL,
  `bajo_c` decimal(10,2) NOT NULL,
  `alto_c` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) NOT NULL,
  `rfc` varchar(50) DEFAULT NULL,
  `dir_fiscal` varchar(100) DEFAULT NULL,
  `num_exterior` varchar(50) NOT NULL,
  `num_interior` varchar(50) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `ciudad` varchar(50) DEFAULT NULL,
  `codigo_postal` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comentarios_wo`
--

CREATE TABLE IF NOT EXISTS `comentarios_wo` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `comentario` varchar(5000) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `archivo` longblob,
  `asignado` int(11) DEFAULT NULL,
  `atendido` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `compatibles`
--

CREATE TABLE IF NOT EXISTS `compatibles` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_modelo` varchar(100) NOT NULL,
  `ano` int(11) NOT NULL,
  `motor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detalles_scrap`
--

CREATE TABLE IF NOT EXISTS `detalles_scrap` (
  `id` int(11) NOT NULL,
  `id_scrap` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_ubi` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detalles_venta`
--

CREATE TABLE IF NOT EXISTS `detalles_venta` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_ubi` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detalleventtc`
--

CREATE TABLE IF NOT EXISTS `detalleventtc` (
  `idDVTC` int(11) NOT NULL,
  `idVenta` int(11) DEFAULT NULL,
  `idUs` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `export_temp`
--
CREATE TABLE IF NOT EXISTS `export_temp` (
`idProducto` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `fotos_comentarios_wo`
--

CREATE TABLE IF NOT EXISTS `fotos_comentarios_wo` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foto` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `garantia`
--

CREATE TABLE IF NOT EXISTS `garantia` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `garantia` varchar(500) NOT NULL,
  `motivo` varchar(500) NOT NULL,
  `accion` varchar(500) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `dinero` int(11) DEFAULT NULL,
  `credito` int(11) DEFAULT NULL,
  `articulo` int(11) DEFAULT NULL,
  `estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `magnitudes`
--

CREATE TABLE IF NOT EXISTS `magnitudes` (
  `id` int(11) NOT NULL,
  `magnitud` varchar(80) NOT NULL,
  `prefijo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `marcas`
--

CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Slug` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modelos`
--

CREATE TABLE IF NOT EXISTS `modelos` (
  `id` int(11) NOT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `ano` varchar(100) DEFAULT NULL,
  `motor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `movimientostool`
--

CREATE TABLE IF NOT EXISTS `movimientostool` (
  `idMov` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `local` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `comentario` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ordenes_trabajo`
--

CREATE TABLE IF NOT EXISTS `ordenes_trabajo` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_asignado` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_programada` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `piezas` int(11) DEFAULT NULL,
  `vehiculo` varchar(100) DEFAULT NULL,
  `motor` varchar(100) DEFAULT NULL,
  `descripcion` varchar(2000) NOT NULL,
  `total` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_venta`
--

CREATE TABLE IF NOT EXISTS `pagos_venta` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `total` varchar(50) NOT NULL,
  `adelanto` varchar(50) NOT NULL,
  `restante` varchar(50) NOT NULL,
  `us` int(11) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_wo`
--

CREATE TABLE IF NOT EXISTS `pagos_wo` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `cantidad` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `us` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `piezas_motor`
--

CREATE TABLE IF NOT EXISTS `piezas_motor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `precio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `piezas_ser_motor`
--

CREATE TABLE IF NOT EXISTS `piezas_ser_motor` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `id_pieza` int(11) NOT NULL,
  `size` varchar(500) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `piezas_temp`
--

CREATE TABLE IF NOT EXISTS `piezas_temp` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `idpieza` int(11) NOT NULL,
  `precio` varchar(100) NOT NULL,
  `size` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `privilegios`
--

CREATE TABLE IF NOT EXISTS `privilegios` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `administrar_usuarios` int(11) NOT NULL DEFAULT '0',
  `reloj` int(11) NOT NULL DEFAULT '0',
  `produTC` int(11) NOT NULL DEFAULT '0',
  `crearPedidosTC` int(11) NOT NULL DEFAULT '0',
  `autorizarTC` int(11) NOT NULL DEFAULT '0',
  `movimientosTC` int(11) NOT NULL DEFAULT '0',
  `crear_garantia` int(11) NOT NULL DEFAULT '0',
  `retiro` int(11) NOT NULL DEFAULT '0',
  `crear_carrito` int(11) NOT NULL DEFAULT '0',
  `crear_venta` int(11) NOT NULL DEFAULT '0',
  `crear_orden` int(11) NOT NULL DEFAULT '0',
  `admin_orden` int(11) NOT NULL DEFAULT '0',
  `crear_scrap` int(11) NOT NULL DEFAULT '0',
  `adm_scrap` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `privilegios`
--

INSERT INTO `privilegios` (`id`, `usuario`, `administrar_usuarios`, `reloj`, `produTC`, `crearPedidosTC`, `autorizarTC`, `movimientosTC`, `crear_garantia`, `retiro`, `crear_carrito`, `crear_venta`, `crear_orden`, `admin_orden`, `crear_scrap`, `adm_scrap`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int(11) NOT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `producto` varchar(200) DEFAULT NULL,
  `descripcion` varchar(1500) DEFAULT NULL,
  `proveedor` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `precio` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `um` varchar(50) DEFAULT NULL,
  `garantia` varchar(50) DEFAULT NULL,
  `cantMax` int(11) DEFAULT NULL,
  `cantMin` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT '0',
  `foto` longblob,
  `defecto` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `puestos`
--

CREATE TABLE IF NOT EXISTS `puestos` (
  `id` int(11) NOT NULL,
  `puesto` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `puestos`
--

INSERT INTO `puestos` (`id`, `puesto`) VALUES
(1, 'MAQUINADOS');

-- --------------------------------------------------------

--
-- Table structure for table `scrap`
--

CREATE TABLE IF NOT EXISTS `scrap` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int(11) NOT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `motivo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scrap_temp`
--

CREATE TABLE IF NOT EXISTS `scrap_temp` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_ubi` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE IF NOT EXISTS `servicios` (
  `id` int(11) NOT NULL,
  `magnitud` varchar(100) NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sitio` varchar(15) NOT NULL,
  `clave_precio` varchar(50) NOT NULL,
  `interno` int(11) NOT NULL,
  `observaciones` text NOT NULL,
  `tags` text NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicios_wo`
--

CREATE TABLE IF NOT EXISTS `servicios_wo` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicios_wo_temp`
--

CREATE TABLE IF NOT EXISTS `servicios_wo_temp` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `precio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tickets_wo`
--

CREATE TABLE IF NOT EXISTS `tickets_wo` (
  `id` int(11) NOT NULL,
  `id_wo` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ubiprods`
--

CREATE TABLE IF NOT EXISTS `ubiprods` (
  `idUbi` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `defecto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `no_empleado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `paterno` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `materno` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `departamento` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `puesto` int(11) NOT NULL,
  `correo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `vencimiento_password` datetime DEFAULT NULL,
  `ultima_sesion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` int(11) DEFAULT NULL,
  `foto` longblob,
  `jefe_directo` int(11) NOT NULL DEFAULT '0',
  `autorizador_compras` int(11) NOT NULL DEFAULT '0',
  `autorizador_compras_venta` int(11) NOT NULL DEFAULT '0',
  `autorizador_cotizacion` int(11) NOT NULL DEFAULT '0',
  `autorizadorTC` int(11) NOT NULL DEFAULT '0',
  `password_correo` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `chat_server` int(11) DEFAULT NULL,
  `huella` longblob,
  `unique_id` int(11) DEFAULT NULL,
  `cod_descuento` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `no_empleado`, `fecha_alta`, `nombre`, `paterno`, `materno`, `departamento`, `puesto`, `correo`, `password`, `vencimiento_password`, `ultima_sesion`, `activo`, `foto`, `jefe_directo`, `autorizador_compras`, `autorizador_compras_venta`, `autorizador_cotizacion`, `autorizadorTC`, `password_correo`, `chat_server`, `huella`, `unique_id`, `cod_descuento`) VALUES
(1, 'MQ-001', '2025-05-17 18:16:25', 'Edgar', 'Rivera', 'McClane', 'MAQUINADOS', 1, 'erivera@regel.mx', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2026-06-28 00:00:00', '2025-07-28 14:28:24', 1, 0x0000001c667479706176696600000000617669666d6966316d696166000000ea6d657461000000000000002168646c72000000000000000070696374000000000000000000000000000000000e7069746d00000000000100000022696c6f630000000044400001000100000000010e0001000000000000061b0000002369696e6600000000000100000015696e6665020000000001000061763031000000006a697072700000004b6970636f00000013636f6c726e636c780001000d0006800000000c6176314381040c00000000146973706500000000000002e4000002e4000000107069786900000000030808080000001769706d61000000000000000100010401820304000006236d64617412000a0a19266e3b8f82021a0d08328a0c11400104104140f4bacdcb2f4897a2cc596702a06ededdf47e362e12f8a9921e05a86d603c3ac9c2deede8eb52c8be46b196b7aa6ddd8fb3990c2d457cffcf803e4d3d989698aba1430cd1e72479efe2cea17cc7c135e05319dae4e2e0d4f02dddff498a629b5e6808421f96da7171399656f6a1209350844d171fbedbbed79786e068753e67d0e34c4f6b28087bf37c11a2f4e8ca1443c7cbe714295c40301090f418109e14e67517347a7fc22515db1437b7b7f0db7dfd742f64c08deb2563cb4c31a46f6315fc918657e19586fad1b1817b6156127e4413e897afa01f7f8d0495ee5f1ba31a1f6facca66a690289af4a9fe980ccd063d7f10bc3faa8abde495a2f0b99b01f333115ab362840e507c88c74e594e079053152289b104ae2a5d3562ad005449472b07409f68c4d7c464f5e8cd0a2a6ec7b5814ce32979d29b04ee5446063764ec4080def78c87629e85e99313d383b714c79ede6e036911f5893ae418bdf90e57df0d084d8188928e06b5e4c8f72f82f0a3813e993966cdab3969681aad85530b60290a041764d3ae9a5ff62eb547a3f6b62825c627b79a232d9c08da9eae702724583362f86854391ff62c6edd832e1ae69e9da94e7aa45f469b110abd1357967e4d5348e9e151275cd15689bcd00ea012593d77a35fe5827527cb319dc03b397e7a3dcdf7ed4c42557a9d751f2cafaed34f9ed929d19cd0052ee8904efb633b59bc36d89494bad0a47642135194bb74b327df2d1ebf1bb21d011e354c2f5643749453f6ab32f93f7a67be89265606d49a65a4b27d7ec61b9678aea5b338702a1c5f40ec65389cac117b9783500bbcad11b74a04da7141c8c4aa0bd58ab38832ef9f51b38678a43f8d24f02adaa651043f53a172f824e1c08570db3e088a614c1de5c57dff750f8716c26d438cc2ca4ad82262d586f1f681d78703584512b318d38ac6648c244b3f96a26070cba5d1c8ddc1ab092b63520f3afb5821a1cce81717ee262fc64010b8f6c8012c28ed42b331399103ec12205b9282a8ebf4410242cabb766362c73ad28d393543ce83af46a8be436f7c01bd30fbfc9245ebcf6758046ebb0af89d1f60a1b16b5e42c82b55cf64a518f8b12ad0d191855aeee26048919361467a3b18dc57abc07983c26f89884eb345a18fd319194a8ecaa5e8dcb8a5c7aeb44dd67c0c16d196e27dba843415df7f4f98035fdbd6d0188ee3df2a0ae2a4a48b2df18df19513f82978a8b2b48645d92d709daffa2d5d574895dfa64a7028fa8fc189529a34af40f33b808c46c6b65a1303858f63770491597abab97ddbe7032fa0e573e75fe875a3272af0f301f1df5f58d24fd1233f25f33fdf87b42a318465068da4582c11c1eaa4d7f0d71eaf3cee1fba1712823898aefa01621332f7d4d07eb56d9cac2c5f0704e22a0ab4af7803bf9a012bff3b85d0d6c4f2535bd9f2c7c1ddec41a8146dcad57564d61e5265b229d52eff608636ccf1f553316ad8c35cc162a70db95fe142ef7e8f6e62f59737ce29656b8a2d40869402923ff3432dac1b7a67bad39241482e84f5b75da5fc258e7e6ae668c062dc787186503420ead0694a65e9e29fddaa48c28dfbb4c57dc3ba44a08e4aebc74436357c1fc6acc9d53bca9eafa1649caccfe421bb8c23da603a675dc143364c25e75b0467f59ac4ca8c9771162fe8f28d431cca61d7e064e1d5b0f8621c0d8eb9955fb21b953e75690b8f0292e83a4765426fbdd0d5e759bf6604cd4e96bfd1ca185a96b990f806281051a0fbc187182d0c052fb579199941bddcb85f5002100ebf05ed9c47f8c0164c7ae7ecb55319a5d6ccd0c78e38811a4670c4b1a3618a95f2542dc74349f3e1b5460e782cedbb56472ba050bbe9e04b2fdd096fd2e7d5691762c2847a53835d8434907b15fea916220a227d43c93d8afaf9817c8d898dd300cc2369c50c4fe3eea4f49ebee9c7979e8987c3160ee25eecdd6948b7e97ff48493484b362ce8b36869d9fd906e8501205d83171296ac09f5cd972631791a209f53b192d1467a743461b1e7dd91ef659b8b2449b30f11e01dfa0e4ef110f816ea0ff9491c311d54cf193774d24aeb64aec910dd65258880cafc590f7e450ed4451c76381bfed9df6452b75c499ecb727edcad7dd85d1fe6c9a52b97a2f9fb545535caabe2cd8c, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(2, 'MQ-002', '2025-05-20 15:42:12', 'User2', 'User2', 'User2', 'MAQUINADOS', 1, 'rsierra@regel.mx', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2026-05-29 00:00:00', '2025-05-20 15:42:12', 1, NULL, 0, 0, 0, 0, 0, NULL, NULL, 0x0000001c667479706176696600000000617669666d6966316d696166000000ea6d657461000000000000002168646c72000000000000000070696374000000000000000000000000000000000e7069746d00000000000100000022696c6f630000000044400001000100000000010e0001000000000000061b0000002369696e6600000000000100000015696e6665020000000001000061763031000000006a697072700000004b6970636f00000013636f6c726e636c780001000d0006800000000c6176314381040c00000000146973706500000000000002e4000002e4000000107069786900000000030808080000001769706d61000000000000000100010401820304000006236d64617412000a0a19266e3b8f82021a0d08328a0c11400104104140f4bacdcb2f4897a2cc596702a06ededdf47e362e12f8a9921e05a86d603c3ac9c2deede8eb52c8be46b196b7aa6ddd8fb3990c2d457cffcf803e4d3d989698aba1430cd1e72479efe2cea17cc7c135e05319dae4e2e0d4f02dddff498a629b5e6808421f96da7171399656f6a1209350844d171fbedbbed79786e068753e67d0e34c4f6b28087bf37c11a2f4e8ca1443c7cbe714295c40301090f418109e14e67517347a7fc22515db1437b7b7f0db7dfd742f64c08deb2563cb4c31a46f6315fc918657e19586fad1b1817b6156127e4413e897afa01f7f8d0495ee5f1ba31a1f6facca66a690289af4a9fe980ccd063d7f10bc3faa8abde495a2f0b99b01f333115ab362840e507c88c74e594e079053152289b104ae2a5d3562ad005449472b07409f68c4d7c464f5e8cd0a2a6ec7b5814ce32979d29b04ee5446063764ec4080def78c87629e85e99313d383b714c79ede6e036911f5893ae418bdf90e57df0d084d8188928e06b5e4c8f72f82f0a3813e993966cdab3969681aad85530b60290a041764d3ae9a5ff62eb547a3f6b62825c627b79a232d9c08da9eae702724583362f86854391ff62c6edd832e1ae69e9da94e7aa45f469b110abd1357967e4d5348e9e151275cd15689bcd00ea012593d77a35fe5827527cb319dc03b397e7a3dcdf7ed4c42557a9d751f2cafaed34f9ed929d19cd0052ee8904efb633b59bc36d89494bad0a47642135194bb74b327df2d1ebf1bb21d011e354c2f5643749453f6ab32f93f7a67be89265606d49a65a4b27d7ec61b9678aea5b338702a1c5f40ec65389cac117b9783500bbcad11b74a04da7141c8c4aa0bd58ab38832ef9f51b38678a43f8d24f02adaa651043f53a172f824e1c08570db3e088a614c1de5c57dff750f8716c26d438cc2ca4ad82262d586f1f681d78703584512b318d38ac6648c244b3f96a26070cba5d1c8ddc1ab092b63520f3afb5821a1cce81717ee262fc64010b8f6c8012c28ed42b331399103ec12205b9282a8ebf4410242cabb766362c73ad28d393543ce83af46a8be436f7c01bd30fbfc9245ebcf6758046ebb0af89d1f60a1b16b5e42c82b55cf64a518f8b12ad0d191855aeee26048919361467a3b18dc57abc07983c26f89884eb345a18fd319194a8ecaa5e8dcb8a5c7aeb44dd67c0c16d196e27dba843415df7f4f98035fdbd6d0188ee3df2a0ae2a4a48b2df18df19513f82978a8b2b48645d92d709daffa2d5d574895dfa64a7028fa8fc189529a34af40f33b808c46c6b65a1303858f63770491597abab97ddbe7032fa0e573e75fe875a3272af0f301f1df5f58d24fd1233f25f33fdf87b42a318465068da4582c11c1eaa4d7f0d71eaf3cee1fba1712823898aefa01621332f7d4d07eb56d9cac2c5f0704e22a0ab4af7803bf9a012bff3b85d0d6c4f2535bd9f2c7c1ddec41a8146dcad57564d61e5265b229d52eff608636ccf1f553316ad8c35cc162a70db95fe142ef7e8f6e62f59737ce29656b8a2d40869402923ff3432dac1b7a67bad39241482e84f5b75da5fc258e7e6ae668c062dc787186503420ead0694a65e9e29fddaa48c28dfbb4c57dc3ba44a08e4aebc74436357c1fc6acc9d53bca9eafa1649caccfe421bb8c23da603a675dc143364c25e75b0467f59ac4ca8c9771162fe8f28d431cca61d7e064e1d5b0f8621c0d8eb9955fb21b953e75690b8f0292e83a4765426fbdd0d5e759bf6604cd4e96bfd1ca185a96b990f806281051a0fbc187182d0c052fb579199941bddcb85f5002100ebf05ed9c47f8c0164c7ae7ecb55319a5d6ccd0c78e38811a4670c4b1a3618a95f2542dc74349f3e1b5460e782cedbb56472ba050bbe9e04b2fdd096fd2e7d5691762c2847a53835d8434907b15fea916220a227d43c93d8afaf9817c8d898dd300cc2369c50c4fe3eea4f49ebee9c7979e8987c3160ee25eecdd6948b7e97ff48493484b362ce8b36869d9fd906e8501205d83171296ac09f5cd972631791a209f53b192d1467a743461b1e7dd91ef659b8b2449b30f11e01dfa0e4ef110f816ea0ff9491c311d54cf193774d24aeb64aec910dd65258880cafc590f7e450ed4451c76381bfed9df6452b75c499ecb727edcad7dd85d1fe6c9a52b97a2f9fb545535caabe2cd8c, NULL, NULL),
(3, 'MQ-003', '2025-05-20 15:42:53', 'User2', 'User2', 'User2', 'MAQUINADOS', 1, 'Carlos@regel.mx', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2026-05-29 00:00:00', '2025-05-20 15:43:07', 1, NULL, 0, 0, 0, 0, 0, NULL, NULL, 0x0000001c667479706176696600000000617669666d6966316d696166000000ea6d657461000000000000002168646c72000000000000000070696374000000000000000000000000000000000e7069746d00000000000100000022696c6f630000000044400001000100000000010e0001000000000000061b0000002369696e6600000000000100000015696e6665020000000001000061763031000000006a697072700000004b6970636f00000013636f6c726e636c780001000d0006800000000c6176314381040c00000000146973706500000000000002e4000002e4000000107069786900000000030808080000001769706d61000000000000000100010401820304000006236d64617412000a0a19266e3b8f82021a0d08328a0c11400104104140f4bacdcb2f4897a2cc596702a06ededdf47e362e12f8a9921e05a86d603c3ac9c2deede8eb52c8be46b196b7aa6ddd8fb3990c2d457cffcf803e4d3d989698aba1430cd1e72479efe2cea17cc7c135e05319dae4e2e0d4f02dddff498a629b5e6808421f96da7171399656f6a1209350844d171fbedbbed79786e068753e67d0e34c4f6b28087bf37c11a2f4e8ca1443c7cbe714295c40301090f418109e14e67517347a7fc22515db1437b7b7f0db7dfd742f64c08deb2563cb4c31a46f6315fc918657e19586fad1b1817b6156127e4413e897afa01f7f8d0495ee5f1ba31a1f6facca66a690289af4a9fe980ccd063d7f10bc3faa8abde495a2f0b99b01f333115ab362840e507c88c74e594e079053152289b104ae2a5d3562ad005449472b07409f68c4d7c464f5e8cd0a2a6ec7b5814ce32979d29b04ee5446063764ec4080def78c87629e85e99313d383b714c79ede6e036911f5893ae418bdf90e57df0d084d8188928e06b5e4c8f72f82f0a3813e993966cdab3969681aad85530b60290a041764d3ae9a5ff62eb547a3f6b62825c627b79a232d9c08da9eae702724583362f86854391ff62c6edd832e1ae69e9da94e7aa45f469b110abd1357967e4d5348e9e151275cd15689bcd00ea012593d77a35fe5827527cb319dc03b397e7a3dcdf7ed4c42557a9d751f2cafaed34f9ed929d19cd0052ee8904efb633b59bc36d89494bad0a47642135194bb74b327df2d1ebf1bb21d011e354c2f5643749453f6ab32f93f7a67be89265606d49a65a4b27d7ec61b9678aea5b338702a1c5f40ec65389cac117b9783500bbcad11b74a04da7141c8c4aa0bd58ab38832ef9f51b38678a43f8d24f02adaa651043f53a172f824e1c08570db3e088a614c1de5c57dff750f8716c26d438cc2ca4ad82262d586f1f681d78703584512b318d38ac6648c244b3f96a26070cba5d1c8ddc1ab092b63520f3afb5821a1cce81717ee262fc64010b8f6c8012c28ed42b331399103ec12205b9282a8ebf4410242cabb766362c73ad28d393543ce83af46a8be436f7c01bd30fbfc9245ebcf6758046ebb0af89d1f60a1b16b5e42c82b55cf64a518f8b12ad0d191855aeee26048919361467a3b18dc57abc07983c26f89884eb345a18fd319194a8ecaa5e8dcb8a5c7aeb44dd67c0c16d196e27dba843415df7f4f98035fdbd6d0188ee3df2a0ae2a4a48b2df18df19513f82978a8b2b48645d92d709daffa2d5d574895dfa64a7028fa8fc189529a34af40f33b808c46c6b65a1303858f63770491597abab97ddbe7032fa0e573e75fe875a3272af0f301f1df5f58d24fd1233f25f33fdf87b42a318465068da4582c11c1eaa4d7f0d71eaf3cee1fba1712823898aefa01621332f7d4d07eb56d9cac2c5f0704e22a0ab4af7803bf9a012bff3b85d0d6c4f2535bd9f2c7c1ddec41a8146dcad57564d61e5265b229d52eff608636ccf1f553316ad8c35cc162a70db95fe142ef7e8f6e62f59737ce29656b8a2d40869402923ff3432dac1b7a67bad39241482e84f5b75da5fc258e7e6ae668c062dc787186503420ead0694a65e9e29fddaa48c28dfbb4c57dc3ba44a08e4aebc74436357c1fc6acc9d53bca9eafa1649caccfe421bb8c23da603a675dc143364c25e75b0467f59ac4ca8c9771162fe8f28d431cca61d7e064e1d5b0f8621c0d8eb9955fb21b953e75690b8f0292e83a4765426fbdd0d5e759bf6604cd4e96bfd1ca185a96b990f806281051a0fbc187182d0c052fb579199941bddcb85f5002100ebf05ed9c47f8c0164c7ae7ecb55319a5d6ccd0c78e38811a4670c4b1a3618a95f2542dc74349f3e1b5460e782cedbb56472ba050bbe9e04b2fdd096fd2e7d5691762c2847a53835d8434907b15fea916220a227d43c93d8afaf9817c8d898dd300cc2369c50c4fe3eea4f49ebee9c7979e8987c3160ee25eecdd6948b7e97ff48493484b362ce8b36869d9fd906e8501205d83171296ac09f5cd972631791a209f53b192d1467a743461b1e7dd91ef659b8b2449b30f11e01dfa0e4ef110f816ea0ff9491c311d54cf193774d24aeb64aec910dd65258880cafc590f7e450ed4451c76381bfed9df6452b75c499ecb727edcad7dd85d1fe6c9a52b97a2f9fb545535caabe2cd8c, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
  `id` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int(11) NOT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) NOT NULL,
  `tipo_pago` varchar(50) DEFAULT NULL,
  `tipo_descuento` varchar(50) DEFAULT NULL,
  `descuento` varchar(50) DEFAULT NULL,
  `total_final` varchar(50) DEFAULT NULL,
  `caja` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `venttctemp`
--

CREATE TABLE IF NOT EXISTS `venttctemp` (
  `idvt` int(11) NOT NULL,
  `idUs` int(11) NOT NULL,
  `idProd` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `venttoolcrib`
--

CREATE TABLE IF NOT EXISTS `venttoolcrib` (
  `idToolCrib` int(11) NOT NULL,
  `idUs` int(11) NOT NULL,
  `aprobador` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_servicio` int(11) DEFAULT NULL,
  `id_garantia` int(11) DEFAULT NULL,
  `total` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vent_temp`
--

CREATE TABLE IF NOT EXISTS `vent_temp` (
  `id` int(11) NOT NULL,
  `id_us` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `id_ubi` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure for view `export_temp`
--
DROP TABLE IF EXISTS `export_temp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `export_temp` AS select `productos`.`idProducto` AS `idProducto` from `productos`;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivos_wo`
--
ALTER TABLE `archivos_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalogo_garantias`
--
ALTER TABLE `catalogo_garantias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `claves_precio`
--
ALTER TABLE `claves_precio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comentarios_wo`
--
ALTER TABLE `comentarios_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compatibles`
--
ALTER TABLE `compatibles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalles_scrap`
--
ALTER TABLE `detalles_scrap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalles_venta`
--
ALTER TABLE `detalles_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detalleventtc`
--
ALTER TABLE `detalleventtc`
  ADD PRIMARY KEY (`idDVTC`);

--
-- Indexes for table `fotos_comentarios_wo`
--
ALTER TABLE `fotos_comentarios_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `garantia`
--
ALTER TABLE `garantia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magnitudes`
--
ALTER TABLE `magnitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movimientostool`
--
ALTER TABLE `movimientostool`
  ADD PRIMARY KEY (`idMov`);

--
-- Indexes for table `ordenes_trabajo`
--
ALTER TABLE `ordenes_trabajo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagos_venta`
--
ALTER TABLE `pagos_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagos_wo`
--
ALTER TABLE `pagos_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `piezas_motor`
--
ALTER TABLE `piezas_motor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `piezas_ser_motor`
--
ALTER TABLE `piezas_ser_motor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `piezas_temp`
--
ALTER TABLE `piezas_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indexes for table `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `puesto_UNIQUE` (`puesto`);

--
-- Indexes for table `scrap`
--
ALTER TABLE `scrap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scrap_temp`
--
ALTER TABLE `scrap_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicios_wo`
--
ALTER TABLE `servicios_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicios_wo_temp`
--
ALTER TABLE `servicios_wo_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_wo`
--
ALTER TABLE `tickets_wo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ubiprods`
--
ALTER TABLE `ubiprods`
  ADD PRIMARY KEY (`idUbi`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_empleado_UNIQUE` (`no_empleado`),
  ADD UNIQUE KEY `correo_UNIQUE` (`correo`),
  ADD KEY `fk_usuarios_puesto_idx` (`puesto`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `venttctemp`
--
ALTER TABLE `venttctemp`
  ADD PRIMARY KEY (`idvt`);

--
-- Indexes for table `venttoolcrib`
--
ALTER TABLE `venttoolcrib`
  ADD PRIMARY KEY (`idToolCrib`);

--
-- Indexes for table `vent_temp`
--
ALTER TABLE `vent_temp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archivos_wo`
--
ALTER TABLE `archivos_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catalogo_garantias`
--
ALTER TABLE `catalogo_garantias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `claves_precio`
--
ALTER TABLE `claves_precio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comentarios_wo`
--
ALTER TABLE `comentarios_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `compatibles`
--
ALTER TABLE `compatibles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detalles_scrap`
--
ALTER TABLE `detalles_scrap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detalles_venta`
--
ALTER TABLE `detalles_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detalleventtc`
--
ALTER TABLE `detalleventtc`
  MODIFY `idDVTC` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fotos_comentarios_wo`
--
ALTER TABLE `fotos_comentarios_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `garantia`
--
ALTER TABLE `garantia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `magnitudes`
--
ALTER TABLE `magnitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `movimientostool`
--
ALTER TABLE `movimientostool`
  MODIFY `idMov` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ordenes_trabajo`
--
ALTER TABLE `ordenes_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagos_venta`
--
ALTER TABLE `pagos_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pagos_wo`
--
ALTER TABLE `pagos_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `piezas_motor`
--
ALTER TABLE `piezas_motor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `piezas_ser_motor`
--
ALTER TABLE `piezas_ser_motor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `piezas_temp`
--
ALTER TABLE `piezas_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `scrap`
--
ALTER TABLE `scrap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scrap_temp`
--
ALTER TABLE `scrap_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicios_wo`
--
ALTER TABLE `servicios_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicios_wo_temp`
--
ALTER TABLE `servicios_wo_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tickets_wo`
--
ALTER TABLE `tickets_wo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ubiprods`
--
ALTER TABLE `ubiprods`
  MODIFY `idUbi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `venttctemp`
--
ALTER TABLE `venttctemp`
  MODIFY `idvt` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `venttoolcrib`
--
ALTER TABLE `venttoolcrib`
  MODIFY `idToolCrib` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vent_temp`
--
ALTER TABLE `vent_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_puesto` FOREIGN KEY (`puesto`) REFERENCES `puestos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
