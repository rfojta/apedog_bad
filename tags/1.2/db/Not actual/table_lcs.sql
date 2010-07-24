-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Pocítac: mysql.wz.cz:3306
-- Vygenerováno: Sobota 18. cervence 2009, 12:38
-- Verze MySQL: 5.0.67
-- Verze PHP: 5.2.10
-- 
-- Databáze: `apedog`
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

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

