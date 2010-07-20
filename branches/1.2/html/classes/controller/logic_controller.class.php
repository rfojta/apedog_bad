<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logic_controllerclass
 *
 * @author Richard
 */
class LogicController extends GenericController {

    public function  __construct($model) {

        $child_model = new KpiModel($model->get_dbutil());

        // $model = new LogicModel()
        parent::__construct($model, array(
            'name' => 'logic',
            'child' => array(
                'model' => $child_model,
                'name'  => $kpi,
                'link'  => 'admin.php?what=kpi'
            )
            )
        );
    }

//put your code here
}
?>
