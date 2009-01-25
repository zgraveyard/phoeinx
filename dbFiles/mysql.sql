CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `passwd` varchar(32) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `active` ENUM('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`email`),
  KEY `active` (`active`)
) TYPE=MyISAM ;

CREATE TABLE `cc` (
  `ci` tinyint(3) unsigned NOT NULL auto_increment,
  `cc` char(2) NOT NULL default '',
  `cn` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`ci`)
) TYPE=MyISAM ;

CREATE TABLE `client_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `phone` int(10) unsigned NOT NULL default '0',
  `mobile` int(10) unsigned NOT NULL default '0',
  `fax` int(10) unsigned NOT NULL default '0',
  `address` varchar(255) NOT NULL default '',
  `moreInfo` text NOT NULL,
  `regDate` date NOT NULL default '0000-00-00',
  `nationality` tinyint(3) unsigned NOT NULL default '0',
  `workId` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`,`company`)
) TYPE=MyISAM ;

CREATE TABLE `client_payment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL default '0',
  `pay_date` date NOT NULL default '0000-00-00',
  `type` varchar(255) NOT NULL default '',
  `ammount` float unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `client_id` (`client_id`,`pay_date`,`ammount`)
) TYPE=MyISAM;

CREATE TABLE `emp_dayoff` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dep_id` int(10) unsigned NOT NULL default '0',
  `emp_id` int(10) unsigned NOT NULL default '0',
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `paid` ENUM('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `emp_id` (`emp_id`,`start_date`,`end_date`,`paid`),
  KEY `dep_id` (`dep_id`)
) TYPE=MyISAM ;

CREATE TABLE `emp_departments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `fatherId` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`,`fatherId`)
) TYPE=MyISAM ;

CREATE TABLE `emp_personal_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `gender` ENUM('0','1') NOT NULL default '0',
  `nationality` tinyint(3) unsigned NOT NULL default '0',
  `birth_date` int(4) NOT NULL default '0',
  `certificate` text NOT NULL,
  `experince` text NOT NULL,
  `mobile` varchar(255) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `dep_id` int(10) unsigned NOT NULL default '0',
  `pos_id` int(10) unsigned NOT NULL default '1',
  `active` ENUM('0','1') NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`),
  KEY `pos_id` (`pos_id`)
) TYPE=MyISAM ;

CREATE TABLE `emp_positions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default 'employee',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM ;

CREATE TABLE `feeds` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;

CREATE TABLE `ip` (
  `start` int(10) unsigned NOT NULL default '0',
  `end` int(10) unsigned NOT NULL default '0',
  `ci` tinyint(3) unsigned NOT NULL default '0'
) TYPE=MyISAM;

CREATE TABLE `projects_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `client_id` int(10) unsigned NOT NULL default '0',
  `type_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `dep_id` int(11) NOT NULL default '0',
  `cost` float NOT NULL default '0',
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `status_id` ENUM('1','2','3') NOT NULL default '1',
  `description` tinytext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`id`,`client_id`,`type_id`)
) TYPE=MyISAM ;

CREATE TABLE `projects_notes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `note` tinytext NOT NULL,
  `issue_date` timestamp NOT NULL,
  `project_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `projects_type` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM ;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL default '',
  `sitename` varchar(255) NOT NULL default '',
  `theme` varchar(255) NOT NULL default '',
  `perPage` int(10) unsigned NOT NULL default '10',
  `curency` char(3) NOT NULL default '$',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM ;

CREATE TABLE `tasks_emp` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL default '0',
  `emp_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_id` (`task_id`,`emp_id`)
) TYPE=MyISAM ;

CREATE TABLE `tasks_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `description` tinytext NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `status_id` enum('1','2','3') NOT NULL default '1',
  `progress` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`,`status_id`)
) TYPE=MyISAM ;

CREATE TABLE `tasks_notes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `note` tinytext NOT NULL,
  `issue_date` timestamp NOT NULL,
  `task_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

CREATE TABLE `tasks_relations` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_id_1` int(10) unsigned NOT NULL default '0',
  `task_id_2` int(10) unsigned NOT NULL default '0',
  `relation` enum('SS','EE','ES') NOT NULL default 'SS',
  PRIMARY KEY  (`id`),
  KEY `task_id_1` (`task_id_1`,`task_id_2`)
) TYPE=MyISAM ;

CREATE TABLE `work_area` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `work_type` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `work_type` (`work_type`)
) TYPE=MyISAM ;