<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Apedog
 * Main apedog class. Encapsulates configuration and database connection.
 *
 * @author Richard
 */
class Apedog {
    var $version = '1.0';
    var $dbres;

    function db_connect( $configuration ) {
        $this->dbres = mysql_connect(
            $configuration['server'],
            $configuration['user'],
            $configuration['password']
        );

        if (!$this->dbres) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db($configuration['database'], $this->dbres);

        // mysql_set_charset('utf8');
        mysql_query("SET NAMES 'utf8");
        mysql_query("SET CHARACTER SET 'utf8'");
    }

    //put your code here
    function Apedog($environment) {
        $configuration = array();
        
        if( $environment == 'prod' ) {
            $configuration = array(
                server => 'localhost',
                user => 'root',
                password => '',
                database => 'apedog'
            );
        } else if ($environment == 'Czech Republic') {
            $configuration = array(
                server => 'localhost',
                user => 'root',
                password => '',
                database => 'apedog'
            );
        } else {
            $configuration = array(
                server => 'localhost',
                user => 'root',
                password => '',
                database => 'apedo'
            ); 
        }
        $this->db_connect( $configuration );
    }

    function db_link() {
        return $this->dbres;
    }
}
?>
