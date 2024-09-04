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


-- Table structure for table `cars`
--

-- 创建 cars 表
CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire, identifiant numérique auto-incrémenté',
  `name` varchar(50) NOT NULL COMMENT 'Nom du véhicule',
  `license_plate` varchar(20) NOT NULL COMMENT 'Numéro de plaque d immatriculation',
  -- `location` varchar(100) DEFAULT NULL COMMENT 'Emplacement du véhicule',
  `owner_id` int(11) DEFAULT NULL COMMENT 'ID du propriétaire du véhicule',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table des véhicules disponibles';

-- 插入数据到 cars 表
INSERT INTO `cars` (`id`, `name`, `license_plate`, `owner_id`)
VALUES
(1, 'Toyota Camry', 'ABC123', 4),
(2, 'Honda Civic', 'XYZ789', 3),
(3, 'Honda Civic', 'XYZ789', 3);

-- Modify the `cars` table to set the `id` column as AUTO_INCREMENT
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire, identifiant numérique auto-incrémenté', AUTO_INCREMENT=4;
