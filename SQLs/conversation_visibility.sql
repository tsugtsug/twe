ALTER TABLE users ENGINE=InnoDB;
ALTER TABLE conversations ENGINE=InnoDB;

CREATE TABLE `conversation_visibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `idUser` int(11) NOT NULL COMMENT 'User ID',
  `idConversation` int(11) NOT NULL COMMENT 'Conversation ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idUser_idConversation` (`idUser`,`idConversation`),
  CONSTRAINT `fk_conversation_visibility_user` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_conversation_visibility_conversation` FOREIGN KEY (`idConversation`) REFERENCES `conversations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 让 Alice 和 Bob 可以访问对话 ID 1 (Sports)
INSERT INTO `conversation_visibility` (`idUser`, `idConversation`)
VALUES (3, 1), (4, 1);

-- 让 Charlie 可以访问对话 ID 2 (Technology)
INSERT INTO `conversation_visibility` (`idUser`, `idConversation`)
VALUES (3, 2);

-- 让 Charlie 可以访问对话 ID 3 (Travel)
INSERT INTO `conversation_visibility` (`idUser`, `idConversation`)
VALUES (3, 3);
