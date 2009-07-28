<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if( isset( $_POST['posted'])) {
    $controller->submit( $_POST );
}
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
                        <?php $controller->get_form_content($_REQUEST); ?>
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
                    <?php echo $page_help ?>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('footer.php'); ?>
    </body>
</html>