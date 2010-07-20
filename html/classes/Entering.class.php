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

/**
 * Constructor
 * @param <type> $dbutil Library for working with db
 * @param <type> $term_id Id of actual term for the page
 * @param <type> $current_area area id for the page
 * @param <type> $user either user or 'all'
 * @param <type> $locking actual locking library
 */
    function  __construct($dbutil, $term_id, $current_area, $user, $locking) {
        parent::__construct($dbutil, $term_id, $current_area, $user, $locking);

        $this->page = 'entering_values.php?';
        $this->actual_values = new DetailTracking($dbutil, 1);
    }
/**
 * Builds kpi row with KPI name, description, input, kpi unit and plan from Kpi
 * @param <type> $kpi
 * @param <type> $i
 */
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
        echo "<td  width='60%'> \n";
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo "</td> \n";
        echo "<td> \n";
        $unit_spec = $this->get_kpi_unit_rf($kpi_id);
        $unit=$this->get_kpi_unit($kpi['kpi_unit']);
        if( $unit_spec == 'boolean') {
            $this->get_boolean_input($kpi_id, $actual);
        } else {
            echo "<input name=\"kpi-$kpi_id\"";
            if ($this->locking->get_count($this->lc_id, $this->quarter_id, 'NULL')) {
                echo ' disabled ';
            }
            echo "value=\"$actual\" />";
        }
        echo "<td style='background-color: #FFFFFF'>";
        echo $unit['name'];
        echo "</td>";
        echo "<td width='15%' align='left' style='background-color: #FFFFFF'> \n";
        echo "Goal: ";
        if( $unit_spec == 'boolean') {
            if($target==1) {
                echo 'Yes';
            } else if ($target=='0') {
                    echo 'No';
                }
        } else if ($target!='') {
                echo $target.' '.$unit['name'];
            }
        echo "</td> \n";
        echo "</tr> \n";
        echo "</li> \n";
    }
/**
 *Sets values into db
 * @param <type> $kpi
 * @param <type> $quarter
 * @param <type> $value
 */
    protected function set_values( $kpi,$quarter, $value ) {
        $this->actual_values->set_value(
            $this->lc_id,
            $quarter,
            $kpi[1],
            $value
        );
    }

/**
 * Returns submit button that could be disabled when entering is locked
 */
    function get_submit_button() {
        echo '<p>';
        echo '<input type="hidden" name="posted" value="1" />';
        echo '<input type=submit';
        $quarter_id;
        if ($this->quarter_id == null) {
            $quarter_id='NULL';
        } else {
            $quarter_id = $this->quarter_id;
        }
        if ($this->locking->get_count($this->lc_id, $quarter_id, 'NULL')!=0) {
            echo ' disabled';
        }
        echo ' value="Save" />';
        echo '</p>';
    }
    /**
     * Returns Locked echo when entering is locked
     */
    function get_locked_echo() {
        if ($this->locking->get_count($this->lc_id, $this->quarter_id, 'NULL')) {
            echo "<p><b>You can't enter values for this quarter as it has been locked by MC for you.</b></p>";
        }
    }

    /**
 * Builds dropdown yes/no input
 * @param <type> $id id of kpi
 * @param <type> $value selected/not selected
 */
    protected function get_boolean_input( $id, $value ) {
        echo "<select name=\"kpi-$id\" ";
        if ($this->locking->get_count($this->lc_id, $this->quarter_id, 'NULL')) {
                echo ' disabled ';
            }
        echo ">\n";
        echo "<option value=\"1\" ";
        if( $value == '1' ) {
            echo "selected=\"true\"";
        }
        echo ">Yes</option>\n";
        echo "<option value=\"0\"";
        if( $value != '1' ) {
            echo "selected=\"true\"";
        }
        echo ">No</option>\n";
        echo "</select>\n<br>\n";
    }
}
?>
