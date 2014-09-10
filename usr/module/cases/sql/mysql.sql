CREATE TABLE `{cases}` (
  `id`              INT(10)                 NOT NULL AUTO_INCREMENT,
  `uid`             INT(10)                 unsigned NOT NULL DEFAULT '0' COMMENT 'Operatior ID',
  `title`           VARCHAR(255)            NOT NULL DEFAULT '' COMMENT 'Case Title',
  `summery`         VARCHAR(255)            NOT NULL DEFAULT '' COMMENT 'Case summery',
  `content`         TEXT                    COMMENT 'Case description',
  `icon`            VARCHAR(255)            NOT NULL COMMENT 'thumb pic file name',
  `order`           INT(2)                  unsigned NOT NULL DEFAULT '0' COMMENT 'Case order',
  `time_created`    INT(10)                 unsigned NOT NULL DEFAULT '0' COMMENT 'Create time',
  `time_updated`    INT(10)                 unsigned NOT NULL DEFAULT '0' COMMENT 'Update time',
  `active`          TINYINT(1)              unsigned NOT NULL DEFAULT '1',
  `clicks`          int(10)                 unsigned    NOT NULL DEFAULT '0',
  `seo_title`       varchar(255)            NOT NULL DEFAULT '',
  `seo_keywords`    varchar(255)            NOT NULL DEFAULT '',
  `seo_description` varchar(255)            NOT NULL DEFAULT '',
  PRIMARY KEY             (`id`)
);