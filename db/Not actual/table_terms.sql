-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Počítač: mysql.wz.cz:3306
-- Vygenerováno: Sobota 18. července 2009, 20:46
-- Verze MySQL: 5.0.67
-- Verze PHP: 5.2.10
-- 
-- Databáze: `apedog`
-- 

-- --------------------------------------------------------

-- 
-- Struktura tabulky `terms`
-- 

DROP TABLE IF EXISTS `terms`;
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

INSERT INTO `terms` (`ID`, `term_from`, `term_to`) VALUES (1, 0x323030392d30372d3031, 0x323030392d30392d3330),
(2, 0x323030392d31302d3031, 0x323030392d31322d3331);
