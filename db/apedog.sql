-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2009 at 12:53 AM
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

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'PR', 'public relation', '0000-00-00 00:00:00', '2009-08-16 19:54:14'),
(2, 'ICX', 'incoming exchange', '0000-00-00 00:00:00', '2009-07-27 01:45:26'),
(3, 'OGX', 'outgoing exchange', '0000-00-00 00:00:00', '2009-07-28 12:18:34'),
(4, 'TM', 'talent management', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'ER', 'enterprise relationship', '0000-00-00 00:00:00', '2009-07-27 01:40:08'),
(6, 'F', 'finance', '2009-07-27 21:16:53', '2009-07-28 12:18:51'),
(7, 'P', 'President', '0000-00-00 00:00:00', '2009-07-28 12:20:41');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `business_perspectives`
--

INSERT INTO `business_perspectives` (`id`, `name`, `description`, `created`, `updated`) VALUES
(11, 'Customers', 'create new item', '2009-08-08 23:02:14', '0000-00-00 00:00:00'),
(12, 'Internal Processes', 'create new item', '2009-08-08 23:02:27', '0000-00-00 00:00:00'),
(13, 'Learning and Capacity', 'create new item', '2009-08-08 23:02:41', '0000-00-00 00:00:00'),
(9, 'The Way we do it', 'create new item', '2009-08-08 23:01:54', '0000-00-00 00:00:00'),
(10, 'Sustainability', 'create new item', '2009-08-08 23:02:01', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Critical succes factor ' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `csfs`
--

INSERT INTO `csfs` (`id`, `name`, `description`, `created`, `updated`, `business_perspective`) VALUES
(2, 'QXP', 'quality of experience', '2009-08-08 22:59:16', '2009-08-08 23:04:40', 9),
(3, 'GLXP', 'dunno', '2009-08-08 23:00:13', '2009-08-08 23:04:47', 9),
(4, 'IXXP', 'dunno', '2009-08-08 23:00:39', '2009-08-08 23:04:51', 9),
(5, 'FH&S', 'critical success factor', '2009-08-08 23:05:17', '0000-00-00 00:00:00', 10),
(6, 'OROM', 'CDROM', '2009-08-08 23:05:48', '0000-00-00 00:00:00', 11),
(7, 'CNMIO', 'critical success factor', '2009-08-08 23:06:20', '2009-08-08 23:06:40', 11),
(8, 'EPSO', 'critical success factor', '2009-08-08 23:07:34', '0000-00-00 00:00:00', 11),
(9, 'MA', 'critical success factor', '2009-08-08 23:07:46', '0000-00-00 00:00:00', 12),
(10, 'RMPA', 'critical success factor', '2009-08-08 23:08:03', '0000-00-00 00:00:00', 12),
(11, 'P&R', 'critical success factor', '2009-08-08 23:08:17', '0000-00-00 00:00:00', 12),
(12, 'Managing Information', 'critical success factor', '2009-08-08 23:09:09', '0000-00-00 00:00:00', 12),
(13, 'G&A', 'critical success factor', '2009-08-08 23:09:29', '0000-00-00 00:00:00', 12),
(14, 'IT', 'critical success factor', '2009-08-08 23:09:42', '0000-00-00 00:00:00', 13),
(15, 'MT', 'critical success factor', '2009-08-08 23:09:52', '0000-00-00 00:00:00', 13),
(16, 'R&I', 'critical success factor', '2009-08-08 23:10:04', '0000-00-00 00:00:00', 13),
(17, 'dunno', 'critical success factor', '2009-08-09 12:53:30', '2009-08-17 20:13:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_tracking`
--

DROP TABLE IF EXISTS `detail_tracking`;
CREATE TABLE `detail_tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` double NOT NULL,
  `target` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `detail_tracking`
--

INSERT INTO `detail_tracking` (`id`, `kpi`, `lc`, `actual`, `target`, `created`, `updated`, `quarter`) VALUES
(35, 2, 10, 30, 60, '0000-00-00 00:00:00', '2009-08-17 19:40:20', 1),
(36, 2, 10, -7, 666, '0000-00-00 00:00:00', '2009-08-17 23:02:31', 2),
(37, 2, 10, 80, 50, '0000-00-00 00:00:00', '2009-08-17 15:44:52', 3),
(38, 2, 10, 88, 90, '0000-00-00 00:00:00', '2009-08-17 15:44:58', 4),
(39, 2, 10, 75, -740.6889, '0000-00-00 00:00:00', '2009-08-17 22:23:55', 5),
(40, 3, 10, 0, 30.099, '0000-00-00 00:00:00', '2009-08-17 22:23:55', 5),
(41, 2, 10, 78, 50, '0000-00-00 00:00:00', '2009-08-17 23:02:40', 6),
(42, 3, 10, -10000, 70, '0000-00-00 00:00:00', '2009-08-17 23:02:40', 6),
(43, 2, 10, 50, 60, '0000-00-00 00:00:00', '2009-08-17 15:45:16', 7),
(44, 2, 10, 50, 80, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(45, 3, 10, -100.7, 70, '0000-00-00 00:00:00', '2009-08-17 23:02:31', 2),
(46, 3, 10, 70, 0, '0000-00-00 00:00:00', '2009-08-17 19:40:20', 1),
(47, 4, 10, 54, 444, '0000-00-00 00:00:00', '2009-08-17 19:40:20', 1),
(48, 4, 10, 190, 888, '0000-00-00 00:00:00', '2009-08-17 23:02:31', 2),
(49, 4, 10, 300, 89, '0000-00-00 00:00:00', '2009-08-17 15:44:52', 3),
(50, 4, 10, 100, 120, '0000-00-00 00:00:00', '2009-08-17 15:44:58', 4),
(51, 4, 10, 767, 234, '0000-00-00 00:00:00', '2009-08-17 22:23:55', 5),
(52, 4, 10, 0, 888, '0000-00-00 00:00:00', '2009-08-17 23:02:40', 6),
(53, 4, 10, 0, 98, '0000-00-00 00:00:00', '2009-08-17 15:45:16', 7),
(54, 4, 10, 0, 78, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(55, 3, 10, 30, 35, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(56, 2, 2, 45, 100, '0000-00-00 00:00:00', '2009-08-17 19:49:46', 1),
(57, 3, 2, 34, 29, '0000-00-00 00:00:00', '2009-08-17 19:49:46', 1),
(58, 2, 2, 55, 89, '0000-00-00 00:00:00', '2009-08-17 19:49:51', 2),
(59, 3, 2, 67, 88, '0000-00-00 00:00:00', '2009-08-17 19:49:51', 2),
(60, 2, 2, 65, 77, '0000-00-00 00:00:00', '2009-08-17 19:49:57', 3),
(61, 3, 2, 55, 56, '0000-00-00 00:00:00', '2009-08-17 19:49:57', 3),
(62, 2, 2, 33, 666, '0000-00-00 00:00:00', '2009-08-17 19:50:02', 4),
(63, 3, 2, 44, 77, '0000-00-00 00:00:00', '2009-08-17 19:50:02', 4),
(64, 2, 2, 0, 67, '0000-00-00 00:00:00', '2009-08-17 19:49:16', 5),
(65, 3, 2, 0, 99, '0000-00-00 00:00:00', '2009-08-17 19:49:16', 5),
(66, 4, 2, 0, 1, '0000-00-00 00:00:00', '2009-08-17 19:49:16', 5),
(67, 2, 2, 56, 32, '0000-00-00 00:00:00', '2009-08-17 19:50:17', 6),
(68, 3, 2, 444, 12, '0000-00-00 00:00:00', '2009-08-17 19:50:17', 6),
(69, 2, 2, 55, 123, '0000-00-00 00:00:00', '2009-08-17 19:50:26', 7),
(70, 3, 2, 0, 22, '0000-00-00 00:00:00', '2009-08-17 19:49:28', 7),
(71, 4, 2, 0, 33, '0000-00-00 00:00:00', '2009-08-17 19:49:28', 7),
(72, 2, 2, 0, 123, '0000-00-00 00:00:00', '2009-08-17 19:49:35', 8),
(73, 3, 2, 0, 44, '0000-00-00 00:00:00', '2009-08-17 19:49:35', 8),
(74, 4, 2, 0, 12, '0000-00-00 00:00:00', '2009-08-17 19:49:35', 8);

-- --------------------------------------------------------

--
-- Table structure for table `end_of_term`
--

DROP TABLE IF EXISTS `end_of_term`;
CREATE TABLE `end_of_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equals` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `end_of_term`
--

INSERT INTO `end_of_term` (`id`, `equals`) VALUES
(1, 'Sum of quarters'),
(2, 'Average of quarters'),
(3, '4th quarter'),
(4, 'if at least 1 yes=>yes');

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
(4, 'Google-o-meter', ''),
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
  `quarter` int(10) unsigned DEFAULT NULL,
  `lc` int(10) unsigned DEFAULT NULL,
  `kpi_unit` int(10) NOT NULL COMMENT 'odkaz na jednotku',
  `graphs` int(1) NOT NULL,
  `end_of_term` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quarter` (`quarter`,`lc`),
  KEY `kpi_unit` (`kpi_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;

--
-- Dumping data for table `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `created`, `updated`, `area`, `csf`, `quarter`, `lc`, `kpi_unit`, `graphs`, `end_of_term`) VALUES
(2, 'Quality index performance', 'Number of stars -  Quality Of the Experiences z myaiesec.net', '2009-08-08 23:48:00', '2009-08-16 20:27:55', 3, 2, NULL, NULL, 4, 2, 2),
(3, 'Number of members that finished both X & LR experiences', 'create new item', '2009-08-08 23:48:41', '2009-08-09 00:11:51', 3, 2, NULL, NULL, 0, 3, 1),
(4, 'Number of members with leadership experience finished', 'create new item', '2009-08-09 00:06:41', '2009-08-09 00:12:06', 4, 3, NULL, NULL, 0, 4, 3),
(5, 'Number of TN realized', 'create new item', '2009-08-09 00:07:04', '0000-00-00 00:00:00', 2, 4, NULL, NULL, 0, 0, 0),
(6, 'Number of EP realized', 'create new item', '2009-08-09 00:07:25', '0000-00-00 00:00:00', 3, 4, NULL, NULL, 0, 0, 0),
(7, 'Real state of finance (cash + receivables - liabilities)', 'create new item', '2009-08-09 00:10:20', '2009-08-09 00:12:23', 6, 5, NULL, NULL, 0, 0, 0),
(8, 'Number of months of reserve = (cash + receivables - liabilities)/average monthly outflow', 'create new item', '2009-08-09 00:10:41', '2009-08-09 00:12:48', 6, 5, NULL, NULL, 0, 0, 0),
(9, 'Number of EP Raised', 'create new item', '2009-08-09 00:13:29', '0000-00-00 00:00:00', 3, 6, NULL, NULL, 0, 0, 0),
(10, 'Number of TN Raised', 'create new item', '2009-08-09 00:13:54', '0000-00-00 00:00:00', 2, 7, NULL, NULL, 0, 0, 0),
(11, 'How often do you run a competitive analysis? ', 'create new item', '2009-08-09 00:14:19', '0000-00-00 00:00:00', 2, 9, NULL, NULL, 0, 0, 0),
(12, 'did you run a competitive analysis?', 'Yes/no', '2009-08-09 12:46:02', '0000-00-00 00:00:00', 0, 0, NULL, NULL, 0, 0, 0),
(14, 'zkouska', 'hovno', '2009-08-17 20:22:28', '2009-08-17 20:23:32', 2, 17, NULL, NULL, 0, 0, 0);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='jednotky ke kpi' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `kpi_units`
--

INSERT INTO `kpi_units` (`id`, `name`, `description`, `spec`, `created`) VALUES
(1, 'days', 'represents count of days', '', '2009-08-16 17:52:05'),
(2, '%', 'represents percentage of something', '', '2009-08-16 17:52:25'),
(3, 'floating point number', 'represents real numbers', '', '2009-08-16 17:53:06'),
(4, 'CZK', 'currency', '', '2009-08-16 18:02:30'),
(5, 'months', 'represents months', '','2009-08-16 18:02:30') ;

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'Praha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Brno', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Ostrava', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Olomouc', 'syrecky', '0000-00-00 00:00:00', '2009-07-29 02:39:40'),
(5, 'Zlín', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ČZU Praha', '', '0000-00-00 00:00:00', '2009-07-28 18:00:54'),
(7, 'Pardubice', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Plzeň', '', '0000-00-00 00:00:00', '2009-07-28 18:01:03'),
(9, 'Karviná', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'MC', 'Member Committee  Czech republic', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `locking`
--

INSERT INTO `locking` (`id`, `lc`, `quarter`, `term`) VALUES
(9, 10, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quarters`
--

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE `quarters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  `quarter_in_term` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `quarters`
--

INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`, `quarter_in_term`) VALUES
(3, '2009-12-16', '2010-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3),
(2, '2009-09-16', '2009-12-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2),
(1, '2009-06-16', '2009-09-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(4, '2010-03-16', '2010-06-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 4),
(5, '2010-06-16', '2010-09-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 1),
(6, '2010-09-16', '2010-12-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 2),
(8, '2011-03-16', '2011-06-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 4),
(7, '2010-12-16', '2011-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 3);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`, `number_of_term`) VALUES
(2, '2010-06-16', '2011-06-15', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(1, '2009-06-16', '2010-06-15', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

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

INSERT INTO `tracking` (`id`, `area`, `lc`, `actual`, `target`, `created`, `updated`, `term`) VALUES
(1, 1, 2, 100, 0, '0000-00-00 00:00:00', '2009-07-20 18:29:57', 1),
(2, 3, 2, 200, 0, '0000-00-00 00:00:00', '2009-07-20 18:29:57', 1),
(3, 6, 2, 400, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(4, 4, 2, 50, 0, '0000-00-00 00:00:00', '2009-07-20 18:29:57', 1),
(5, 5, 2, 20, 0, '0000-00-00 00:00:00', '2009-07-20 18:29:57', 1),
(6, 1, 1, 200, 100, '0000-00-00 00:00:00', '2009-07-31 21:03:46', 1),
(7, 2, 1, 13, 12, '0000-00-00 00:00:00', '2009-07-31 21:03:46', 1),
(8, 3, 1, 15, 0, '0000-00-00 00:00:00', '2009-07-24 16:17:56', 1),
(9, 1, 1, 10, 20, '0000-00-00 00:00:00', '2009-07-24 16:16:49', 2),
(10, 2, 1, 12, 0, '0000-00-00 00:00:00', '2009-07-22 00:22:50', 2),
(11, 3, 1, 13, 0, '0000-00-00 00:00:00', '2009-07-22 00:22:50', 2),
(12, 4, 1, 0, 100, '0000-00-00 00:00:00', '2009-07-31 21:03:46', 1),
(13, 5, 1, 0, 150, '0000-00-00 00:00:00', '2009-07-31 21:03:46', 1),
(14, 4, 1, 15, 0, '0000-00-00 00:00:00', '2009-07-22 00:22:50', 2),
(15, 5, 1, 20, 0, '0000-00-00 00:00:00', '2009-07-22 00:22:50', 2),
(16, 1, 1, 10, 0, '0000-00-00 00:00:00', '2009-07-29 19:52:26', 4),
(17, 6, 1, 20, 0, '0000-00-00 00:00:00', '2009-07-29 19:52:26', 4),
(18, 6, 1, 0, 1000, '0000-00-00 00:00:00', '2009-07-31 21:03:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `surname` varchar(45) COLLATE utf8_bin NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `login` varchar(45) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users-lc` (`lc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `lc`, `pass`, `login`, `created`, `updated`) VALUES
(1, 'Marek', 'Beran', 1, 'brucelee', 'Praha', '0000-00-00 00:00:00', '2009-07-28 17:52:50'),
(2, '', '', 3, 'brucelee', 'Ostrava', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '', '', 8, 'brucelee', 'Plzen', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '', '', 7, 'brucelee', 'Pardubice', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '', '', 2, 'brucelee', 'Brno', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '', '', 6, 'brucelee', 'CZU', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '', '', 9, 'brucelee', 'Karvina', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '', '', 5, 'brucelee', 'Zlin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '', '', 4, 'brucelee', 'Olomouc', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '', '', 10, 'brucelee', 'MC', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_ibfk_1` FOREIGN KEY (`quarter`) REFERENCES `kpis` (`quarter`);
