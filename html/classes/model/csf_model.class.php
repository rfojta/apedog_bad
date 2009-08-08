<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_modelclass
 *
 * @author Krystof
 */
class CsfModel extends GenericModel {

    protected $table_name = 'csfs';
    //put your code here

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'critical success factor',
        'business_perspective' => ''
        );
    }

    public function get_row_label($row) {
        if ($row['name']!=null) {
            return $row['name'] . " - " . $row['description'];
        }
    }
}
?>
