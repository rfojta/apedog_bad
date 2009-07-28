<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_controller
 *
 * @author Richard
 */
class UserController extends GenericController {
    //put your code here

    protected function get_row_label( $row ) {
        return $row['login'] . " - " . $row['lc'];
    }
}
?>
