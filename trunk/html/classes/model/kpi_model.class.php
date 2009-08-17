<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of kpi_modelclass
 *
 * @author Richard
 */
class KpiModel extends GenericModel {

    protected $table_name = 'kpis';
    //put your code here

    protected $kpi_query = 'select * from kpis where area = ';
    protected $editable_fields = array('name', 
        'description', 'area', 'csf', 'kpi_unit',
        'graphs', 'end_of_term');

    /**
     * Call query to find kpis by area. Deprecated, use find_by instead
     * @param <type> $area area id
     * @return <type> rows
     */
    public function find_by_area( $area ) {
        $query = $this->kpi_query . $area;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

    /**
     * Generates associative array with default values for each item
     * @return <type>
     */
    public function new_item_row() {
        return array(
        'id' => 'new',
        'name' => 'new',
        'description' => 'create new item',
        'area' => '',
        'csf' => '',
        'kpi_unit' => ''
        );
    }

    /**
     * Return string for specified row
     * @param <type> $row
     * @return <type> 
     */
    public function get_row_label( $row ) {
        return $row['name'];
    }
}
?>
