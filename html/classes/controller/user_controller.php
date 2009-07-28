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

    protected $lc;
    protected $lc_link = 'lc_conf.php';

    function  __construct($model, $lc) {
        parent::__construct($model);
        $this->lc = $lc;
    }

    protected function get_row_label( $row ) {
        return $row['login'] . " - " . $row['lc'];
    }

    private function lc_list($id, $selected) {
        $a = $this->lc;
        echo "<span title=\"select superior LC for this User\">LC: </span>";
        if( isset( $this->request['lc']) ) {
            $a->get_list_box($id, $this->request['lc']);

        } else {
            $a->get_list_box($id, $selected);
        }
        if( $selected > 0 ) {
            $link = $this->lc_link;
            echo "(<a href=\"$link?id=$selected\">". $a->get_label($selected) ."</a>)<br>";
        }
    }

    protected function edit_item_row($id, $key, $value) {
        if( $key == 'lc') {
            $this->lc_list($id, $value);
        } else {
            parent::edit_item_row($id, $key, $value);
        }
    }
}
?>
