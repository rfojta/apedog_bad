<?php
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$info = $_SESSION['user'];
$lc = $_SESSION['user'];

include('classes/Apedog.class');
include('classes/Planning.class');
include('classes/Entering.class');
include('classes/Term.class');
include('classes/LC.class');
include('classes/Tracking.class');
include('classes/Report.class');


$apedog = new Apedog('devel');
$dbres = $apedog->dbres;

$term = new Term($dbres);

$current_term = $term->get_current_term();
if( isset($_REQUEST['term_id']) ) {
    $current_term = $_REQUEST['term_id'];
}

$terms = $term->get_term_labels();
?>
