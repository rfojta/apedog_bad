<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

if( isset($_REQUEST['what'] )) {
    $what = $_REQUEST['what'];
    $_SESSION['what'] = $what;
    header('Location: ' . $_SERVER['PHP_SELF']);
    break;
} elseif( isset($_SESSION['what'] )) {
    $what = $_SESSION['what'];
}

$filename ="administration/".$what."_conf.php";

$conf_items = array('area', 'kpi', 'term', 'quarter', 'user', 'lc');

foreach( $conf_items as $c ) {
    echo "<a href=\"admin.php?what=$c\">$c</a>|\n";
}

if( file_exists($filename)) {
    include($filename);
} else {
    echo "No page found for $what";
}
?>
