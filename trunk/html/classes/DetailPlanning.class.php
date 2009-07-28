<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Planning
 *
 * @author Richard
 */
class DetailPlanning {
    protected $dbutil;

    protected $quarter_id;
    protected $lc_id;
    protected $target_values;

    protected $area_query = 'select * from areas';
    protected $kpi_query = 'select * from kpis where area = ';

    function __construct( $dbutil, $quarter_id, $user ) {
        $this->dbutil = $dbutil;
        $this->quarter_id = $quarter_id;

        $lc = new LC($dbutil->dbres);
        $this->lc_id = $lc->get_lc_by_user($user);

        $this->target_values = new DetailTracking($dbutil);

    }

    function get_area_list() {
        $query = $this->area_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    function get_kpis ($area_id ) {
        $query = $this->kpi_query . $this->dbutil->escape($area_id);
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    protected function get_kpi_input($kpi) {
        $kpi_id = $kpi['id'];
        $quarter_id = $this->quarter_id;
        $lc_id = $this->lc_id;
        $value = $this->target_values
            ->get_value($lc_id, $quarter_id, $kpi_id);

        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo "<input name=\"kpi-$kpi_id\" value=\"$value\" />";
    }

    protected function get_area_section( $area_id, $area_name, $area_desc ) {
        echo '<li>';
        echo "\n";
        echo "<span title=\"$area_desc\">$area_name</span>: ";
        echo '<ul>';
        $kpis = $this->get_kpis($area_id);
        foreach( $kpis as $kpi) {
            echo '<li>';
            $this->get_kpi_input($kpi);
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
        echo "\n";
    }

    function get_form_content() {
        $area_list = $this->get_area_list();

        echo "<ul>\n";
        foreach( $area_list as $row ) {
            $area_id = $row['id'];
            $area_name = $row['name'];
            $area_desc = $row['description'];
            $this->get_area_section( $area_id, $area_name, $area_desc );
        }
        echo "</ul>\n";
    }

    protected function set_values($tokens, $value ) {
        $this->target_values->set_value(
            $this->lc_id,
            $this->quarter_id,
            $tokens[1],
            $value
        );
    }

    function submit( $post ) {
        foreach( $post as $key => $value ) {
        // $tokens = array();
            if( preg_match('/^kpi-(\d+)$/', $key, $tokens) ) {
                if( $value > 0 ) {
                    $this->set_values($tokens, $value);
                }
            }
        }
    }
}

?>
