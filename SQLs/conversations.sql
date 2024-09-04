-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 27, 2016 at 11:57 PM
-- Server version: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TWE_projet`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL COMMENT 'Clé primaire',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'indique si la conversation est active',
  `theme` varchar(40) CHARACTER SET latin1 NOT NULL COMMENT 'Thème de la conversation',
  `admin_id` int(11) DEFAULT NULL COMMENT 'ID de l administrateur'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `active`, `theme`, `admin_id`) VALUES
(1, 1, 'Le Web en EBM', 3),
(2, 1, 'Les qualifs de foot pour la France', 3);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL COMMENT 'Identifiant du message',
  `idConversation` int(11) NOT NULL COMMENT 'Clé étrangère vers la table des conversations',
  `idAuteur` int(11) NOT NULL COMMENT 'Clé étrangère vers la table des auteurs',
  contenu VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contenu du message',
  `dateEnvoi` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date denvoi du message',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `idConversation`, `idAuteur`, `contenu`, `dateEnvoi`)
VALUES
(1, 1, 3, 'Que penses-tu de la nouvelle organisation des cours en EBM ? Pas mal, non ?', NOW()),
(2, 2, 4, 'Que va faire la France, cette fois-ci ?', NOW()),
(3, 2, 3, 'Elle se qualifiera pour le mondial !', NOW()),
(6, 2, 4, 'Hum... Pas sûr... espérons-le !', NOW()),
(5, 1, 4, 'Oui, tu as raison', NOW());




-- --------------------------------------------------------

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du message', AUTO_INCREMENT=7;
