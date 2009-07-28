<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_modelclass
 *
 * @author Richard
 */
class TermModel extends GenericModel {

    protected $table_name = 'terms';
    //put your code here

    protected $editable_fields = array('term_from', 'term_to', 'description');

    public function new_item_row() {
        return array(
        'id' => 'new',
        'term_from' => '',
        'term_to' => '',
        'description' => 'create new item'
        );
    }
}
?>
