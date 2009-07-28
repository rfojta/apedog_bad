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
class KpiController extends GenericController {
//put your code here
    protected $table_name = 'kpis';
    protected $area;
    protected $area_link = 'area_conf.php';

    function  __construct($model, $area) {
        parent::__construct($model);
        $this->area = $area;
    }

    private function area_list($id, $selected) {
        $a = $this->area;
        echo "<span title=\"select superior area for this KPI\">Area: </span>";
        if( isset( $this->request['area']) ) {
            $a->get_list_box($id, $this->request['area']);
     
        } else {
            $a->get_list_box($id, $selected);
        }
        if( $selected > 0 ) {
            $link = $this->area_link;
            echo "(<a href=\"$link?id=$selected\">". $a->get_label($selected) ."</a>)";
        }
    }

    protected function edit_item_row($id, $key, $value) {
        if( $key == 'area') {
            $this->area_list($id, $value);
        } else {
            parent::edit_item_row($id, $key, $value);
        }
    }

}
?>
