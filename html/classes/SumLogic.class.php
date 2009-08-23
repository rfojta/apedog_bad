<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SumLogic {

    protected $targets;
    protected $logic;

    function __construct( $values, $logic) {

        $this->values=$values;
        $this->logic = $logic;
    }

    function get_sum() {
        switch($this->logic) {
            
            case 1: {
                    return array_sum($this->values);
                };break;

            case 2: {
                    $i=0;
                    foreach ($this->values as $val){
                        $sum+=$val;
                        if($val!=null){
                            $i++;
                        }
                    }
                    if($i==0){
                        $i=1;
                    }
                    $value = $sum/$i;
                    return $value;
                };break;

            case 3: {
                    return end($this->values);
                };break;

            case 4: {
                    foreach ($this->values as $value){
                        if ($value!=0){
                            return $value;
                        }
                    }
                };break;

            case 5: {
                    return max($this->values);
                };break;
            default: {
                    return '-';
                };break;
        }
    }

}

?>

