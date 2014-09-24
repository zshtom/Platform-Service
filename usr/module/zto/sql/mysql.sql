# Quote all table names with '{' and '}', and prefix all system tables with 'core.'

CREATE TABLE `{contact_us}` (
  `id`            int(10) unsigned        NOT NULL auto_increment,
  `company`       varchar(255)            NOT NULL default '',
  `address`        varchar(255)              NOT NULL default '1',
  `phone`        varchar(255)              NOT NULL default '1',
  `email`        varchar(255)              NOT NULL default '1',

  PRIMARY KEY  (`id`)
);