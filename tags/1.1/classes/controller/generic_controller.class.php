<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenericController
 *
 * Latest changes: added multiple parent, view functionality moved to ViewController
 *
 * @author Richard
 */
class GenericController {
//put your code here

    protected $model;
    protected $view;
    protected $child_view;
    protected $parent_view;

    // Developer can define parent controller
    protected $parent_conf;

    // Developer can define child model
    protected $child_conf;
    protected $multi_conf; // other model with name

    // This entinty name
    protected $name;

    protected $request;

    // for inserting purposes
    protected $insert_cache = array();
    protected $multi_cache = array();

    /**
     *
     * @param <type> $model data model object for related data table
     * @param <type> $links further configuration of certain behaviour
     */
    function  __construct($model, $links = array()) {
        $this->model = $model;

        $this->parent_conf = $links['parent'];
        $this->child_conf = $links['child'];
        $this->multi_conf = $links['multi'];

        $this->name = $links['name'];

        $this->view = new ViewController($this->name, $this, null);
        $this->child_view = new ChildView($this->name, $this->child_conf, $this);

        // detect one or more parent
        if( isset( $this->parent_conf['name']) ) {
        // one parent
            $this->parent_view =
                new ParentView($name,
                $this->parent_conf, $this);
        }
        elseif( is_array( $this->parent_conf ) ) {
        // more parents
            $this->parent_view = array();
            $parent_conf = $this->parent_conf;
            // new style to set more than one parent
            foreach( $parent_conf as $name => $p_conf ) {
                $this->parent_view[$name] = new ParentView(
                    $name, $p_conf, $this);
            }
        }

        $this->multi_view = new multi_link_view(
            $this->multi_conf['link_model'],
            $this->multi_conf['models']
        );
    }

    public function add_parent( $name, $p_conf ) {
    // should be the same name as indexed by
        $p_conf['name'] = $name;
        if( is_array($this->parent_view) ) {
            $this->parent_view[$name] = new ParentView(
                $name, $p_conf, $this);
            $this->parent_conf[$name] = $p_conf;
        } else {
            $tmp_name = $this->parent_view->get_name();
            $this->parent_view = array(
                $tmp_name => $this->parent_view
            );
            $this->parent_conf = array(
                $tmp_name => $this->parent_conf
            );
            $this->add_parent($name, $p_conf); // should not cycle
        }
    }

    /**
     * model getter
     * @return <type>
     */
    public function get_model() {
        return $this->model;
    }

    /**
     * view setter
     * @param <type> $view
     */
    public function set_view( $view ) {
        $this->view = $view;
    }

    /**
     * reset object cache
     */
    protected function clear_cache() {
        $this->insert_cache = array();
        $this->multi_cache = array();
    }

    /**
     * Check whether controller cache is used and call insert into table.
     */
    protected function flush() {
        $id = null;
        if(count($this->insert_cache) > 0) {
            $columns = array_keys($this->insert_cache);
            $values = array_values($this->insert_cache);
            $id = $this->model->insert($columns, $values);
        }
        if( is_numeric($id) && count($this->multi_cache) > 0) {
            foreach( $this->multi_cache as $field => $value) {
                $this->update_multi($field, $value, $id);
            }
        }
        $this->clear_cache();
        return $id;
    }

    /**
     * Calls update into DB, when id is 'new', store value into cache
     * @param <type> $field table column
     * @param <type> $value value
     * @param <type> $id row id
     */
    protected function update($field, $value, $id) {
        if( $field == 'id') {
        // cannot update id
        }
        elseif( $id == 'new' ) {
            // We need to cache differently record field and fields with links to other table.
            if( $this->is_multi_field($field) ) {
                $this->multi_cache[$field] = $value; // this will be read and processed after we know record id.
            }
            else {
                $this->insert_cache[$field] = $value;
            }
        }
        elseif( $this->is_multi_field($field) ) {
            $this->update_multi($field, $value, $id);
        }
        elseif( $this->model->update($field, $value, $id) ) {
            echo "... updated $field!<br>";
        }
        else {
        // field is not editable
        }
    }

    /**
     * Specific for update of multi_field
     * @param <type> $field
     * @param <type> $value
     * @param <type> $id
     */
    protected function update_multi($field, $value, $id) {
        $link_model = $this->multi_conf['link_model'];
        $target = $this->multi_conf['target'];

        $this->delete_multi($id);

        // create new
        if( is_array($value) ) {
            foreach( $value as $v ) {
                $columns = array( $this->name, $target );
                $values = array( $id, $v );
                $link_model->insert($columns, $values);
            }
        }
        else {
            $columns = array( $this->name, $target );
            $values = array( $id, $value );
            $link_model->insert($columns, $values);
        }
    }

