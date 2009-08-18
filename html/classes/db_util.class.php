<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db_utilclass
 *
 * @author Richard
 */
class DB_Util {
//put your code here
    public $dbres;
    protected $debug;

    /**
     * Initialize DB utility class for mysql database
     * @param <type> $dbres mysql db resourse
     * @param <boolean> $debug true or false for debugging
     */
    function  __construct( $dbres, $debug = 0 ) {
        $this->dbres = $dbres;
        $this->debug = $debug;
    }

    /**
     * shows an error on screen
     * @param <type> $query source query of error
     */
    function error($query) {
        echo( 'Invalid query: ' . $query . ' ' . mysql_error($this->dbres) );
    }


    /**
     * return associative array for all rows returned by query
     * @param <type> $query
     * @return <type> array of rows
     */
    function process_query_assoc($query) {
        if( $this->debug ) {
            echo "<pre>$query</pre>";
        }
        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
		$this->error($query);
        }

        $out_array = array();

        while( $row = mysql_fetch_assoc($res) ) {
            $out_array[] = $row;
        }

        return $out_array;
    }

    /**
     * return number indexed array for all rows returned by query
     * @param <type> $query
     * @return <type> 
     */
    function process_query_array($query) {
        if( $this->debug ) {
            echo "<pre>$query</pre>";
        }
        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
		$this->error($query);
        }

        $out_array = array();

        while( $row = mysql_fetch_row($res) ) {
            $out_array[] = $row;
        }

        return $out_array;
    }

    /**
     * Call insert, update or delete query, no results expected
     * @param <type> $query 
     */
    function do_query($query) {
        if( $this->debug ) {
            echo "<pre>$query</pre>";
        }
        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
		$this->error($query);
        }
    }

    /**
     * return list of columns for specified table
     * @param <type> $table
     * @return <type> 
     */
    function get_columns($table) {
        $query = "show columns from $table";
        return $this->process_query_assoc($query);
    }

    /**
     * escape string parameter
     * @param <type> $item
     * @return <type> 
     */
    function escape($item, $type = null) {
        if( $type == null ) {
            return mysql_real_escape_string($item, $this->dbres);
        }
        error_log("escape('$item', '$type')");
        $escaped = '';
        if( strtolower($type) == 'double') {
            $escaped = str_replace(',','.', $item);
        }
        elseif( substr(strtolower($type), 0, 7) == 'varchar' ) {
            $escaped = mysql_real_escape_string($item, $this->dbres);
        }
        else {
            $escaped = $item;
        }
        return $escaped;
    }

}
?>
