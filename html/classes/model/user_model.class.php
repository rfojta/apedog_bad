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
class UserModel extends GenericModel {

    protected $table_name = 'users';
    //put your code here

    protected $lc_query = 'select * from users where lc = ';

    public function find_by_lc( $lc ) {
        $query = $this->lc_query . $area;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item',
        'area' => ''
        );
    }

    public function get_row_label($row) {
        return $row['login'];
    }
}
?>
