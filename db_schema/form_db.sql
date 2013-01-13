CREATE TABLE `signup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(1000) NOT NULL DEFAULT '',
  `user_email` varchar(1000) NOT NULL DEFAULT '',
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `unsubscribed` tinyint(1) NOT NULL DEFAULT '0',
  `user_key` varchar(1000) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
