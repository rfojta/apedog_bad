<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of child_view
 *
 * @author Richard
 */
class ChildView {
//put your code here

    protected $child_conf;
    protected $name;
    protected $controller;

    function  __construct($name, $conf, $controller) {
        $this->name = $name;
        $this->child_conf = $conf;
        $this->controller = $controller;
    }

      /**
     * View<br>
     * Display list of child objects for current item
     * @param <type> $id row id
     */
    public function child_list($id) {
        $name = $this->name;
        $chname = $this->child_conf['name'];
        $chlink = $this->child_conf['link'];
        $chmodel = $this->child_conf['model'];
        echo "<hr>";
        echo $chname . "s for this $name:&nbsp;";
        echo "<a href=\"$chlink&id=new&$name=$id\">Add new</a>";
        echo "<br>";

        $rows = $this->child_rows($id);

        echo "<ul>\n";
        foreach( $rows as $row ) {
            echo "<li><a href=\"$chlink&id=" . $row[id] . "\">";
            echo $chmodel->get_row_label($row);
            echo "</a></li>";
        }
        echo "</ul>\n";
    }

    protected function child_rows($id) {
        return $this->controller->child_rows($id);
    }
}
?>
