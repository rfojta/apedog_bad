<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reporting
 *
 * @author Krystof
 */
class Report {
    protected $dbres;

    protected $area_id;
    protected $lc_id;
    protected $target_values;
    protected $actual_values;
    protected $planned_data=array();
    protected $actual_data=array();
    

    protected $kpi_query = 'select * from kpis where area = ';
    protected $term_query = 'select * from terms';

    function __construct( $dbres, $user ) {
        include('classes/charts/LineOnBarChart.class.php');
        include('classes/charts/LineChart.class.php');
        
        $this->dbres = $dbres;
        $this->area_id = $area_id;

        $lc = new LC($dbres);
        $this->lc_id = $lc->get_lc_by_name($user);

        $this->target_values = new Tracking($dbres);
        $this->actual_values = new Tracking($dbres, 1);
    }

    function get_term_list() {
        $query = $this->term_query;

        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
            die( 'Invalid query: ' . mysql_error($this->dbres) );
        }

        $out_array = array();

        while( $row = mysql_fetch_assoc($res) ) {
            $out_array[] = $row;
        }

        return $out_array;
    }

    protected function get_chart_content_element( $term_id ) {
        
        $actual = $this->actual_values->get_actual(
            $this->lc_id, $term_id, $this->area_id
        );
        $this->actual_data[]=$actual;
        
        $target = $this->target_values->get_actual(
            $this->lc_id, $term_id, $this->area_id
        );
        $this->planned_data[]=$target;
    }

    function get_form_content($area_id) {
        $this->area_id = $area_id;
        $term_list = $this->get_term_list();
        
        foreach( $term_list as $row ) {
            $term_id = $row['id'];  
            $this->get_chart_content_element( $term_id );
        }
        $chart = new LineOnBarChart($this->planned_data,$this->actual_data,$term_list,500,'Plan','Reality','76A4FB','0033FF','400x200');
        $chart->draw_chart();

        echo '<br>';
        
        
	  $data=array();
    $data[]=$this->planned_data;
    $data[]=$this->actual_data;
    
	  $line_labels=array();
    $line_labels[]='Plan';
    $line_labels[]='Reality';
    
	  $line_colors=array();
    $line_colors[]='76A4FB';
    $line_colors[]='0033FF';
    
        $chart2 = new LineChart($data,$term_list,500,$line_labels,$line_colors,'400x200');
        $chart2->draw_chart();
    }
}

?>

