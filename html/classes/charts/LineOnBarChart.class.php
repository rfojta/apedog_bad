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

      private $bar_data;
      private $line_data;
      private $x_labels;
      private $y_max;
      private $bar_label;
      private $line_label;
      private $bar_color;
      private $line_color;
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

      function __construct( $bar_data, $line_data, $x_labels, $y_max, $bar_label, $line_label, $bar_color, $line_color, $scale) {
          $this->bar_data=$bar_data;
          $this->line_data=$line_data;
          $this->x_labels=$x_labels;
          $this->y_max=$y_max;
          $this->bar_label=$bar_label;
          $this->line_label=$line_label;
          $this->bar_color=$bar_color;
          $this->line_color=$line_color;
          $this->scale=$scale;
      }

      function draw_chart(){
        $chxlx='0:';
        foreach ($this->x_labels as $row){
        $chxlx .= '|' .$row['ID'];
        }

        $chd = 't1:';
        if (!empty($this->bar_data)){
            foreach ($this->bar_data as $value){
                $chd.= $value/1 . ',';
              }
            $chd1 = substr($chd, 0, -1);
        }

        $chd3 = '';
        if (!empty($this->line_data)){
          foreach ($this->line_data as $value){
            $chd3.= $value/1 . ',';
          }
          $chd2.= substr($chd3, 0, -1);
        }

        $chd = $chd1.'|'.$chd2;

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
        $values[]='D,'.$this->line_color.',1,0,6,3';
        $values[]='20';
        $values[]=$this->scale;
        $values[]='x,y';
        $values[]=$chxlx;
        $values[]='1,0,'.$this->y_max.','.$this->y_max/10;
        $values[]=$chd;
        $values[]=$this->bar_color.','.$this->line_color;
        $values[]=$this->bar_label.'|'.$this->line_label;
        $values[]='0,'.$this->y_max;


        $parameters=array();
        for($i=0;$i<sizeof($values);$i++){
           $parameters[]=$keys[$i].'='.$values[$i];
        }
        $parameters_str=implode('&',$parameters);

        
        $chart_loc = 'http://chart.apis.google.com/chart?' .$parameters_str;
        echo '<img src="'.$chart_loc.'">';
      }
}