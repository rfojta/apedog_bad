<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Term
 *
 * @author Richard
 */
class Term {
    private $dbres;
    private $term_query = 'select * from terms';
    private $current_term_query =
    'select id from terms
         where term_to   > current_date()
           and term_from < current_date()';

    private $term_labels_query =
    'select id, CONCAT_WS(\' - \',
        date_format(term_from,\'%e.%m.%Y\'),
        date_format(term_to  ,\'%e.%m.%Y\'))
     from terms';

    //put your code here

    function Term( $dbres ) {
        $this->dbres = $dbres;
    }

    function get_current_term() {
        $query = $this->current_term_query;

        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
            die( 'Invalid query: ' . mysql_error($this->dbres) );
        }

        $out_array = array();

        while( $row = mysql_fetch_assoc($res) ) {
            $out_array[] = $row;
        }

        return $out_array[0]['id'];
    }

    function get_term_labels() {
        $query = $this->term_labels_query;

        $res = mysql_query( $query, $this->dbres );
        if( !$res ) {
            die( 'Invalid query: ' . mysql_error($this->dbres) );
        }

        $out_array = array();

        while( $row = mysql_fetch_row($res) ) {
            $out_array[] = $row;
        }

        return $out_array;
    }
}
?>
