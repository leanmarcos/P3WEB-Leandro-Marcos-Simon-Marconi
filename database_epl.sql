-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2024 a las 14:27:19
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
-- Base de datos: `database_epl`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `fundacion` int(11) NOT NULL,
  `estadio` varchar(55) NOT NULL,
  `logo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nombre`, `fundacion`, `estadio`, `logo`) VALUES
(1, 'Arsenal', 1886, 'Emirates Stadium', 'https://cdn.sofifa.net/meta/team/19/120.png'),
(4, 'Manchester City', 1880, 'Eithad Stadium', 'https://cdn.sofifa.net/meta/team/9/120.png'),
(5, 'Liverpool', 1892, 'Anfield', 'https://cdn.sofifa.net/meta/team/8/120.png'),
(6, 'Tottenham', 1880, 'Tottenham Hotspur Stadium', 'https://cdn.sofifa.net/meta/team/6/120.png'),
(14, 'Manchester United', 1878, 'Old Trafford', 'https://cdn.sofifa.net/meta/team/14/120.png'),
(22, 'Chelsea', 1905, 'Stamford Bridge', 'https://cdn.sofifa.net/meta/team/18/120.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id_jugador` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `edad` int(11) NOT NULL,
  `club` int(11) NOT NULL,
  `valor_de_mercado` varchar(40) NOT NULL,
  `posicion` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id_jugador`, `nombre`, `edad`, `club`, `valor_de_mercado`, `posicion`) VALUES
(1, 'Mohamed Salah', 32, 5, '55M', 'Delantero'),
(4, 'Martin Odegaard', 25, 1, '110M', 'Mediocampista'),
(5, 'Rodri', 28, 4, '130M', 'Mediocampista'),
(6, 'Virgil Van Dijk', 33, 5, '30M', 'Defensor'),
(8, 'Cristian Romero', 26, 6, '65M', 'Defensor'),
(35, 'Lisandro Martinez', 25, 14, '50M', 'Defensor'),
(36, 'Cole Palmer', 22, 22, '55M', 'Mediocampista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

CREATE TABLE `reseñas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id`, `titulo`, `descripcion`, `valor`) VALUES
(1, 'Regular', 'Esta regular porque', 3),
(2, 'Pruebando editar', 'Prueba de PUT', 4),
(3, 'Siendo sincero la verdad', 'Buena pagina', 5),
(5, 'OK', 'La pagina esta OK', 2),
(6, 'Sin comentarios', 'No es clara', 2),
(8, 'Prueba', 'Prueba de POST', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(1, 'webadmin', '$2y$10$lUdQYKlptAUeD5tnFZ6G1.WS.eBP6V5o.Eh/QxLirCq4eTxE41LWW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id_jugador`),
  ADD KEY `club` (`club`),
  ADD KEY `club_2` (`club`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id_jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `jugadores_ibfk_1` FOREIGN KEY (`club`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
