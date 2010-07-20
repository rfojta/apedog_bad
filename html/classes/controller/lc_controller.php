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
class LcController extends GenericController {
//put your code here

    protected function get_row_label( $row ) {
        return $row['name'] . " - " . $row['description'];
    }

    function  __construct($model, $user_model) {
        parent::__construct($model,
            array(
               'name' => 'lc',
               'child' => array(
                   'name' => 'user',
                   'model' => $user_model,
//                   'link'  => 'user_conf.php',
                   'link'  => 'admin.php?what=user'
               )
            ));
    }

 
}
?>
