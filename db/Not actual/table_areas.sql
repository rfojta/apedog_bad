-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Pocítac: mysql.wz.cz:3306
-- Vygenerováno: Sobota 18. cervence 2009, 12:34
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

