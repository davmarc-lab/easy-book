-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2023 at 06:40 PM
-- Server version: 8.0.34-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.13

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
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `proprietario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sedeFisica` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenzia`
--

INSERT INTO `agenzia` (`id`, `nome`, `proprietario`, `sedeFisica`, `telefono`, `email`) VALUES
(1, 'VACation s.r.l', 'Speranza Siciliano', 'Canicattì', '+39 0357243361', 'speranza.siciliano@mail.it'),
(2, 'WonderQuest Tours', 'Matteo Marino', '', '+39 2148760426', 'matteo.marino@mail.it'),
(3, 'Horizon Hoppers', 'Beatrice Fontana', '', '+39 1903052606', 'beatrice.fontana@mail.it'),
(4, 'Sentieri della Meraviglia', 'Tommaso Grassi', 'Santorini', '+39 1295971253', 'tommaso.grassi@mail.it'),
(5, 'WanderWisdom Trips', 'Emanuele Marra', 'Roma', '+39 5547690157', 'emanuele.marra@mail.it'),
(6, 'Euphoric Adventures', 'Sofia Benedetti', 'Ancona', '+39 7461212435', 'sofia.benedetti@mail.it'),
(7, 'Eco Journay', 'Luigi Bianchi', '', '', 'luigi.bianchi1@mail.it'),
(8, 'Agency For Fun', 'Davide Marchetti', '', '', 'davide.marchetti@mail.it');

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
(2, 'determinato', '2023-08-25', 7, 10),
(7, 'indeterminato', NULL, 7, 1);

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
  `codiceSconto` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `descrizione` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_agenzia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `codiceSconto`, `descrizione`, `id_agenzia`) VALUES
(1, 'K0Z04DSL1W', 'Prova inserimento primo coupon', 7);

-- --------------------------------------------------------

--
-- Table structure for table `insdata`
--

CREATE TABLE `insdata` (
  `inizio` date NOT NULL,
  `fine` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `insdata`
--

INSERT INTO `insdata` (`inizio`, `fine`) VALUES
('2023-08-21', '2023-08-31');

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
(14, 'Spend one week at New York.');

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
(102, 76, 14);

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
(76, 'New York', NULL, NULL);

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
(1, '2023-08-21', '2023-08-24', '', ''),
(2, '2023-08-15', '2023-08-18', NULL, NULL),
(3, '2023-08-14', '2023-08-18', 'revisione', 'Revisione ogni due anni.'),
(4, '2023-08-16', '2023-08-18', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `mezzo`
--

CREATE TABLE `mezzo` (
  `id` int NOT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `annoImmatricolazione` year NOT NULL,
  `postiDisponibili` int NOT NULL,
  `id_agenzia` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mezzo`
--

INSERT INTO `mezzo` (`id`, `tipo`, `annoImmatricolazione`, `postiDisponibili`, `id_agenzia`) VALUES
(1, 'pullman', 1984, 75, 7),
(2, 'auto', 1993, 82, 7),
(3, 'nave', 1988, 91, 7),
(4, 'pullman', 2015, 74, 7),
(5, 'taxi', 1988, 63, 7),
(6, 'taxi', 1992, 76, 7),
(7, 'aereo', 1983, 77, 7),
(9, 'nave', 1987, 100, 7),
(10, 'auto', 1990, 85, 7),
(11, 'auto', 2006, 6, 7),
(12, 'pullman', 1999, 100, 7),
(14, 'barca', 2020, 200, 7),
(15, 'bus', 2022, 23, 8),
(16, 'car', 2000, 99, 8);

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
(1, 2, 1),
(2, 15, 2),
(3, 14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE `utente` (
  `id` int NOT NULL,
  `nome` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `cognome` varchar(40) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` tinytext COLLATE utf8mb4_general_ci NOT NULL,
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
(5, 'Enea', 'Marino', '+39 3282344449', 'enea.marino@mail.it', '$2y$10$ZalKNW4DajzTSOk2znwv8.Jm5Hw.0ZeOwX9luzkP/WMWfphXuYN8O'),
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
(1, 100, '2023-08-01', '2023-08-11', 50, 7, 5),
(2, 130, '2023-08-11', '2023-08-25', 200, 7, 6),
(3, 297, '2023-08-11', '2023-08-22', 150, 7, 7),
(8, 96, '2023-09-05', '2023-09-06', 75, 7, 13),
(9, 99, '2023-10-10', '2023-10-17', 750, 8, 14);

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
(30, 1, 6),
(31, 1, 7),
(32, 2, 4),
(33, 2, 10),
(37, 3, 9),
(38, 3, 1),
(39, 3, 14),
(45, 8, 12),
(46, 9, 15);

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
(5, 4, 1, 8, NULL),
(8, 1, 1, 9, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenzia`
--
ALTER TABLE `agenzia`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `agenzia_utente`
--
ALTER TABLE `agenzia_utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `amministratore`
--
ALTER TABLE `amministratore`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `itinerario`
--
ALTER TABLE `itinerario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `itinerario_localita`
--
ALTER TABLE `itinerario_localita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `localita`
--
ALTER TABLE `localita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `manutenzione`
--
ALTER TABLE `manutenzione`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mezzo`
--
ALTER TABLE `mezzo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mezzo_manutenzione`
--
ALTER TABLE `mezzo_manutenzione`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `viaggio`
--
ALTER TABLE `viaggio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `viaggio_mezzo`
--
ALTER TABLE `viaggio_mezzo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `viaggio_utente`
--
ALTER TABLE `viaggio_utente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
