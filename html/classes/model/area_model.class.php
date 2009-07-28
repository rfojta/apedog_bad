<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of area_modelclass
 *
 * @author Richard
 */
class AreaModel {
//put your code here
    protected $queries = array('select_query', 'update_query', 'insert_query');
    protected $select_query = 'select * from :table_name';


    protected $editable_fields;
    protected $update_query = 'update :table_name
        set :field = \':value\', updated = current_timestamp()
        where id = :id';

    protected $insert_query = 'insert into :table_name
        (:columns, created) values (:values, current_timestamp())';

    protected $dbutil;
    protected $id;
    protected $table_name = 'areas';

    private function parse_queries() {
        foreach( $this->queries as $q) {
            $this->$q = $this->parse_table_name($this->$q);
        }
    }

    private function parse_table_name( $query ) {
        return str_replace(':table_name', $this->table_name, $query );

    }

    protected function parse_query($pre_query, $values) {
        $tags = array(':field', ':value', ':id');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    function  __construct($dbutil) {
        $this->dbutil = $dbutil;
        //TODO add description, name
        $this->select_query = 'select * from ' . $this->table_name;
        $this->editable_fields = array('name', 'description');

        $this->parse_queries();
    }

    public function update($field, $value, $id) {
        if( in_array($field, $this->editable_fields)) {
            $query = $this->update_query;
            $values = array($field, $value, $id);
            $query = $this->parse_query($query, $values);
            $this->dbutil->do_query($query);
        }
    }

    protected function parse_insert_query($pre_query, $values) {
        $tags = array(':columns', ':values');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    public function insert($columns, $values ) {
        $pre_query = $this->insert_query;
        $cs = join(', ', $columns);
        $vs = "'" . join("', '", $values) . "'";
        $query = $this->parse_insert_query($pre_query, array($cs, $vs));
        $this->dbutil->do_query($query);
    }

    public function find_all() {
        $query = $this->select_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    public function find($id) {
        $query = $this->select_query . " where id = " . $id;
        $rows = $this->dbutil->process_query_assoc($query);
        $row = $rows[0];
        return $row;
    }

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item'
        );
    }

}
?>
