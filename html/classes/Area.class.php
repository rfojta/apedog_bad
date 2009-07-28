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

    protected $model;
    private $kpi_model;

    // for inserting purposes
    protected $insert_cache = array();
    
    function  __construct($model, $kpi_model) {
        $this->model = $model;
        $this->kpi_model = $kpi_model;
    }

    protected function clear_cache() {
        $this->insert_cache = array();
    }

    protected function flush() {
        if(count($this->insert_cache) > 0) {
            $columns = array_keys($this->insert_cache);
            $values = array_values($this->insert_cache);
            $this->model->insert($columns, $values);
            $this->clear_cache();
        }
    }

    protected function update($field, $value, $id) {
        if( $id == 'new') {
            $this->insert_cache[$field] = $value;
        }
        else {
            echo "... updating $field!<br>";
            $this->model->update($field, $value, $id);
        }
    }

    protected function get_list() {
        $rows = $this->model->find_all();
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
            . "</a>";
    }

    public function get_list_box($id, $selected) {
        $rows = $this->model->find_all();
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
            $row = $this->model->new_item_row();
        } else {
            $row = $this->model->find($id);
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

        $rows = $this->kpi_model->find_by_area($id);

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

    /**
     * Generates HTML form for areas
     * @param <type> $request http request data
     */
    public function get_form_content($request) {
        echo "<table width=\"100%\"><tr><td>";
        $this->new_item_link();
        $this->get_list();

        echo "</td><td>";
        $id = $request[id];
        if(isset($id) ) {
            $this->edit_item($id);
        }
        echo "</td></tr></table>";
    }

    /**
     * Handles page form submit
     * @param <type> $post HTTP POST data
     */
    public function submit($post) {

        $this->clear_cache();

        foreach($post as $key => $value) {
        // $tokens = array();
            if( preg_match('/^(\w+)-(\w+)$/', $key, $tokens) ) {
                $this->set_values($tokens, $value);
            }
        }

        $this->flush();
    }

    protected function set_values($tokens, $value) {
        $this->update($tokens[2], $value, $tokens[1]);
    }
}
?>
