# Quote all table names with '{' and '}', and prefix all system tables with 'core.'

--
-- Table structure for table `apps`
--

CREATE TABLE IF NOT EXISTS `{apps}` (
  `id`              int(10)     unsigned    NOT NULL AUTO_INCREMENT,
  `uid`             int(10)     unsigned    NOT NULL DEFAULT '0',
  `name`            varchar(64)             DEFAULT NULL,
  `title`           varchar(255)            NOT NULL DEFAULT '',
  `time_release`    int(10)     unsigned    NOT NULL DEFAULT '0',
  `icon`            varchar(255)            NOT NULL,
  `summery`         varchar(255)            NOT NULL,
  `content`         text,
  `markup`          varchar(64)             NOT NULL DEFAULT 'html',
  `nav_order`       smallint(5) unsigned    NOT NULL DEFAULT '0',
  `time_created`    int(10)     unsigned    NOT NULL DEFAULT '0',
  `time_updated`    int(10)     unsigned    NOT NULL DEFAULT '0',
  `active`          tinyint(1)              NOT NULL DEFAULT '1',
  
  -- SEO slug for URL
  `slug`            varchar(64)             default NULL,
  `clicks`          int(10)                 unsigned    NOT NULL default '0',
  `seo_title`       varchar(255)            NOT NULL default '',
  `seo_keywords`    varchar(255)            NOT NULL default '',
  `seo_description` varchar(255)            NOT NULL default '',
  
  -- For rendering
  `theme`           varchar(64)             NOT NULL default '',
  `layout`          varchar(64)             NOT NULL default '',
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);
