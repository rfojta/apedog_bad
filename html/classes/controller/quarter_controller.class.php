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
class QuarterController extends GenericController {
//put your code here
    protected $editable_fields = array('quarter_from', 'quarter_to', 'description', 'term');

    function  __construct($model, $term_controller) {
        parent::__construct($model, array(
                'name' => 'quarter',
                'parent' => array(
                    'controller' => $term_controller,
                    'name' => 'term',
                    'link' => 'admin.php?what=term'
                )));
    }

    protected function get_row_label( $row ) {
        return $row['quarter_from'] . " - " . $row['quarter_to'];
    }


}
?>
