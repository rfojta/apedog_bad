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
class KpiModel extends AreaModel {

    protected $table_name = 'kpis';
    //put your code here

    protected $kpi_query = 'select * from kpis where area = ';

    public function find_by_area( $area ) {
        $query = $this->kpi_query . $area;
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
}
?>
