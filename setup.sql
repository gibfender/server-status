CREATE DATABASE `arma`;

USE arma;

CREATE TABLE `missions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `dateupdated` date DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `minplayers` varchar(3) CHARACTER SET utf8 NOT NULL,
  `maxplayers` varchar(3) CHARACTER SET utf8 NOT NULL,
  `terrain` varchar(45) CHARACTER SET utf8 NOT NULL,
  `author` varchar(45) CHARACTER SET utf8 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 NOT NULL,
  `gamemode` varchar(45) NOT NULL,
  `broken` tinyint(1) NOT NULL DEFAULT '0',
  `brokentype` varchar(45) DEFAULT NULL,
  `brokendes` varchar(255) DEFAULT NULL,
  `version` varchar(45) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename_UNIQUE` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `comment` text NOT NULL,
  `version` varchar(45) NOT NULL,
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `releasenotes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(45) NOT NULL,
  `note` text NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;






CREATE USER 'USERNAME'@'localhost' IDENTIFIED BY 'PASSWORD!';

GRANT ALL PRIVILEGES ON arma.missions TO 'USERNAME'@'localhost';
