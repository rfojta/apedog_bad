<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_modelclass
 *
 * @author Richard
 */
class QuarterModel extends GenericModel {

    protected $table_name = 'quarters';
    //put your code here

    public function new_item_row() {
        return array(
        'id' => 'new',
        'quarter_from' => 'new',
        'quarter_to' => 'create new quarter',
        'description' => '',
        'term' => ''
        );
    }

    public function get_row_label($row) {
        return $row['quarter_from'] . " - " . $row['quarter_to'];
    }
}

/*
-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 25. srpna 2009, 11:26
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `apedog2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `quarters`
--

CREATE TABLE IF NOT EXISTS `quarters` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `quarter_from` date NOT NULL,
  `quarter_to` date NOT NULL,
  `description` datetime NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `term` int(10) unsigned NOT NULL,
  `quarter_in_term` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `quarters`
--

INSERT INTO `quarters` (`id`, `quarter_from`, `quarter_to`, `description`, `created`, `updated`, `term`, `quarter_in_term`) VALUES
(3, '2009-12-16', '2010-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3),
(2, '2009-09-16', '2009-12-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2),
(1, '2009-06-16', '2009-09-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1),
(4, '2010-03-16', '2010-06-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 4),
(5, '2010-06-16', '2010-09-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 1),
(6, '2010-09-16', '2010-12-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 2),
(8, '2011-03-16', '2011-06-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 4),
(7, '2010-12-16', '2011-03-15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 3);

</pre>

*/
?>