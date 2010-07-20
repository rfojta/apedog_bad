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

        $model = new CsfModel($this->dbutil);
        $business_perspectiveModel = new Business_PerspectiveModel($this->dbutil);
        $business_perspectiveController = new Business_PerspectiveController($business_perspectiveModel,$model);
        $csf = new CsfController($model, $business_perspectiveController, $kpi_model);

        // multi link
        $lckpi = new LcKpiModel($this->dbutil);
        $lc_model = new LcModel($this->dbutil);

        $this->controller = new KpiController($kpi_model, $area, $csf,
            $this->kpi_unit_controller(), $lckpi, $lc_model);

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

        $this->page_title = "Apedog: Term Configuration";
        $this->page_help = "<h3>$this->page_title</h3>
<p>you can add, modify, remove Quarter or Terms</p>
<p>Each Quarter belongs to one Term</p>
<p>You must have term for
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

    function business_perspective() {
        $model = new Business_PerspectiveModel($this->dbutil);
        $csf_model = new CsfModel($this->dbutil);

        $this->controller = new Business_PerspectiveController($model,$csf_model);
        $this->page_title = "Apedog: Business Perspective Configuration";
        $this->page_help = "<h3>$this->page_title</h3>
<p>you can add, modify, remove Business Perspective or Critical Success Factors</p>
<p>Each CSF belongs to one Business Perspective</p>
            ";
    }

    function csf() {
        $model = new CsfModel($this->dbutil);
        $business_perspectiveModel = new Business_PerspectiveModel($this->dbutil);

        $business_perspectiveController = new Business_PerspectiveController($business_perspectiveModel,$model);
        $kpi_model = new KpiModel($this->dbutil);
        $this->controller = new CsfController($model, $business_perspectiveController, $kpi_model);
        $this->page_title = "Apedog: Critical Success factors configuration";
        $this->page_help = "
        <h3>$this->page_title</h3>
        <p>you can add, modify, remove Business Perspective or Critical Success Factors</p>
        <p>Each CSF belongs to one Business Perspective</p>
            ";
    }

    private function kpi_unit_controller() {
        $model = new KpiUnitModel($this->dbutil);
        $kpi_model = new KpiModel($this->dbutil);
        return new KpiUnitController($model, $kpi_model);
    }

    private function get_bp_controller() {
        $model = new Business_PerspectiveModel($this->dbutil);
        $csf_model = new CsfModel($this->dbutil);
        $controller = new Business_PerspectiveController($model, $csf_model);
        return $controller;
    }

    function kpi_unit() {
        $this->controller = $this->kpi_unit_controller();
        $this->page_title = "Apedog: KPI Units configuration";
        $this->page_help = "
        <h3>$this->page_title</h3>
        <p>you can add, modify, remove KPI unit</p>
        <p>Each KPI belongs to one KPI unit</p>
        <p>Insert spec 'boolean' for Yes/no options in planning and entering</p>
            ";

    }
}
?>
