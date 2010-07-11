<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prepared "Data line on bar" chart
 * Two data series, one in form of bars, second as a line
 *
 * @author Krystof
 */
class LineOnBarChart {

    private $data;
    private $x_labels;
    private $y_max;
    private $labels;
    private $line_color;
    private $colors;
    private $scale;

    /**
     * Constructor
     *
     *$bar_data:Array
     *$line_data:Array
     *$x_labels:Array<Object['ID']>
     *$y_max:int
     *$bar_label:String
     *$line_label:String
     *$bar_color
     *$bar_color
     *$scale:'intxint'
     *
     * @author Krystof
     */

    function __construct( $data,$x_labels,$y_max,$line_labels,$colors,$scale) {
        $this->data=$data;
        $this->x_labels=$x_labels;
        $this->y_max=$y_max;
        $this->labels=$line_labels;
        $this->colors=$colors;
        $this->scale=$scale;
    }

    function draw_chart() {
        $chxlx = '0:';
        foreach ($this->x_labels as $label){
          $chxlx .= '|' .$label;
        }

        $chd = 't1:';
        if (!empty($this->data)) {
            foreach ($this->data as $serie) {
                if (!empty($serie)) {
                    foreach ($serie as $value) {
                        $chd.= $value/1 . ',';
                    }
                    $chd = substr($chd, 0, -1);
                    $chd .= '|';
                }
            }
            $chd = substr($chd, 0, -1);
        }
        $chco = '';
        foreach($this->colors as $color){
          if($color!=null){
            $chco .=$color . ',';
            }
        }
        $chco = substr($chco, 0, -1);

        $chdl = '';
        foreach($this->labels as $label){
          if($label!=null){
            $chdl .=$label . '|';
            }
        }
        $chdl = substr($chdl, 0, -1);

        $keys = array();
        $keys[]='cht';
        $keys[]='chm';
        $keys[]='chbh';
        $keys[]='chs';
        $keys[]='chxt';
        $keys[]='chxl';
        $keys[]='chxr';
        $keys[]='chd';
        $keys[]='chco';
        $keys[]='chdl';
        $keys[]='chds';


        $values=array();
        $values[]='bvg';
        $values[]='D,'.$this->colors[1].',1,0,6,3';
        $values[]='30';
        $values[]=$this->scale;
        $values[]='x,y';
        $values[]=$chxlx;
        $values[]='1,0,'.$this->y_max.','.$this->y_max/10;
        $values[]=$chd;
        $values[]=$chco;
        $values[]=$chdl;
        $values[]='0,'.$this->y_max;


        $parameters=array();
        for($i=0;$i<sizeof($values);$i++) {
            $parameters[]=$keys[$i].'='.$values[$i];
        }
        $parameters_str=implode('&',$parameters);


        $chart_loc = 'http://chart.apis.google.com/chart?' .$parameters_str;
        echo '<img src="'.$chart_loc.'">';
    }
}