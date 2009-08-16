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
class AreaModel extends GenericModel {
//put your code here

    protected $table_name = 'areas';
    protected $editable_fields = array('name', 'description');

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item'
        );
    }

    public function get_row_label( $row  ) {
        return $row['name'] . " - " . $row['description'];
    }

}
?>
