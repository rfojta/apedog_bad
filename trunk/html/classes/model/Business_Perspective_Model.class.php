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
class Business_PerspectiveModel extends GenericModel {

    protected $table_name = 'business_perspectives';
    //put your code here

    protected $editable_fields = array('name', 'description');

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item'
        );
    }

    public function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }
}
?>
