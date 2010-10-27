CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `login_inserted` varchar(48) DEFAULT NULL,
  `pass_inserted` varchar(48) NOT NULL,
  `successful` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

