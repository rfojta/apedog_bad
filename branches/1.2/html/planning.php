<?php
include('init.php');

$planning = new Planning($dbutil, $current_term,$current_area, $_SESSION['user']);

if( isset( $_POST['posted'])) {
    $planning->submit( $_POST );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Apedog: Planning</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
        <link href="images/common/favicon.png" rel="icon" type="image/png" />
    </head>
    <body>

        <?php
        $page='planning';
        include('components/menu.php'); ?>

        <div id="content">
            <div id="colOne">
                <h2 class="section">Planning</h2>
                <div class="content">
                    <form method="POST" action="">
                        <?php
                        include('components/select_term.php');
                        $planning->get_form_content();

                        ?>
                        <p>
                        <input type="hidden" name="posted" value="1" />
                        <input type=submit />
                        </p>
                    </form>

			//implementace planningu v zavislosti na case <br/>
			//Areas ani KPIs se upravovat nebudou<br/>
                    //PLANUJEME pro jednotlive kvartaly a pro cely term!
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <h3>Planning</h3>
                    <p>
                        At the beginning of a term, you can enter here values of your KPIs. Then it will be locked.
                    </p></div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>

        <?php include('components/footer.php'); ?>

    </body>
</html>
