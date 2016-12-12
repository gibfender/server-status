CREATE DATABASE `arma` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE arma;

CREATE TABLE `missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `minplayers` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `maxplayers` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `terrain` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `gamemode` varchar(45) DEFAULT NULL,
  `broken` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE USER 'USERNAME'@'localhost' IDENTIFIED BY 'PASSWORD!';

GRANT ALL PRIVILEGES ON arma.missions TO 'USERNAME'@'localhost';