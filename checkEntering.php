<?php

include(dirname(__FILE__) . '/classes/Apedog.class.php');
include(dirname(__FILE__) . '/classes/db_util.class.php');
include(dirname(__FILE__) . '/classes/Reminder.class.php');
$apedog = new Apedog(null);
    $dbres = mysql_connect(
            'mysql.praha.aiesec.cz',
            'qwerta',
            'testtest');
$dbutil = new DB_Util($apedog->dbres);
$country_query = 'SELECT * from countries order by name';
$countries = $dbutil->process_query_assoc($country_query);

foreach ($countries as $country) {
    echo "Country:".$country;
	$apedog = new Apedog($country['Code']);
    $dbres = $apedog->dbres;

    $dbutil = new DB_Util($apedog->dbres);

    $reminder = new Reminder($dbutil);
    $reminder->check_tracking();
}
?>
