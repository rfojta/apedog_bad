<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Locking
 *
 * @author Krystof
 */
class Locking {
    private $dbutil;

    protected $table_name = "locking";

    private $queries = array(
    'get_count_query',
    'delete_query'
    );

    private $get_count_query = 'select count(*) from :table_name';
    private $update_query = 'update :table_name
        set lc = :lc_id,
        quarter = :quarter_id,
        term = :term_id';

    private $where_query = 'where lc = :lc_id
       and quarter =:quarter_id and term =:term_id';

    private $insert_query =
    'insert into :table_name (lc, quarter, term)
       values(:lc_id, :quarter_id, :term_id)';

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
        $this->update_query =
            str_replace($search, $replace, $this->update_query);
    }

    function parse_query($pre_query, $values) {
        $tags = array(':lc_id', ':quarter_id', ':term_id');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    function parse_where_query($query, $values) {

        $query = str_replace(':lc_id', $values[0], $query);
        if ($values[1]!='NULL'){
            $query = str_replace('=:quarter_id', '='.$values[1], $query);
        } else {
            $query = str_replace('=:quarter_id', 'IS NULL', $query);
        }
        if ($values[2]!='NULL'){
            $query = str_replace('=:term_id', '='.$values[2], $query);
        } else {
            $query = str_replace('=:term_id', 'IS NULL', $query);
        }
        return $query;
    }


    function get_count($lc_id, $quarter_id, $term_id) {
        $pre_query = $this->get_count_query;
        $values = array($lc_id, $quarter_id, $term_id);
        $query = $this->parse_where_query($pre_query, $values );
        $rows = $this->dbutil->process_query_array($query);

        return $rows[0][0];
    }

    function set_value($lc_id, $quarter_id, $term_id) {
        $count = $this->get_count($lc_id, $quarter_id, $term_id);
        if( $count == 0 ) {
            $this->insert_value($lc_id, $quarter_id, $term_id);
            } else {
            $this->update_value($lc_id, $quarter_id, $term_id);
        }
    }

    function insert_value($lc_id, $quarter_id, $term_id) {
        $values = array($lc_id, $quarter_id, $term_id);
        $pre_query = $this->insert_query;
        $query = $this->parse_query( $pre_query, $values);
        $this->dbutil->do_query($query);
    }

    function update_value($lc_id, $quarter_id, $term_id) {
        $values = array( $lc_id, $quarter_id, $term_id);
        $pre_query = $this->update_query;
        $query = $this->parse_query( $pre_query, $values );
        $query .= ' '.$this->parse_where_query($this->where_query, $values);
        $this->dbutil->do_query($query);
    }

    function delete_value($lc_id, $quarter_id, $term_id) {
        $count = $this->get_count($lc_id, $quarter_id, $term_id);
        while( $count != 0 ) {
            $values = array( $lc_id, $quarter_id, $term_id);
            $pre_query = $this->delete_query;
            $query = $this->parse_where_query( $pre_query, $values );

            $this->dbutil->do_query($query);
            $count = $this->get_count($lc_id, $quarter_id, $term_id);
        }
    }


}
?>
