<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Areaclass
 *
 * @author Krystof
 */
class CsfController extends GenericController {
//put your code here
    protected $editable_fields = array('name', 'description', 'business_perspective');

    function  __construct($model, $business_perspectiveController, $kpi_model) {
        parent::__construct($model, array(
                'name' => 'csf',
                'desription' => 'Critical Success Factor',
                'parent' => array(
                    'controller' => $business_perspectiveController,
                    'name' => 'business_perspective',
                    'link' => 'admin.php?what=business_perspective'
                ),
                'child' => array(
                    'model' => $kpi_model,
                    'name' => 'kpi',
                    'link' => 'admin.php?what=kpi'
                )
        ));
    }

    protected function get_row_label( $row ) {
        return $row['name'];
    }


}
?>

