-- phpMyAdmin SQL Dump
-- version 2.6.0-pl3
-- http://www.phpmyadmin.net
-- 
-- Pocítac: mysql.wz.cz:3306
-- Vygenerováno: Sobota 18. cervence 2009, 20:57
-- Verze MySQL: 5.0.67
-- Verze PHP: 5.2.10
-- 
-- Databáze: `apedog`
-- 

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

