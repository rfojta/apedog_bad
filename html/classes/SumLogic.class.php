<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class determines output from an array of values
 *
 * @author Krystof
 */
class SumLogic {

    protected $targets;
    protected $logic;

    function __construct( $values, $logic) {

        $this->values=$values;
        $this->logic = $logic;
    }

    /**
     * Determines output in dependendcy of kind of logic
     * @return <type> value
     */
    function get_sum() {
        switch($this->logic) {

            case 1: {
                    foreach ($this->values as $val) {
                        if ($val!=null && $val!='-') {
                            $sum+=$val;
                        }
                    }
                    return $sum;
                };break;

            case 2: {
                    $i=0;
                    $sum=0;
                    foreach ($this->values as $val) {
                        if($val!=null && $val!='-') {
                            $sum+=$val;
                            $i++;
                        }
                    }
                    if($i==0) {
                        return null;
                    } else {
                        $value = $sum/$i;
                        return $value;
                    }
                };break;

            case 3: {
                    return end($this->values);
                };break;

            case 4: {
                    foreach ($this->values as $value) {
                        if ($value!=0) {
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

