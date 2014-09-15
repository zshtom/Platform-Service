CREATE TABLE `{freetrial}` (
  `id`           INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(64)             NOT NULL DEFAULT '',
  `title`        VARCHAR(64)             NOT NULL DEFAULT '',
  `company`      VARCHAR(64)             NOT NULL DEFAULT '',
  `email`        VARCHAR(64)             NOT NULL DEFAULT '',
  `phone`        VARCHAR(11)             NOT NULL DEFAULT '',
  `flag`          tinyint(1) unsigned     NOT NULL default '0',
  `time`        INT(10)             NOT NULL ,


  PRIMARY KEY        (`id`),
  UNIQUE KEY         (`name`)

);
