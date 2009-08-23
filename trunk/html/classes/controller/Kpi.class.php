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

    function  __construct($model, $area, $csf, $kpi_unit, $lckpi, $lc_model) {
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
                ),
                'kpi_unit' => array(
                    'controller' => $kpi_unit,
                    'name' => 'kpi_unit',
                    'description' => 'units',
                    'link' => 'admin.php?what=kpi_unit'
                )
            ),
            'multi' => array(
                'link_model' => $lckpi,
                'target' => 'lc',
                'models' => array(
                    'kpi' => $model,
                    'lc' => $lc_model
                )
            )
        ));
    }

    function get_row_label( $row ) {
        return $this->model->get_row_label($row);
    }



}
?>
