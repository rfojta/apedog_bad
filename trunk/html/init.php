<?php
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$info = $_SESSION['user'];
$lc = $_SESSION['user'];

include('classes/Apedog.class.php');
include('classes/Results.class.php');
include('classes/DetailPlanning.class.php');
include('classes/Locking.class.php');
include('classes/DetailTracking.class.php');
include('classes/Entering.class.php');
include('classes/LockEntering.class.php');
include('classes/LockPlanning.class.php');
include('classes/Term.class.php');
include('classes/LC.class.php');
include('classes/Tracking.class.php');
include('classes/Report.class.php');
include('classes/db_util.class.php');
include('classes/Reminder.class.php');
include('classes/LcKPIs.class.php');
include('classes/Graphs.class.php');
include('classes/SumLogic.class.php');

include_once('classes/model/generic_model.class.php');
include_once('classes/controller/generic_controller.class.php');
include_once('classes/view/view_controller.class.php');

foreach( glob('classes/model/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}

foreach( glob('classes/charts/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}

foreach( glob('classes/controller/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}

foreach( glob('classes/view/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}



$apedog = new Apedog('devel');
$dbres = $apedog->dbres;

$dbutil = new DB_Util($apedog->dbres);

$locking = new Locking($dbutil);

$term = new Term($dbres);

$current_term = $term->get_current_term();
if( isset($_REQUEST['term_id']) ) {
    $current_term = $_REQUEST['term_id'];
}

$quarter_in_term = 1;
if( isset($_REQUEST['quarter_in_term']) ) {
    $quarter_in_term = $_REQUEST['quarter_in_term'];
}

//end of a term
$eot = null;
if( isset($_REQUEST['eot']) ) {
    $eot = $_REQUEST['eot'];
}

$custom = null;
if( isset($_REQUEST['custom']) ) {
    $custom = $_REQUEST['custom'];
}

$current_area = 'all';
if( isset($_REQUEST['area_id']) ) {
    $current_area = $_REQUEST['area_id'];
}

$kpi_id = null;
if (isset($_REQUEST['kpi_id'])){
    $kpi_id = $_REQUEST['kpi_id'];
}

$terms = $term->get_term_labels();
?>
