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
class TermModel extends GenericModel {

    protected $table_name = 'terms';
    //put your code here

    protected $editable_fields = array('term_from', 'term_to', 'description', 'number_of_term');

    public function new_item_row() {
        return array(
        'id' => 'new',
        'term_from' => 'new',
        'term_to' => 'create new term',
        'description' => 'create new item',
        'number_of_term' => ''
        );
    }

    public function get_row_label( $row ) {
        return $row['term_from'] . " - " . $row['term_to'];
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
-- Struktura tabulky `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `term_from` date NOT NULL,
  `term_to` date NOT NULL,
  `description` varchar(255) character set latin2 collate latin2_czech_cs NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `number_of_term` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `term_from` (`term_from`,`term_to`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Vypisuji data pro tabulku `terms`
--

INSERT INTO `terms` (`id`, `term_from`, `term_to`, `description`, `created`, `updated`, `number_of_term`) VALUES
(2, '2010-06-16', '2011-06-15', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(1, '2009-06-16', '2010-06-15', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

</pre>

*/
?>