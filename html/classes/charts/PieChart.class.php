<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prepared "Line" chart
 * Possibility of multiple data series inserted in constructor
 *
 * @author Krystof
 */
class PieChart {

    private $percentile;
    private $label;
    private $colors;
    private $title;
    private $scale;

    /**
     * Constructor
     *
     *Paramethers similar to other charts
     *
     */

    function __construct($percentile,$label,$colors,$title,$scale) {

        $this->percentile = $percentile;
        $this->label = $label;
        $this->colors = $colors;
        $this->title= $title;
        $this->scale = $scale;
    }

    function draw_chart() {
        $chd = 't:';
        $chd .= $this->percentile.',';
        $chd .= 100-$this->percentile;

        $chco = '';
        foreach($this->colors as $color) {
            if($color!=null) {
                $chco .=$color . ',';
            }
        }
        $chco = substr($chco, 0, -1);

        $keys = array();
        $keys[]='cht';
        $keys[]='chd';
        $keys[]='chs';
        $keys[]='chl';
        $keys[]='chtt';
        $keys[]='chco';

        $values = array();
        $values[] = 'p3';
        $values[] = $chd;
        $values[] = $this->scale;
        $values[] = $this->label;
        $values[] = $this->title;
        $values[] = $chco;

        $parameters=array();
        for($i=0;$i<sizeof($values);$i++) {
            $parameters[]=$keys[$i].'='.$values[$i];
        }
        $parameters_str=implode('&',$parameters);

        $chart_loc = 'http://chart.apis.google.com/chart?' .$parameters_str;

        echo '<img src="'.$chart_loc.'">';
    }
}