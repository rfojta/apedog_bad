<?php
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$info = $_SESSION['user'];
$lc = $_SESSION['user'];

include('classes/Apedog.class.php');
include('classes/Planning.class.php');
include('classes/Entering.class.php');
include('classes/Term.class.php');
include('classes/LC.class.php');
include('classes/Tracking.class.php');
include('classes/Report.class.php');
include('classes/db_util.class.php');

include_once('classes/model/generic_model.class.php');
include_once('classes/controller/generic_controller.class.php');

foreach( glob('classes/model/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}

foreach( glob('classes/controller/*.php') as $php_class ) {
    // echo "$php_class<br>\n";
    include_once($php_class);
}



$apedog = new Apedog('devel');
$dbres = $apedog->dbres;

$dbutil = new DB_Util($apedog->dbres);

$term = new Term($dbres);

$current_term = $term->get_current_term();
if( isset($_REQUEST['term_id']) ) {
    $current_term = $_REQUEST['term_id'];
}

$terms = $term->get_term_labels();
?>
