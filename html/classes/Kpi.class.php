<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpiclass
 *
 * @author Richard
 */
class Kpi extends Area {
    //put your code here
    protected $table_name = 'kpis';

    public function test_queries() {
       $qs = $this->queries;
       foreach( $qs as $q ) {
           echo $this->$q . "<br>";
       }
    }

    private function area_list($id, $selected) {
        $a = new Area($this->dbutil);
        $a->get_list_box($id, $selected);
    }

    protected function kpi_list() {
        
    }

    protected function edit_item_row($id, $key, $value) {
        if( $key == 'area') {
            area_list($id, $value);
        } else {
            parent::edit_item_row($id, $key, $value);
        }
    }

}
?>
