CREATE TABLE `{freetrial}` (
  `id`           INT(10) UNSIGNED        NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(64)             NOT NULL DEFAULT '',
  `title`        VARCHAR(64)             NOT NULL DEFAULT '',
  `company`      VARCHAR(64)             NOT NULL DEFAULT '',
<<<<<<< HEAD
  `comp_mail`      VARCHAR(64)             NOT NULL DEFAULT '',
  `phonenum`        INT(11) UNSIGNED         NOT NULL ,
  
   PRIMARY KEY        (`id`)
=======
  `email`        VARCHAR(64)             NOT NULL DEFAULT '',
  `phone`        VARCHAR(11)             NOT NULL DEFAULT '',

  PRIMARY KEY        (`id`)

>>>>>>> 7648b317fb2872603b4af2e3b31007475aa04339
);
