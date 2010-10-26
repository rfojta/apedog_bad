<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tracking
 *
 * @author Richard
 */
class DetailTracking {
    private $dbutil;

    protected $table_name = "detail_tracking";
    private $actual;

    private $queries = array(
        'get_query',
        'get_count_query',
        'update_query'
    );

    private $get_query = 'select actual from :table_name';
    private $get_count_query = 'select count(*) from :table_name';
    private $update_query = 'update :table_name
        set actual = :value,
        updated = current_timestamp()';

    private $where_query = 'where lc = :lc_id
       and quarter = :quarter_id
       and kpi = :kpi_id';

    private $insert_query =
    'insert into :table_name (lc, quarter, kpi, actual, updated)
       values(:lc_id, :quarter_id, :kpi_id, :value, current_timestamp())';

    function __construct($dbutil, $actual = 0) {
        $this->dbutil = $dbutil;
        $this->actual = $actual;
        $this->parse_queries();
    }

    private function parse_queries() {
        $search = array(':table_name');
        $replace = array($this->table_name);
        if( ! $this->actual ) {
            $search[] = 'actual';
            $replace[] = 'target';
        }
        foreach( $this->queries as $q ) {
            $this->$q = str_replace($search, $replace, $this->$q)
                . ' ' . $this->where_query;
        }
        $this->insert_query =
            str_replace($search, $replace, $this->insert_query);
    }

    function parse_query($pre_query, $values) {
        $tags = array(':lc_id', ':quarter_id', ':kpi_id', ':value');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    function get_value($lc_id, $quarter_id, $kpi_id) {
        $count = $this->get_count($lc_id, $quarter_id, $kpi_id);
        if( $count == 0 ) {
            return '';
        }
        $pre_query = $this->get_query;
        $values = array($lc_id, $quarter_id, $kpi_id);
        $query = $this->parse_query($pre_query, $values);
        $rows = $this->dbutil->process_query_assoc($query);

        if( $this->actual == 0 ) {
            return $rows[0]['target'];
        } else {
            return $rows[0]['actual'];
        }
    }

    function get_count($lc_id, $quarter_id, $kpi_id) {
        $pre_query = $this->get_count_query;
        $values = array($lc_id, $quarter_id, $kpi_id);
        $query = $this->parse_query($pre_query, $values );

        $rows = $this->dbutil->process_query_array($query);

        return $rows[0][0];
    }

    function set_value($lc_id, $quarter_id, $kpi_id, $value) {
        $count = $this->get_count($lc_id, $quarter_id, $kpi_id);
        if( $count == 0 ) {
            $this->insert_value($lc_id, $quarter_id, $kpi_id, $value);
        } else {
            $this->update_value($lc_id, $quarter_id, $kpi_id, $value);
        }
    }

    function insert_value($lc_id, $quarter_id, $kpi_id, $value) {
        $value = str_replace(",", ".", $value);
        $values = array( $lc_id, $quarter_id, $kpi_id, $value );
        $pre_query = $this->insert_query;
        $query = $this->parse_query( $pre_query, $values );

        $this->dbutil->do_query($query);
    }

    function update_value($lc_id, $quarter_id, $kpi_id, $value) {
        $values = array( $lc_id, $quarter_id, $kpi_id, $value );
        $pre_query = $this->update_query;
        $query = $this->parse_query( $pre_query, $values );

        $this->dbutil->do_query($query);
    }

}

/*
-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Úterý 25. srpna 2009, 11:28
-- Verze MySQL: 5.0.45
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `apedog2`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `detail_tracking`
--

CREATE TABLE IF NOT EXISTS `detail_tracking` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kpi` int(10) unsigned NOT NULL,
  `lc` int(10) unsigned NOT NULL,
  `actual` double NOT NULL,
  `target` double NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `quarter` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kpi-lc-quarter` (`kpi`,`lc`,`quarter`),
  KEY `kpi` (`kpi`),
  KEY `quarter` (`quarter`),
  KEY `lc` (`lc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Vypisuji data pro tabulku `detail_tracking`
--

INSERT INTO `detail_tracking` (`id`, `kpi`, `lc`, `actual`, `target`, `created`, `updated`, `quarter`) VALUES
(35, 2, 10, 50, 60, '0000-00-00 00:00:00', '2009-08-17 16:08:23', 1),
(36, 2, 10, 89, 666, '0000-00-00 00:00:00', '2009-08-17 16:09:06', 2),
(37, 2, 10, 80, 50, '0000-00-00 00:00:00', '2009-08-17 15:44:52', 3),
(38, 2, 10, 88, 90, '0000-00-00 00:00:00', '2009-08-17 15:44:58', 4),
(39, 2, 10, -89, -40, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(40, 3, 10, 0, 30, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(41, 2, 10, 78, 50, '0000-00-00 00:00:00', '2009-08-17 15:45:10', 6),
(42, 3, 10, 79, 70, '0000-00-00 00:00:00', '2009-08-17 15:45:10', 6),
(43, 2, 10, 50, 60, '0000-00-00 00:00:00', '2009-08-17 15:45:16', 7),
(44, 2, 10, 50, 80, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(45, 3, 10, 90, 70, '0000-00-00 00:00:00', '2009-08-17 16:09:06', 2),
(46, 3, 10, 70, 0, '0000-00-00 00:00:00', '2009-08-17 01:47:38', 1),
(47, 4, 10, 54, 444, '0000-00-00 00:00:00', '2009-08-17 16:08:23', 1),
(48, 4, 10, 190, 888, '0000-00-00 00:00:00', '2009-08-17 16:09:06', 2),
(49, 4, 10, 300, 89, '0000-00-00 00:00:00', '2009-08-17 15:44:52', 3),
(50, 4, 10, 100, 120, '0000-00-00 00:00:00', '2009-08-17 15:44:58', 4),
(51, 4, 10, 767, 234, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(52, 4, 10, 0, 888, '0000-00-00 00:00:00', '2009-08-17 15:45:10', 6),
(53, 4, 10, 0, 98, '0000-00-00 00:00:00', '2009-08-17 15:45:16', 7),
(54, 4, 10, 0, 78, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(55, 3, 10, 30, 35, '0000-00-00 00:00:00', '2009-08-17 16:00:10', 8),
(56, 7, 10, 0, -12.5, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(57, 10, 10, 0, -10, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(58, 12, 10, 0, 0, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5),
(59, 6, 10, 0, -1, '0000-00-00 00:00:00', '2009-08-18 21:02:15', 5);

</pre>
*/
?>