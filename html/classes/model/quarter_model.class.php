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
class QuarterModel extends GenericModel {

    protected $table_name = 'quarters';
    //put your code here

    public function new_item_row() {
        return array(
        'id' => 'new',
        'quarter_from' => '',
        'quarter_to' => '',
        'description' => '',
        'term' => ''
        );
    }

    public function get_row_label($row) {
        return $row['quarter_from'] . " - " . $row['quarter_to'];
    }
}
?>
