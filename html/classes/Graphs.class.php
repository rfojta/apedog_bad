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
        $term_list = $this->get_term_list();
        if ($this->eot==1) {
            $data=$this->get_values($term_list, $kpi);
            $x_labels = $this->get_xlabels($term_list);
        } else {
            $data=$this->get_values($quarter_list, $kpi);
            $x_labels = $this->get_xlabels($quarter_list);
        }
        $y_max = 100;
        $line_labels=array('Current','Goal');
        $line_colors=array('4AA02C','151B8D');
        $scale='800x300';

        $chart=$this->draw_chart($kpi, $data, $x_labels, $y_max, $line_labels, $line_colors, $scale);

    }

    function get_values($list, $kpi) {
        $actuals=array();
        $targets=array();
        if($this->eot!=1) {
            foreach ($list as $quarter) {
                $actuals[] = $this->get_actual($this->lc_id, $quarter['id'], $kpi['id']);
                $targets[] = $this->get_target($this->lc_id, $quarter['id'], $kpi['id']);
            }
        } else {
            foreach($list as $term) {
                $actuals[] = $this->get_year_actual($kpi, $term['id']);
                $targets[] = $this->get_year_target($kpi, $term['id']);
            }
        }
        $data=array();

        $data[]=$actuals;
        $data[]=$targets;

        return $data;
    }

    function get_xlabels($list) {
        $xlabels = array();
        $j=3;
        if ($this->eot!=1) {
            foreach ($list as $quarter) {
                $xlabels[]='Q'.$j;
                $j++;
                if ($j>4) {
                    $j=1;
                }
            }
        } else {
            foreach ($list as $term) {
                $xlabels[]=date('Y', strtotime($term['term_from'])).'/'.date('Y', strtotime($term['term_to']));
            }
        }
        return $xlabels;
    }

    function draw_chart($kpi, $data, $x_labels, $y_max, $line_labels, $line_colors, $scale) {
        echo "<p><b>".$kpi['name'].':</b></p>';
        switch ($kpi['graphs']) {
            case 1: {
                    $chart=new LineChart($data, $x_labels, $y_max, $line_labels, $line_colors, $scale);
                    $chart->draw_chart();
                };break;
            case 2: {
                    $chart=new BarChart($data, $x_labels, $y_max, $line_labels, $line_colors, $scale);
                    $chart->draw_chart();

                };break;
            case 3: {
                    $i=0;
                    foreach($x_labels as $title) {
                        $scale = '250x86';
                        $line_colors=array('4AA02C','B5EAAA');
                        $percentile = $data[0][$i];
                        $label = $line_labels[0].' '.$percentile.'%';
                        if ($percentile>100) {
                            $percentile=100;
                        }
                        $chart = new PieChart($percentile,$label,$line_colors,$title,$scale);
                        $chart->draw_chart();
                        $i++;
                    }

                };break;
            case 4: {
                    $i=0;
                    foreach($x_labels as $title) {
                        $scale = '300x100';
                        if ($data[1][$i]!=0) {
                            $percentile = $data[0][$i]/$data[1][$i]*100;
                            $lab=$data[0][$i];
                        } else {
                            $percentile=100;
                            $lab=$data[0][$i];
                        }
                        if ($data[0][$i]==null){
                            $percentile=0;
                            $lab=0;
                        }
                        $percentile=round($percentile);
                        $label = $line_labels[0].' '.$lab.' ('.$percentile.'%)';
                        $chart = new GoogleOMeter($scale,$percentile, $label, $title);
                        
                        $chart->draw_chart();
                        
                        $i++;
                    }

                };break;
            case 5: {
                    $chart=new LineOnBarChart($data, $x_labels, $y_max, $line_labels, $line_colors, $scale);
                    $chart->draw_chart();
                };break;
            default : {
                    echo "<p>You haven't assigned any type of chart to this KPI. Please contact your MC to fix it.</p>";
                }
        }


    }
}

?>
