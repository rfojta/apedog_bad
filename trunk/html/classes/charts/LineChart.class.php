<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prepared "Line" chart
 * Possibility up to 10 lines when multiple data series inserted in constructor
 *  
 * @author Krystof
 */
class LineChart {

      private $data;
      private $x_labels;
      private $y_max;
      private $line_labels;
      private $line_colors;
      private $scale;

      /**
       * Constructor
       * 
       *Paramethers similar to other charts
       *                                                
       * @author Krystof
       */

      function __construct( 
      $data_1,$data_2,$data_3,$data_4,$data_5,$data_6,$data_7,$data_8,$data_9,$data_10, 
      $x_labels, $y_max, 
      $line_1_label,$line_2_label,$line_3_label,$line_4_label,$line_5_label,
      $line_6_label,$line_7_label,$line_8_label,$line_9_label,$line_10_label,
      $line_1_color,$line_2_color,$line_3_color,$line_4_color,$line_5_color,
      $line_6_color,$line_7_color,$line_8_color,$line_9_color,$line_10_color,
      $scale) {
      
          $this->data[] = $data_1;
          $this->data[] = $data_2;
          $this->data[] = $data_3;
          $this->data[] = $data_4;
          $this->data[] = $data_5;
          $this->data[] = $data_6;
          $this->data[] = $data_7;
          $this->data[] = $data_8;
          $this->data[] = $data_9;
          $this->data[] = $data_10;
          $this->x_labels = $x_labels;
          $this->y_max = $y_max;
          $this->line_labels[] = $line_1_label;
          $this->line_labels[] = $line_2_label;
          $this->line_labels[] = $line_3_label;
          $this->line_labels[] = $line_4_label;
          $this->line_labels[] = $line_5_label;
          $this->line_labels[] = $line_6_label;
          $this->line_labels[] = $line_7_label;
          $this->line_labels[] = $line_8_label;
          $this->line_labels[] = $line_9_label;
          $this->line_labels[] = $line_10_label;
          $this->line_colors[] = $line_1_color;
          $this->line_colors[] = $line_2_color;
          $this->line_colors[] = $line_3_color;
          $this->line_colors[] = $line_4_color;
          $this->line_colors[] = $line_5_color;
          $this->line_colors[] = $line_6_color;
          $this->line_colors[] = $line_7_color;
          $this->line_colors[] = $line_8_color;
          $this->line_colors[] = $line_9_color;
          $this->line_colors[] = $line_10_color;
          $this->scale = $scale;
      }
      
      function draw_chart(){
        $cht = 'cht=lc';
        $chs = 'chs='.$this->scale;
        $chxt = 'chxt=x,y';
        
        $chxlx = 'chxl=0:';
        foreach ($this->x_labels as $row){
          $chxlx .= '|' .$row['ID'];
        }
           
        $chxly = 'chxr=1,0,'.$this->y_max.','.$this->y_max/10;
        
        $chls= 'chls=';
        $chd = 'chd=t:';
        foreach($this->data as $serie){
  
          if (!empty($serie)){
              foreach ($serie as $value){   
                  $chd.= $value/1 . ',';          
                } 
              $chd = substr($chd, 0, -1);
              $chd .= '|';
              $chls .= '6,1,0|';
          }
        }
        $chd = substr($chd, 0, -1);
        $chls = substr($chls, 0, -1);;
        
        $chco = 'chco=';
        foreach($this->line_colors as $color){
          if($color!=null){
            $chco .=$color . ',';
            }
        }        
        $chco = substr($chco, 0, -1);
        
        $chdl = 'chdl=';
        foreach($this->line_labels as $label){
          if($label!=null){
            $chdl .=$label . '|';
            }
        }        
        $chdl = substr($chdl, 0, -1);
        
        $chds = 'chds=0,'.$this->y_max;

        $chart_loc = 'http://chart.apis.google.com/chart?' . $cht . '&' . $chs . '&' .$chxt.
        '&' . $chxlx . '&' .$chxly . '&' . $chd . '&' .$chds. '&' .$chco. '&' .$chdl. '&' .$chls;
        
        echo '<img src="'.$chart_loc.'">';
      }
}