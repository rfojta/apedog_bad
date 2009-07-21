<?php
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
$info = $_SESSION['user'];
$lc = $_SESSION['user'];

include('classes/Apedog.class');
include('classes/Planning.class');
include('classes/Term.class');
include('classes/LC.class');
include('classes/Tracking.class');

$apedog = new Apedog('prod');
$dbres = $apedog->dbres;

$term = new Term($dbres);

$current_term = $term->get_current_term();
if( isset($_REQUEST['term_id']) ) {
    $current_term = $_REQUEST['term_id'];
}

$terms = $term->get_term_labels();

$planning = new Planning($dbres, $current_term, $_SESSION['user']);

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
    </head>
    <body>

        <?php include('menu.php'); ?>

        <div id="content">
            <div id="colOne">
                <h2 class="section">Planning</h2>
                <div class="content">
                    <form method="POST">
                        <?php
                        include('components/select_term.php');
                        $planning->get_form_content();

                        ?>
                        <input type="hidden" name="posted" value="1" />
                        <input type=submit />
                    </form>

			//implementace planningu v zavislosti na case <br>
			//Areas ani KPIs se upravovat nebudou<br>
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

        <?php include('footer.php'); ?>

    </body>
</html>
