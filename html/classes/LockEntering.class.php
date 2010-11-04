<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Locking of entering values
 *
 * @author Krystof
 */
class LockEntering extends DetailPlanning {
//put your code here

    protected $lcs_query = 'select * from lcs';

    function  __construct($dbutil, $term_id, $current_area, $user, $locking) {
        parent::__construct($dbutil, $term_id, $current_area, $user, $locking );

        $this->page = 'locking.php?entering&';
    }

    function get_form_content() {
        $term_list = $this->get_term_list();
        $lcs_list = $this->get_lcs_list();
        $quarter_list = $this->get_quarter_list($this->term_id);


        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);

        echo "<p>";
        echo "<table>";
        foreach ($lcs_list as $lc) {
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

    function get_lc_input($lc) {
        $quarter_id = $this->quarter_id;
        $lc_id = $lc['id'];
        $value='';
        $checked = '';
        if ($quarter_id!=null) {
            $value = $this->locking
                ->get_count($lc_id, $quarter_id, 'NULL');
        }
        if ($value==1) {
            $checked=" checked='yes' ";
        }
        echo "<tr> \n";
        echo "<td> \n";
        echo '<span title="' . $lc['description'] . '">'
            . $lc['name'] . ':</span>';
        echo "</td> \n";
        echo "<td> \n";
        echo "<input type='checkbox'".$checked."name='lc-".$lc_id."' value='checked' />";
        echo "</td> \n";
        echo "</tr> \n";
        echo "</li> \n";
    }

    function submit( $post ) {
        $quarter;
        $changed_lcs = array();
        $lcs_list = $this->get_lcs_list();
        foreach( $post as $key => $value ) {
            if( $key=='quarter_id') {
                $quarter=$value;
            }

            if( preg_match('/^lc-(\d+)$/', $key, $tokens) ) {
                $lc=$tokens;
                if ($quarter!='') {
                    $this->set_values($lc,$quarter);
                    $changed_lcs[]=$lc[1];
                }
            }
        }
        foreach($lcs_list as $lc) {
            if (!in_array($lc['id'], $changed_lcs)&&$quarter!='') {
                $this->locking->delete_value($lc['id'],$quarter, 'NULL');
            }
        }

    }

    protected function set_values($lc,$quarter) {
        $this->locking->set_value(
            $lc[1],
            $quarter,
            'NULL'
        );
    }
}
?>
