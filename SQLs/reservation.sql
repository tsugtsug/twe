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

-- Table structure for table `reservation`
--

-- create reservation table
CREATE TABLE `reservations` (
    id INT AUTO_INCREMENT COMMENT 'ID de reservations',
    id_cars_avail INT COMMENT 'ID de car_availability pour cette reservation',
	id_user INT COMMENT 'ID de utilisateur de reservation',
	time_reservation TIMESTAMP COMMENT 'le temps de reservation',
    status ENUM('Ready', 'Done', 'Canceled') NOT NULL COMMENT 'l état de la reservation(/Ready/Done/Canceled)',
    PRIMARY KEY (id),
    FOREIGN KEY (id_cars_avail) REFERENCES car_availability (id),
	FOREIGN KEY (id_user) REFERENCES users (id)
) ENGINE=MyISAM COMMENT 'la table pour les plans d utilisateurs';
