<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parent_viewclass
 *
 * @author Richard
 */
class ParentView {
    //put your code here
    protected $parent_conf;
    protected $name;
    protected $controller;

    function  __construct($name, $conf, $controller) {
        $this->name = $name;
        $this->parent_conf = $conf;
        $this->controller = $controller;
    }


      /**
     * View<br>
     * Generates list box for editing parent object
     * @param <type> $id
     * @param <type> $selected
     */
    public function parent_list($key, $id, $selected) {
	$p_conf = $this->parent_conf; //[$key];
        $descr = $p_conf['descr'];
        $pname = $p_conf['name'];
        $p_ctrl = $p_conf['controller'];

        $name = $this->name;
        echo "<span title=\"select superior $pname for this $name\">$pname: </span>";
        if( isset( $this->request[$pname]) ) {
            $p_ctrl->get_list_box($id, $this->request[$pname]);
            $this->get_delete_checkbox();
        } else {
            $p_ctrl->get_list_box($id, $selected);
        }
        if( $selected > 0 ) {
            $link = $this->parent_conf['link'];
            echo "(<a href=\"$link&id=$selected\">"
                . $p_ctrl->get_label($selected) ."</a>)<br>";
        }
    }
}
?>
