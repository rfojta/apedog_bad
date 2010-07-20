<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logic_modelclass
 *
 * @author Richard
 */
class LogicModel extends GenericModel {
    protected $table_name = 'logic';

    public function get_row_label($row) {
        return $row['equals'];
    }

    //put your code here
}
?>
