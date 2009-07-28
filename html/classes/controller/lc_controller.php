<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_controller
 *
 * @author Richard
 */
class LcController extends GenericController {
//put your code here

    protected function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }

    public function get_list_box($id, $selected) {
        $rows = $this->model->find_all();
        echo "<select name=\"$id-lc\">";
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
}
?>
