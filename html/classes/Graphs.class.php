<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Graphs extends Results {

    protected $area_id;
    protected $eot;
    protected $kpi_id;

    function __construct( $dbutil, $term_id, $current_area, $user, $quarter_in_term, $eot, $kpi_id ) {
        parent::__construct( $dbutil, $term_id, $user, $quarter_in_term, $eot);
        $this->area_id = $current_area;
        $this->page='reports.php?graphs';
        $this->kpi_id = $kpi_id;
    }

    function get_form_content() {
        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        //        $kpi_list=$this->get_kpi_by_csf_list(null);
        echo "<p></p>";
        echo "<p>";
        if( $_SESSION['user'] == 'MC') {
            $lc_list = $this->get_lc_list();
            $this->get_lc_section($lc_list);
        }
        $this->get_eot_checkbox();

        echo '<table>';
        if(isset($_REQUEST['kpi_id'])) {
            $this->kpi_id=$_REQUEST['kpi_id'];
            $this->get_graph($_REQUEST['kpi_id']);            
        } else {
            echo "<p> There is no KPI selected! Go to previous tabs and select KPI.</p>";
        }
        echo '</table>';
    }

    function get_graph($kpi_id) {
        $query = $this->kpi_query.' where id = '.$kpi_id;
        $rows = $this->dbutil->process_query_assoc($query);
        $kpi = $rows[0];
        $quarter_list = $this->get_quarter_list(null);
        $data=$this->get_values($quarter_list, $kpi);
        $x_labels = $this->get_xlabels($quarter_list);
        $y_max = 100;
        $line_labels=array('Current','Goal');
        $line_colors=array('4AA02C','151B8D');
        $scale='800x300';
        $chart=new BarChart($data, $x_labels, $y_max, $line_labels, $line_colors, $scale);
        echo "<p>".$kpi['name'].':</p>';
        $chart->draw_chart();
    }

    function get_values($quarter_list, $kpi) {
        $actuals=array();
        $targets=array();
        foreach ($quarter_list as $quarter) {
            $actuals[] = $this->get_actual($this->lc_id, $quarter['id'], $kpi['id']);
            $targets[] = $this->get_target($this->lc_id, $quarter['id'], $kpi['id']);
        }
        $data=array();

        $data[]=$actuals;
        $data[]=$targets;
        
        return $data;
    }

    function get_xlabels($quarter_list) {
        $xlabels = array();
        $j=3;
        foreach ($quarter_list as $quarter) {
            $xlabels[]='Q'.$j;
            $j++;
            if ($j>4) {
                $j=1;
            }
        }
        return $xlabels;
    }
}

?>
