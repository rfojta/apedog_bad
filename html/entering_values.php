<?php
include('init.php');

$entering = new Entering($dbres, $current_term, $_SESSION['user']);

if( isset( $_POST['posted'])) {
    $entering->submit( $_POST );
}


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
        <?php include('menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">Entering Values</h2>
                <div class="content">
                    <form method="POST">
                        <?php
                        include('components/select_term.php');
                        $entering->get_form_content();

                        ?>
                        <input type="hidden" name="posted" value="1" />
                        <input type=submit />
                    </form>
			//implementation of entering actual values
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
        <?php include('footer.php'); ?>
    </body>
</html>
