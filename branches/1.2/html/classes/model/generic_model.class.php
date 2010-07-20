<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of generic_modelclass
 *
 * @author Richard
 */
class GenericModel {
    protected $queries = array('select_query', 'update_query', 'insert_query');
    protected $select_query = 'select * from :table_name';


    protected $editable_fields;
    protected $update_query = 'update :table_name
        set :field = \':value\', updated = current_timestamp()
        where id = :id';

    protected $insert_query = 'insert into :table_name
        (:columns, created) values (:values, current_timestamp())';

    protected $delete_query = 'delete from :table_name';

    protected $dbutil;
    protected $id;

    public function get_dbutil() {
        return $this->dbutil;
    }

    /**
     * call parse_table_name for each of $this->queries
     */
    private function parse_queries() {
        foreach( $this->queries as $q) {
            $this->$q = $this->parse_table_name($this->$q);
        }
    }

    /**
     *
     * @param <type> $query sql query to be parsed
     * @return <type> replace :table_name with current table 
     */
    private function parse_table_name( $query ) {
        return str_replace(':table_name', $this->table_name, $query );

    }

    /**
     * Replace :field, :value, :id with specified values
     * @param <type> $pre_query sql query, presumed update ...
     * @param <type> $values array of field, value, id
     * @return <type> 
     */
    protected function parse_query($pre_query, $values) {
        $tags = array(':field', ':value', ':id');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    /**
     * Initialization of ORM object
     * @param <type> $dbutil
     */
    function  __construct($dbutil) {
        $this->dbutil = $dbutil;
        $this->parse_queries();

        // all columns are editable
        if(!isset($this->editable_fields)) {
            $this->editable_fields = array();
            $rows = $this->get_columns();
            foreach( $rows as $row ) {
                $col_name = $row['Field'];
                if( $col_name != 'created' && $col_name != 'updated') {
                    $this->editable_fields[] = $col_name;
                }
            }
        }

    }

    /**
     * Call update for specified $field with $value in a row specified by $id
     * @param <type> $field field
     * @param <type> $value new value
     * @param <type> $id row identification
     * @return <boolean> if field was updated successfully TODO
     */
    public function update($field, $value, $id) {
        if( in_array($field, $this->editable_fields)) {
            $query = $this->update_query;
            $type = $this->get_column_type($field);
            $values = array($field, $this->dbutil->escape($value, $type), $id);
            $query = $this->parse_query($query, $values);
            $this->dbutil->do_query($query);
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * replace :columns, :values tags with specified values
     * @param <string> $pre_query insert query
     * @param <array> $values columns and values both joined with ','
     * @return <string> $query
     */
    protected function parse_insert_query($pre_query, $values) {
        $tags = array(':columns', ':values');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    /**
     * Insert new record into db table
     * @param <array> $columns list of columns
     * @param <array> $values  list of values
     * @return <type> $row id
     */
    public function insert($columns, $values ) {
        $pre_query = $this->insert_query;
        $this->escape_values_before_insert($columns, $values);
        $cs = join(', ', $columns);
        $vs = "'" . join("', '", $values ) . "'";
        $query = $this->parse_insert_query($pre_query, array($cs, $vs));
//        echo "<pre>";
//        echo $query;
//        echo "</pre>";
        $res = $this->dbutil->do_query($query);
        return mysql_insert_id($this->dbutil->dbres);
    }

    private function escape_values_before_insert( $columns, $values ) {
        $col_length = count($columns);
        $val_length = count($values);
        $length = $val_length > $col_length ? $col_length : $val_length;

        // echo "delka je $length<br>";

        for( $i = 0; $i < $length; $i++ ) {
            $type = $this->get_column_type($columns[$i]);
            // echo "parsing " . $values[$i] . "<br>";
            $values[$i] = $this->dbutil->escape($values[$i], $type);
        }
    }

    /**
     * return all rows in a table
     * @return <array>  rows
     */
    public function find_all() {
        $query = $this->select_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     * Load one record with specified id
     * @param <type> $id
     * @return <array> row
     */
    public function find($id) {
        $query = $this->select_query . " where id = " . $id;
        $rows = $this->dbutil->process_query_assoc($query);
        $row = $rows[0];
        return $row;
    }

    /**
     * find rows with defined condition column = value
     * 
     * TODO add mysql_real_escape_string function
     * 
     * @param <type> $column
     * @param <type> $value
     * @return <type> 
     */
    public function find_by( $column, $value ) {
        $query = $this->select_query . " where $column = $value";
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     * generates new row with default values
     * @return <type> 
     */
    public function new_item_row() {
        return array(
        'id' => 'new'
        );
    }

    /**
     * return columns of model table
     * @return <type> 
     */
    public function get_columns() {
        return $this->dbutil->get_columns($this->table_name);
    }

    public function get_column_names() {
        $columns = $this->get_columns();
        $names = array();
        foreach( $columns as $col ) {
            $names[] = $col['Field'];
        }
        return $names;
    }

    /**
     * return db type of specified column
     * @param <type> $column
     * @return <type> 
     */
    public function get_column_type($column) {
        $rows = $this->get_columns();
        foreach( $rows as $row ) {
            if( $row['Field'] == $column) {
                return $row['Type'];
            }
        }
    }

    /**
     * generates row in a string
     * @param <type> $row
     * @return <type> 
     */
    public function get_row_label( $row ) {
        return $row['id'];
    }

    /**
     * delete row
     * @param <type> $id 
     */
    public function delete_row($id) {
        $pre_query = $this->delete_query . " where id = " . $id;
        $query = $this->parse_table_name($pre_query);
        $this->dbutil->do_query($query);
    }

    /**
     * delete all rows with specifield $field = $value
     * @param <type> $field
     * @param <type> $value 
     */
    public function delete_by($field, $value) {
        $pre_query = $this->delete_query . " where $field = " . $value;
        $query = $this->parse_table_name($pre_query);
        $this->dbutil->do_query($query);
    }
}
?>
