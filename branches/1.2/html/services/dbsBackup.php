<?php

foreach ($countries as $country) {

    $dbname = 'apedog_' . $country['Code'];
    $backupFile = './backups/_'. $country['Code']. '/' . $dbname . date("Y-m-d-H-i-s") . '.sql';
    $command = "mysqldump --opt -uqwerta -ptesttest -h mysql.praha.aiesec.cz $dbname > $backupFile";

    $output = shell_exec($command);
    echo $output;

    if (file_exists($backupFile)) {
        echo $country['Code'] . '-OK
            ';
    }
}
?>

