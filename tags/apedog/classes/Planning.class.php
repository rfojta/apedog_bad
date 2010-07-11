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
class Planning {
    protected $dbutil;

    protected $term_id;
    protected $area_id;
    protected $lc_id;
    protected $target_values;

    protected $area_query = 'select * from areas';
    protected $kpi_query = 'select * from kpis where area = ';

    /**
     *
     * @param <type> $dbutil
     * @param <type> $term_id
     * @param <type> $area_id
     * @param <type> $user 
     */
    function __construct( $dbutil, $term_id, $area_id, $user ) {
        $this->dbutil = $dbutil;
        $this->term_id = $term_id;
        $this->quarter_id = $area_id;

        $lc = new LC($dbutil->dbres);
        $this->lc_id = $lc->get_lc_by_name($user);

        $this->target_values = new Tracking($dbutil);

    }

    /**
     *
     * @return <type>
     */
    function get_area_list() {
        $query = $this->area_query;
	$rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     *
     * @param <type> $area_id
     * @return <type> 
     */
    function get_kpis ($area_id ) {
        $query = $this->kpi_query
            . $this->dbutil->escape($area_id);
	$rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     *
     * @param <type> $area_id
     * @param <type> $area_name
     * @param <type> $area_desc 
     */
    protected function get_form_content_row( $area_id, $area_name, $area_desc ) {
        echo '<li>';
        echo "\n";
        echo "<span title=\"$area_desc\">$area_name</span>: ";
        $actual = $this->target_values->get_actual(
            $this->lc_id, $this->term_id, $area_id
        );

        echo '<input name="'
            . $this->lc_id . '-'
            . $this->term_id . '-'
            . $area_id .'" value="' . $actual . '">';
        echo "\n";
        echo '</li>';
        echo "\n";
    }

    /**
     * generates html form content for Use Case Planning
     */
    function get_form_content() {
        $area_list = $this->get_area_list();

        echo "<ul>\n";
        foreach( $area_list as $row ) {
            $area_id = $row['id'];
            $area_name = $row['name'];
            $area_desc = $row[description];
            $this->get_form_content_row( $area_id, $area_name, $area_desc );
        }
        echo "</ul>\n";
    }

    /**
     *
     * @param <type> $tokens
     * @param <type> $value 
     */
    protected function set_values($tokens, $value ) {
        $this->target_values->set_actual(
            $tokens[1], $tokens[2],
            $tokens[3], $value);
    }

    /**
     * parse values and insert/update rows in Tracking table
     * @param <type> $post HTTP POST request
     */
    function submit( $post ) {
        foreach( $post as $key => $value ) {
        // $tokens = array();
            if( preg_match('/^(\d)-(\d)-(\d)$/', $key, $tokens) ) {
                if( $value > 0 ) {
                    $this->set_values($tokens, $value);
                }
            }
        }
    }
}

?>
