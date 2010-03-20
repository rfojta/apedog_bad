<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prepared "Google-o-meter"
 *
 * @author Krystof
 */
class GoogleOMeter {

    private $scale;
    private $percentile;
    private $label;
    private $title;

    /**
     * Constructor
     *
     *Paramethers similar to other charts
     *
     *
     */


    function __construct($scale,$percentile, $label, $title) {

        $this->scale = $scale;
        $this->percentile = $percentile;
        $this->label = $label;
        $this->title= $title;
    }

    function draw_chart() {
        $keys=array();

        $values=array();

        $keys[]='cht';
        $keys[]='chs';
        $keys[]='chd';
        $keys[]='chl';
        $keys[]='chtt';

        $values[]='gom';
        $values[]=$this->scale;
        $values[]='t:'.$this->percentile;
        $values[]=$this->label;
        $values[]=$this->title;

        $parameters=array();
        for($i=0;$i<sizeof($values);$i++) {
            if ($values[$i]!='') {
                $parameters[]=$keys[$i].'='.$values[$i];
            }
        }
        $parameters_str=implode('&',$parameters);

        $chart_loc = 'http://chart.apis.google.com/chart?' .$parameters_str;

        echo '<img src="'.$chart_loc.'">';
    }
}
?>
