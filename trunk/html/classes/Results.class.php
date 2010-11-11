<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reports-Results
 *
 * @author Krystof
 */
class Results {

    protected $dbutil;
    protected $term_id;
    protected $quarter_id;
    protected $quarter_in_term;
    protected $lc_id;
    protected $this_page;
    protected $target_values;
    protected $actual_values;
    protected $locking;
    protected $user;
    protected $eot;
 //end of a term
    protected $help;    

    protected $custom;
 //include custom KPIs
    protected $area_id;
    protected $area_query = 'select * from areas';
    protected $quarter_query = 'select * from quarters';
    protected $kpi_query = 'select distinct k.* from lc_kpi l join kpis k on l.kpi = k.id';
    protected $term_query = 'select * from terms';
    protected $business_perspective_query = 'select * from business_perspectives';
    protected $csf_query = 'select * from csfs where business_perspective ';
    protected $lc_query = 'select * from lcs';
    protected $end_of_term_query = 'select * from logic WHERE `id` = ';
    protected $kpi_unit_query = 'select * from kpi_units';

    function __construct($dbutil, $term_id, $user, $quarter_in_term, $eot, $custom, $area_id) {
        $this->dbutil = $dbutil;


        $this->page = 'reports.php?results';
        $this->user = $user;
        $this->term_id = $term_id;
        $this->quarter_in_term = $quarter_in_term;
        $this->eot = $eot;
        $this->custom = $custom;
        $this->area_id = $area_id;

        $lc = new LC($dbutil->dbres);
        $this->lc_id = $lc->get_lc_by_name($user);
        $this->target_values = new DetailTracking($dbutil);
        $this->actual_values = new DetailTracking($dbutil, 1);

        $this->help = "<h3>BSC Results</h3><p>You can see output of all your
        Business Perspectives here.<p>You can choose term and quarter.
        Check your values at the end of term! Check your LC's custom KPIs!</p><p>You can see graphs by clicking on KPI.</p>
        <p>For more info about KPI, CSF or BP roll over it with mouse.</p>";
    }

    function get_area_list() {
        $query = $this->area_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        $business_perspectives_list = $this->get_bp_list();
        echo "<p>";
        if ($_SESSION['user'] == 'MC') {
            $lc_list = $this->get_lc_list();
            $this->get_lc_section($lc_list);
        }
        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);
        $this->get_eot_checkbox();
        echo "</p>";
        echo "<p>";
        if ($this->custom == 'true') {
            $this->get_area_section($this->get_area_list());
        }
        $this->get_custom_checkbox();
        if(isset ($_REQUEST['lc_id'])){
            $lc =  $_REQUEST['lc_id'];
        } else {
            $lc=$this->lc_id;
        }
        echo "&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
        //echo "<a href='xlswriter.php?l=".$lc."' target='_blank'>Export to XLS</a>";
echo '<INPUT TYPE="BUTTON" VALUE="Export to XLS" ONCLICK="window.open(\'xlswriter.php?l='.$lc.'\')">';
        echo "</p>";

