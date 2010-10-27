<?php

foreach ($countries as $country) {
    echo 'Country: ' . $country['Code'] . '
        Users: ';
    $apedog = new Apedog($country['Code']);
    $dbres = $apedog->dbres;

    $dbutil = new DB_Util($apedog->dbres);

    $reminder = new Reminder($dbutil);
    $reminder->check_tracking();
    $reminder->check_actions();
}
?>

