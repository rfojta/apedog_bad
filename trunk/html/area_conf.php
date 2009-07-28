<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

include('classes/Area.class.php');
include('classes/Kpi.class.php');
include('classes/model/area_model.class.php');
include('classes/model/kpi_model.class.php');
include('classes/db_util.class.php');

$dbutil = new DB_Util($apedog->dbres);
$area_model = new AreaModel($dbutil);
$kpi_model = new KpiModel($dbutil);
$area = new Area($area_model, $kpi_model);

if( isset( $_POST['posted'])) {
    $area->submit( $_POST );
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Apedog: Main Page</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php include('menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">KPI Configuration</h2>
                <div class="content">
                    <form method="POST">
                        <?php $area->get_form_content($_REQUEST); ?>
                        <p>
                            <input type="hidden" name="posted" value="1" />
                            <input type=submit />
                        </p>
                    </form>
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <h3>KPI Configuration</h3>
                    <p>you can add, modify, remove KPI or Area</p>
                    <p>Each KPI belongs to one Area</p>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>
