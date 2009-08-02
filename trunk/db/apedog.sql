-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Neděle 02. srpna 2009, 19:50
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
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `areas`;
CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `description` varchar(45) character set latin1 collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

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
-- Struktura tabulky `detail_tracking`
--
-- Vytvoření: Úterý 28. července 2009, 23:58
--

DROP TABLE IF EXISTS `detail_tracking`;
CREATE TABLE IF NOT EXISTS `detail_tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `detail_tracking`
--

INSERT INTO `detail_tracking` (`id`, `kpi`, `lc`, `actual`, `target`, `created`, `updated`, `quarter`) VALUES
(1, 7, 1, 0, 20, '0000-00-00 00:00:00', '2009-07-29 01:17:48', 1),
(2, 8, 1, 0, 30, '0000-00-00 00:00:00', '2009-07-29 01:17:48', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `kpis`
--
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `kpis`;
CREATE TABLE IF NOT EXISTS `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `description` varchar(45) character set latin1 collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kpis-area` (`area`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `created`, `updated`, `area`) VALUES
(7, 'Market research', 'did you run a competitive analysis? (ano/ne)', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(8, 'tm test', 'test kpi under tm', '2009-07-28 14:09:28', '2009-07-28 17:40:12', 4),
(9, 'new finance', 'create new item', '2009-07-29 02:28:56', '0000-00-00 00:00:00', 7),
(10, 'test pr', 'test pr', '2009-07-29 13:12:43', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `lcs`
--
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `lcs`;
CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate utf8_bin NOT NULL,
  `description` varchar(45) collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- Vypisuji data pro tabulku `lcs`
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
-- Struktura tabulky `quarters`
--
-- Vytvoření: Úterý 28. července 2009, 18:22
--

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE IF NOT EXISTS `quarters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`quarter_from`,`quarter_to`),
  UNIQUE KEY `quarter-term` (`term`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Vypisuji data pro tabulku `quarters`
--

INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`) VALUES
(1, '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '2009-07-28 20:44:24', '0000-00-00 00:00:00', 2),
(2, '2009-08-01', '2009-07-16', '0000-00-00 00:00:00', '2009-07-29 14:35:20', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Vypisuji data pro tabulku `roles`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `terms`
--
-- Vytvoření: Úterý 28. července 2009, 20:41
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  `description` varchar(255) character set latin2 collate latin2_czech_cs NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`) VALUES
(1, '2009-07-31', '2009-09-30', '', '0000-00-00 00:00:00', '2009-07-31 21:08:33'),
(2, '2009-10-01', '2009-12-31', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '2010-01-01', '2010-03-30', 'Winter 2010', '2009-07-29 02:47:51', '0000-00-00 00:00:00'),
(4, '2010-04-01', '2010-06-30', '2010 Spring', '2009-07-29 02:48:37', '0000-00-00 00:00:00'),
(5, '2010-07-01', '2010-09-30', '2010 Summer', '2009-07-29 02:49:22', '0000-00-00 00:00:00'),
(6, '0000-00-00', '0000-00-00', 'create new item', '2009-07-31 22:12:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `tracking`
--
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `tracking`;
CREATE TABLE IF NOT EXISTS `tracking` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=19 ;

--
-- Vypisuji data pro tabulku `tracking`
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
-- Struktura tabulky `users`
--
-- Vytvoření: Pondělí 20. července 2009, 13:16
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `surname` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) character set latin1 collate latin1_general_ci default NULL,
  `login` varchar(45) character set latin1 collate latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `users-lc` (`lc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

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

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `detail_tracking`
--
ALTER TABLE `detail_tracking`
  ADD CONSTRAINT `detail_tracking_ibfk_1` FOREIGN KEY (`kpi`) REFERENCES `kpis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `quarters`
--
ALTER TABLE `quarters`
  ADD CONSTRAINT `quarters_ibfk_1` FOREIGN KEY (`term`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracking_ibfk_2` FOREIGN KEY (`term`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`lc`) REFERENCES `lcs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
