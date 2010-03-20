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

    protected $editable_fields = array('term_from', 'term_to', 'description', 'number_of_term');



    function  __construct($model, $quarter_model) {
        parent::__construct($model,
            array(
               'name' => 'term',
               'child' => array(
                   'name' => 'quarter',
                   'model' => $quarter_model,
//                   'link'  => 'quarter_conf.php',
                   'link'  => 'admin.php?what=quarter'
               )
            ));
    }

 
}
?>
