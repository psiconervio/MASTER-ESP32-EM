-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2024 a las 13:25:05
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
-- Base de datos: `id21999724_esp32_01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esp32_01_tablerecord`
--

CREATE TABLE `esp32_01_tablerecord` (
  `id` varchar(255) NOT NULL,
  `board` varchar(255) NOT NULL,
  `temperature` float(10,2) NOT NULL,
  `humidity` int(3) NOT NULL,
  `veleta` varchar(10) NOT NULL,
  `anemometro` int(3) NOT NULL,
  `pluviometro` int(3) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `esp32_01_tablerecord`
--

INSERT INTO `esp32_01_tablerecord` (`id`, `board`, `temperature`, `humidity`, `veleta`, `anemometro`, `pluviometro`, `time`, `date`) VALUES
('id1', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-15'),
('id10', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-06'),
('id11', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-05'),
('id12', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-04'),
('id13', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-03'),
('id14', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-02'),
('id15', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-01'),
('id16', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-04-30'),
('id17', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-04-29'),
('id18', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-04-28'),
('id19', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-04-27'),
('id2', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-14'),
('id20', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-04-26'),
('id3', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-13'),
('id4', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-12'),
('id5', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-11'),
('id6', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-10'),
('id61', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-15'),
('id62', 'esp32_03', 22.30, 20, 'Sur', 12, 0, '08:15:00', '2024-05-15'),
('id63', 'esp32_02', 23.10, 30, 'Este', 11, 0, '08:30:00', '2024-05-15'),
('id64', 'esp32_03', 24.00, 40, 'Oeste', 9, 0, '08:45:00', '2024-05-15'),
('id65', 'esp32_02', 25.20, 50, 'Norte', 8, 0, '09:00:00', '2024-05-15'),
('id66', 'esp32_03', 26.50, 60, 'Sur', 10, 0, '09:15:00', '2024-05-15'),
('id67', 'esp32_02', 27.80, 70, 'Este', 12, 0, '09:30:00', '2024-05-15'),
('id68', 'esp32_03', 28.30, 80, 'Oeste', 11, 0, '09:45:00', '2024-05-15'),
('id69', 'esp32_02', 29.70, 90, 'Norte', 9, 0, '10:00:00', '2024-05-15'),
('id7', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-09'),
('id70', 'esp32_03', 30.10, 100, 'Sur', 10, 0, '10:15:00', '2024-05-15'),
('id71', 'esp32_02', 31.50, 90, 'Este', 12, 0, '10:30:00', '2024-05-15'),
('id72', 'esp32_03', 32.00, 80, 'Oeste', 11, 0, '10:45:00', '2024-05-15'),
('id73', 'esp32_02', 33.20, 70, 'Norte', 8, 0, '11:00:00', '2024-05-15'),
('id74', 'esp32_03', 34.00, 60, 'Sur', 10, 0, '11:15:00', '2024-05-15'),
('id75', 'esp32_02', 35.50, 50, 'Este', 12, 0, '11:30:00', '2024-05-15'),
('id76', 'esp32_03', 36.20, 40, 'Oeste', 11, 0, '11:45:00', '2024-05-15'),
('id77', 'esp32_02', 37.80, 30, 'Norte', 9, 0, '12:00:00', '2024-05-15'),
('id78', 'esp32_03', 38.10, 20, 'Sur', 10, 0, '12:15:00', '2024-05-15'),
('id79', 'esp32_02', 39.60, 10, 'Este', 12, 0, '12:30:00', '2024-05-15'),
('id8', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-08'),
('id80', 'esp32_03', 40.00, 0, 'Oeste', 11, 0, '12:45:00', '2024-05-15'),
('id9', 'esp32_02', 21.50, 10, 'Norte', 10, 0, '08:00:00', '2024-05-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esp32_01_tableupdate`
--

CREATE TABLE `esp32_01_tableupdate` (
  `id` varchar(255) NOT NULL,
  `temperature` float(10,2) NOT NULL,
  `humidity` int(3) NOT NULL,
  `veleta` varchar(255) NOT NULL,
  `anemometro` int(3) NOT NULL,
  `pluviometro` int(3) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `esp32_01_tableupdate`
--

INSERT INTO `esp32_01_tableupdate` (`id`, `temperature`, `humidity`, `veleta`, `anemometro`, `pluviometro`, `time`, `date`) VALUES
('esp32_01', 21.90, 55, 'SUR', 0, 0, '19:05:32', '2024-04-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esp32_01_tableupdatedia`
--

CREATE TABLE `esp32_01_tableupdatedia` (
  `tempmax` int(11) NOT NULL,
  `tempmin` int(11) NOT NULL,
  `hummax` int(11) NOT NULL,
  `hummin` int(11) NOT NULL,
  `veleta` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `anemometro` int(11) NOT NULL,
  `pluviometro` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `esp32_01_tableupdatedia`
--

INSERT INTO `esp32_01_tableupdatedia` (`tempmax`, `tempmin`, `hummax`, `hummin`, `veleta`, `anemometro`, `pluviometro`, `fecha`) VALUES
(40, 22, 100, 0, 'Sur', 12, 0, '2024-05-16'),
(40, 22, 100, 0, 'Sur', 12, 0, '2024-05-15'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-14'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-13'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-12'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-11'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-10'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-09'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-08'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-07'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-06'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-05'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-04'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-03'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-02'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-01'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-30'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-29'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-28'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-27'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-26'),
(40, 22, 100, 0, 'Sur', 12, 0, '2024-05-15'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-14'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-13'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-12'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-11'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-10'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-09'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-08'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-07'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-06'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-05'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-04'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-03'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-02'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-01'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-30'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-29'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-28'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-27'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-26'),
(40, 22, 100, 0, 'Sur', 12, 0, '2024-05-15'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-14'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-13'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-12'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-11'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-10'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-09'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-08'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-07'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-06'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-05'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-04'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-03'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-02'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-05-01'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-30'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-29'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-28'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-27'),
(22, 22, 10, 10, 'Norte', 10, 0, '2024-04-26');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `esp32_01_tablerecord`
--
ALTER TABLE `esp32_01_tablerecord`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `esp32_01_tableupdate`
--
ALTER TABLE `esp32_01_tableupdate`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
