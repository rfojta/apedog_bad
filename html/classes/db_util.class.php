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

    function  __construct( $dbres, $debug = 0 ) {
        $this->dbres = $dbres;
        $this->debug = $debug;
    }

    function error($query) {
        echo( 'Invalid query: ' . $query . ' ' . mysql_error($this->dbres) );
    }


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

    function do_query($query) {
        if( $this->debug ) {
            echo "<pre>$query</pre>";
        }
        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
		$this->error($query);
        }
    }

    function get_columns($table) {
        $query = "show columns from $table";
        return $this->process_query_assoc($query);
    }

    function escape($item) {
        return mysql_real_escape_string($item, $this->dbres);
    }

}
?>
