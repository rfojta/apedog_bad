<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of graphs_modelclass
 *
 * @author Richard
 */
class GraphModel extends GenericModel {

    protected $table_name = 'graphs';
    //put your code here

    public function get_row_label($row) {
        return $row['name'];
    }
}
?>
