CREATE DATABASE `arma`;

USE arma;

CREATE TABLE `missions` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `filename`    varchar(255) NOT NULL,
  `dateupdated` date         DEFAULT NULL,
  `name`        varchar(255) NOT NULL,
  `minplayers`  smallint     NOT NULL DEFAULT 1,   -- was varchar(3); integer enables correct numeric sorting/comparison
  `maxplayers`  smallint     NOT NULL DEFAULT 99,  -- was varchar(3)
  `terrain`     varchar(45)  NOT NULL,
  `author`      varchar(45)  NOT NULL,
  `description` text         NOT NULL,             -- was varchar(255); text supports longer descriptions
  `gamemode`    varchar(45)  NOT NULL,
  `broken`      tinyint(1)   NOT NULL DEFAULT 0,
  `brokentype`  varchar(45)  DEFAULT NULL,
  `brokendes`   text         DEFAULT NULL,         -- was varchar(255); text supports longer descriptions
  `version`     varchar(45)  DEFAULT NULL,
  `datecreated` date         DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename_UNIQUE` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `comments` (
  `comment_id` int(11)      NOT NULL AUTO_INCREMENT,
  `name`       varchar(128) NOT NULL,
  `comment`    text         NOT NULL,
  `version`    varchar(45)  NOT NULL,
  `id`         int(11)      NOT NULL,  -- references missions.id
  `date`       date         NOT NULL,
  PRIMARY KEY (`comment_id`),
  CONSTRAINT `fk_comments_mission` FOREIGN KEY (`id`) REFERENCES `missions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- was MyISAM (no transactions/foreign keys)

CREATE TABLE `releasenotes` (
  `note_id` int(11)     NOT NULL AUTO_INCREMENT,
  `version` varchar(45) NOT NULL,
  `note`    text        NOT NULL,
  `date`    date        NOT NULL,
  `id`      int(11)     NOT NULL,  -- references missions.id
  PRIMARY KEY (`note_id`),
  CONSTRAINT `fk_releasenotes_mission` FOREIGN KEY (`id`) REFERENCES `missions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- was MyISAM (no transactions/foreign keys)


CREATE USER 'USERNAME'@'localhost' IDENTIFIED BY 'PASSWORD!';

GRANT SELECT, INSERT, UPDATE, DELETE ON arma.* TO 'USERNAME'@'localhost';  -- was GRANT ALL (overly permissive)
