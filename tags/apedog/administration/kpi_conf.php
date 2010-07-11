<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

$dbutil = new DB_Util($apedog->dbres);
$area_model = new AreaModel($dbutil);
$kpi_model = new KpiModel($dbutil);
$area = new AreaController($area_model, $kpi_model);
$controller = new KpiController($kpi_model, $area);

$page_title = 'Apedog: KPI Configuration';
$page = 'configuration';
$page_help = '
                    <h3>KPI Configuration</h3>
                    <p>you can add, modify, remove KPI or Area</p>
                    <p>Each KPI belongs to one Area</p>
';

include('components/basic_form.php');

?>
