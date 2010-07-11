<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of multi_link_viewclass
 *
 * @author Richard
 */
class multi_link_view {
    //put your code here

    protected $models;
    /* example array( name => model )
     *      lc => lc_model
     *      kpi => kpi_model
     */
    protected $link_model; // model of link table with columns as names

    function  __construct($link_model, $models) {
        $this->models = $models;
        $this->link_model = $link_model;
    }

    private function get_other_name( $name ) {
        // names is contained as keys in $this->models
        $names = array_keys( $this->models );
        foreach( $names as $n ) {
            if ( $n != $name ) {
                return $n;
            }
        }
    }

    /**
     *
     * @param <type> $from_key
     * @param <type> $from_name
     * @param <type> $default
     */
    public function get_select_multi_for( $from_key, $from_name, $default ) {

        // load all rows from link table for from_key
        $selected_rows = array();
        $selected_hash = array();

        $other_name = $this->get_other_name( $from_name );

        if( is_numeric($from_key) ) {
            $selected_rows = $this->link_model->find_by( $from_name, $from_key );

            foreach( $selected_rows as $row ) {
               $selected_hash[$row[$other_name]] = 1; // mark selected
            }
        }

        $model = $this->models[$from_name];

        $other_model = $this->models[$other_name];

        $rows = $other_model->find_all();

        echo "<br>$other_name: ";
        echo "<select size=" . count($rows)
            . " multiple=\"1\" name=\"$from_key-$other_name"."[]\">";
        foreach( $rows as $row ) {
//            echo "<pre>";
//            print_r($row);
//            echo "</pre>";
            echo '<option value="';
            echo $row['id'];
            echo '"';
            // detect selected rows
            if( key_exists($row['id'], $selected_hash)) {
                echo 'selected="1"';
            }
            
            echo '>';
            echo $other_model->get_row_label($row);
            // echo $model->get_label( $target_row );
            echo "</option>";
        }
        echo "</select>";

    }
}
?>
