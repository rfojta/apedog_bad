<?php
include('init.php');

$controller = new Entering($dbutil, $current_term,$current_area, $_SESSION['user'], $locking);

$page = 'planning';
$page_title = "Apedog: Entering values";
$page_help = "<h3>Entering values</h3>
  <p>Firstly choose period for which you want to enter value. Past and future
periods are locked. Then choose your area. Enter the value you achieved in KPI
and save it. You will be able to change the value until the end of actual time interval.</p>";

include('components/basic_form.php');
?>