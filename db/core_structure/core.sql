-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Pocitac: localhost
-- Vygenerovano: Utery 26. rijna 2010, 16:43
-- Verze MySQL: 5.1.37
-- Verze PHP: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databaze: `apedog_cz`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `created`, `updated`) VALUES
(4, 'F', 'Finance', '2009-09-01 16:52:09', '0000-00-00 00:00:00'),
(5, 'CR', 'Corporate relations', '2009-09-01 16:52:32', '2010-03-09 08:45:20'),
(6, 'ICX', 'Incoming exchange', '2009-09-01 16:52:41', '2009-09-01 16:52:56'),
(7, 'OGX', 'Outgoing Exchange', '2009-09-01 16:53:23', '2010-03-09 08:45:28'),
(8, 'TM', 'Talent Management', '2009-09-01 16:53:37', '0000-00-00 00:00:00'),
(9, 'PR', 'Public Relations', '2009-09-01 16:54:02', '2010-03-09 08:44:47'),
(10, 'President', '', '2009-09-01 16:54:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `bsc_action`
--

CREATE TABLE IF NOT EXISTS `bsc_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `strategy` int(11) NOT NULL,
  `term` int(10) NOT NULL,
  `lc` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=265 ;

--
-- Vypisuji data pro tabulku `bsc_action`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `bsc_operation`
--

CREATE TABLE IF NOT EXISTS `bsc_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `responsible` int(11) NOT NULL,
  `when` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `action` int(11) NOT NULL,
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `term` int(10) NOT NULL,
  `lc` int(10) NOT NULL,
  `when_txt` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=551 ;

--
-- Vypisuji data pro tabulku `bsc_operation`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `bsc_responsible`
--

CREATE TABLE IF NOT EXISTS `bsc_responsible` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lc` int(11) NOT NULL,
  `email` varchar(48) NOT NULL,
  `term` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=120 ;

--
-- Vypisuji data pro tabulku `bsc_responsible`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `bsc_strategy`
--

CREATE TABLE IF NOT EXISTS `bsc_strategy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lc` int(11) NOT NULL,
  `csfs` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `csf_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `csf_name` (`csf_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Vypisuji data pro tabulku `bsc_strategy`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `business_perspectives`
--

CREATE TABLE IF NOT EXISTS `business_perspectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Vypisuji data pro tabulku `business_perspectives`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `csfs`
--

CREATE TABLE IF NOT EXISTS `csfs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 NOT NULL,
  `description` varchar(45) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `business_perspective` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Critical succes factor ' AUTO_INCREMENT=17 ;

--
-- Vypisuji data pro tabulku `csfs`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `detail_tracking`
--

CREATE TABLE IF NOT EXISTS `detail_tracking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` double DEFAULT NULL,
  `target` double DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2322 ;

--
-- Vypisuji data pro tabulku `detail_tracking`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `graphs`
--

CREATE TABLE IF NOT EXISTS `graphs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) NOT NULL,
  `description` varchar(48) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `graphs`
--

INSERT INTO `graphs` (`id`, `name`, `description`) VALUES
(1, 'Line Chart', ''),
(2, 'Bar Chart', ''),
(3, 'Pie Chart', 'use in combination with percentile KPI'),
(4, 'Meter', ''),
(5, 'Line on Bar Chart', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `kpis`
--

CREATE TABLE IF NOT EXISTS `kpis` (
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
  `in_bsc` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kpi_unit` (`kpi_unit`),
  KEY `kpi_unit_2` (`kpi_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=50 ;

--
-- Vypisuji data pro tabulku `kpis`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `kpi_units`
--

CREATE TABLE IF NOT EXISTS `kpi_units` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'jmeno jednotky',
  `description` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'popis jednotky',
  `spec` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'specifikace prace s jednotky',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'vytvoreno',
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='jednotky ke kpi' AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `kpi_units`
--

INSERT INTO `kpi_units` (`id`, `name`, `description`, `spec`, `created`, `updated`) VALUES
(3, '%', 'represents percentage', '', '2009-09-02 02:12:00', '0000-00-00 00:00:00'),
(4, 'CZK', 'currency', '', '2009-09-02 02:12:11', '0000-00-00 00:00:00'),
(5, '', 'for yes/no', 'boolean', '2009-09-02 03:19:56', '2009-09-01 18:20:07'),
(6, 'days', 'represents count of days', '', '2009-09-02 03:20:29', '0000-00-00 00:00:00'),
(7, 'months', 'represents months', '', '2009-09-02 03:20:47', '2009-09-01 18:21:02');

-- --------------------------------------------------------

--
-- Struktura tabulky `lcs`
--

CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Vypisuji data pro tabulku `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'MC', 'Member Committee', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `lc_kpi`
--

CREATE TABLE IF NOT EXISTS `lc_kpi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lc` int(10) unsigned NOT NULL,
  `kpi` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lc_kpi_lc` (`lc`),
  KEY `lc_kpi_kpi` (`kpi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='vazebni tabulka mezi lc a kpi' AUTO_INCREMENT=981 ;

--
-- Vypisuji data pro tabulku `lc_kpi`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `locking`
--

CREATE TABLE IF NOT EXISTS `locking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lc` int(11) NOT NULL,
  `quarter` int(11) DEFAULT NULL,
  `term` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `locking`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `logic`
--

CREATE TABLE IF NOT EXISTS `logic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equals` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `logic`
--

INSERT INTO `logic` (`id`, `equals`) VALUES
(1, 'Sum'),
(2, 'Average'),
(3, 'Last value'),
(4, 'if at least 1 yes=>yes');

-- --------------------------------------------------------

--
-- Struktura tabulky `quarters`
--

CREATE TABLE IF NOT EXISTS `quarters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` varchar(75) NOT NULL,
  `created` varchar(75) NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  `quarter_in_term` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Vypisuji data pro tabulku `quarters`
--
INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`, `quarter_in_term`) VALUES
(19, '2010-07-01', '2010-09-30', '', '2010-06-25 05:36:34', '0000-00-00 00:00:00', 6, 1),
(20, '2010-10-01', '2010-12-31', '', '2010-06-25 05:37:44', '0000-00-00 00:00:00', 6, 2),
(21, '2011-01-01', '2010-03-31', '', '2010-06-25 05:38:05', '2010-06-25 05:40:35', 6, 3),
(22, '2011-04-01', '2011-06-30', '', '2010-06-25 05:38:18', '2010-06-25 05:40:23', 6, 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `roles`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
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
-- Vypisuji data pro tabulku `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`, `number_of_term`) VALUES
(6, '2010-07-01', '2011-06-30', 'create new item', '2010-06-25 05:36:08', '2010-06-25 05:38:39', 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `tracking`
--

CREATE TABLE IF NOT EXISTS `tracking` (
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
-- Vypisuji data pro tabulku `tracking`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `lc`, `pass`, `login`, `created`, `updated`) VALUES
(1, '', '', '', 1, 'aiesec', 'MC', '0000-00-00 00:00:00', '2009-09-01 19:44:02');
