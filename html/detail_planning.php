<?php
include('init.php');
include('classes/DetailPlanning.class.php');
include('classes/DetailTracking.class.php');

$controller = new DetailPlanning($dbutil, $current_term, $_SESSION['user']);

$page = 'planning';
$page_title = "Apedog: Detail Planning";
$page_help = "<h3>Planning</h3>
  <p>At the beginning of a term,
  you can enter here values of your KPIs.
  Then it will be locked.</p>";

include('components/basic_form.php');
?>