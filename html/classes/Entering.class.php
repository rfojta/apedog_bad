<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entering
 *
 * @author Richard, Krystof
 */
class Entering extends DetailPlanning {
//put your code here

    protected $actaul_values;

    function  __construct($dbutil, $term_id, $current_area, $user, $locking) {
        parent::__construct($dbutil, $term_id, $current_area, $user, $locking);

        $this->page = 'entering_values.php?';
        $this->actual_values = new DetailTracking($dbutil, 1);
    }

    protected function get_kpi_input($kpi, $i) {
        $quarter_id = $this->quarter_id;
        $lc_id = $this->lc_id;
        $kpi_id = $kpi['id'];
        if ($quarter_id!=null) {
            $actual = $this->actual_values->get_value(
                $lc_id, $quarter_id, $kpi_id
            );
            $target = $this->target_values->get_value(
                $lc_id, $quarter_id, $kpi_id
            );
        };

        echo "<tr class='kpiRow".$i."'> \n";
        echo "<td> \n";
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo "</td> \n";
        echo "<td> \n";
        echo "<input name=\"kpi-$kpi_id\"";
        if ($quarter_id!=null) {
            if ($this->locking->get_count($lc_id, $quarter_id, 'NULL')!=0) {
                echo ' disabled ';
            }
        }
        echo "value=\"$actual\" />";
        echo "</td> \n";
        echo "<td> \n";
        echo "Goal: ".$target;
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

    function get_submit_button(){
        echo '<p>';
        echo '<input type="hidden" name="posted" value="1" />';
        echo '<input type=submit';
        $quarter_id;
        if ($this->quarter_id == null){
            $quarter_id='NULL';
        } else {
            $quarter_id = $this->quarter_id;
        }
        if ($this->locking->get_count($this->lc_id, $quarter_id, 'NULL')!=0){
            echo ' disabled';
        }
        echo ' value="Save" />';
        echo '</p>';
    }
}
?>
