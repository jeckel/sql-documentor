CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `area_code` varchar(5) DEFAULT NULL COMMENT 'Code of ''Country'' area',
  `city` varchar(64) NOT NULL,
  `description` text COMMENT 'Description',
  PRIMARY KEY (`id`),
  KEY `city_to_user_ibfk_1` (`id_user`),
  CONSTRAINT `city_to_user_ibfk1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cities of the world';
