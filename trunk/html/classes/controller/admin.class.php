<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminclass
 *
 * @author Richard
 */
class Admin {
//put your code here

    public $controller;
    public $page_title;
    public $page = 'configuration';
    public $page_help;
    
    protected $dbutil;

    function  __construct($dbutil) {
        $this->dbutil = $dbutil;
    }

    function area() {
        $area_model = new AreaModel($this->dbutil);
        $kpi_model = new KpiModel($this->dbutil);
        $this->controller = new AreaController($area_model, $kpi_model);

        $this->page_title = "Apedog: Area and KPI configuration";
        $this->page_help = "<h3>KPI Configuration</h3>
<p>you can add, modify, remove KPI or Area</p>
<p>Each KPI belongs to one Area</p>";
    }

    function kpi() {
        $area_model = new AreaModel($this->dbutil);
        $kpi_model = new KpiModel($this->dbutil);
        $area = new AreaController($area_model, $kpi_model);
        $this->controller = new KpiController($kpi_model, $area);

        $this->page_title = 'Apedog: KPI Configuration';
        $this->page_help = '
                    <h3>KPI Configuration</h3>
                    <p>you can add, modify, remove KPI or Area</p>
                    <p>Each KPI belongs to one Area</p>';

    }

    function user() {
    // initialize models
        $lc_model = new LcModel($this->dbutil);
        $user_model = new UserModel($this->dbutil);

        // initialize controllers
        $lc = new LcController($lc_model, $user_model);
        $this->controller = new UserController($user_model, $lc);

        $this->page_title = "Apedog: User Configuration";
        $this->page_help = "
<h3>$this->page_title</h3>
<p>you can add, modify, remove Users or LCs</p>
<p>Each User belongs to one LC</p>
            ";
    }

    function lc() {
        $model = new LcModel($this->dbutil);
        $user_model = new UserModel($this->dbutil);
        $this->controller = new LcController($model, $user_model);

        $this->page_title = "Apedog: LC Configuration";
        $this->page_help = "
<h3>$this->page_title</h3>
<p>you can add, modify, remove Users or LCs</p>
<p>Each User belongs to one LC</p>
            ";
    }

    function term() {
        $model = new QuarterModel($this->dbutil);
        $term_model = new TermModel($this->dbutil);

        $this->controller = new TermController($term_model, $model);
        
        $this->page_title = "Apedog: Quarter Configuration";
        $this->page_help = "<h3>$this->page_title</h3>
<p>you can add, modify, remove Quarter or Terms</p>
<p>Each Quarter belongs to one Term</p>
            ";
    }

    function quarter() {
        $model = new QuarterModel($this->dbutil);
        $term_model = new TermModel($this->dbutil);

        $term_controller = new TermController($term_model, $model);
        $this->controller = new QuarterController($model, $term_controller);

        $this->page_title = "Apedog: Quarter Configuration";
        $this->page_help = "
<h3>$this->page_title</h3>
<p>you can add, modify, remove Quarter or Terms</p>
<p>Each Quarter belongs to one Term</p>
            ";
    }
}
?>
