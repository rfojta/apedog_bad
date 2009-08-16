<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }

if( isset($_REQUEST['what'] )) {
    $what = $_REQUEST['what'];
    $_SESSION['what'] = $what;
    session_write_close();
} elseif( isset($_SESSION['what'] )) {
    $what = $_SESSION['what'];
}

include('init.php');
include_once('classes/controller/admin.class.php');

$admin = new Admin($dbutil);


$conf_items = array('area', 'kpi', 'term', 'quarter', 'user', 'lc', 'business_perspective', 'csf');
$conf_items[] = 'kpi_unit';

echo "<div style=\"float:left\">";
foreach( $conf_items as $c ) {
    echo "<a href=\"admin.php?what=$c\">$c</a>|\n";
}
echo "</div>";

if( in_array($what, $conf_items)) {
    $admin->$what();
    $page = $admin->page;
    $page_help = $admin->page_help;
    $page_title = $admin->page_title;
    $controller = $admin->controller;
    include('components/basic_form.php');
}
?>
