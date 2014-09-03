#Quote all table names with '{' and '}', and prefix all system tables without 'core.' 



CREATE TABLE IF NOT EXISTS `{solution}` (
  `id`              int(10) NOT         NULL AUTO_INCREMENT,
  `user`            int(10) NOT         NULL DEFAULT '0',
  `name`            varchar(64)         DEFAULT NULL,
  `title`          varchar(255)        NOT NULL,
  `icon`            varchar(255)        NOT NULL,
  `summery`         varchar(255)        NOT NULL,
  `content`         text,
  `markup`          varchar(64)         NOT NULL DEFAULT 'html',
  `nav_order`       smallint(5)         NOT NULL DEFAULT '1',
  `time_created`    int(11)             NOT NULL,
  `time_updated`    int(11)             NOT NULL,
  `active`          tinyint(1)          NOT NULL DEFAULT '1',

  -- SEO slug for URL
  `slug`            varchar(64)         DEFAULT NULL,
  `clicks`          int(10) NOT         NULL DEFAULT '0',
  `seo_title`       varchar(255)        NOT NULL,
  `seo_keywords`    varchar(255)        NOT NULL,
  `seo_description` varchar(255)        NOT NULL,

  -- For rendering
  `theme`           varchar(64)         NOT NULL,
  `layout`          varchar(64)         NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);



CREATE TABLE IF NOT EXISTS `{solution_app}` (
  `id`              int(10)             NOT NULL AUTO_INCREMENT,
  `solution`        int(10)             NOT NULL DEFAULT '0',
  `apps`            int(10)             NOT NULL DEFAULT '0',
  `title`           varchar(255)        NOT NULL,
  `icon`            varchar(255)        NOT NULL,
  `summery`         varchar(255)        NOT NULL,
  `time_created`    int(10)             NOT NULL DEFAULT '0',
  `time_updated`    int(10)             NOT NULL DEFAULT '0',
  `active`          tinyint(1)          NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);
