<?php
include('init.php');

$reminder= new Reminder($dbutil);
$reminder->check_tracking();
?>
