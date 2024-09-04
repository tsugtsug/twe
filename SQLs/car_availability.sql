-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2024 at 04:25 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twe_projet`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_availability`
--

CREATE TABLE `car_availability` (
  `id` int NOT NULL COMMENT 'Clé primaire, identifiant numérique auto-incrémenté',
  `car_id` int NOT NULL COMMENT 'ID du véhicule',
  `available_from` datetime NOT NULL COMMENT 'Heure de disponibilité du véhicule',
  `available_to` datetime NOT NULL COMMENT 'Heure de fin de disponibilité du véhicule',
  `departure` varchar(100) DEFAULT NULL COMMENT '起始点',
  `destination` varchar(100) DEFAULT NULL COMMENT '终点',
  `passenger_limit` int DEFAULT NULL COMMENT '用户上限',
  `available` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 si disponible, 0 sinon',
  `idConversation` int NOT NULL COMMENT 'Clé étrangère vers la table des conversations, quand on ajouter un car_availability, une conversation est créer automatiquement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Table des plages de disponibilité des véhicules';

--
-- Dumping data for table `car_availability`
--

INSERT INTO `car_availability` (`id`, `car_id`, `available_from`, `available_to`, `departure`, `destination`, `passenger_limit`, `available`, `idConversation`) VALUES
(1, 1, '2024-06-23 09:00:00', '2024-06-23 12:00:00', 'Centrale Lille', 'IG2I', 4, 1, 1),
(2, 1, '2024-06-23 14:00:00', '2024-06-23 18:00:00', 'Centrale Lille', 'IG2I', 3, 1, 2),
(3, 4, '2024-06-24 10:00:00', '2024-06-24 16:00:00', 'IG2I', 'Centrale Lille', 4, 1, 3),
(4, 2, '2024-06-19 01:00:00', '2024-06-19 04:00:00', '', NULL, 3, 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_availability`
--
ALTER TABLE `car_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_availability`
--
ALTER TABLE `car_availability`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire, identifiant numérique auto-incrémenté', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
