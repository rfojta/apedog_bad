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
    protected $area_id;
    protected $lc_id;
    protected $this_page;
    protected $target_values;
    protected $actual_values;
    protected $locking;
    protected $user;

    protected $area_query = 'select * from areas';
    protected $quarter_query = 'select * from quarters';
    protected $kpi_query = 'select * from kpis';
    protected $term_query = 'select * from terms';
    protected $business_perspective_query = 'select * from business_perspectives';
    protected $csf_query = 'select * from csfs where business_perspective ';
    protected $lc_query = 'select * from lcs';


    function __construct( $dbutil, $term_id, $current_area, $user, $quarter_in_term ) {
        $this->dbutil = $dbutil;

        $this->area_id = $current_area;
        $this->page = 'reports.php?results';
        $this->user = $user;
        $this->term_id = $term_id;
        $this->quarter_in_term = $quarter_in_term;

        $lc = new LC($dbutil->dbres);
        $this->lc_id = $lc->get_lc_by_user($user);
        $this->target_values = new DetailTracking($dbutil);
        $this->actual_values = new DetailTracking($dbutil, 1);

    }

    function get_area_list() {
        $query = $this->area_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    protected function get_area_section( $area_list ) {
        echo "Select area: \n";
        echo "<select name=\"area_id\" id=\"area_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."&term_id=".$this->term_id
            ."&lc_id=".$this->lc_id."&quarter_in_term=".$this->quarter_in_term."&area_id='+this.value\">\n";
        echo "<option value=\"all\"";
        if( isset($_REQUEST['area_id']) ) {
            if('all' == $_REQUEST['area_id']) {
                $this->area_id='all';
                echo " selected ";
            }
        }
        echo ">";
        echo 'All';
        echo "</option>\n";

        foreach( $area_list as $area ) {
            echo "<option value=\"".$area['id']."\"";
            if( isset($_REQUEST['area_id']) ) {
                if( $area['id'] == $_REQUEST['area_id']) {
                    $this->area_id=$area['id'];
                    echo " selected ";
                }
            }

            echo ">";
            echo $area['name'];
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        $kpi_list = $this->get_kpi_list($this->area_id);
        $business_perspectives_list = $this->get_bp_list();
        if( $_SESSION['user'] == 'MC') {
            $lc_list = $this->get_lc_list();
            $this->get_lc_section($lc_list);
        }
        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);

        echo "<table width=100%><tr><td valign=top>";
	$i = 0;
        foreach( $business_perspectives_list as $bp ) {
            echo "<p>";
            echo "<table width=100% >";
            $this->get_output($bp);
            echo "</table>";
            echo "</p>";
            if( ( $i % 2 ) == 0 ) {
                echo "</td>\n<td valign=top>";
            } else {
                echo "</td></tr>\n<tr><td valign=top>";
            }
	    $i++;
        }
        echo "</td></tr></table>";


        $this->get_area_section($area_list);
        $kpi_list=$this->get_kpi_by_csf_list(null);
        echo '<table>';
        foreach($kpi_list as $kpi) {
            $this->get_kpi_section($kpi);
        }
        echo '</table>';

    }

    function submit( $post ) {
        $quarter;
        $rec;
        $kpi=array();
        foreach( $post as $key => $value ) {
        // $tokens = array();
            if( $key=='quarter_id') {
                $quarter=$value;
            }

            if( preg_match('/^kpi-(\d+)$/', $key, $tokens) ) {

                if( $value > 0 && $quarter!=null ) {
                    $kpi=$tokens;
                    $this->set_values($kpi,$quarter,$value);
                }
            }
        }
    }

    function get_term_list() {
        $query = $this->term_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_quarter_list($term_id) {
        $query = $this->quarter_query . ' where term = '.$term_id;
        $rows = $this->dbutil->process_query_assoc($query);
        $this->quarter_id=$rows[0]['id'];
        return $rows;
    }

    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."&lc_id=".$this->lc_id."&area_id=".$this->area_id."&quarter_in_term=".$this->quarter_in_term."&term_id='+this.value\">\n";

        foreach( $term_list as $term ) {
            echo "<option value=\"".$term['id']."\"";
            if( isset($_REQUEST['term_id']) ) {
                if( $term['id'] == $_REQUEST['term_id']) {
                    $this->term_id=$term['id'];
                    echo " selected ";
                }
            } else if ($term['id']==$this->term_id) {
                    echo " selected";
                }

            echo ">";
            echo date('Y', strtotime($term['term_from'])).'/'.date('Y', strtotime($term['term_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_quarter_section($quarter_list) {
        echo "Select quarter: \n";
        echo "<select name=\"quarter_id\" id=\"quarter_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."&lc_id=".$this->lc_id."&area_id=".$this->area_id."&term_id=".$this->term_id."&quarter_in_term='+this.value\">\n";

        foreach( $quarter_list as $quarter ) {
            echo "<option value=\"".$quarter['quarter_in_term']."\"";
            if( isset($_REQUEST['quarter_in_term']) ) {
                if( $quarter['quarter_in_term'] == $_REQUEST['quarter_in_term']) {
                    $this->quarter_id=$quarter['id'];
                    $this->quarter_in_term=$quarter['quarter_in_term'];
                    echo " selected ";
                }
            } else if ($quarter['quarter_in_term']==$this->quarter_in_term) {
                    echo " selected ";
                }

            echo ">";
            echo date('j.n.Y', strtotime($quarter['quarter_from'])).'-'.date('j.n.Y', strtotime($quarter['quarter_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_kpi_list($area_id) {
        if ($area_id!='all') {
            $query = $this->kpi_query . " where csf = " . $this->dbutil->escape($area_id);
        } else {
            $query = $this->kpi_query;
        }
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_bp_list() {
        $query = $this->business_perspective_query;
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
        $rate = $this->get_rate($kpi_list);
        echo '<tr bgcolor="#CCCCFF">';
        echo '<td>';
        echo '<big>';
        echo '<span title="' . $bp['description'] . '">'
            . $bp['name']. ':</span>';
        echo '</big>';
        echo '</td>';
        echo '<th width="60" colspan="4" align="left">';
        echo $rate;
        echo '</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo '</td>';
        echo '<td>';
        echo 'Actual';
        echo '</td>';
        echo '<td>';
        echo 'Target';
        echo '</td>';
        echo '<td>';
        echo 'Status';
        echo '</td>';
        echo '<td>';
        echo 'Trend';
        echo '</td>';
        echo '</tr>' . "\n";

        foreach($csf_list as $csf) {
            $this->get_csf_section($csf);
        }
    }

    function get_csf_list($bp_id) {
        if ($bp_id==null) {
            $query = $this->csf_query.'IS NULL';
        } else {
            $query = $this->csf_query.'='.$bp_id;
        }
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_kpi_by_csf_list($csf_id) {
        if ($csf_id==null) {
            $query = $this->kpi_query.' WHERE csf = 0';
        } else {
            $query = $this->kpi_query.' WHERE csf ='.$csf_id;
        }
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_csf_section($csf) {
        $kpi_list = $this->get_kpi_by_csf_list($csf['id']);
        $csf_name = $csf['name'];
        $rate = $this->get_rate($kpi_list);

        echo '<tr bgcolor="#E5E5E5">';
        echo '<td>';
        echo '<span title="' . $csf['description'] . '">'
            . $csf['name'] . ':</span>';
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '<td align ="center">';
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
        $actual = $this->get_actual($this->lc_id, $this->quarter_id, $kpi['id']);
        $target = $this->get_target($this->lc_id, $this->quarter_id, $kpi['id']);

        if ($target!=null && $target != 0) {
            $rate = $actual/$target;
        }
        $past_values = $this->get_year_ago($kpi);

        echo '<tr>';
        echo '<td>';
        echo '<small>';
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo '</small>';
        echo '</td>';
        echo '<td align="right">';
        echo '<small>';
        echo $actual;
        echo '</small>';
        echo '</td>';
        echo '<td align="right">';
        echo '<small>';
        echo $target;
        echo '</small>';
        echo '</td>';
        echo '<td align="center">';
        echo $this->get_status($rate);
        echo '</td>';
        echo '<td align="center">';
        echo $this->get_trend($actual, $past_values);
        echo '</td>';
        echo '</tr>';
    }

    function get_status($rate) {
        if ($rate != null) {
            if ($rate < '0.9') {
                echo "<img src='images/red_status.png'>";
            } else if ($rate < '1') {
                    echo "<img src='images/orange_status.png'>";
                } else {
                    echo "<img src='images/green_status.png'>";
                }
        }
    }

    function get_rate($kpi_list) {
        foreach ($kpi_list as $kpi) {
            $actual = $this->get_actual($this->lc_id, $this->quarter_id, $kpi['id']);
            $target = $this->get_target($this->lc_id, $this->quarter_id, $kpi['id']);

            if ($target!=null && $target != 0) {
                $rates[]= $actual/$target;
            }
        }
        if ($rates!=null) {
            $rate = array_sum($rates)/count($rates);
        }
        return $rate;
    }

    function get_actual($lc_id, $quarter_id, $kpi_id) {
        if($quarter_id!=null && $kpi_id!=null) {
            $actual=$this->actual_values->get_value(
                $lc_id, $quarter_id, $kpi_id
            );
        }
        return $actual;
    }

    function get_target($lc_id, $quarter_id, $kpi_id) {
        if($quarter_id!=null && $kpi_id!=null) {
            $target=$this->target_values->get_value(
                $lc_id, $quarter_id, $kpi_id
            );
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
        echo "onchange=\"window.location.href='".$this->page."&area_id="
            .$this->area_id."&lc_id=".$this->lc_id."&term_id=".$this->term_id."&quarter_in_term=".$this->quarter_in_term."&lc_id='+this.value\">\n";
        echo "<option value='all'";
        if( isset($_REQUEST['lc_id']) ) {
            if( $lc['id'] == $_REQUEST['lc_id']) {

                $this->lc_id=$lc['id'];
                echo " selected ";

            }
        }
        echo ">";
        echo 'All';
        echo "</option>\n";

        foreach( $lc_list as $lc ) {
            echo "<option value=\"".$lc['id']."\"";
            if( isset($_REQUEST['lc_id']) ) {
                if( $lc['id'] == $_REQUEST['lc_id']) {
                    $this->lc_id=$lc['id'];
                    echo " selected ";
                }
            } else if ($lc['id']==$this->lc_id) {
                    echo " selected ";
                }

            echo ">";
            echo $lc['name'];
            echo "</option>\n";
        }
        echo "</select>\n";
    }

    function get_year_ago($kpi) {
        $query = $this->quarter_query. ' WHERE id = '.$this->quarter_id;
        $rows = $this->dbutil->process_query_assoc($query);
        $selected_quarter = $rows[0];

        $year_ago = $selected_quarter['term']-1;
        $quarter_in_term = $selected_quarter['quarter_in_term'];

        $query = $this->quarter_query. ' WHERE term = '
            .$year_ago. ' and quarter_in_term = '.$quarter_in_term;
        $rows = $this->dbutil->process_query_assoc($query);
        $quarter_term_ago = $rows[0];

        $past_actual = $this->get_actual($this->lc_id, $quarter_term_ago['id'], $kpi['id']);
        return $past_actual;
    }

    function get_trend($actual, $past) {
        if ($past!=0) {
            $rate = $actual/$past;
        } else if ($actual > 0) {
                $rate = 2;
            } else {
                $rate = 0;
            }
        if ($rate<0.9 && $actual!=null) {
            echo '<img src="images/red_trend.png">';
        } else if ($rate<1.1 && $actual!=null) {
                echo '<img src="images/yellow_trend.png">';
            } else if ($rate >=1.1 & $past!=null) {
                    echo '<img src="images/green_trend.png">';
                }
    }
}
?>
