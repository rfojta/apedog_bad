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
class Locking {
    private $dbutil;

    protected $table_name = "locking";

    private $queries = array(
    'get_count_query',
    'update_query',
    'delete_query'
    );

    private $get_count_query = 'select count(*) from :table_name';
    private $update_query = 'update :table_name
        set lc = :lc_id,
        quarter = :quarter_id';

    private $where_query = 'where lc = :lc_id
       and quarter = :quarter_id';

    private $insert_query =
    'insert into :table_name (lc, quarter)
       values(:lc_id, :quarter_id)';

    private $delete_query =
    'DELETE FROM :table_name';

    function __construct($dbutil) {
        $this->dbutil = $dbutil;
        $this->parse_queries();
    }
    private function parse_queries() {
        $search = array(':table_name');
        $replace = array($this->table_name);

        foreach( $this->queries as $q ) {
            $this->$q = str_replace($search, $replace, $this->$q)
                . ' ' . $this->where_query;
        }
        $this->insert_query =
            str_replace($search, $replace, $this->insert_query);
    }

    function parse_query($pre_query, $values) {
        $tags = array(':lc_id', ':quarter_id');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    function get_count($lc_id, $quarter_id) {
        $pre_query = $this->get_count_query;
        $values = array($lc_id, $quarter_id);
        $query = $this->parse_query($pre_query, $values );
        $query .= ' '.$where_query;

        $rows = $this->dbutil->process_query_array($query);

        return $rows[0][0];
    }

    function set_value($lc_id, $quarter_id) {
        $count = $this->get_count($lc_id, $quarter_id);
        if( $count == 0 ) {
            $this->insert_value($lc_id, $quarter_id);
        } else {
            $this->update_value($lc_id, $quarter_id);
        }
    }

    function insert_value($lc_id, $quarter_id) {
        $values = array( $lc_id, $quarter_id);
        $pre_query = $this->insert_query;
        $query = $this->parse_query( $pre_query, $values );

        $this->dbutil->do_query($query);
    }

    function update_value($lc_id, $quarter_id) {
        $values = array( $lc_id, $quarter_id);
        $pre_query = $this->update_query;
        $query = $this->parse_query( $pre_query, $values );

        $this->dbutil->do_query($query);
    }

    function delete_value($lc_id, $quarter_id) {
        $count = $this->get_count($lc_id, $quarter_id);
        while( $count != 0 ) {
            $values = array( $lc_id, $quarter_id);
            $pre_query = $this->delete_query;
            $query = $this->parse_query( $pre_query, $values );

            $this->dbutil->do_query($query);
            $count = $this->get_count($lc_id, $quarter_id);
        }
    }


}
?>
