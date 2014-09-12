
CREATE TABLE IF NOT EXISTS `{resource}` (
  `id`            int(10)     unsigned    NOT NULL AUTO_INCREMENT,
  `uid`           int(11)                 NOT NULL DEFAULT '0' ,
  `sid`           int (11)                NOT NULL DEFAULT '0' ,
  `title`         varchar(255)           NOT NULL,
  `icon`          varchar(255)           NOT NULL,
  `filename`      varchar(255)           NOT NULL,
  `description`   longtext                NOT NULL,
  `case_time`     int(11)                 NOT NULL ,
  `weight`        int(2)                  NOT NULL,
  `created`       int(11)                 NOT NULL ,
  `updated`       int(11)                 NOT NULL ,
  `status`        tinyint(1) unsigned      NOT NULL default '0',

  -- SEO slug for URL
  `slug`            varchar(64)             default NULL,
  `clicks`          int(10)                 unsigned    NOT NULL default '0',
  `seo_title`       varchar(255)            NOT NULL default '',
  `seo_keywords`    varchar(255)            NOT NULL default '',
  `seo_description` varchar(255)            NOT NULL default '',


  PRIMARY KEY (`id`)

  );