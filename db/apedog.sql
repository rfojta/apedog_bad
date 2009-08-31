-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 28, 2009 at 01:56 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `apedog`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;


-- --------------------------------------------------------

--
-- Table structure for table `business_perspectives`
--

DROP TABLE IF EXISTS `business_perspectives`;
CREATE TABLE `business_perspectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;


-- --------------------------------------------------------

--
-- Table structure for table `csfs`
--

DROP TABLE IF EXISTS `csfs`;
CREATE TABLE `csfs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `business_perspective` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Critical succes factor ' AUTO_INCREMENT=17 ;


-- --------------------------------------------------------

--
-- Table structure for table `detail_tracking`
--

DROP TABLE IF EXISTS `detail_tracking`;
CREATE TABLE `detail_tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` double default NULL,
  `target` double default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;


-- --------------------------------------------------------

--
-- Table structure for table `graphs`
--

DROP TABLE IF EXISTS `graphs`;
CREATE TABLE `graphs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) NOT NULL,
  `description` varchar(48) NOT NULL,
  PRIMARY KEY (`id`)
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) unsigned DEFAULT NULL,
  `csf` int(10) unsigned DEFAULT NULL,
  `kpi_unit` int(10) NOT NULL COMMENT 'odkaz na jednotku',
  `graphs` int(10) NOT NULL,
  `end_of_term` int(10) NOT NULL,
  `all_lcs` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kpi_unit` (`kpi_unit`),
  KEY `kpi_unit_2` (`kpi_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;


-- --------------------------------------------------------

--
-- Table structure for table `kpi_units`
--

DROP TABLE IF EXISTS `kpi_units`;
CREATE TABLE `kpi_units` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'jmeno jednotky',
  `description` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'popis jednotky',
  `spec` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'specifikace prace s jednotky',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'vytvoreno',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='jednotky ke kpi' AUTO_INCREMENT=6 ;


-- --------------------------------------------------------

--
-- Table structure for table `lcs`
--

DROP TABLE IF EXISTS `lcs`;
CREATE TABLE `lcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lc` int(10) unsigned NOT NULL,
  `kpi` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_kpi_lc` (`lc`),
  KEY `lc_kpi_kpi` (`kpi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='vazebni tabulka mezi lc a kpi' AUTO_INCREMENT=134 ;


-- --------------------------------------------------------

--
-- Table structure for table `locking`
--

DROP TABLE IF EXISTS `locking`;
CREATE TABLE `locking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lc` int(11) NOT NULL,
  `quarter` int(11) DEFAULT NULL,
  `term` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equals` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` varchar(75) NOT NULL,
  `created` varchar(75) NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  `quarter_in_term` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  `description` varchar(255) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `number_of_term` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE `tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `surname` varchar(45) COLLATE utf8_bin NOT NULL,
  `email` varchar(48) COLLATE utf8_bin NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `login` varchar(45) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;


--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `lc`, `pass`, `login`, `created`, `updated`) VALUES
(1, '', '', 1, 'brucelee', 'MC', '0000-00-00 00:00:00', '0000-00-00 00:00:00');