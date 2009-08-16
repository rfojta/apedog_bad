<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpiclass
 *
 * @author Richard
 */
class KpiController extends GenericController {
//put your code here

    function  __construct($model, $area, $csf) {
        parent::__construct($model, array(
            'name' => 'kpi',
            'parent' => array(
                'area' => array(
                    'controller' => $area,
                    'name' => 'area',
                    'link' => 'admin.php?what=area'
                ),
                'csf' => array(
                    'controller' => $csf,
                    'name' => 'csf',
                    'description' => 'Critical Success Factor',
                    'link' => 'admin.php?what=csf'
                )
            )
        ));
    }

    function get_row_label( $row ) {
        return $this->model->get_row_label($row);
    }



}
?>
