<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

$model = new TermModel($dbutil);
$child_model = new QuarterModel($dbutil);
$controller = new TermController($model, $child_model);

if( isset( $_POST['posted'])) {
    $controller->submit( $_POST );
}

$page_title = "Apedog: Term Configuration";
$page_help = "
<h3>$page_title</h3>
<p>you can add, modify, remove Term or Quarters</p>
<p>Each Quarter belongs to one Term</p>
";
include('components/basic_form.php');

?>
