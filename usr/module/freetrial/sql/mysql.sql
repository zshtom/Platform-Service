CREATE TABLE `{freetrial}` (
  `id`           INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(64)             NOT NULL DEFAULT '',
  `title`        VARCHAR(64)             NOT NULL DEFAULT '',
  `company`      VARCHAR(64)             NOT NULL DEFAULT '',
  `email`        VARCHAR(64)             NOT NULL DEFAULT '',
  `phone`        VARCHAR(11)             NOT NULL DEFAULT '',

<<<<<<< HEAD

  PRIMARY KEY        (`id`),
  UNIQUE KEY         (`name`)

);
=======
  PRIMARY KEY        (`id`)
);
>>>>>>> upstream/master
