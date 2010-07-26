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
    
    function __construct($dbutil, $csfs, $user) {
        $this->dbutil = $dbutil;
        $this->csfs = $csfs;
        $this->user = $user;
    }
    
    /**
     * generates html table from strategy,
     * operations, actions and responsible
     */
    function get_form_content() {
        $select = "select s.name strategy, sa.name action "
            . "from bsc_strategy s join bsc_strategic_action sa on (sa.strategy = s.id) "
            . " where s.csfs = " . $this->csfs;
        $rows = $this->dbutil->process_query_assoc($select);
        echo "<table><tr>";
        foreach( $rows[0] as $key => $value ) {
            echo "<th>" . htmlspecialchars($key) . "</th>";
        }
        echo "</tr>\n";
        foreach( $rows as $row ) {
            echo "<tr>";
            foreach( $row as $key => $value ) {
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
