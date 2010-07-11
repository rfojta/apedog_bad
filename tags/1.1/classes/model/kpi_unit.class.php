<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_unitclass
 *
 * @author Richard
 */
class KpiUnitModel extends GenericModel {
//put your code here
    protected $table_name = 'kpi_units';

// protected $editable_fields = array('name', 'description');

    public function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'spec' => '',
        'description' => 'create new item'
        );
    }

}

/*
-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 25. srpna 2009, 11:24
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `apedog2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `kpi_units`
--

CREATE TABLE IF NOT EXISTS `kpi_units` (
  `id` int(10) NOT NULL auto_increment COMMENT 'PK',
  `name` varchar(50) collate utf8_bin NOT NULL COMMENT 'jmeno jednotky',
  `description` varchar(100) collate utf8_bin NOT NULL COMMENT 'popis jednotky',
  `spec` varchar(100) collate utf8_bin NOT NULL COMMENT 'specifikace prace s jednotky',
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'vytvoreno',
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='jednotky ke kpi' AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `kpi_units`
--

INSERT INTO `kpi_units` (`id`, `name`, `description`, `spec`, `created`, `updated`) VALUES
(1, 'days', 'represents count of days', '', '2009-08-16 17:52:05', '0000-00-00 00:00:00'),
(2, '%', 'represents percentage of something', '', '2009-08-16 17:52:25', '0000-00-00 00:00:00'),
(3, 'floating point number', 'represents real numbers', '', '2009-08-16 17:53:06', '0000-00-00 00:00:00'),
(4, 'CZK', 'currency', '', '2009-08-16 18:02:30', '0000-00-00 00:00:00'),
(5, 'boolean3', 'Yes/No', 'boolean', '0000-00-00 00:00:00', '2009-08-18 21:05:38');

</pre>
*/
?>
