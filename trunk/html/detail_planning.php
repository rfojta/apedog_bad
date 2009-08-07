<?php
include('init.php');

$controller = new DetailPlanning($dbutil, $current_term, $current_area, $_SESSION['user'], $locking);

$page = 'planning';
$page_title = "Apedog: Planning";
$page_help = "<h3>Planning</h3>
  <p>At the beginning of a term,
  you can enter here values of your KPIs.
  Then it will be locked.</p>";

include('components/basic_form.php');
?>