    /**
     *
     * @param <type> $id
     */
    protected function delete_multi($id) {
        $link_model = $this->multi_conf['link_model'];
        $target = $this->multi_conf['target'];

        // delete old links
        $link_model->delete_by( $this->name, $id );
    }

    /**
     * display html input with loaded value
     * @param $id of deleted item
     */
    public function delete_item($id) {
        $this->model->delete_row($id);
    }


    /**
     * Handles page form submit
     * @param <type> $post HTTP POST data
     */
    public function submit($post) {

    //        echo "<pre>";
    //        print_r ( $post );
    //        echo "</pre>";

        $this->clear_cache();
        if( $this->has_multi() ) {

        }

        foreach($post as $key => $value) {
        // $tokens = array();
        // parsing id-field
            if( preg_match('/^(\w+)-(\w+)$/', $key, $tokens) ) {
                $this->set_values($tokens, $value);
            }
        }

        $id = $this->flush();
        if( $this->has_multi() ) {
        // convert new to $ID
        }
    }

    /**
     * Calls update with proper parameters
     * @param <type> $tokens parsed input name
     * @param <type> $value
     */
    protected function set_values($tokens, $value) {
        $this->update($tokens[2], $value, $tokens[1]);
    }

    /**
     * View<br>
     * Generates select tag with option according to this type
     * @param <type> $id source object id
     * @param <type> $selected current target object id
     */
    public function get_list_box($id, $selected, $name = null) {
        $rows = $this->model->find_all();
        if( $name == null) {
            $name = $this->name;
        }
        echo "<select name=\"$id-$name\">";
        echo "<option value=\"" . $row['id'] . "\"";
        if( $row[id] == $selected ) {
            echo "selected=\"1\"";
        }
        echo ">";
        echo "NULL</option>\n";
        foreach( $rows as $row ) {
            echo "<option value=\"" . $row['id'] . "\"";
            if( $row[id] == $selected ) {
                echo "selected=\"1\"";
            }
            echo ">";
            echo $this->model->get_row_label($row)
                . "</option>\n";
        }
        echo "</select>\n";
    }

    /**
     * detect if another table references this model
     * @return <type>
     */
    public function has_child() {
        return isset( $this->child_conf);
    }

    /**
     * generate html list using child_view
     * @param <type> $id
     */
    public function child_list($id) {
        if( is_numeric($id)) {
            $this->child_view->child_list($id);
        }
    }


    /**
     * Proxy method for view
     * @param <type> $request
     */
    public function get_form_content($request) {
        $this->view->get_form_content($request);
    }


    /**
     * View<br>
     * Retrieve rows from table
     * @param <type> $id
     * @return array of db rows
     */
    public function child_rows($id) {
        $name = $this->name;
        $model = $this->child_conf['model'];
        $rows = $model->find_by($name, $id);
        return $rows;
    }

    /**
     * detect whether column with name referenced another table
     * @param <type> $name column definition
     * @return <boolean> true or false
     */
    public function is_parent( $name ) {
        if( ! is_array($this->parent_conf)) {
            return false;
        }
        if( array_key_exists('name', $this->parent_conf) ) {
            return $name == $this->parent_conf['name'] ;
        }
        elseif( isset( $this->parent_conf[$name])) {
            return true;
        }
        return false;
    }

    /**
     * generates html for specified $key, using parent_view
     * @param <type> $key
     * @param <type> $id
     * @param <type> $selected
     */
    public function parent_list($key, $id, $selected) {
        if( is_array( $this->parent_view )) {
            $this->parent_view[$key]->parent_list($key, $id, $selected);
        } else {
            $this->parent_view->parent_list($key, $id, $selected);
        }
    }

    /**
     * wrapper for view get_label function for specified row
     * @param <type> $id
     */
    public function get_label($id) {
        $this->view->get_label($id );
    }

    /**
     * detects whether there is table m to n with other object
     * @param <type> $name
     * @return <type>
     */
    public function has_multi() {
        return isset( $this->multi_conf);
    }

    /**
     * Show <select multiple> for related db table
     * @param <type> $id
     */
    public function multi_list($id) {
        if( is_numeric( $id ) || $id == 'new' ) {
            $this->multi_view->get_select_multi_for($id, $this->name, 0);
        }
    }

    /**
     * check if specified field is related in multi_link table
     * @param <type> $field
     * @return <boolean>
     */
    protected function is_multi_field( $field ) {
        if( $this->has_multi() ) {
            return $this->multi_conf['target'] == $field;
        }
        return false;
    }


}
?>
