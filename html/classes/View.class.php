<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View - view of bsc excel structure
 *
 * @author rf
 */
class BSC_View {
    //put your code here
    private $dbutil;
    private $csfs;
    private $user;
    private $query;
    
    function __construct($dbutil, $csfs, $user) {
        $this->dbutil = $dbutil;
        $this->csfs = $csfs;
        $this->user = $user;
        $this->query = "select s.name strategy, sa.name action, "
            . " o.name operation, r.name responsible, o.when, o.status"
            . " from bsc_strategy s join bsc_strategic_action sa on (sa.strategy = s.id) "
            . " join bsc_operations o on (o.strategic_action = sa.id) "
            . " join bsc_responsible r on (o.responsible = r.id) "
            . " where s.csfs = ";
    }
    
    /**
     * generates html table from strategy,
     * operations, actions and responsible
     */
    function get_form_content() {
        $select = $this->query . $this->csfs;
        $rows = $this->dbutil->process_query_assoc($select);
        echo "<table class=\"view\"><tr>";
        foreach( $rows[0] as $key => $value ) {
            echo "<th>" . htmlspecialchars($key) . "</th>";
        }
        echo "</tr>\n";
        foreach( $rows as $row ) {
            echo "<tr>";
            foreach( $row as $key => $value ) {
                if( $key == 'status') {
                    echo "<td><input type=checkbox "
                    . (($value == 1) ? "checked=\"checked\"" : "") . "/></td>";
                }
                else
                    echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    }

    /**
     * handle status changes
     */
    function submit($post) {
        echo "";
    }

    /**
     * print simple help
     */
    function get_help() {
       echo  "Columns: strategy, action, operation, responsible, deadline and status";
    }

}
?>
