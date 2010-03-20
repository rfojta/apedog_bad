-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Počítač: mysql.wz.cz:3306
-- Vygenerováno: Pondělí 20. července 2009, 12:59
-- Verze MySQL: 5.0.67
-- Verze PHP: 5.2.10
-- 
-- Databáze: `apedog`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `areas`
-- 

CREATE TABLE `areas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Vypisuji data pro tabulku `areas`
-- 

INSERT INTO `areas` VALUES (1, 'PR', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `areas` VALUES (2, 'ICX', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `areas` VALUES (3, 'OGX', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `areas` VALUES (4, 'TM', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `areas` VALUES (5, 'CR', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `areas` VALUES (6, 'ER', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `kpis`
-- 

CREATE TABLE `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

-- 
-- Vypisuji data pro tabulku `kpis`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `lcs`
-- 

CREATE TABLE `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `description` varchar(45) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- 
-- Vypisuji data pro tabulku `lcs`
-- 

INSERT INTO `lcs` VALUES (1, 'Praha', '');
INSERT INTO `lcs` VALUES (2, 'Brno', '');
INSERT INTO `lcs` VALUES (3, 'Ostrava', '');
INSERT INTO `lcs` VALUES (4, 'Olomouc', '');
INSERT INTO `lcs` VALUES (5, 'Zlín', '');
INSERT INTO `lcs` VALUES (6, '?ZU Praha', '');
INSERT INTO `lcs` VALUES (7, 'Pardubice', '');
INSERT INTO `lcs` VALUES (8, 'Plze?', '');
INSERT INTO `lcs` VALUES (9, 'Karviná', '');
INSERT INTO `lcs` VALUES (10, 'MC', 'Member Committee  Czech republic');

-- --------------------------------------------------------

-- 
-- Struktura tabulky `roles`
-- 

CREATE TABLE `roles` (
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

CREATE TABLE `terms` (
  `ID` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=3 ;

-- 
-- Vypisuji data pro tabulku `terms`
-- 

INSERT INTO `terms` VALUES (1, 0x323030392d30372d3031, 0x323030392d30392d3330);
INSERT INTO `terms` VALUES (2, 0x323030392d31302d3031, 0x323030392d31322d3331);

-- --------------------------------------------------------

-- 
-- Struktura tabulky `tracking`
-- 

CREATE TABLE `tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `area` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` int(10) unsigned NOT NULL,
  `target` int(10) unsigned NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `term` (`term`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_czech_cs AUTO_INCREMENT=1 ;

-- 
-- Vypisuji data pro tabulku `tracking`
-- 


-- --------------------------------------------------------

-- 
-- Struktura tabulky `users`
-- 

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) collate latin1_general_ci NOT NULL,
  `surname` varchar(45) collate latin1_general_ci NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `pass` varchar(45) collate latin1_general_ci default NULL,
  `login` varchar(45) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

-- 
-- Vypisuji data pro tabulku `users`
-- 

INSERT INTO `users` VALUES (1, '', '', 1, 'brucelee', 'Praha');
INSERT INTO `users` VALUES (2, '', '', 3, 'brucelee', 'Ostrava');
INSERT INTO `users` VALUES (3, '', '', 8, 'brucelee', 'Plzen');
INSERT INTO `users` VALUES (4, '', '', 7, 'brucelee', 'Pardubice');
INSERT INTO `users` VALUES (5, '', '', 2, 'brucelee', 'Brno');
INSERT INTO `users` VALUES (6, '', '', 6, 'brucelee', 'CZU');
INSERT INTO `users` VALUES (7, '', '', 9, 'brucelee', 'Karvina');
INSERT INTO `users` VALUES (8, '', '', 5, 'brucelee', 'Zlin');
INSERT INTO `users` VALUES (9, '', '', 4, 'brucelee', 'Olomouc');
INSERT INTO `users` VALUES (10, '', '', 10, 'brucelee', 'MC');
