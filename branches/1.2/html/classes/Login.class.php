<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *
 * @author Richard
 */
class Login {
    var $dbres;
    var $user_query = 'select pass from users where login = ';
    var $user_count_query = 'select count(pass) from users where login = ';
    var $lc_query = 'select l.name from lcs l join users u on l.id = u.lc where u.login = ';

    /**
     *
     * @param resource database link
     */
    function Login($dbres) {
        $this->dbres = $dbres;
    }

    /**
     *
     * @param array $_POST global variable
     * @return array( code, message )
     */
    function validate($post) {
        if (isset($post['userid'])) {
        // check user exists
            $query = $this->user_count_query
                . '\''
                . mysql_real_escape_string($post['userid'])
                . '\'';

            $res = mysql_query( $query , $this->dbres );
            if (!$res) {
                die('Invalid query: ' . mysql_error());
            }

            $row = mysql_fetch_row($res);
            $count = $row[0];

            // each user should be in table Users just once.
            if( $count == 1 ) {
                $res = mysql_query( $this->user_query
                    . '\''
                    . mysql_real_escape_string($post['userid'])
                    . '\'' , $this->dbres
                );

                $row = mysql_fetch_row($res);
                $pass = $row[0];

                //more users from MC
                if( $pass == $post['userpass'] ) {
                    $query = $this->lc_query
                        . '\''
                        . mysql_real_escape_string($post['userid'])
                        . '\'';
                    $res = mysql_query( $query , $this->dbres );
                    if (!$res) {
                        die('Invalid query: ' . mysql_error());
                    }

                    $row = mysql_fetch_row($res);
                    return array(1,$row[0]);
                }
            }
            return array(2,'Wrong password or not existing user!');
        }
        return array(0,'Please login');
    }
}
?>
