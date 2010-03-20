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
class KpiModel extends GenericModel {

    protected $table_name = 'kpis';
    //put your code here

    protected $kpi_query = 'select * from kpis where area = ';
    protected $editable_fields = array('name', 
        'description', 'area', 'csf', 'kpi_unit',
        'graphs', 'end_of_term', 'in_bsc', 'all_lcs');

    /**
     * Call query to find kpis by area. Deprecated, use find_by instead
     * @param <type> $area area id
     * @return <type> rows
     */
    public function find_by_area( $area ) {
        $query = $this->kpi_query . $area;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     * Generates associative array with default values for each item
     * @return <type>
     */
    public function new_item_row() {
        $column_names = $this->get_column_names();
        $new_row = array();
        foreach( $column_names as $name) {
            if( $name != 'created' && $name != 'updated') {
                $new_row[$name] = '';
            }
        }
        $new_row['name'] = 'new';
        $new_row['id'] = 'new';
        return $new_row;
        // old stupid way, sucks.
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item',
        'area' => '',
        'csf' => '',
        'kpi_unit' => ''
        );
    }

    /**
     * Return string for specified row
     * @param <type> $row
     * @return <type> 
     */
    public function get_row_label( $row ) {
        return $row['name'];
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
-- Struktura tabulky `kpis`
--

CREATE TABLE IF NOT EXISTS `kpis` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) character set latin1 collate latin1_general_ci NOT NULL,
  `description` varchar(100) character set latin1 collate latin1_general_ci default NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `area` int(10) unsigned default NULL,
  `csf` int(10) unsigned default NULL,
  `quarter` int(10) unsigned default NULL,
  `kpi_unit` int(10) NOT NULL COMMENT 'odkaz na jednotku',
  `graphs` int(1) NOT NULL,
  `end_of_term` int(1) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `quarter` (`quarter`),
  KEY `kpi_unit` (`kpi_unit`),
  KEY `kpi_unit_2` (`kpi_unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `kpis`
--

INSERT INTO `kpis` (`id`, `name`, `description`, `created`, `updated`, `area`, `csf`, `quarter`, `kpi_unit`, `graphs`, `end_of_term`) VALUES
(2, 'Quality index performance', 'Number of stars -  Quality Of the Experiences z myaiesec.net', '2009-08-08 23:48:00', '2009-08-24 13:16:26', 3, 2, NULL, 4, 1, 1),
(3, 'Number of members that finished both X & LR experiences', 'create new item', '2009-08-08 23:48:41', '2009-08-24 21:51:49', 3, 2, NULL, 0, 1, 1),
(4, 'Number of members with leadership experience finished', 'create new item', '2009-08-09 00:06:41', '2009-08-24 21:52:47', 4, 3, NULL, 5, 1, 1),
(5, 'Number of TN realized', 'create new item', '2009-08-09 00:07:04', '0000-00-00 00:00:00', 2, 4, NULL, 0, 0, 0),
(6, 'Number of EP realized', 'create new item', '2009-08-09 00:07:25', '0000-00-00 00:00:00', 3, 4, NULL, 0, 0, 0),
(7, 'Real state of finance (cash + receivables - liabilities)', 'create new item', '2009-08-09 00:10:20', '2009-08-09 00:12:23', 6, 5, NULL, 0, 0, 0),
(8, 'Number of months of reserve = (cash + receivables - liabilities)/average monthly outflow', 'create new item', '2009-08-09 00:10:41', '2009-08-09 00:12:48', 6, 5, NULL, 0, 0, 0),
(9, 'Number of EP Raised', 'create new item', '2009-08-09 00:13:29', '0000-00-00 00:00:00', 3, 6, NULL, 0, 0, 0),
(10, 'Number of TN Raised', 'create new item', '2009-08-09 00:13:54', '0000-00-00 00:00:00', 2, 7, NULL, 0, 0, 0),
(11, 'How often do you run a competitive analysis? ', 'create new item', '2009-08-09 00:14:19', '0000-00-00 00:00:00', 2, 9, NULL, 0, 0, 0),
(12, 'did you run a competitive analysis?', 'Yes/no', '2009-08-09 12:46:02', '2009-08-18 20:45:09', 0, 0, NULL, 5, 0, 0);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `kpis`
--
ALTER TABLE `kpis`
  ADD CONSTRAINT `kpis_ibfk_1` FOREIGN KEY (`quarter`) REFERENCES `kpis` (`quarter`);

</pre>

*/
?>