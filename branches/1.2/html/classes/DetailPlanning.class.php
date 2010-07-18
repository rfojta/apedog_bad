<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Planning
 *
 * @author Richard, Krystof
 */
class DetailPlanning {
    protected $dbutil;

    protected $term_id;
    protected $quarter_id;
    protected $area_id;
    protected $lc_id;
    protected $this_page;
    protected $target_values;
    protected $locking;

    protected $area_query = 'select * from areas';
    protected $quarter_query = 'select * from quarters where term = ';
    protected $kpi_query = 'select distinct k.* from lc_kpi l join kpis k on l.kpi = k.id';
    protected $term_query = 'select * from terms';
    protected $kpi_unit_query = 'select * from kpi_units';

/**
 * Constructor
 * @param <type> $dbutil Library for working with db
 * @param <type> $term_id Id of actual term for the page
 * @param <type> $current_area area id for the page
 * @param <type> $user either user or 'all'
 * @param <type> $locking actual locking library
 */
    function __construct( $dbutil, $term_id, $current_area, $user, $locking ) {
        $this->dbutil = $dbutil;
        $this->term_id = $term_id;
        $this->area_id = $current_area;
        $this->page = 'detail_planning.php?';
        $this->locking = $locking;

        $lc = new LC($dbutil->dbres);
        $this->lc_id = $lc->get_lc_by_name($user);

        $this->target_values = new DetailTracking($dbutil);

    }

/**
 * Function that returns list of all areas in db
 * @return <type>
 */
    function get_area_list() {
        $query = $this->area_query;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

/**
 * Builds HTML code for KPI row with KPI name, description and input field
 * @param <type> $kpi KPI for the row
 * @param <type> $i integer for changing colors of row
 */
    protected function get_kpi_input($kpi, $i) {
        $kpi_id = $kpi['id'];
        $quarter_id = $this->quarter_id;
        $lc_id = $this->lc_id;
        $value='';
        if ($quarter_id!=null) {
            $value = $this->target_values
                ->get_value($lc_id, $quarter_id, $kpi_id);
        }

        echo "<tr class='kpiRow".$i."'> \n";
        echo "<td width='99%'> \n";
        echo '<span title="' . $kpi['description'] . '">'
            . $kpi['name'] . ':</span>';
        echo "</td> \n";
        echo "<td> \n";
        $unit_spec = $this->get_kpi_unit_rf($kpi_id);
        $unit=$this->get_kpi_unit($kpi['kpi_unit']);
        if( $unit_spec == 'boolean') {
            $this->get_boolean_input($kpi_id, $value);
        } else {
            echo "<input name=\"kpi-$kpi_id\"";
            if ($this->locking->get_count($this->lc_id, 'NULL', $this->term_id)) {
                echo ' disabled ';
            }
            echo "value=\"$value\" />";
        }
        echo "<td style='background-color: #FFFFFF'>";
        echo $unit['name'];
        echo "</td>";
        echo "</td> \n";
        echo "</tr> \n";
        echo "</li> \n";
    }

    /**
     * Richard's function for getting spec of kpi unit of KPI
     * @param <type> $kpi actual kpi
     * @return <type> spec
     */
    protected function get_kpi_unit_rf( $kpi ) {
        $query = "select spec 
            from kpi_units ku join kpis k on k.kpi_unit = ku.id
            where k.id = $kpi";
        
        $rows = $this->dbutil->process_query_assoc( $query );

        return $rows[0]['spec'];
    }
/**
 * Builds dropdown yes/no input
 * @param <type> $id id of kpi
 * @param <type> $value selected/not selected
 */
    protected function get_boolean_input( $id, $value ) {
        echo "<select name=\"kpi-$id\" ";
        if ($this->locking->get_count($this->lc_id, 'NULL', $this->term_id)) {
                echo ' disabled ';
            }
        echo ">\n";
        echo "<option value=\"1\" ";
        if( $value == '1' ) {
            echo "selected=\"true\"";
        }
        echo ">Yes</option>\n";
        echo "<option value=\"0\"";
        if( $value != '1' ) {
            echo "selected=\"true\"";
        }
        echo ">No</option>\n";
        echo "</select>\n<br>\n";
    }

/**
 * Builds area dropdown input from area list
 * @param <type> $area_list
 */
    protected function get_area_section( $area_list ) {
        echo "Select area: \n";
        echo "<select name=\"area_id\" id=\"area_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."term_id=".$this->term_id
            ."&quarter_id=".$this->quarter_id."&area_id='+this.value\">\n";
        echo "<option value=\"all\"";
        if( isset($_REQUEST['area_id']) ) {
            if('all' == $_REQUEST['area_id']) {
                $this->area_id='all';
                echo " selected ";
            }
        }
        echo ">";
        echo 'All';
        echo "</option>\n";

        foreach( $area_list as $area ) {
            echo "<option value=\"".$area['id']."\"";
            if( isset($_REQUEST['area_id']) ) {
                if( $area['id'] == $_REQUEST['area_id']) {
                    $this->area_id=$area['id'];
                    echo " selected ";
                }
            }

            echo ">";
            echo $area['name'];
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    /**
     * Basic function of this class which builds all parts of planning
     *  and put them together
     */
    function get_form_content() {
        $term_list = $this->get_term_list();

        $quarter_list = $this->get_quarter_list($this->term_id);
        $area_list = $this->get_area_list();
        $kpi_list = $this->get_kpi_list($this->area_id);



        $this->get_term_section($term_list);
        $this->get_quarter_section($quarter_list);
        echo '&nbsp;&nbsp;&nbsp;';
        $this->get_area_section($area_list);

        echo "<p>";
        $this->get_locked_echo();
        echo "<table class='detailTable'>";
        $i=0;
        foreach( $kpi_list as $kpi ) {
            $this->get_kpi_input( $kpi, $i);
            $i++;
            if($i>5) {
                $i = 0;
            }
        }
        echo "</table>";
        echo "</p>";

        $this->get_submit_button();
    }

/**
 * Function is calling dbutil and sets values
 * @param <type> $kpi id
 * @param <type> $quarter id
 * @param <type> $value value
 */
    protected function set_values($kpi,$quarter, $value ) {
        $this->target_values->set_value(
            $this->lc_id,
            $quarter,
            $kpi[1],
            $value
        );
    }

/**
 * Function determines post and call set function with proper values
 * @param <type> $post
 */
    function submit( $post ) {
        $quarter;
        $rec;
        $kpi=array();
        foreach( $post as $key => $value ) {
        // $tokens = array();
            if( $key=='quarter_id') {
                $quarter=$value;
            }

            if( preg_match('/^kpi-(\d+)$/', $key, $tokens) ) {

                if( isset($value) && $value != "" && $quarter!=null ) {
                    $kpi=$tokens;
                    $this->set_values($kpi,$quarter,$value);
                }
            }
        }
    }

/**
 *Returns term list ordered by number of term
 * @return <type> terms rows
 */
    function get_term_list() {
        $query = $this->term_query . ' ORDER BY `term_from`';
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

/**
 * Returns quarter list depending on actual/chosen term ordered by order in term
 * @param <type> $term_id
 * @return <type>
 */
    function get_quarter_list($term_id) {
        $query = $this->quarter_query . $term_id . ' ORDER BY `quarter_from`';
        $rows = $this->dbutil->process_query_assoc($query);
        $this->quarter_id=$rows[0]['id'];
        return $rows;
    }

/**
 *Builds term dropdown menu from term list
 * @param <type> $term_list
 */
    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."area_id=".$this->area_id."&term_id='+this.value\">\n";

        foreach( $term_list as $term ) {
            echo "<option value=\"".$term['id']."\"";
            if( isset($_REQUEST['term_id']) ) {
                if( $term['id'] == $_REQUEST['term_id']) {
                    $this->term_id=$term['id'];
                    echo " selected ";
                }
            } else if ($term['id']==$this->term_id) {
                    echo " selected";
                }

            echo ">";
            echo date('Y', strtotime($term['term_from'])).'/'.date('Y', strtotime($term['term_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

/**
 * Builds quarter dropdown menu from quarter list
 * @param <type> $quarter_list
 */
    function get_quarter_section($quarter_list) {
        echo "Select quarter: \n";
        echo "<select name=\"quarter_id\" id=\"quarter_id\"\n";
        echo "onchange=\"window.location.href='".$this->page."area_id=".$this->area_id."&term_id=".$this->term_id."&quarter_id='+this.value\">\n";

        foreach( $quarter_list as $quarter ) {
            echo "<option value=\"".$quarter['id']."\"";
            if( isset($_REQUEST['quarter_id']) ) {
                if( $quarter['id'] == $_REQUEST['quarter_id']) {
                    $this->quarter_id=$quarter['id'];
                    echo " selected ";
                }
            }

            echo ">";
            echo date('j.n.Y', strtotime($quarter['quarter_from'])).'-'.date('j.n.Y', strtotime($quarter['quarter_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

/**
 * Returns kpis either depending on chosen area or all
 * @param <type> $area_id
 * @return <type>
 */
    function get_kpi_list($area_id) {
        if ($area_id!='all') {
            $query = $this->kpi_query . " where area = " . $this->dbutil->escape($area_id);
        }  else {
            $query = $this->kpi_query.' and l.lc = '.$this->lc_id;
        }
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows;
    }

/**
 * Builds submit button, that could be disabled when planning is locked
 */
    function get_submit_button() {
        echo '<p>';
        echo '<input type="hidden" name="posted" value="1" />';
        echo '<input type=submit';
        if ($this->locking->get_count($this->lc_id, 'NULL', $this->term_id)!=0) {
            echo ' disabled';
        }
        echo ' value="Save" />';
        echo '</p>';
    }
/**
 * Returns Locked echo when planning is disabled
 */
    function get_locked_echo() {
        if ($this->locking->get_count($this->lc_id, 'NULL', $this->term_id)) {
            echo '<p><b>Your planning for this period has been locked by MC.</b></p>';
        }
    }
/**
 *Returns KPI unit name from unit id
 * @param <type> $unit_id
 * @return <type>
 */
    function get_kpi_unit($unit_id){
        $query = $this->kpi_unit_query . ' WHERE `id` = '.$unit_id;
        $rows = $this->dbutil->process_query_assoc($query);
        return $rows[0];
    }
}

?>
