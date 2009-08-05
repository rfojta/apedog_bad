<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entering
 *
 * @author Richard
 */
class Entering extends DetailPlanning {
//put your code here

    protected $actaul_values;

    function  __construct($dbutil, $term_id, $current_area, $user ) {
        parent::__construct($dbutil, $term_id, $current_area, $user );

        $this->page = 'entering_values.php';
        $this->actual_values = new DetailTracking($dbutil, 1);
    }

    protected function get_kpi_input($kpi)  {
        $quarter_id = $this->quarter_id;
        $lc_id = $this->lc_id;
        $kpi_id = $kpi['id'];

        $actual = $this->actual_values->get_value(
            $lc_id, $quarter_id, $kpi_id
        );
        $target = $this->target_values->get_value(
            $lc_id, $quarter_id, $kpi_id
        );

        echo "<tr> \n";
        echo "<td> \n";
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo "</td> \n";
        echo "<td> \n";
        echo "<input name=\"kpi-$kpi_id\" value=\"$actual\" />";
        echo "</td> \n";
        echo "<td> \n";
        echo "Planned: ".$target;
        echo "</td> \n";
        echo "</tr> \n";
        echo "</li> \n";
    }
       
    protected function set_values( $kpi,$quarter, $value ) {
        $this->actual_values->set_value(
            $this->lc_id,
            $quarter,
            $kpi[1],
            $value
        );
    }
}
?>
