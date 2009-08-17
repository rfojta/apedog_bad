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
                        echo "<div class='inner_menu'>";
                        if( isset( $_REQUEST['entering'])) {
                            echo "<a href=".$_SERVER["PHP_SELF"]."?planning>Lock planning</a>&nbsp;";
                            echo "<b><a href=".$_SERVER["PHP_SELF"]."?entering>Lock enterning</a></b>";
                            $lock_entering = new LockEntering($dbutil, $current_term,$current_area, $_SESSION['user'], $locking);
                            if( isset( $_POST['posted'])) {
                                $lock_entering->submit( $_POST );
                            }
                            echo "<hr width='30%' align='left'>";
                            echo "</div>";
                            echo "<p></p>";
                            $lock_entering->get_form_content();
                        } else {
                            echo "<b><a href=".$_SERVER["PHP_SELF"]."?planning>Lock planning</a></b>&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?entering>Lock enterning</a>";
                            $lock_planning = new LockPlanning($dbutil, $current_term,$current_area, $_SESSION['user'], $locking);
                            if( isset( $_POST['posted'])) {
                                $lock_planning->submit( $_POST );
                            }
                            echo "<hr width='30%' align='left'>";
                            echo "</div>";
                            echo "<p></p>";
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
                    <h3>Locking</h3>
                    <p>Firstly choose if you want to lock planning or entering values. Then choose LC. If checkbox is checked, LC can't edit values. </p>

                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
