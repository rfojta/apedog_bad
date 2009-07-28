<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
include('init.php');

$user_model = new UserModel($dbutil);
$user = new UserController($user_model);

if( isset( $_POST['posted'])) {
    $user->submit( $_POST );
}

$page_title = "Apedog: User Configuration";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?php echo $page_title; ?></title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php include('menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section"><?php echo $page_title; ?></h2>
                <div class="content">
                    <form method="POST">
                        <?php $user->get_form_content($_REQUEST); ?>
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
                    <h3><?php echo $page_title; ?></h3>
                    <p>you can add, modify, remove Users or LCs</p>
                    <p>Each User belongs to one LC</p>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>
