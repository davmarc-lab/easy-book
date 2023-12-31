-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2023 at 03:42 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easybook`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenzia`
--

CREATE TABLE `agenzia` (
  `id` int NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `proprietario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sedeFisica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_utente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenzia`
--

INSERT INTO `agenzia` (`id`, `nome`, `proprietario`, `sedeFisica`, `telefono`, `id_utente`) VALUES
(9, 'Eco Jurnay', 'Luigi Bianchi', 'Milano', '', 14),
(10, ' Info Agency', 'Davide Marchetti', '', '', 1),
(11, 'EasyTravel', 'Marco Sinto', '', '', 15);

-- --------------------------------------------------------

--
-- Table structure for table `agenzia_utente`
--

CREATE TABLE `agenzia_utente` (
  `id` int NOT NULL,
  `tipoContratto` varchar(50) NOT NULL,
  `scadenza` date DEFAULT NULL,
  `id_agenzia` int NOT NULL,
  `id_utente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `agenzia_utente`
--

INSERT INTO `agenzia_utente` (`id`, `tipoContratto`, `scadenza`, `id_agenzia`, `id_utente`) VALUES
(8, 'indeterminato', NULL, 9, 1),
(11, 'indeterminato', NULL, 10, 4),
(12, 'determinato', '2024-04-11', 10, 6),
(14, 'determinato', '2025-08-31', 9, 15),
(16, 'determinato', '2025-06-05', 11, 8),
(17, 'a chiamata', '2024-08-31', 11, 9),
(18, 'indeterminato', NULL, 9, 9),
(19, 'indeterminato', NULL, 10, 14);

-- --------------------------------------------------------

--
-- Table structure for table `amministratore`
--

CREATE TABLE `amministratore` (
  `id` int NOT NULL,
  `dataDebutto` date NOT NULL,
  `dataRitiro` date DEFAULT NULL,
  `id_utente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `amministratore`
--

INSERT INTO `amministratore` (`id`, `dataDebutto`, `dataRitiro`, `id_utente`) VALUES
(1, '2023-08-02', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int NOT NULL,
  `codiceSconto` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descrizione` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_agenzia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `codiceSconto`, `descrizione`, `id_agenzia`) VALUES
(2, '69149X255D', 'Codice sconto prima prenotazione.', 9);

-- --------------------------------------------------------

--
-- Table structure for table `itinerario`
--

CREATE TABLE `itinerario` (
  `id` int NOT NULL,
  `descrizione` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `itinerario`
--

INSERT INTO `itinerario` (`id`, `descrizione`) VALUES
(1, 'Viaggio per la città di Roma.'),
(2, 'Viaggio di prova'),
(3, 'Seconda prova'),
(4, 'Giro turistico per la via Salaria'),
(5, 'Giro turistico per le 3 città famose della Spagna'),
(6, 'Viaggio strano'),
(7, 'Prova modifica'),
(12, 'Giro turistico per Ascoli Piceno e dintorni'),
(13, 'Giro turistico ascoli storica e san benedetto.'),
(14, 'Spend one week at New York.'),
(15, 'Giro turistuco per Ascoli Piceno e San Benedetto del Tronto'),
(16, 'Fine settimana visitando la germania del nord.'),
(17, 'Natale in america.');

-- --------------------------------------------------------

--
-- Table structure for table `itinerario_localita`
--

CREATE TABLE `itinerario_localita` (
  `id` int NOT NULL,
  `id_localita` int NOT NULL,
  `id_itinerario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `itinerario_localita`
--

INSERT INTO `itinerario_localita` (`id`, `id_localita`, `id_itinerario`) VALUES
(1, 15, 1),
(2, 1, 1),
(3, 1, 3),
(4, 15, 4),
(5, 1, 4),
(75, 11, 5),
(76, 68, 5),
(77, 69, 5),
(78, 2, 6),
(79, 70, 6),
(80, 71, 6),
(84, 2, 7),
(85, 70, 7),
(86, 71, 7),
(96, 1, 12),
(100, 1, 13),
(101, 66, 13),
(102, 76, 14),
(105, 1, 15),
(106, 66, 15),
(107, 27, 16),
(108, 77, 16),
(109, 78, 16),
(110, 76, 17);

-- --------------------------------------------------------

--
-- Table structure for table `localita`
--

CREATE TABLE `localita` (
  `id` int NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stato` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `continente` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `localita`
--

INSERT INTO `localita` (`id`, `nome`, `stato`, `continente`) VALUES
(1, 'Ascoli Piceno', 'Italia', 'Europa'),
(2, 'Parigi', 'Francia', 'Europa'),
(3, 'Tokyo', 'Giappone', 'Asia'),
(4, 'New York City', 'Stati Uniti', 'America del Nord'),
(5, 'Città del Capo', 'Sudafrica', 'Africa'),
(6, 'Sydney', 'Australia', 'Oceania'),
(7, 'Venezia', 'Italia', 'Europa'),
(8, 'Rio de Janeiro', 'Brasile', 'America del Sud'),
(9, 'Amsterdam', 'Paesi Bassi', 'Europa'),
(10, 'Milano', 'Italia', 'Europa'),
(11, 'Barcellona', 'Spagna', 'Europa'),
(12, 'Bangkok', 'Thailandia', 'Asia'),
(13, 'Città del Messico', 'Messico', 'America del Nord'),
(14, 'Dubai', 'Emirati Arabi Uniti', 'Asia'),
(15, 'Roma', 'Italia', 'Europa'),
(16, 'Istanbul', 'Turchia', 'Asia/Europa'),
(17, 'Vancouver', 'Canada', 'America del Nord'),
(18, 'Buenos Aires', 'Argentina', 'America del Sud'),
(19, 'Londra', 'Regno Unito', 'Europa'),
(20, 'Verona', 'Italia', 'Europa'),
(21, 'Singapore', 'Singapore', 'Asia'),
(22, 'Città del Vaticano', 'Città del Vaticano', 'Europa'),
(23, 'Vienna', 'Austria', 'Europa'),
(24, 'Marrakech', 'Marocco', 'Africa'),
(25, 'Città del Cairo', 'Egitto', 'Africa'),
(26, 'Firenze', 'Italia', 'Europa'),
(27, 'Berlino', 'Germania', 'Europa'),
(28, 'Città del Guatemala', 'Guatemala', 'America Centrale'),
(29, 'Atene', 'Grecia', 'Europa'),
(30, 'Seoul', 'Corea del Sud', 'Asia'),
(31, 'Venezia', 'Italia', 'Europa'),
(32, 'Città di Petra', 'Giordania', 'Asia'),
(33, 'Praga', 'Repubblica Ceca', 'Europa'),
(34, 'Budapest', 'Ungheria', 'Europa'),
(35, 'Città di Cusco', 'Perù', 'America del Sud'),
(36, 'Lisbona', 'Portogallo', 'Europa'),
(37, 'Amalfi', 'Italia', 'Europa'),
(38, 'Cape Town', 'Sudafrica', 'Africa'),
(39, 'Santorini', 'Grecia', 'Europa'),
(40, 'Bali', 'Indonesia', 'Asia'),
(41, 'Palermo', 'Italia', 'Europa'),
(42, 'Machu Picchu', 'Perù', 'America del Sud'),
(43, 'Dublino', 'Irlanda', 'Europa'),
(44, 'Città di Chiang Mai', 'Thailandia', 'Asia'),
(45, 'New Orleans', 'Stati Uniti', 'America del Nord'),
(46, 'Bologna', 'Italia', 'Europa'),
(47, 'Honolulu', 'Stati Uniti', 'America del Nord'),
(48, 'Kyoto', 'Giappone', 'Asia'),
(49, 'Città di Cusco', 'Perù', 'America del Sud'),
(50, 'Firenze', 'Italia', 'Europa'),
(51, 'Vancouver', 'Canada', 'America del Nord'),
(52, 'San Francisco', 'Stati Uniti', 'America del Nord'),
(53, 'Praga', 'Repubblica Ceca', 'Europa'),
(54, 'Istanbul', 'Turchia', 'Asia/Europa'),
(55, 'Città di Petra', 'Giordania', 'Asia'),
(56, 'Sydney', 'Australia', 'Oceania'),
(57, 'Roma', 'Italia', 'Europa'),
(58, 'Santorini', 'Grecia', 'Europa'),
(59, 'Reykjavik', 'Islanda', 'Europa'),
(60, 'Città di Chiang Mai', 'Thailandia', 'Asia'),
(61, 'Ancona', NULL, NULL),
(66, 'San Benedetto Del Tronto', NULL, NULL),
(67, '', NULL, NULL),
(68, 'Saragozza', NULL, NULL),
(69, 'Valencia', NULL, NULL),
(70, 'Lione', NULL, NULL),
(71, 'Madrid', NULL, NULL),
(72, 'Torino', NULL, NULL),
(73, 'Nizza', NULL, NULL),
(74, 'Marsiglia', NULL, NULL),
(75, 'Cannes', NULL, NULL),
(76, 'New York', NULL, NULL),
(77, 'Amburgo', NULL, NULL),
(78, 'Brema', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manutenzione`
--

CREATE TABLE `manutenzione` (
  `id` int NOT NULL,
  `dataInizio` date NOT NULL,
  `dataFine` date DEFAULT NULL,
  `motivo` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `descrizione` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `manutenzione`
--

INSERT INTO `manutenzione` (`id`, `dataInizio`, `dataFine`, `motivo`, `descrizione`) VALUES
(5, '2023-08-31', '2023-09-02', 'manutenzione annuale', '');

-- --------------------------------------------------------

--
-- Table structure for table `mezzo`
--

CREATE TABLE `mezzo` (
  `id` int NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `annoImmatricolazione` year NOT NULL,
  `postiDisponibili` int NOT NULL,
  `id_agenzia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mezzo`
--

INSERT INTO `mezzo` (`id`, `tipo`, `annoImmatricolazione`, `postiDisponibili`, `id_agenzia`) VALUES
(17, 'bus', 2001, 150, 9),
(18, 'barca', 2000, 200, 9),
(19, 'aereo', 2020, 70, 11);

-- --------------------------------------------------------

--
-- Table structure for table `mezzo_manutenzione`
--

CREATE TABLE `mezzo_manutenzione` (
  `id` int NOT NULL,
  `id_mezzo` int NOT NULL,
  `id_manutenzione` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `mezzo_manutenzione`
--

INSERT INTO `mezzo_manutenzione` (`id`, `id_mezzo`, `id_manutenzione`) VALUES
(5, 17, 5);

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `id` int NOT NULL,
  `nome` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cognome` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `telefono`, `email`, `password`) VALUES
(1, 'Davide', 'Marchetti', '+39 3311364887', 'davide.marchetti@mail.it', '$2y$10$jvpXMyGoarkoYxV1M5t37ehmqIvbPEWlEVxTX1skRV4SnYKFUDP5m'),
(2, 'Isabella', 'Orlando', '+39 3712376030', 'isabella.orlando@mail.it', '$2y$10$6pTMszDclmLJ.OWAUcPoVufvlqb4Q6/crO0r3wi8jt.HifZ/HB2WC'),
(3, 'Matteo', 'Parisi', '+39 3406977990', 'matteo.parisi@mail.it', '$2y$10$f.5UGUBMyDw6ZU/bHgVJl.SRqKDZHq9Q2yu460khd/M9uHUAHvJzW'),
(4, 'Sofia', 'Basile', '+39 3565631249', 'sofia.basile@mail.it', '$2y$10$/z5iyoGCeAxEL1I8kfUCSePB7AS5rQbrxvvbquYMJykpklQylB7dS'),
(6, 'Martina', 'Rossetti', '+39 3985543509', 'martina.rossetti@mail.it', '$2y$10$SKqon1p//BtruSlGm2RVTesZPU79o8EIM3FeAgcV1dSOMBw1ElF7a'),
(7, 'Carlotta', 'Serra', '+39 3282570875', 'carlotta.serra@mail.it', '$2y$10$TqeiObRgDpL3GC7cqFhVPe48nEbnbpXa4Izj6qmTprABaiUJHTRtu'),
(8, 'Matteo', 'Bianchi', '+39 3113021183', 'matteo.bianchi@mail.it', '$2y$10$Ubk/YZSOXdyR.YPi62789../fecIuXd.hMfiKXW2DZU.5nYgY4utK'),
(9, 'Cristiano', 'Orlando', '+39 3593432196', 'cristiano.orlando1@mail.it', '$2y$10$Ij2AXLufJa09I687JU2EL.vl6y7HDxhTk795Is6v8yIL5.VRIEG8u'),
(10, 'Gabriele', 'Mariani', '+39 3099212380', 'gabriele.mariani@mail.it', '$2y$10$GYY6ArZ2Dv4Z.wVPsI4WKO802WJ1/lkJiEPe/KcjYAV6LtawbopMu'),
(11, 'Davide', 'Marchetti', '+39 7236678176', 'davide.marchetti1@mail.it', '$2y$10$jvpXMyGoarkoYxV1M5t37ehmqIvbPEWlEVxTX1skRV4SnYKFUDP5m'),
(12, 'Mario', 'Rossi', '', 'mari.rossi@mail.it', '$2y$10$Ffstd6XXH3CuJL.KGjC7cOI7ueFATwnAqjBvXDlnpKtDR8igha1aa'),
(13, 'Luigi', 'Bianchi', '', 'luigi.bianchi@mail.it', '$2y$10$O561N0AfxW70ueytYs18sOva5iUXqc4TlWkypTWXVM1siJ/xjm/Ia'),
(14, 'Luigi', 'Bianchi', '', 'luigi.bianchi1@mail.it', '$2y$10$r8ujlWM/YCDxQDePkd4qrelY8D37SLFDgHoFdDiA9dvPRi8EV/NN2'),
(15, 'Marco', 'Sinto', '', 'marco.sinto@mail.it', '$2y$10$MUj5dGbI5jqGbEwepdqaN.66nL4a0Bc74yd8kAFBvGmoVQ4xsU...');

-- --------------------------------------------------------

--
-- Table structure for table `viaggio`
--

CREATE TABLE `viaggio` (
  `id` int NOT NULL,
  `postiDisponibili` int NOT NULL,
  `dataPartenza` date NOT NULL,
  `dataArrivo` date NOT NULL,
  `prezzo` int NOT NULL,
  `id_agenzia` int NOT NULL,
  `id_itinerario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `viaggio`
--

INSERT INTO `viaggio` (`id`, `postiDisponibili`, `dataPartenza`, `dataArrivo`, `prezzo`, `id_agenzia`, `id_itinerario`) VALUES
(10, 98, '2023-10-04', '2023-10-07', 40, 9, 15),
(11, 100, '2024-01-03', '2024-01-06', 300, 9, 16),
(12, 50, '2023-12-20', '2023-12-27', 700, 11, 17);

-- --------------------------------------------------------

--
-- Table structure for table `viaggio_mezzo`
--

CREATE TABLE `viaggio_mezzo` (
  `id` int NOT NULL,
  `id_viaggio` int NOT NULL,
  `id_mezzo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `viaggio_mezzo`
--

INSERT INTO `viaggio_mezzo` (`id`, `id_viaggio`, `id_mezzo`) VALUES
(48, 10, 17),
(49, 11, 17),
(50, 12, 19);

-- --------------------------------------------------------

--
-- Table structure for table `viaggio_utente`
--

CREATE TABLE `viaggio_utente` (
  `id` int NOT NULL,
  `numeroPrenotazioni` int NOT NULL,
  `id_utente` int NOT NULL,
  `id_viaggio` int NOT NULL,
  `id_coupon` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `viaggio_utente`
--

INSERT INTO `viaggio_utente` (`id`, `numeroPrenotazioni`, `id_utente`, `id_viaggio`, `id_coupon`) VALUES
(9, 1, 14, 10, NULL),
(10, 1, 1, 10, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenzia`
--
ALTER TABLE `agenzia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indexes for table `agenzia_utente`
--
ALTER TABLE `agenzia_utente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_agenzia` (`id_agenzia`),
  ADD KEY `id_dipendente` (`id_utente`);

--
-- Indexes for table `amministratore`
--
ALTER TABLE `amministratore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codiceSconto` (`codiceSconto`),
  ADD KEY `id_agenzia` (`id_agenzia`);

--
-- Indexes for table `itinerario`
--
ALTER TABLE `itinerario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itinerario_localita`
--
ALTER TABLE `itinerario_localita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_localita` (`id_localita`),
  ADD KEY `id_itinerario` (`id_itinerario`);

--
-- Indexes for table `localita`
--
ALTER TABLE `localita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manutenzione`
--
ALTER TABLE `manutenzione`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mezzo`
--
ALTER TABLE `mezzo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_agenzia` (`id_agenzia`);

--
-- Indexes for table `mezzo_manutenzione`
--
ALTER TABLE `mezzo_manutenzione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mezzo` (`id_mezzo`),
  ADD KEY `id_manutenzione` (`id_manutenzione`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viaggio`
--
ALTER TABLE `viaggio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_agenzia` (`id_agenzia`),
  ADD KEY `id_itinerario` (`id_itinerario`);

--
-- Indexes for table `viaggio_mezzo`
--
ALTER TABLE `viaggio_mezzo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_viaggio` (`id_viaggio`),
  ADD KEY `id_mezzo` (`id_mezzo`);

--
-- Indexes for table `viaggio_utente`
--
ALTER TABLE `viaggio_utente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_utente`),
  ADD KEY `id_viaggio` (`id_viaggio`),
  ADD KEY `id_coupon` (`id_coupon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenzia`
--
ALTER TABLE `agenzia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `agenzia_utente`
--
ALTER TABLE `agenzia_utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `amministratore`
--
ALTER TABLE `amministratore`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `itinerario`
--
ALTER TABLE `itinerario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `itinerario_localita`
--
ALTER TABLE `itinerario_localita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `localita`
--
ALTER TABLE `localita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `manutenzione`
--
ALTER TABLE `manutenzione`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mezzo`
--
ALTER TABLE `mezzo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mezzo_manutenzione`
--
ALTER TABLE `mezzo_manutenzione`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `viaggio`
--
ALTER TABLE `viaggio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `viaggio_mezzo`
--
ALTER TABLE `viaggio_mezzo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `viaggio_utente`
--
ALTER TABLE `viaggio_utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenzia`
--
ALTER TABLE `agenzia`
  ADD CONSTRAINT `agenzia_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `agenzia_utente`
--
ALTER TABLE `agenzia_utente`
  ADD CONSTRAINT `agenzia_utente_ibfk_1` FOREIGN KEY (`id_agenzia`) REFERENCES `agenzia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agenzia_utente_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `amministratore`
--
ALTER TABLE `amministratore`
  ADD CONSTRAINT `amministratore_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupon`
--
ALTER TABLE `coupon`
  ADD CONSTRAINT `coupon_ibfk_1` FOREIGN KEY (`id_agenzia`) REFERENCES `agenzia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `itinerario_localita`
--
ALTER TABLE `itinerario_localita`
  ADD CONSTRAINT `itinerario_localita_ibfk_1` FOREIGN KEY (`id_itinerario`) REFERENCES `itinerario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itinerario_localita_ibfk_2` FOREIGN KEY (`id_localita`) REFERENCES `localita` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mezzo`
--
ALTER TABLE `mezzo`
  ADD CONSTRAINT `mezzo_ibfk_1` FOREIGN KEY (`id_agenzia`) REFERENCES `agenzia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mezzo_manutenzione`
--
ALTER TABLE `mezzo_manutenzione`
  ADD CONSTRAINT `mezzo_manutenzione_ibfk_1` FOREIGN KEY (`id_mezzo`) REFERENCES `mezzo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mezzo_manutenzione_ibfk_2` FOREIGN KEY (`id_manutenzione`) REFERENCES `manutenzione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `viaggio`
--
ALTER TABLE `viaggio`
  ADD CONSTRAINT `viaggio_ibfk_1` FOREIGN KEY (`id_agenzia`) REFERENCES `agenzia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viaggio_ibfk_2` FOREIGN KEY (`id_itinerario`) REFERENCES `itinerario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `viaggio_mezzo`
--
ALTER TABLE `viaggio_mezzo`
  ADD CONSTRAINT `viaggio_mezzo_ibfk_1` FOREIGN KEY (`id_mezzo`) REFERENCES `mezzo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viaggio_mezzo_ibfk_2` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `viaggio_utente`
--
ALTER TABLE `viaggio_utente`
  ADD CONSTRAINT `viaggio_utente_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viaggio_utente_ibfk_2` FOREIGN KEY (`id_viaggio`) REFERENCES `viaggio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `viaggio_utente_ibfk_3` FOREIGN KEY (`id_coupon`) REFERENCES `coupon` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
