<?php
include('init.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Apedog: Reports</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
        <link href="images/common/favicon.png" rel="icon" type="image/png" />
    </head>
    <body>
        <?php include('components/menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">Reports</h2>
                <div class="content">
                    <form method="POST" action="" >
                        <?php
                        $reports;
                        if( isset( $_REQUEST['graphs'])) {
                            $reports = new Graphs($dbutil, $current_term,$current_area, $_SESSION['user'], $quarter_in_term, $eot,$custom,null, $kpi_id);
                            
                        }  else {
                            $reports = new Results($dbutil, $current_term, $_SESSION['user'], $quarter_in_term, $eot, $custom, $c);
                            }
                        if( isset( $_POST['posted'])) {
                                $reports->submit( $_POST );
                            }
                            
                            $reports->get_form_content();

                            ?>
                        <p>
                            <input type="hidden" name="posted" value="1" />
                        </p>
                    </form>
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <?php $reports->get_help() ?>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
