<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of generic_viewclass
 *
 * @author Richard
 */
class generic_view {
    //put your code here

    protected $model;
    protected $name;
    protected $context;
    protected $controller;

    function  __construct($name, $model, $context, $controller) {
        $this->controller = $controller;
        $this->context = $context;
        $this->model = $model;
        $this->name = $name;
    }
}
?>
