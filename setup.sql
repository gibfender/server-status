CREATE DATABASE `arma`;

USE arma;

CREATE TABLE `missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `minplayers` varchar(3) CHARACTER SET utf8 NOT NULL,
  `maxplayers` varchar(3) CHARACTER SET utf8 NOT NULL,
  `terrain` varchar(45) CHARACTER SET utf8 NOT NULL,
  `author` varchar(45) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gamemode` varchar(45) NOT NULL,
  `broken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


CREATE USER 'USERNAME'@'localhost' IDENTIFIED BY 'PASSWORD!';

GRANT ALL PRIVILEGES ON arma.missions TO 'USERNAME'@'localhost';
