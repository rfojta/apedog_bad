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
class LcModel extends GenericModel {

    protected $table_name = 'lcs';
    //put your code here

    protected $editable_fields = array('name', 'description');


    public function find_by_area( $area ) {
        $query = $this->kpi_query . $area;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item'
        );
    }

    public function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }

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
-- Struktura tabulky `lcs`
--

CREATE TABLE IF NOT EXISTS `lcs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `description` varchar(45) character set utf8 collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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

</pre>

*/
?>
