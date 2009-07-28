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
class TermController extends GenericController {
//put your code here

    protected function get_row_label( $row ) {
        return $row['term_from'] . " - " . $row['term_to'];
    }

    function  __construct($model, $quarter_model) {
        parent::__construct($model,
            array(
               'name' => 'term',
               'child' => array(
                   'name' => 'quarter',
                   'model' => $quarter_model,
                   'link'  => 'quarter_conf.php'
               )
            ));
    }

 
}
?>
