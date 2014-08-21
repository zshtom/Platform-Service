CREATE TABLE `{freetrial}` (
  `id`           INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(64)             NOT NULL DEFAULT '',
  `title`        VARCHAR(64)             NOT NULL DEFAULT '',
  `company`      VARCHAR(64)             NOT NULL DEFAULT '',
<<<<<<< HEAD
  `email`        VARCHAR(64)             NOT NULL DEFAULT '',
  `phone`        VARCHAR(11)             NOT NULL DEFAULT '',


  PRIMARY KEY        (`id`),
  UNIQUE KEY         (`name`)

);
=======
  `comp_mail`      VARCHAR(64)             NOT NULL DEFAULT '',
  `phonenum`        INT(11) UNSIGNED         NOT NULL ,
  
   PRIMARY KEY        (`id`)
);
>>>>>>> upstream/master
