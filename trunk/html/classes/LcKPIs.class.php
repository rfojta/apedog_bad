<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LcKPIs extends Results {

    protected $area_id;

    function __construct( $dbutil, $term_id, $current_area, $user, $quarter_in_term, $eot) {
        parent::__construct( $dbutil, $term_id, $user, $quarter_in_term, $eot );
        $this->area_id = $current_area;
        $this->page='reports.php?lc_kpis';

        $this->help="<h3>LC's KPIs</h3><p>You can see KPIs specially assigned by MC to
        your LC here.</p> <p>If you put your KPIs in a group, you can see it here.
        There are also your KPIs that aren't in groups.<p>Click on KPI to see a graph.
        Select your area, term and quarter. Check your values at the end of term!</p>";
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $csf_list = $this->get_csf_list(null);
        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        //        $kpi_list = $this->get_kpi_list($this->area_id);

        echo "<p></p>";
        echo "<p>";
        if( $_SESSION['user'] == 'MC') {
            $lc_list = $this->get_lc_list();
            $this->get_lc_section($lc_list);
        }
        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);
        $this->get_eot_checkbox();
        $this->get_area_section($area_list);
        $term_list = $this->get_term_list();

        echo "<h4>Custom LC's KPIs in groups:</h4>";
        echo "<table width=100%><tr><td width='50%' valign=top>";
        $i = 0;
        foreach($csf_list as $csf) {
            $kpi_list = $this->get_kpi_by_csf_list($csf['id']);
            if (count($kpi_list)>0) {

                $this->get_table_head();

                $this->get_csf_section($csf);
                echo '</table>';

                if( ( $i % 2 ) == 0 ) {
                    echo "</td>\n<td valign=top>";
                } else {
                    echo "</td></tr>\n<tr><td width='50%' valign=top>";
                }
                $i++;
            } 
        }
        echo "</table>";

        echo "<p></p>";
        echo "<h4>Custom LC's KPIs:</h4>";
        $kpi_list=$this->get_kpi_by_csf_list(null);
        if (count($kpi_list)>0) {

            $this->get_table_head();
            
            foreach($kpi_list as $kpi) {
                $this->get_kpi_section($kpi);
            }
            echo '</table>';
            echo '<p>';
        } else {
                echo "<b>No custom KPIs out of groups</b>";
            }

    }

    protected function get_area_section( $area_list ) {
        echo "<p>";
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
        echo "</p>";
    }

    function get_kpi_list($area_id) {
        $query = $this->kpi_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_table_head() {
        echo '<p>';
        echo "<table cellspacing='0' cellpadding='3' class='bpTable' width=100%>";
        echo '<tr class="headTableRow">';
        echo '<th width="70%">';
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
    }
}

?>
