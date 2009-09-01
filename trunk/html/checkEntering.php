<?php
include(dirname(__FILE__).'/classes/Apedog.class.php');
include(dirname(__FILE__).'/classes/db_util.class.php');
include(dirname(__FILE__).'/classes/Reminder.class.php');

$apedog = new Apedog('devel');
$dbres = $apedog->dbres;

$dbutil = new DB_Util($apedog->dbres);

$reminder= new Reminder($dbutil);
$reminder->check_tracking();
?>
