<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Locking of planning
 *
 * @author Krystof
 */
class LockPlanning extends DetailPlanning {
//put your code here

    protected $lcs_query = 'select * from lcs';

    function  __construct($dbutil, $term_id, $current_area, $user ) {
        parent::__construct($dbutil, $term_id, $current_area, $user );

        $this->page = 'locking.php?planning&';
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $lcs_list = $this->get_lcs_list();

        $this->get_term_section($term_list);

        echo "<p>";
        echo "<table>";
        foreach ($lcs_list as $lc){
            $this->get_lc_input($lc);
        }
        echo "</table>";
        echo "</p>";

    }

    function get_lcs_list() {
        $query = $this->lcs_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_lc_input($lc){
        
    }
}
?>
