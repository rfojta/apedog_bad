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

    function  __construct($model, $lc) {
        parent::__construct($model, array(
                'name' => 'user',
                'parent' => array(
                    'name' => 'lc',
                    'controller' => $lc,
                    'link' => 'admin.php?what=lc'
                )
            ));
        $this->lc = $lc;
        $this->lc_link = 'admin.php?what=lc';
    }
}
?>