        echo '<p>';
        echo "<table width=100%><tr><td width='50%' valign=top>";
        $i = 0;
        foreach ($business_perspectives_list as $bp) {

            echo "<table cellspacing='0' cellpadding='3' class='bpTable' width=100%>";
            $this->get_output($bp);
            echo "</table>";

            if (( $i % 2 ) == 0) {
                echo "</td>\n<td valign=top>";
            } else {
                echo "</td></tr>\n<tr><td width='50%' valign=top>";
            }
            $i++;
        }
        echo "</table>";
    }

    function submit($post) {
        $quarter;
        $rec;
        $kpi = array();
        foreach ($post as $key => $value) {
            // $tokens = array();
            if ($key == 'quarter_id') {
                $quarter = $value;
            }

            if (preg_match('/^kpi-(\d+)$/', $key, $tokens)) {

                if ($value > 0 && $quarter != null) {
                    $kpi = $tokens;
                    $this->set_values($kpi, $quarter, $value);
                }
            }
        }
    }

    function get_term_list() {
        $query = $this->term_query . ' ORDER BY `term_from`';
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_quarter_list($term_id) {
        if ($term_id == null) {
            $query = $this->quarter_query . ' ORDER BY `id`';
        } else {
            $query = $this->quarter_query . ' where term = ' . $term_id . ' ORDER BY `quarter_from`';
        }
        $rows = $this->dbutil->process_query_assoc($query);
        //        $this->quarter_id=$rows[0]['id'];
        return $rows;
    }

    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page . "&lc_id=" . $this->lc_id .
        "&area_id=" . $this->area_id . "&quarter_in_term=" . $this->quarter_in_term . "&custom=" . $this->custom .
        "&eot=" . $this->eot . "&term_id='+this.value\">\n";

        foreach ($term_list as $term) {
            echo "<option value=\"" . $term['id'] . "\"";
            if (isset($_REQUEST['term_id'])) {
                if ($term['id'] == $_REQUEST['term_id']) {
                    $this->term_id = $term['id'];
                    echo " selected ";
                }
            } else if ($term['id'] == $this->term_id) {
                echo " selected";
            }

            echo ">";
            echo date('Y', strtotime($term['term_from'])) . '/' . date('Y', strtotime($term['term_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_quarter_section($quarter_list) {
        echo "Select quarter: \n";
        echo "<select name=\"quarter_id\" id=\"quarter_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page .
        "&lc_id=" . $this->lc_id . "&area_id=" . $this->area_id . "&term_id="
        . $this->term_id . "&custom=" . $this->custom .
        "&quarter_in_term='+this.value\">\n";

        foreach ($quarter_list as $quarter) {
            echo "<option value=\"" . $quarter['quarter_in_term'] . "\"";
            if (isset($_REQUEST['quarter_in_term'])) {
                if ($quarter['quarter_in_term'] == $_REQUEST['quarter_in_term']) {
                    $this->quarter_id = $quarter['id'];
                    $this->quarter_in_term = $quarter['quarter_in_term'];
                    echo " selected ";
                }
            } else if ($quarter['quarter_in_term'] == $this->quarter_in_term) {
                $this->quarter_id = $quarter['id'];
                echo " selected ";
            }

            echo ">";
            echo date('j.n.Y', strtotime($quarter['quarter_from'])) . '-' . date('j.n.Y', strtotime($quarter['quarter_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_bp_list() {
        $query = $this->business_perspective_query . ' ORDER BY `id`';
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_output($bp) {
        $csf_list = $this->get_csf_list($bp['id']);
        $kpi_list = array();
        foreach ($csf_list as $csf) {
            $temp = $this->get_kpi_by_csf_list($csf['id']);
            $kpi_list = array_merge($kpi_list, $temp);
        }
        $rate = round($this->get_rate($kpi_list) * 100);
        if ($rate > 100) {
            $rate = 100;
        }
        $gom = new GoogleOMeter('50x24', $rate, null, null);
        echo '<tr class="bpTableRow">';
        echo '<th width="48%">';
        echo '<big>';
        echo '<span title="' . $bp['description'] . '">'
        . $bp['name'] . ':</span>';
        echo '</big>';
        echo '</th>';
        echo '<th colspan="4" align="right">';
        echo $gom->draw_chart();
        echo '</th>';
        echo '</tr>';
        echo '<tr class="headTableRow">';
        echo '<td>';
        echo '</td>';
        echo '<td class="current">';
        echo 'Current';
        echo '</td>';
        echo '<td class="goal">';
        echo 'Goal';
        echo '</td>';
        echo '<td class="status">';
        echo 'Status';
        echo '</td>';
        echo '<td class="trend">';
        echo 'Trend';
        echo '</td>';
        echo '</tr>' . "\n";

        foreach ($csf_list as $csf) {
            $this->get_csf_section($csf);
        }
    }

    function get_csf_list($bp_id) {
        if ($bp_id == null) {
            $query = $this->csf_query . '= 0';
        } else {
            $query = $this->csf_query . '=' . $bp_id;
        }
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_kpi_by_csf_list($csf_id) {
        if ($csf_id == null) {
            $query = $this->kpi_query . ' WHERE k.csf = 0';
        } else {
            $query = $this->kpi_query . ' WHERE k.csf =' . $csf_id;
        }

        if ($this->lc_id != 'all') {
            $query.=' and l.lc = ' . $this->lc_id;
        }

        if ($this->custom != 'true') {
            $query.=' and k.in_bsc = 1';
        }

        $query.=' order by `id`';

        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_csf_section($csf) {
        $kpi_list = $this->get_kpi_by_csf_list($csf['id']);
        $csf_name = $csf['name'];
        $rate = $this->get_rate($kpi_list);

        echo '<tr class="csfTableRow">';
        echo '<td>';
        echo '<span title="' . $csf['description'] . '">'
            .'<a href="view.php?csfs=' . $csf['id'] . '">'
            . $csf['name'] . '</a>:</span>';
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '<td class="csfStatus">';
        echo $this->get_status($rate);
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '</tr>';

        foreach ($kpi_list as $kpi) {
            $this->get_kpi_section($kpi);
        }
    }

    function get_kpi_section($kpi) {
        if ($this->area_id == $kpi['area'] || $this->area_id == 'all' || $this->area_id == null) {

            $actual = $this->get_actual($this->lc_id, $this->quarter_id, $this->term_id, $kpi);

            $target = $this->get_target($this->lc_id, $this->quarter_id, $this->term_id, $kpi);


            $rate = $this->get_rate(array($kpi));

            $past_values = $this->get_year_ago($kpi);
            $unit = $this->get_kpi_unit($kpi['kpi_unit']);
            echo '<tr class="kpi1TableRow">';
            echo '<td class="kpiName">';
            echo '<small>';
            echo '<a href="reports.php?graphs&kpi_id=' . $kpi['id'] . '&lc_id=' . $this->lc_id .
            '&eot=' . $this->eot . '" title="' . $kpi['description'] . '">' . $kpi['name'] . ':</a>';
            echo '</small>';
            echo '</td>';
            echo '<td class="currentValue">';
            if ($actual != null || $actual == '0') {
                if ($unit['spec'] == 'boolean') {
                    if ($actual == '1') {
                        echo 'Yes';
                    } else if ($actual == '0') {
                        echo 'No';
                    } else if ($actual == '-') {
                        echo '-';
                    }
                } else if ($actual != '-' || $actual == '0') {
                    echo round($actual, 2) . ' ' . $unit['name'];
                } else if ($actual == '-') {
                    echo '-';
                }
            }
            echo '</td>';
            echo '<td class="goalValue">';
            if ($target != null || $target == '0') {
                if ($unit['spec'] == 'boolean') {
                    if ($target == '1') {
                        echo 'Yes';
                    } else if ($target == '0') {
                        echo 'No';
                    } else if ($target == '-') {
                        echo '-';
                    }
                } else if ($target != '-' || $target == '0') {
                    echo round($target, 2) . ' ' . $unit['name'];
                } else if ($target == '-') {
                    echo '-';
                }
            }

            echo '</td>';
            echo '<td class="kpiStatus">';
            echo $this->get_status($rate);
            echo '</td>';
            echo '<td class="kpiTrend">';
            echo $this->get_trend($actual, $past_values);
            echo '</td>';
            echo '</tr>';
        }
    }

    function get_status($rate) {
        if ($rate == '0' || $rate != null) {
            if ($rate < '0.85') {
                echo "<img src='images/common/red_status.png'>";
            } else if ($rate < '1') {
                echo "<img src='images/common/orange_status.png'>";
            } else {
                echo "<img src='images/common/green_status.png'>";
            }
        }
    }

    function get_rate($kpi_list) {

        foreach ($kpi_list as $kpi) {

            $actual = $this->get_actual($this->lc_id, $this->quarter_id, $this->term_id, $kpi);
            $target = $this->get_target($this->lc_id, $this->quarter_id, $this->term_id, $kpi);

            if ($target != null && $target != '-' && $actual != '-') {
                if ($target > 0) {
                    $rates[] = $actual / $target;
                } else if ($target < 0) {
                    $rates[] = -$actual / $target + 2;
                } else if ($target == 0) {
                    if ($actual >= 0) {
                        $rates[] = 1;
                    } else {
                        $rates[] = 0;
                    }
                }
            }
        }

        if ($rates != null) {
            $rate = array_sum($rates) / count($rates);
        }
        return $rate;
    }

    function get_actual($lc_id, $quarter_id, $term_id, $kpi) {
        if ($quarter_id != null && $kpi != null) {
            if ($this->eot == 'true') {
                $quarter_list = $this->get_quarter_list($term_id);
                $actual;
                if ($lc_id == 'all' && $this->user = 'MC') {
                    $lc_list = $this->get_lc_list();
                    $actualz = array();
                    foreach ($lc_list as $lc) {
                        $actuals = array();
                        foreach ($quarter_list as $quarter) {
                            $actuals[] = $this->actual_values->get_value($lc['id'], $quarter['id'], $kpi['id']);
                        }
                        $sumLogic = new SumLogic($actuals, $kpi['end_of_term']);
                        $actualz[] = $sumLogic->get_sum();
                    }
                    $sumLogic = new SumLogic($actualz, $kpi['all_lcs']);
                    $actual = $sumLogic->get_sum();
                } else {
                    foreach ($quarter_list as $quarter) {
                        $a = $this->actual_values->get_value($lc_id, $quarter['id'], $kpi['id']);
                        $actuals[] = $a;
                    }
                    $sumLogic = new SumLogic($actuals, $kpi['end_of_term']);
                    $actual = $sumLogic->get_sum();
                }
            } else if ($lc_id == 'all' && $this->user = 'MC') {
                $actuals = array();
                $lc_list = $this->get_lc_list();
                foreach ($lc_list as $lc) {
                    $actuals[] = $this->actual_values->get_value(
                                    $lc['id'], $quarter_id, $kpi['id']);
                }
                $sumLogic = new SumLogic($actuals, $kpi['all_lcs']);
                $actual = $sumLogic->get_sum();
            } else {
                $actual = $this->actual_values->get_value(
                                $lc_id, $quarter_id, $kpi['id']
                );
            }
        }
        return $actual;
    }

    function get_target($lc_id, $quarter_id, $term_id, $kpi) {
        if ($quarter_id != null && $kpi != null) {
            if ($this->eot == 'true') {
                $quarter_list = $this->get_quarter_list($term_id);

                $target;
                if ($lc_id == 'all' && $this->user = 'MC') {
                    $lc_list = $this->get_lc_list();
                    $targetz = array();
                    foreach ($lc_list as $lc) {
                        $targets = array();
                        foreach ($quarter_list as $quarter) {
                            $targets[] = $this->target_values->get_value($lc['id'], $quarter['id'], $kpi['id']);
                        }
                        $sumLogic = new SumLogic($targets, $kpi['end_of_term']);
                        $targetz[] = $sumLogic->get_sum();
                    }
                    $sumLogic = new SumLogic($targetz, $kpi['all_lcs']);
                    $target = $sumLogic->get_sum();
                } else {
                    foreach ($quarter_list as $quarter) {
                        $targets[] = $this->target_values->get_value($lc_id, $quarter['id'], $kpi['id']);
                    }
                    $sumLogic = new SumLogic($targets, $kpi['end_of_term']);
                    $target = $sumLogic->get_sum();
                }
            } else if ($lc_id == 'all' && $this->user = 'MC') {
                $targets = array();
                $lc_list = $this->get_lc_list();
                foreach ($lc_list as $lc) {
                    $targets[] = $this->target_values->get_value(
                                    $lc['id'], $quarter_id, $kpi['id']);
                }
                $sumLogic = new SumLogic($targets, $kpi['all_lcs']);
                $target = $sumLogic->get_sum();
            } else {
                $target = $this->target_values->get_value(
                                $lc_id, $quarter_id, $kpi['id']
                );
            }
        }
        return $target;
    }

    function get_lc_list() {
        $query = $this->lc_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_lc_section($lc_list) {
        echo "Select LC: \n";
        echo "<select name=\"lc_id\" id=\"lc_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page . "&area_id="
        . $this->area_id . "&kpi_id=" . $this->kpi_id . "&term_id=" . $this->term_id .
        "&quarter_in_term=" . $this->quarter_in_term . "&custom=" . $this->custom .
        "&eot=" . $this->eot . "&lc_id='+this.value\">\n";

        echo "<option value='all'";
        if (isset($_REQUEST['lc_id'])) {
            if ('all' == $_REQUEST['lc_id']) {
                $this->lc_id = 'all';
                echo " selected ";
            }
        } else if ('all' == $this->lc_id) {
            echo " selected ";
        }

        echo ">";
        echo 'All';
        echo "</option>\n";


        foreach ($lc_list as $lc) {
            echo "<option value=\"" . $lc['id'] . "\"";
            if (isset($_REQUEST['lc_id'])) {
                if ($lc['id'] == $_REQUEST['lc_id']) {
                    $this->lc_id = $lc['id'];
                    echo " selected ";
                }
            } else if ($lc['id'] == $this->lc_id) {
                echo " selected ";
            }

            echo ">";
            echo $lc['name'];
            echo "</option>\n";
        }
        echo "</select>\n";
    }

    function get_year_ago($kpi) {
        if ($this->quarter_id != null) {
            $quarter_id = $this->quarter_id;
        } else {
            $quarter_list = $this->get_quarter_list($this->term_id);
            $quarter_id = $quarter_list[0]['id'];
        }
        $past_actual = '';

        $query = $this->quarter_query . ' join terms t on quarters.term=t.id WHERE quarters.id = ' . $quarter_id;
        $rows = $this->dbutil->process_query_assoc($query);
        $selected_quarter = $rows[0];

        $year_ago = $selected_quarter['number_of_term'] - 1;
        $quarter_in_term = $selected_quarter['quarter_in_term'];

        $query = 'select q.id quarter_id from quarters q join terms t on t.id=q.term WHERE number_of_term = '
                . $year_ago . ' and quarter_in_term = ' . $quarter_in_term;
        $rows = $this->dbutil->process_query_assoc($query);
        $quarter_term_ago = $rows[0];
        $past_actual = $this->get_actual($this->lc_id, $quarter_term_ago['quarter_id'], $year_ago, $kpi);
        return $past_actual;
    }

    function get_trend($actual, $past) {
        if ($past != null && $actual != null && $past != '-' && $actual != '-') {
            if ($past > 0) {
                if ($actual < 0.9 * $past) {
                    echo '<img src="images/common/red_trend.png">';
                } else if ($actual < 1.1 * $past) {
                    echo '<img src="images/common/yellow_trend.png">';
                } else if ($actual >= 1.1 * $past) {
                    echo '<img src="images/common/green_trend.png">';
                }
            } else {
                if ($actual < 1.1 * $past) {
                    echo '<img src="images/common/red_trend.png">';
                } else if ($actual > 1.1 * $past && $actual < 0.9 * $past) {
                    echo '<img src="images/common/yellow_trend.png">';
                } else if ($actual >= 0.9 * $past) {
                    echo '<img src="images/common/green_trend.png">';
                }
            }
        }
    }

    function get_eot_checkbox() {
        echo '<input type="checkbox" name="eot" value="1" ';
        //        echo "onchange=if(this.checked){\"window.location.href='".$this->page."&area_id="
        //            .$this->area_id."&lc_id=".$this->lc_id."&term_id=".$this->term_id.
        //            "&eot='+this.checked\"}";
        echo "onchange=\"window.location.href='" . $this->page . "&area_id="
        . $this->area_id . "&lc_id=" . $this->lc_id . "&kpi_id=" . $this->kpi_id .
        "&term_id=" . $this->term_id . "&custom=" . $this->custom .
        "&eot='+this.checked\"";
        if (isset($_REQUEST['eot'])) {
            if ('true' == $_REQUEST['eot']) {
                $this->eot = $_REQUEST['eot'];
                echo ' checked';
            }
        }
        echo ">";
        echo "End of a term";
    }

    function get_custom_checkbox() {
        echo '<input type="checkbox" name="custom" value="1" ';
        //        echo "onchange=if(this.checked){\"window.location.href='".$this->page."&area_id="
        //            .$this->area_id."&lc_id=".$this->lc_id."&term_id=".$this->term_id.
        //            "&eot='+this.checked\"}";
        echo "onchange=\"window.location.href='" . $this->page . "&area_id="
        . $this->area_id . "&lc_id=" . $this->lc_id . "&kpi_id=" . $this->kpi_id . "&quarter_in_term=" . $this->quarter_in_term .
        "&term_id=" . $this->term_id . "&eot=" . $this->eot . "&area_id=" . $this->area_id . "&custom='+this.checked\"";
        if (isset($_REQUEST['custom'])) {
            if ('true' == $_REQUEST['custom']) {
                $this->custom = $_REQUEST['custom'];
                echo ' checked';
            } else {
                $this->area_id = 'all';
            }
        }
        echo ">";
        echo "Include custom KPIs";
    }

    function get_help() {
        echo $this->help;
    }

    function get_kpi_unit($unit_id) {
        $query = $this->kpi_unit_query . ' WHERE `id` = ' . $unit_id;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows[0];
    }

    protected function get_area_section($area_list) {
        echo "Select area: \n";
        echo "<select name=\"area_id\" id=\"area_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page . "&area_id="
        . $this->area_id . "&lc_id=" . $this->lc_id . "&kpi_id=" . $this->kpi_id . "&quarter_in_term=" . $this->quarter_in_term .
        "&term_id=" . $this->term_id . "&eot=" . $this->eot . "&custom=" . $this->custom . "&area_id='+this.value\">\n";
        echo "<option value=\"all\"";
        if (isset($_REQUEST['area_id'])) {
            if ('all' == $_REQUEST['area_id']) {
                $this->area_id = 'all';
                echo " selected ";
            }
        }
        echo ">";
        echo 'All';
        echo "</option>\n";

        foreach ($area_list as $area) {
            echo "<option value=\"" . $area['id'] . "\"";
            if (isset($_REQUEST['area_id'])) {
                if ($area['id'] == $_REQUEST['area_id']) {
                    $this->area_id = $area['id'];
                    echo " selected ";
                }
            }

            echo ">";
            echo $area['name'];
            echo "</option>\n";
        }

        echo "</select>\n";
    }

}
?>

