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
class Business_PerspectiveController extends GenericController {
//put your code here
    protected $editable_fields = array('name', 'description');

    function  __construct($model, $csf_model) {
        parent::__construct($model,
            array(
            'name' => 'business_perspective',
            'description' => 'description',
            'child' => array(
            'name' => 'csf',
            'description' => 'Critical success factor',
            'model' => $csf_model,
            //                   'link'  => 'quarter_conf.php',
            'link'  => 'admin.php?what=csf'
            )
        ));
    }

    protected function get_row_label( $row ) {
        if ($row['name']!=null) {
            return $row['name'];
        }
    }


}
?>
