-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.praha.aiesec.cz
-- Generation Time: Sep 01, 2009 at 02:01 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apedog_COUNTRY_CODE`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `description` varchar(45) character set latin1 collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `areas`
--


-- --------------------------------------------------------

--
-- Table structure for table `business_perspectives`
--

DROP TABLE IF EXISTS `business_perspectives`;
CREATE TABLE `business_perspectives` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `business_perspectives`
--


-- --------------------------------------------------------

--
-- Table structure for table `csfs`
--

DROP TABLE IF EXISTS `csfs`;
CREATE TABLE `csfs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) character set latin1 NOT NULL,
  `description` varchar(45) character set latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `business_perspective` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Critical succes factor ' AUTO_INCREMENT=17 ;

--
-- Dumping data for table `csfs`
--


-- --------------------------------------------------------

--
-- Table structure for table `detail_tracking`
--

DROP TABLE IF EXISTS `detail_tracking`;
CREATE TABLE `detail_tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` double default NULL,
  `target` double default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `detail_tracking`
--


-- --------------------------------------------------------

--
-- Table structure for table `graphs`
--

DROP TABLE IF EXISTS `graphs`;
CREATE TABLE `graphs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(48) NOT NULL,
  `description` varchar(48) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `graphs`
--

INSERT INTO `graphs` (`id`, `name`, `description`) VALUES
(1, 'Line Chart', ''),
(2, 'Bar Chart', ''),
(3, 'Pie Chart', 'use in combination with percentile KPI'),
(4, 'Meter', ''),
(5, 'Line on Bar Chart', '');

-- --------------------------------------------------------

--
-- Table structure for table `kpis`
--

DROP TABLE IF EXISTS `kpis`;
CREATE TABLE `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) character set latin1 collate latin1_general_ci NOT NULL,
  `description` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) unsigned default NULL,
  `csf` int(10) unsigned default NULL,
  `kpi_unit` int(10) NOT NULL COMMENT 'link to unit',
  `graphs` int(10) NOT NULL,
  `end_of_term` int(10) NOT NULL,
  `all_lcs` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `kpi_unit` (`kpi_unit`),
  KEY `kpi_unit_2` (`kpi_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kpis`
--


-- --------------------------------------------------------

--
-- Table structure for table `kpi_units`
--

DROP TABLE IF EXISTS `kpi_units`;
CREATE TABLE `kpi_units` (
  `id` int(10) NOT NULL auto_increment COMMENT 'PK',
  `name` varchar(50) collate utf8_bin NOT NULL COMMENT 'unit name',
  `description` varchar(100) collate utf8_bin NOT NULL COMMENT 'unit desc',
  `spec` varchar(100) collate utf8_bin NOT NULL COMMENT 'specification of working with unit',
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'created',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='kpi units' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `kpi_units`
--


-- --------------------------------------------------------

--
-- Table structure for table `lcs`
--

DROP TABLE IF EXISTS `lcs`;
CREATE TABLE `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `description` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'MC', 'Member Committee  Czech republic', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `lc_kpi`
--

DROP TABLE IF EXISTS `lc_kpi`;
CREATE TABLE `lc_kpi` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lc` int(10) unsigned NOT NULL,
  `kpi` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lc_kpi_lc` (`lc`),
  KEY `lc_kpi_kpi` (`kpi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='relational table between lc and kpi' AUTO_INCREMENT=140 ;

--
-- Dumping data for table `lc_kpi`
--


-- --------------------------------------------------------

--
-- Table structure for table `locking`
--

DROP TABLE IF EXISTS `locking`;
CREATE TABLE `locking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lc` int(11) NOT NULL,
  `quarter` int(11) default NULL,
  `term` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `locking`
--


-- --------------------------------------------------------

--
-- Table structure for table `logic`
--

DROP TABLE IF EXISTS `logic`;
CREATE TABLE `logic` (
  `id` int(11) NOT NULL auto_increment,
  `equals` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logic`
--

INSERT INTO `logic` (`id`, `equals`) VALUES
(1, 'Sum'),
(2, 'Average'),
(3, 'Last value'),
(4, 'if at least 1 yes=>yes');

-- --------------------------------------------------------

--
-- Table structure for table `quarters`
--

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE `quarters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` varchar(75) NOT NULL,
  `created` varchar(75) NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  `quarter_in_term` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `quarters`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  `description` varchar(255) character set latin2 collate latin2_czech_cs NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `number_of_term` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `terms`
--


-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE `tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `area` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `area-lc-term` (`area`,`lc`,`term`),
  KEY `term` (`term`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tracking`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate utf8_bin NOT NULL,
  `surname` varchar(45) collate utf8_bin NOT NULL,
  `email` varchar(48) collate utf8_bin NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) collate utf8_bin default NULL,
  `login` varchar(45) collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `lc`, `pass`, `login`, `created`, `updated`) VALUES
(1, '', '', '', 1, 'aiesec', 'MC', '0000-00-00 00:00:00', '2009-09-01 00:19:55');
