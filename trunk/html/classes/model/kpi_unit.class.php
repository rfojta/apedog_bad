<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_unitclass
 *
 * @author Richard
 */
class KpiUnitModel extends GenericModel {
//put your code here
    protected $table_name = 'kpi_units';

// protected $editable_fields = array('name', 'description');

    public function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
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
