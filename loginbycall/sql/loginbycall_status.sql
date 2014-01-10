CREATE TABLE IF NOT EXISTS `loginbycall_status` (
  `uid` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `status` int(11) default NULL COMMENT 'UID opencart user',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

