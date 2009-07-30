-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 28. července 2009, 21:28
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `apedog`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `areas`
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'PR', 'public relations', '0000-00-00 00:00:00', '2009-07-28 12:16:45'),
(2, 'ICX', 'incoming exchange', '0000-00-00 00:00:00', '2009-07-27 01:45:26'),
(3, 'OGX', 'outgoing exchange', '0000-00-00 00:00:00', '2009-07-28 12:18:34'),
(4, 'TM', 'talent management', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'ER', 'enterprise relationship', '0000-00-00 00:00:00', '2009-07-27 01:40:08'),
(6, 'F', 'finance', '2009-07-27 21:16:53', '2009-07-28 12:18:51'),
(7, 'P', 'President', '0000-00-00 00:00:00', '2009-07-28 12:20:41');

-- --------------------------------------------------------

--
-- Struktura tabulky `kpis`
--

DROP TABLE IF EXISTS `kpis`;
CREATE TABLE IF NOT EXISTS `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kpis-area` (`area`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `created`, `updated`, `area`) VALUES
(7, 'Market research', 'did you run a competitive analysis? (ano/ne)', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(8, 'tm test', 'test kpi under tm', '2009-07-28 14:09:28', '2009-07-28 17:40:12', 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `lcs`
--

DROP TABLE IF EXISTS `lcs`;
CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `description` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'Praha', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Brno', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Ostrava', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Olomouc', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Zlín', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ČZU Praha', '', '0000-00-00 00:00:00', '2009-07-28 18:00:54'),
(7, 'Pardubice', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Plzeň', '', '0000-00-00 00:00:00', '2009-07-28 18:01:03'),
(9, 'Karviná', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'MC', 'Member Committee  Czech republic', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `quarters`
--

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE IF NOT EXISTS `quarters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`quarter_from`,`quarter_to`),
  UNIQUE KEY `quarter-term` (`term`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `quarters`
--

INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`) VALUES
(1, '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '2009-07-28 20:44:24', '0000-00-00 00:00:00', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `roles`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  `description` varchar(255) collate latin2_czech_cs NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`) VALUES
(1, '2009-07-01', '2009-09-30', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '2009-10-01', '2009-12-31', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `tracking`
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE IF NOT EXISTS `tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `area` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `area-lc-term` (`area`,`lc`,`term`),
  KEY `term` (`term`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=16 ;

--
-- Vypisuji data pro tabulku `tracking`
--

INSERT INTO `tracking` (`id`, `area`, `lc`, `actual`, `target`, `updated`, `term`) VALUES
(1, 1, 2, 100, 0, '2009-07-20 18:29:57', 1),
(2, 3, 2, 200, 0, '2009-07-20 18:29:57', 1),
(3, 6, 2, 400, 0, '0000-00-00 00:00:00', 2),
(4, 4, 2, 50, 0, '2009-07-20 18:29:57', 1),
(5, 5, 2, 20, 0, '2009-07-20 18:29:57', 1),
(6, 1, 1, 200, 100, '2009-07-24 16:18:01', 1),
(7, 2, 1, 13, 12, '2009-07-24 16:18:01', 1),
(8, 3, 1, 15, 0, '2009-07-24 16:17:56', 1),
(9, 1, 1, 10, 20, '2009-07-24 16:16:49', 2),
(10, 2, 1, 12, 0, '2009-07-22 00:22:50', 2),
(11, 3, 1, 13, 0, '2009-07-22 00:22:50', 2),
(12, 4, 1, 0, 100, '2009-07-24 16:18:01', 1),
(13, 5, 1, 0, 150, '2009-07-24 16:18:01', 1),
(14, 4, 1, 15, 0, '2009-07-22 00:22:50', 2),
(15, 5, 1, 20, 0, '2009-07-22 00:22:50', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `surname` varchar(45) collate latin1_general_ci NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) collate latin1_general_ci default NULL,
  `login` varchar(45) collate latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `users-lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `users`
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
