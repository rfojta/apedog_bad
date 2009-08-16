<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenericViewController
 * 
 * due to Increasing count of methods of generating html
 * I've decided to move all this methods to separate class
 * according to desing pattern MVC
 *
 * @author Richard
 */
class ViewController {

    protected $controller;
    protected $name;
    protected $model;
    protected $request;


    /**
     *
     * @param <type> $name view name
     * @param <type> $controller embedded controller for handling submit_form
     */
    function  __construct($name, $controller, $request) {
        $this->controller = $controller;
	$this->request = $request;
	$this->model = $controller->get_model();
        $this->name = $name;
    }



    /**
     * Generates html list of objects stored in model
     *
     * @param <number> $selected id of selected item for highlighting
     */
    protected function get_list($selected) {
        $rows = $this->model->find_all();
        echo "<ul>";
        foreach( $rows as $row ) {
            $this->get_list_item($row, $selected);
        }
        echo "</ul>";
    }

    /**
     * Generates html for one item in the list
     * @param <type> $row
     */
    protected function get_list_item($row, $selected) {
        echo "<li ";
        if( $row['id'] == $selected ) {
            echo 'class="selected"';
        }
        echo ">";
        $this->get_list_item_content($row);
        echo "</li>";
    }

    /**
     * Generate inner html of one item
     * @param <type> $row
     */
    protected function get_list_item_content($row) {
        $page_name = $_SERVER['PHP_SELF'];
        echo "<a href=\"$page_name?id="
            . $row['id'] . "\">"
            . $this->get_row_label($row)
            . "</a>";
    }

    /**
     * Return label for specified row
     * @param <type> $id row id
     * @return <type>
     */
    public function get_label($id) {
        $row = $this->model->find($id);
        return $this->get_row_label($row);
    }

    /**
     * Convert $row into single string
     * @param <type> $row
     * @return <type> string
     */
    protected function get_row_label( $row ) {
        return $this->model->get_row_label( $row );
    }

    /**
     * Generates edit form for specified item and load values from db model
     * @param <type> $id row id
     */
    protected function edit_item($id) {
        if( $id == 'new') {
            $row = $this->model->new_item_row();
        } else {
            $row = $this->model->find($id);
        }

        foreach( $row as $key => $value) {
            $this->edit_item_row($id, $key, $value);
        }

        $this->get_delete_checkbox($name);

        if( $id != 'new' && $this->controller->has_child() )  {
            $this->controller->child_list($id);
        }

    }

    /**
     * display html input with loaded value
     * @param <type> $id row id
     * @param <type> $key table column
     * @param <type> $value value
     */
    protected function edit_item_row($id, $key, $value) {
	    # todo parents should be asociative array
	    # with names as keys
       
        $type = $this->model->get_column_type($key);
        // $value = $this->request[$key];

        if( $this->controller->is_parent( $key ) ) {
            $this->controller->parent_list($key, $id, $value);
        } 
        elseif( strtolower( substr($type, 0, 6) ) == 'int(1)') {
            echo "$key: <select name=\"$id-$key\" >\n";
            echo "<option value=\"1\" ";
            if( $value != 0 ) {
                echo "selected=\"true\"";
            }
            echo ">Ano</option>\n";
            echo "<option value=\"0\"";
            if( $value == 0 ) {
                echo "selected=\"true\"";
            }
            echo ">Ne</option>\n";
            echo "</select>\n($value)<br>\n";
        }
        else {
            echo "$key: <input name=\"$id-$key\" ";
            if($key == 'id') {
                echo "type=\"hidden\" ";
            }
            echo 'class="'.$type.'"';
            if( isset($this->request[$key])) {
                echo "value=\"". $this->request[$key] . "\"> ($value)<br>\n";
            } else {
                echo "value=\"$value\"><br>\n";
            }
        }
    }

    /**
     * Display link to create new item in db table
     */
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

        $id = $request[id];
        $delete = $request[delete];
        if( $delete=='yes' && $id!='new' ) {
            $this->controller->delete_item($id);
        }

        $this->new_item_link();
        $this->get_list($id);

        echo "</td><td>";

        $this->request = $request;
        if(isset($id) && $delete!='yes' ) {
            $this->edit_item($id);
        }
        echo "</td></tr></table>";
        $this->get_submit_button();
    }

    /**
     * Handles page form submit
     * @param <type> $post HTTP POST data
     */
    public function submit($post) {
	    $this->controller->submit($post);
    }

    /**
     * Generates select tag with option according to this type
     * @param <type> $id source object id
     * @param <type> $selected current target object id
     */
    public function get_list_box($id, $selected) {
        $rows = $this->model->find_all();
        $name = $this->name;
         echo "<select name=\"$id-$name\">";
         echo "<option value=\"" . $row['id'] . "\"";
            if( $row[id] == $selected ) {
                echo "selected=\"1\"";
            }
            echo ">";
         echo "NULL</option>";
        foreach( $rows as $row ) {
            echo "<option value=\"" . $row['id'] . "\"";
            if( $row[id] == $selected ) {
                echo "selected=\"1\"";
            }
            echo ">";
            echo $this->get_row_label($row)
                . "</option>";
        }
        echo "</select>";
    }

    /**
     * generate checkbox for deleting record
     */
    protected function get_delete_checkbox() {
        echo "<br><input type='checkbox' name='delete' value='yes'/>";
        echo "<b>Permanently delete this ".$this->name." and all related history</b>";
    }

    /**
     * generate submit button and hidden input
     */
    function get_submit_button(){
        echo '<p>';
        echo '<input type="hidden" name="posted" value="1" />';
        echo '<input type=submit';
        echo ' value="Save" />';
        echo '</p>';
    }
}
?>
