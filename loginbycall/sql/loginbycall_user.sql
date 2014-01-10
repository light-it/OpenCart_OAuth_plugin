CREATE TABLE IF NOT EXISTS `loginbycall_user` (
  `id4` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `uid` int(11) default NULL COMMENT 'UID opencart user',
  `login` varchar(100) default NULL COMMENT 'loginbycall user login',
  `mail` varchar(100) default NULL COMMENT 'loginbycall user email',
  `target_token` varchar(255) default NULL COMMENT 'loginbycall target_token',
  `status` int(11) default NULL COMMENT 'Bind status',
  PRIMARY KEY  (`id4`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;