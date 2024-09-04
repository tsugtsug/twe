-- --------------------------------------------------------

--
-- Table structure for table `users`
--

-- 创建 users 表并包括头像列
CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'clé primaire, identifiant numérique auto incrémenté',
  `pseudo` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'pseudo',
  `passe` varchar(20) CHARACTER SET latin1 NOT NULL COMMENT 'mot de passe',
  `blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est en liste noire',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est un administrateur',
  `couleur` varchar(10) CHARACTER SET latin1 NOT NULL DEFAULT 'black' COMMENT 'indique la couleur préférée de l''utilisateur, en anglais',
  `connecte` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indique si l''utilisateur est connecté',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'chemin ou identifiant de l''avatar'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 插入示例数据
INSERT INTO `users` (`id`, `pseudo`, `passe`, `blacklist`, `admin`, `couleur`, `connecte`, `avatar`) VALUES
(1, 'zheng', 'xinyu', 0, 1, 'orange', 0, '/path/to/default_avatar_tom.png'),
(2, 'zhang', 'jinhong', 0, 0, 'green', 0, '/path/to/default_avatar_jpb.png');

--
-- Indexes for dumped tables
-- (this section can include actual index creation statements if needed)
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clé primaire, identifiant numérique auto incrémenté', AUTO_INCREMENT=6;