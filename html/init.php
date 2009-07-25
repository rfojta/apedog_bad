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


$apedog = new Apedog('devel');
$dbres = $apedog->dbres;

$term = new Term($dbres);

$current_term = $term->get_current_term();
if( isset($_REQUEST['term_id']) ) {
    $current_term = $_REQUEST['term_id'];
}

$terms = $term->get_term_labels();
?>
