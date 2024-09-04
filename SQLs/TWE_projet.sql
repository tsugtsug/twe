-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2024-06-28 07:28:17
-- 服务器版本： 8.0.37-0ubuntu0.22.04.3
-- PHP 版本： 8.1.2-1ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `TWE_projet`
--

-- --------------------------------------------------------

--
-- 表的结构 `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL COMMENT 'Clé primaire, identifiant numérique auto-incrémenté',
  `name` varchar(50) NOT NULL COMMENT 'Nom du véhicule',
  `license_plate` varchar(20) NOT NULL COMMENT 'Numéro de plaque d immatriculation',
  `owner_id` int DEFAULT NULL COMMENT 'ID du propriétaire du véhicule'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Table des véhicules disponibles';

--
-- 转存表中的数据 `cars`
--

INSERT INTO `cars` (`id`, `name`, `license_plate`, `owner_id`) VALUES
(1, 'Toyota Camry', 'ABC123', 4),
(2, 'Honda Civic', 'XYZ789', 3),
(3, 'Honda Civic', 'XYZ789', 3),
(4, 'Yukitsugu', 'Okamura', 6);

-- --------------------------------------------------------

--
-- 表的结构 `car_availability`
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
  `idConversation` int NOT NULL COMMENT 'Clé étrangère vers la table des conversations, quand on ajouter un car_availability, une conversation est créer automatiquement',
  `reservation_number` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Table des plages de disponibilité des véhicules';

--
-- 转存表中的数据 `car_availability`
--

INSERT INTO `car_availability` (`id`, `car_id`, `available_from`, `available_to`, `departure`, `destination`, `passenger_limit`, `available`, `idConversation`, `reservation_number`) VALUES
(1, 1, '2024-07-23 09:00:00', '2024-07-23 12:00:00', 'Centrale Lille', 'IG2I', 3, 0, 1, 3),
(2, 1, '2024-06-23 14:00:00', '2024-06-23 18:00:00', 'Centrale Lille', 'IG2I', 4, 1, 2, 0),
(3, 4, '2024-06-24 10:00:00', '2024-06-24 16:00:00', 'IG2I', 'Centrale Lille', 7, 1, 3, 0),
(5, 4, '2024-06-29 08:00:00', '2024-06-29 18:00:00', 'Centrale Lille', NULL, 6, 1, 16, 0),
(6, 4, '2024-06-30 04:33:00', '2024-06-30 04:33:00', 'Centrale Lille', NULL, 2, 1, 17, 0);

-- --------------------------------------------------------

--
-- 表的结构 `conversations`
--

CREATE TABLE `conversations` (
  `id` int NOT NULL COMMENT 'Clé primaire',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'indique si la conversation est active',
  `theme` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Thème de la conversation',
  `admin_id` int DEFAULT NULL COMMENT 'ID de l administrateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `conversations`
--

INSERT INTO `conversations` (`id`, `active`, `theme`, `admin_id`) VALUES
(1, 1, 'Le Web en EBM', 3),
(2, 1, 'Les qualifs de foot pour la France', 3),
(11, 0, 'Try admin', 8),
(12, 1, 'try delete other members', 8),
(13, 1, 'Why I can\'t ?', 8),
(14, 1, 'a', 6),
(15, 1, 'b', 6),
(16, 1, '2024-06-29T08:00', 6),
(17, 1, '2024-06-30T04:33', 6);

-- --------------------------------------------------------

--
-- 表的结构 `conversation_visibility`
--

CREATE TABLE `conversation_visibility` (
  `id` int NOT NULL COMMENT 'Primary Key',
  `idUser` int NOT NULL COMMENT 'User ID',
  `idConversation` int NOT NULL COMMENT 'Conversation ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `conversation_visibility`
--

INSERT INTO `conversation_visibility` (`id`, `idUser`, `idConversation`) VALUES
(1, 3, 1),
(3, 3, 2),
(2, 4, 1),
(17, 6, 12),
(22, 6, 14),
(23, 6, 15),
(24, 6, 16),
(25, 6, 17),
(21, 7, 12),
(15, 8, 11),
(16, 8, 12),
(19, 8, 13);

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL COMMENT 'Identifiant du message',
  `idConversation` int NOT NULL COMMENT 'Clé étrangère vers la table des conversations',
  `idAuteur` int NOT NULL COMMENT 'Clé étrangère vers la table des auteurs',
  `contenu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateEnvoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date denvoi du message'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `messages`
--

