<?php
include('init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Apedog: Entering Values</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php include('components/menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">Entering Values</h2>
                <div class="content">
                    <form method="POST" action="" >
                        <?php

                        if( isset( $_REQUEST['entering'])) {
                            echo "<p><a href=".$_SERVER["PHP_SELF"]."?planning>Lock planning</a>&nbsp;";
                            echo "<b><a href=".$_SERVER["PHP_SELF"]."?entering>Lock enterning</a></b></p>";
                            $lock_entering = new LockEntering($dbutil, $current_term,$current_area, $_SESSION['user']);                           
                            if( isset( $_POST['posted'])) {
                                $lock_entering->submit( $_POST );
                            }
                            $lock_entering->get_form_content();
                        } else {
                            echo "<p><b><a href=".$_SERVER["PHP_SELF"]."?planning>Lock planning</a></b>&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?entering>Lock enterning</a></p>";
                            $lock_planning = new LockPlanning($dbutil, $current_term,$current_area, $_SESSION['user']);
                            if( isset( $_POST['posted'])) {
                                $lock_planning->submit( $_POST );
                            }
                            $lock_planning->get_form_content();
                        }

                        ?>
                        <p>
                            <input type="hidden" name="posted" value="1" />
                            <input type=submit value="Save"/>
                        </p>
                    </form>
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <h3>Entering values</h3>
                    <p>Firstly choose period for which you want to enter value. Past and future periods are locked. Then choose your area. Enter the value you achieved in KPI and save it. You will be able to change the value until the end of actual time interval.</p>

                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
