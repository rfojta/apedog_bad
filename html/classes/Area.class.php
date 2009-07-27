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
    protected $table_name = 'areas';

    protected $queries = array('select_query', 'update_query', 'insert_query');
    protected $select_query = 'select * from :table_name';
    protected $kpi_query = 'select * from kpis where area = ';

    protected $editable_fields;
    protected $update_query = 'update :table_name
        set :field = \':value\', updated = current_timestamp()
        where id = :id';

    protected $insert_query = 'insert into :table_name
        (:columns) values (:values)';

    function  __construct($dbutil) {
        $this->dbutil = $dbutil;
        //TODO add description, name
        $this->select_query = 'select * from ' . $this->table_name;
        $this->editable_fields = array('name', 'description');

        $this->parse_queries();
    }

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


    protected function update($field, $value, $id) {
    // TODO rewrite condition to test if is allowed
        if( in_array($field, $this->editable_fields)) {
            echo "... updating $field!<br>";
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

    protected function insert($columns, $values ) {
        $pre_query = $this->insert_query;
        $cs = join(', ', $columns);
        $vs = "'" . join("', '", $values) . "'";
        $query = $this->parse_insert_query($pre_query, array($cs, $vs));
        $this->dbutil->do_query($query);
    }

    protected function get_list() {
        $query = $this->select_query;
        $rows = $this->dbutil->process_query_assoc($query);
        echo "<ul>";
        foreach( $rows as $row ) {
            $this->get_list_item($row);
        }
        echo "</ul>";
    }

    protected function get_list_item($row) {
        echo "<li>";
        $this->get_list_item_content($row);
        echo "</li>";
    }

    protected function get_list_item_content($row) {
        echo "<a href=\"kpi_conf.php?id="
            . $row['id'] . "\">"
            . $row['name'] . " - " . $row[description]
            . "</li>";
    }

    public function get_list_box($id, $selected) {
        $query = $this->select_query;
        $rows = $this->dbutil->process_query_assoc($query);
        echo "<select name=\"$id-areas\">";
        foreach( $rows as $row ) {
            echo "<option value=\"" . $row['id'] . "\"";
            if( $row[id] == $selected ) {
                echo "selected=\"1\"";
            }
            echo ">";
            echo $row['name'] . " - " . $row[description]
                . "</option>";
        }
        echo "</ul>";
    }

    protected function edit_item($id) {
        if( $id == 'new') {
            $row = array(
                'id' => 'new',
                'name' => 'new',
                'description' => 'create new item'
            );
        } else {
            $query = $this->select_query . " where id = " . $id;
            $rows = $this->dbutil->process_query_assoc($query);
            $row = $rows[0];
        }

        foreach( $row as $key => $value) {
            $this->edit_item_row($id, $key, $value);
        }

        if( $id != 'new') {
            $this->kpi_list($id);
        }
    }

    protected function edit_item_row($id, $key, $value) {
        echo "$key: <input name=\"$id-$key\" ";
        if($key == 'id') {
            echo "type=\"hidden\" ";
        }
        echo "value=\"$value\"><br>\n";
    }

    protected function kpi_list($id) {
        echo "<hr>";
        echo "KPIs for this area:<br>";

        $query = $this->kpi_query . $id;
        $rows = $this->dbutil->process_query_assoc($query);

        echo "<ul>\n";
        foreach( $rows as $row ) {
            echo "<li>";
            echo $row[name] . " - ", $row[description];
            echo "</li>";
        }
        echo "</ul>\n";
    }

    protected function new_item_link() {
        $row = array( 'id' => 'new',
            'name' => 'new',
            'description' => 'create new item'
        );
        $this->get_list_item_content($row);
        echo "<br>";
    }

    public function get_form_content($request) {
        $id = $request[id];
        if(isset($id) ) {
            $this->edit_item($id);
        }
        echo "<br>";
        $this->new_item_link();
        $this->get_list();
    }

    public function submit($post) {
        foreach($post as $key => $value) {
        // $tokens = array();
            if( preg_match('/^(\w+)-(\w+)$/', $key, $tokens) ) {
                $this->set_values($tokens, $value);
            }
        }
    }

    protected function set_values($tokens, $value) {
        $this->update($tokens[2], $value, $tokens[1]);
    }
}
?>
