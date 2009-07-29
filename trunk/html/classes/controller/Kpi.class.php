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

    function  __construct($model, $area) {
        parent::__construct($model, array(
                'name' => 'kpi',
                'parent' => array(
                    'controller' => $area,
                    'name' => 'area',
                    'link' => 'admin.php?what=area'
                )
            ));
    }

    function get_row_label( $row ) {
        return $this->model->get_row_label($row);
    }



}
?>
