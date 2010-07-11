<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
//ini_set('include_path',
//  ini_get('include_path') . PATH_SEPARATOR . '../');
//chdir('..');
include('init.php');

$area_model = new AreaModel($dbutil);
$kpi_model = new KpiModel($dbutil);
$controller = new AreaController($area_model, $kpi_model);

$page_title = "Apedog: Area and KPI configuration";
$page_help = "<h3>KPI Configuration</h3>
<p>you can add, modify, remove KPI or Area</p>
<p>Each KPI belongs to one Area</p>";
$page = 'configuration';

include('components/basic_form.php');

?>

