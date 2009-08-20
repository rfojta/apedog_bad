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

        $rows = $this->link_model->find_by( $from_name, $from_key );
        $model = $this->models[$from_name];

        $other_name = $this->get_other_name( $from_name );
        $other_model = $this->models[$other_name];


        echo "<select multi name=\"$from_name\">";
        foreach( $rows as $row ) {
            $target_row = $other_model->find( $row[$other_name] );
            echo '<option value="';
            echo $row[$other_name];
            echo '">';
            echo $model->get_label( $target_row );
            echo "</option>";
        }
        echo "</select>";

    }
}
?>
