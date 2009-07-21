<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entering
 *
 * @author Richard
 */
class Entering extends Planning {
//put your code here

    protected $actaul_values;

    function  __construct($dbres, $term_id, $user) {
        parent::__construct($dbres, $term_id, $user);

        $this->actual_values = new Tracking($dbres, 1);
    }

    protected function get_form_content_row( $area_id, $area_name ) {

        $actual = $this->actual_values->get_actual(
            $this->lc_id, $this->term_id, $area_id
        );
        $target = $this->target_values->get_actual(
            $this->lc_id, $this->term_id, $area_id
        );

        echo '<li>';
        echo "\n";
        echo $area_name . ': ';
        echo '<input name="'
            . $this->lc_id . '-'
            . $this->term_id . '-'
            . $area_id .'" value="' . $actual . '">';
        echo "&nbsp;Planned: $target\n";
        echo '</li>';
        echo "\n";
    }

    protected function set_values( $tokens, $value ) {
        $this->actual_values->set_actual(
            $tokens[1], $tokens[2],
            $tokens[3], $value);
    }
}
?>
