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
class GenericController {
//put your code here

    protected $model;
    protected $request;

    // for inserting purposes
    protected $insert_cache = array();

    function  __construct($model) {
        $this->model = $model;
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
    // TODO parametrize page_name
        $page_name = $_SERVER['PHP_SELF'];
        echo "<a href=\"$page_name?id="
            . $row['id'] . "\">"
            . $this->get_row_label($row)
            . "</a>";
    }

    public function get_label($id) {
        $row = $this->model->find($id);
        return $this->get_row_label($row);
    }

    protected function get_row_label( $row ) {
        return $row['name'] . " - " . $row[description];
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

    }

    protected function edit_item_row($id, $key, $value) {
        echo "$key: <input name=\"$id-$key\" ";
        if($key == 'id') {
            echo "type=\"hidden\" ";
        }
        if( isset($this->request[$key])) {
            echo "value=\"". $this->request[$key] . "\"> ($value)<br>\n";
        } else {
            echo "value=\"$value\"><br>\n";
        }
    }

    protected function new_item_link() {
        $row = $this->model->new_item_row();
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
        $this->request = $request;
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
