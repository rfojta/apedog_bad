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
?>
