<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_modelclass
 *
 * @author Krystof
 */
class Business_PerspectiveModel extends GenericModel {

    protected $table_name = 'business_perspectives';
    //put your code here

    protected $editable_fields = array('name', 'description');

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
-- Vygenerováno: Úterý 25. srpna 2009, 11:22
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `apedog2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `business_perspectives`
--

CREATE TABLE IF NOT EXISTS `business_perspectives` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Vypisuji data pro tabulku `business_perspectives`
--

INSERT INTO `business_perspectives` (`id`, `name`, `description`, `created`, `updated`) VALUES
(11, 'Customers', 'create new item', '2009-08-08 23:02:14', '0000-00-00 00:00:00'),
(12, 'Internal Processes', 'create new item', '2009-08-08 23:02:27', '0000-00-00 00:00:00'),
(13, 'Learning and Capacity', 'create new item', '2009-08-08 23:02:41', '0000-00-00 00:00:00'),
(9, 'The Way we do it', 'create new item', '2009-08-08 23:01:54', '0000-00-00 00:00:00'),
(10, 'Sustainability', 'create new item', '2009-08-08 23:02:01', '0000-00-00 00:00:00');

</pre>

*/
?>