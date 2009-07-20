-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pondělí 20. července 2009, 19:18
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

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `created`, `updated`) VALUES
(1, 'PR', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'ICX', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'OGX', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'TM', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'CR', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ER', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `kpis`
--

CREATE TABLE IF NOT EXISTS `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `kpis`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `lcs`
--

CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `lcs`
--

INSERT INTO `lcs` (`id`, `name`, `description`) VALUES
(1, 'Praha', ''),
(2, 'Brno', ''),
(3, 'Ostrava', ''),
(4, 'Olomouc', ''),
(5, 'Zlín', ''),
(6, '?ZU Praha', ''),
(7, 'Pardubice', ''),
(8, 'Plze?', ''),
(9, 'Karviná', ''),
(10, 'MC', 'Member Committee  Czech republic');

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

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

CREATE TABLE IF NOT EXISTS `terms` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `terms`
--

INSERT INTO `terms` (`ID`, `term_from`, `term_to`) VALUES
(1, '2009-07-01', '2009-09-30'),
(2, '2009-10-01', '2009-12-31');

-- --------------------------------------------------------

--
-- Struktura tabulky `tracking`
--

CREATE TABLE IF NOT EXISTS `tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `area` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `term` (`term`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=12 ;

--
-- Vypisuji data pro tabulku `tracking`
--

INSERT INTO `tracking` (`id`, `area`, `lc`, `actual`, `target`, `updated`, `term`) VALUES
(1, 1, 2, 100, 0, '2009-07-20 18:29:57', 1),
(2, 3, 2, 200, 0, '2009-07-20 18:29:57', 1),
(3, 6, 2, 400, 0, '0000-00-00 00:00:00', 2),
(4, 4, 2, 50, 0, '2009-07-20 18:29:57', 1),
(5, 5, 2, 20, 0, '2009-07-20 18:29:57', 1),
(6, 1, 1, 12, 10, '2009-07-20 18:47:21', 1),
(7, 2, 1, 13, 0, '2009-07-20 18:42:33', 1),
(8, 3, 1, 15, 0, '2009-07-20 18:42:33', 1),
(9, 1, 1, 10, 0, '2009-07-20 18:43:10', 2),
(10, 2, 1, 12, 0, '2009-07-20 18:43:10', 2),
(11, 3, 1, 13, 0, '2009-07-20 18:43:10', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `surname` varchar(45) collate latin1_general_ci NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) collate latin1_general_ci default NULL,
  `login` varchar(45) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `lc`, `pass`, `login`) VALUES
(1, '', '', 1, 'brucelee', 'Praha'),
(2, '', '', 3, 'brucelee', 'Ostrava'),
(3, '', '', 8, 'brucelee', 'Plzen'),
(4, '', '', 7, 'brucelee', 'Pardubice'),
(5, '', '', 2, 'brucelee', 'Brno'),
(6, '', '', 6, 'brucelee', 'CZU'),
(7, '', '', 9, 'brucelee', 'Karvina'),
(8, '', '', 5, 'brucelee', 'Zlin'),
(9, '', '', 4, 'brucelee', 'Olomouc'),
(10, '', '', 10, 'brucelee', 'MC');
