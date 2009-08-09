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
    protected $area_id;
    protected $lc_id;
    protected $this_page;
    protected $target_values;
    protected $actual_values;
    protected $locking;

    protected $area_query = 'select * from areas';
    protected $quarter_query = 'select * from quarters where term = ';
    protected $kpi_query = 'select * from kpis';
    protected $term_query = 'select * from terms';
    protected $business_perspective_query = 'select * from business_perspectives';
    protected $csf_query = 'select * from csfs where business_perspective ';

    function __construct( $dbutil, $term_id, $current_area, $user ) {
        $this->dbutil = $dbutil;
        $this->term_id = $term_id;
        $this->area_id = $current_area;
        $this->page = 'reports.php?results';

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
        echo "onchange=\"window.location.href='".$this->page."term_id=".$this->term_id
            ."&quarter_id=".$this->quarter_id."&area_id='+this.value\">\n";
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

        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);
        echo '&nbsp;&nbsp;&nbsp;';



        foreach( $business_perspectives_list as $bp ) {
            echo "<p>";
            echo "<table>";
            $this->get_output($bp);
            echo "</table>";
            echo "</p>";
        }


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
        $query = $this->quarter_query . $term_id;
        $rows = $this->dbutil->process_query_assoc($query);
        $this->quarter_id=$rows[0]['id'];
        return $rows;
    }

    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."area_id=".$this->area_id."&term_id='+this.value\">\n";

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
        echo "onchange=\"window.location.href='".$this->page."area_id=".$this->area_id."&term_id=".$this->term_id."&quarter_id='+this.value\">\n";

        foreach( $quarter_list as $quarter ) {
            echo "<option value=\"".$quarter['id']."\"";
            if( isset($_REQUEST['quarter_id']) ) {
                if( $quarter['id'] == $_REQUEST['quarter_id']) {
                    $this->quarter_id=$quarter['id'];
                    echo " selected ";
                }
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
        $bp_name = $bp['name'];
        $csf_list = $this->get_csf_list($bp['id']);
        echo '<tr>';
        echo '<td>';
        echo '<big>'.$bp_name.'</big>';
        echo '</td>';
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
        echo '</tr>';

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
        echo '<tr>';
        echo '<td>';
        echo $csf_name;
        echo '</td>';
        echo '</tr>';

        foreach ($kpi_list as $kpi) {
            $this->get_kpi_section($kpi);
        }
    }

    function get_kpi_section($kpi) {
        if($this->quarter_id!=null && $kpi['id']!=null) {
            $actual=$this->actual_values->get_value(
                $this->lc_id, $this->quarter_id, $kpi['id']
            );
        }
        if($this->quarter_id!=null && $kpi['id']!=null) {
            $target=$this->target_values->get_value(
                $this->lc_id, $this->quarter_id, $kpi['id']
            );
        }
        echo '<tr>';
        echo '<td>';
        echo '<small>';
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo '</small>';
        echo '</td>';
        echo '<td>';
        echo '<small>';
        echo $actual;
        echo '</small>';
        echo '</td>';
        echo '<td>';
        echo '<small>';
        echo $target;
        echo '</small>';
        echo '</td>';
        echo '</tr>';
    }
}

?>