INSERT INTO `messages` (`id`, `idConversation`, `idAuteur`, `contenu`, `dateEnvoi`) VALUES
(1, 1, 3, 'Que penses-tu de la nouvelle organisation des cours en EBM ? Pas mal, non ?', '2024-06-26 16:57:30'),
(2, 2, 4, 'Que va faire la France, cette fois-ci ?', '2024-06-26 16:57:30'),
(3, 2, 3, 'Elle se qualifiera pour le mondial !', '2024-06-26 16:57:30'),
(6, 2, 4, 'Hum... Pas sûr... espérons-le !', '2024-06-26 16:57:30'),
(5, 1, 4, 'Oui, tu as raison', '2024-06-26 16:57:30'),
(7, 3, 6, 'good', '2024-06-26 17:57:30'),
(8, 3, 7, 'And ZHANG Jinghong can add message in this conversation', '2024-06-26 18:13:13'),
(9, 13, 8, 'try', '2024-06-26 20:46:08'),
(16, 12, 6, 'I Don&#039;t know', '2024-06-26 21:29:18'),
(15, 12, 6, 'Try', '2024-06-26 21:25:00'),
(14, 13, 8, 'A', '2024-06-26 21:21:56'),
(17, 12, 6, '现在应该就可以输入中文了。', '2024-06-26 21:31:40'),
(18, 12, 6, '这', '2024-06-26 21:38:51'),
(19, 12, 6, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa             sssssssssssssssssssssssssssssssssssssss', '2024-06-26 21:43:43'),
(20, 12, 6, '长度长度长度', '2024-06-26 21:46:47'),
(21, 12, 6, '长度检测长度', '2024-06-26 21:49:55'),
(22, 12, 6, '长度检测长度', '2024-06-26 21:50:05');

-- --------------------------------------------------------

--
-- 表的结构 `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL COMMENT 'ID de reservations',
  `id_cars_avail` int DEFAULT NULL COMMENT 'ID de car_availability pour cette reservation',
  `id_user` int DEFAULT NULL COMMENT 'ID de utilisateur de reservation',
  `time_reservation` timestamp NULL DEFAULT NULL COMMENT 'le temps de reservation',
  `status` enum('Ready','Done','Canceled') NOT NULL COMMENT 'l état de la reservation(/Ready/Done/Canceled)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='la table pour les plans d utilisateurs';

--
-- 转存表中的数据 `reservations`
--

INSERT INTO `reservations` (`id`, `id_cars_avail`, `id_user`, `time_reservation`, `status`) VALUES
(1, 1, 3, '2024-06-27 15:10:58', 'Ready'),
(2, 2, 4, '2024-06-27 08:00:00', 'Done'),
(33, 2, 6, '2024-06-28 05:23:14', 'Canceled'),
(32, 1, 6, '2024-06-28 05:23:11', 'Ready'),
(34, 3, 6, '2024-06-28 05:23:29', 'Canceled');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL COMMENT 'clé primaire, identifiant numérique auto incrémenté',
  `pseudo` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'pseudo',
  `passe` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'mot de passe',
  `blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est en liste noire',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est un administrateur',
  `couleur` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'black' COMMENT 'indique la couleur préférée de l''utilisateur, en anglais',
  `connecte` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est connecté',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'chemin ou identifiant de l''avatar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `pseudo`, `passe`, `blacklist`, `admin`, `couleur`, `connecte`, `avatar`) VALUES
(3, 'tom', 'ebm', 0, 1, 'orange', 0, '/path/to/default_avatar_tom.png'),
(4, 'jpb', 'maestro', 0, 0, 'green', 0, '/path/to/default_avatar_jpb.png'),
(6, 'zheng', 'XINYU', 0, 0, 'green', 1, NULL),
(7, 'zhang', 'jinhong', 0, 0, 'black', 0, NULL),
(8, 'wang', 'hongxuan', 0, 0, 'black', 0, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `car_availability`
--
ALTER TABLE `car_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- 表的索引 `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `conversation_visibility`
--
ALTER TABLE `conversation_visibility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idUser_idConversation` (`idUser`,`idConversation`),
  ADD KEY `fk_conversation_visibility_conversation` (`idConversation`);

--
-- 表的索引 `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cars_avail` (`id_cars_avail`),
  ADD KEY `id_user` (`id_user`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire, identifiant numérique auto-incrémenté', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `car_availability`
--
ALTER TABLE `car_availability`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire, identifiant numérique auto-incrémenté', AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Clé primaire', AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `conversation_visibility`
--
ALTER TABLE `conversation_visibility`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du message', AUTO_INCREMENT=23;

--
-- 使用表AUTO_INCREMENT `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID de reservations', AUTO_INCREMENT=35;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'clé primaire, identifiant numérique auto incrémenté', AUTO_INCREMENT=9;

--
-- 限制导出的表
--

--
-- 限制表 `conversation_visibility`
--
ALTER TABLE `conversation_visibility`
  ADD CONSTRAINT `fk_conversation_visibility_conversation` FOREIGN KEY (`idConversation`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_conversation_visibility_user` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
