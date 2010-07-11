<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prepared "Bar" chart
 * Possibility of multiple data series inserted in constructor
 *
 * @author Krystof
 */
class BarChart {

    private $data;
    private $x_labels;
    private $x2_labels;
    private $y_min;
    private $y_max;
    private $bar_labels;
    private $bar_colors;
    private $scale;
    private $unit;

    /**
     * Constructor
     *
     *Paramethers similar to other charts
     *
     */

    function __construct($data,$x_labels,$x2_labels, $y_min, $y_max,$bar_labels,$bar_colors,$scale,$unit) {

        $this->data = $data;
        $this->x_labels = $x_labels;
        $this->x2_labels = $x2_labels;
        $this->y_min = $y_min;
        $this->y_max = $y_max;
        $this->bar_labels= $bar_labels;
        $this->bar_colors = $bar_colors;
        $this->scale = $scale;
        $this->unit = $unit;
    }

    function draw_chart() {

        $chxlx = '0:';
        foreach ($this->x_labels as $label) {
            $chxlx .= '|' .$label;
        }
        if($this->x2_labels!=null) {
            $chxlx .= '|2:';
            foreach ($this->x2_labels as $label) {
                $chxlx .= '|' .$label . '|||';
            }
        }
        $chls= '';
        $chd = 't:';
        $i = 0;
        foreach($this->data as $serie) {
            
            if (!empty($serie)) {
                foreach ($serie as $value) {
                    $chd.= $value/1 . ',';
                }
                $chd = substr($chd, 0, -1);
                $chd .= '|';
                $chls .= '6,1,0|';
                $chm .= 'N*f1*'.$this->unit['name'].',000000,'.$i.',-1,7,1|';
                $i++;
            }
        }

        $chd = substr($chd, 0, -1);
        $chls = substr($chls, 0, -1);
        $chm = substr($chm,0,-1);
        
        $chco = '';
        foreach($this->bar_colors as $color) {
            if($color!=null) {
                $chco .=$color . ',';
            }
        }
        $chco = substr($chco, 0, -1);

        $chdl = '';
        foreach($this->bar_labels as $label) {
            if($label!=null) {
                $chdl .=$label . '|';
            }
        }
        $chdl = substr($chdl, 0, -1);

        $chxr='1,';
        $chxr.=$this->y_min.',';
        $chxr.=$this->y_max;

        $chxt = 'x,y';
        if($this->x2_labels!=null) {
            $chxt .=',x';
        }

        $chds=$this->y_min.','.$this->y_max;

        $keys = array();
        $keys[]='cht';
        $keys[]='chs';
        $keys[]='chxt';
        $keys[]='chxl';
        $keys[]='chxly';
        $keys[]='chls';
        $keys[]='chd';
        $keys[]='chco';
        $keys[]='chdl';
        $keys[]='chxr';
        $keys[]='chds';
        $keys[]='chm';

        $values = array();
        $values[] = 'bvg';
        $values[] = $this->scale;
        $values[] = $chxt;
        $values[] = $chxlx;
        $values[] = '1,0,'.$this->y_max.','.$this->y_max/10;
        $values[] = $chls;
        $values[] = $chd;
        $values[] = $chco;
        $values[] = $chdl;
        $values[] = $chxr;
        $values[] = $chds;
        $values[] = $chm;

        $parameters=array();
        for($i=0;$i<sizeof($values);$i++) {
            $parameters[]=$keys[$i].'='.$values[$i];
        }
        $parameters_str=implode('&',$parameters);

        $chart_loc = 'http://chart.apis.google.com/chart?' .$parameters_str;

        echo '<img src="'.$chart_loc.'">';
    }
}