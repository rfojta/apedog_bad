<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Areaclass
 *
 * @author Richard
 */
class Area {
//put your code here
    protected $dbutil;
    protected $id;

    protected $area_query = 'select * from areas';
    protected $kpi_query = 'select * from kpis where area = ';

    protected $editable_fields;
    protected $update_query = 'update areas
        set :field = \':value\', updated = current_timestamp()
        where id = :id';

    function  __construct($dbres) {
        $this->dbutil = $dbres;
        //TODO add description, name
        $this->editable_fields = array('name', 'description');
    }

    function parse_query($pre_query, $values) {
        $tags = array(':field', ':value', ':id');
        $query = str_replace($tags, $values, $pre_query);
        return $query;
    }

    function update($field, $value, $id) {
        // TODO rewrite condition to test if is allowed
        if( in_array($field, $this->editable_fields)) {
            echo "... updating $field!<br>";
            $query = $this->update_query;
            $values = array($field, $value, $id);
            $query = $this->parse_query($query, $values);
            $this->dbutil->do_query($query);
        }
    }

    function get_list() {
        $query = $this->area_query;
        $rows = $this->dbutil->process_query_assoc($query);
        echo "<ul>";
        foreach( $rows as $row ) {
            echo "<li><a href=\"kpi_conf.php?id="
                . $row['id'] . "\">"
                . $row['name'] . "</a></li>";
        }
        echo "</ul>";
    }

    function edit_item($id) {
        $query = $this->area_query . " where id = " . $id;
        $rows = $this->dbutil->process_query_assoc($query);
        $row = $rows[0];

        foreach( $row as $key => $value) {
            echo "$key: <input name=\"$id-$key\" value=\"$value\"><br>";
        }
    }

    function get_form_content($request) {
        $id = $request[id];
        if(isset($id) ) {
            $this->edit_item($id);
        }
        echo "<br>";
        $this->get_list();
    }

    function submit($post) {
        foreach($post as $key => $value) {
        // $tokens = array();
            if( preg_match('/^(\d+)-(\w+)$/', $key, $tokens) ) {
                $this->set_values($tokens, $value);
            }
        }
    }

    function set_values($tokens, $value) {
        $this->update($tokens[2], $value, $tokens[1]);
    }
}
?>
