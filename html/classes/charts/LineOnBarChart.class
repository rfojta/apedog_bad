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
        $cht = 'cht=bvg';
        $chbh = 'chbh=5,2';
        $chm = 'chm=D,'.$this->line_color.',1,0,6,3';
        $chbh = 'chbh=20';
        $chs = 'chs='.$this->scale;
        $chxt = 'chxt=x,y';
        
        $chxlx = 'chxl=0:';        
        foreach ($this->x_labels as $row){
        $chxlx .= '|' .$row['ID'];
        }
           
        $chxly = 'chxr=1,0,'.$this->y_max.','.$this->y_max/10;
        
        $chd = 'chd=t1:';

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
        
        $chco1 = $this->bar_color;
        $chco = 'chco='.$chco1.','.$this->line_color;
        
        $chdl = 'chdl='.$this->bar_label.'|'.$this->line_label;
        
        $chds = 'chds=0,'.$this->y_max;        
        
        $chart_loc = 'http://chart.apis.google.com/chart?' . $cht . '&' . $chbh . '&' . $chm . '&' . $chbh . '&' . $chs . '&' .$chxt.
        '&' . $chxlx . '&' .$chxly . '&' . $chd1 . '|' . $chd2 . '&' .$chco. '&' .$chdl. '&' .$chds;
        
        echo '<img src="'.$chart_loc.'">';
      }
}