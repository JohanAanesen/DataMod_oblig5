-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02. Nov, 2017 23:21 PM
-- Server-versjon: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oblig5`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `overview`
--

CREATE TABLE `overview` (
  `userName` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `fallYear` int(11) DEFAULT NULL,
  `id` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `Total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `season`
--

CREATE TABLE `season` (
  `fallYear` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `skier`
--

CREATE TABLE `skier` (
  `userName` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `lastName` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `yearOfBirth` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `skierclub`
--

CREATE TABLE `skierclub` (
  `id` varchar(50) COLLATE utf8_danish_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `City` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL,
  `County` varchar(50) COLLATE utf8_danish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `overview`
--
ALTER TABLE `overview`
  ADD KEY `userName` (`userName`),
  ADD KEY `fallYear` (`fallYear`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`fallYear`);

--
-- Indexes for table `skier`
--
ALTER TABLE `skier`
  ADD PRIMARY KEY (`userName`);

--
-- Indexes for table `skierclub`
--
ALTER TABLE `skierclub`
  ADD PRIMARY KEY (`id`);

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `overview`
--
ALTER TABLE `overview`
  ADD CONSTRAINT `overview_ibfk_1` FOREIGN KEY (`userName`) REFERENCES `skier` (`userName`),
  ADD CONSTRAINT `overview_ibfk_2` FOREIGN KEY (`fallYear`) REFERENCES `season` (`fallYear`),
  ADD CONSTRAINT `overview_ibfk_3` FOREIGN KEY (`id`) REFERENCES `skierclub` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
