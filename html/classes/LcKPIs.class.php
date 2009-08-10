<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LcKPIs extends Results {

    protected $area_id;

    function __construct( $dbutil, $term_id, $current_area, $user, $quarter_in_term ) {
        parent::__construct( $dbutil, $term_id, $user, $quarter_in_term );
        $this->area_id = $current_area;
        $this->page='reports.php?lc_kpis';
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        $kpi_list = $this->get_kpi_list($this->area_id);
//        $kpi_list=$this->get_kpi_by_csf_list(null);
        echo "<p></p>";
        echo "<p>";
        if( $_SESSION['user'] == 'MC') {
            $lc_list = $this->get_lc_list();
            $this->get_lc_section($lc_list);
        }
        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);
        $this->get_area_section($area_list);

        echo '<table>';
        foreach($kpi_list as $kpi) {
            $this->get_kpi_section($kpi);
        }
        echo '</table>';

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

    function get_kpi_list($area_id) {
        $query = $this->kpi_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }
}

?>
