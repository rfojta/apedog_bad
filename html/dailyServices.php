<?php
//prerequisities
include(dirname(__FILE__) . '/classes/Apedog.class.php');
include(dirname(__FILE__) . '/classes/db_util.class.php');
include(dirname(__FILE__) . '/classes/Reminder.class.php');
$apedog = new Apedog(null);
$dbutil = new DB_Util($apedog->dbres);
$country_query = 'SELECT * from countries order by name';
$countries = $dbutil->process_query_assoc($country_query);



//checking planning and entering and sending reminders via mail
echo '--- Check Planning and entering starts ---
    ';
include(dirname(__FILE__) . '/services/checkPlanningEntering.php');
echo '--- Check Planning and entering ends ---

';




//backup of dbs
echo '--- DBs backup start ---
    ';
include(dirname(__FILE__) . '/services/dbsBackup.php');
echo '--- DBS backup ends ---

';
?>
