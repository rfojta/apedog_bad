<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of lckpi_modelclass
 *
 * @author Richard
 */
class LcKpiModel extends GenericModel {
    //put your code here

    protected $table_name = 'lc_kpi';
}

/*
-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 25. srpna 2009, 11:25
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `apedog2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `lc_kpi`
--

CREATE TABLE IF NOT EXISTS `lc_kpi` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `lc` int(10) unsigned NOT NULL,
  `kpi` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lc_kpi_lc` (`lc`),
  KEY `lc_kpi_kpi` (`kpi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='vazebni tabulka mezi lc a kpi' AUTO_INCREMENT=18 ;

--
-- Vypisuji data pro tabulku `lc_kpi`
--

INSERT INTO `lc_kpi` (`id`, `lc`, `kpi`, `created`, `updated`) VALUES
(4, 6, 2, '2009-08-24 13:14:27', '0000-00-00 00:00:00'),
(5, 5, 2, '2009-08-24 13:16:14', '0000-00-00 00:00:00'),
(6, 7, 2, '2009-08-24 13:16:26', '0000-00-00 00:00:00'),
(14, 3, 3, '2009-08-24 21:51:49', '0000-00-00 00:00:00'),
(15, 1, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00'),
(16, 2, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00'),
(17, 3, 4, '2009-08-24 21:52:47', '0000-00-00 00:00:00');

</pre>

*/
?>