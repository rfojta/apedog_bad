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
class KpiUnitController extends GenericController {
//put your code here

    protected function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }

    function  __construct($model, $kpi_model) {

        $child_conf = array(
            'name' => 'kpi',
            'model' => $kpi_model,
            'link'  => 'admin.php?what=kpi'
        );

        $links_conf = array(
            'name' => 'kpi_unit',
            'child' =>  $child_conf
        );

        parent::__construct($model, $links_conf);
    }


}
?>
