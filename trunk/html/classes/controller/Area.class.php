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
class AreaController extends GenericController {
//put your code here



    function  __construct($model, $kpi_model) {
        parent::__construct($model, array(
                'name' => 'area',
                'child' => array(
                    'model' => $kpi_model,
                    'name' => 'kpi',
                  //  'link' => 'kpi_conf.php',
                    'link' => 'admin.php?what=kpi'
                )));
    }

    protected function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }


}
?>
