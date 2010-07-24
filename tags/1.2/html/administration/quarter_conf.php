<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

$model = new QuarterModel($dbutil);
$term_model = new TermModel($dbutil);

$controller = new TermController($term_model, $model);

$page_title = "Apedog: Quarter Configuration";
$page_help = "
<h3>$page_title</h3>
<p>you can add, modify, remove Quarter or Terms</p>
<p>Each Quarter belongs to one Term</p>
";
include('components/basic_form.php');

?>
