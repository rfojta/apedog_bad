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
                        echo '<div class="inner_menu">';
                        if( isset( $_REQUEST['graphs'])) {
                            echo "<a href=".$_SERVER["PHP_SELF"]."?results>BSC Results</a>&nbsp;&nbsp;&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?lc_kpis>LC's KPIs</a>&nbsp;&nbsp;&nbsp;";
                            echo "<b><a href=".$_SERVER["PHP_SELF"]."?graphs>Reports - Graphs</a></b>";
                            $reports = new Graphs($dbutil, $current_term,$current_area, $_SESSION['user'], $quarter_in_term, $eot, $kpi_id);
                            
                        } else if (isset ( $_REQUEST['lc_kpis'])){
                            echo "<a href=".$_SERVER["PHP_SELF"]."?results>BSC Results</a>&nbsp;&nbsp;&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?lc_kpis><b>LC's KPIs</b></a>&nbsp;&nbsp;&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?graphs>Reports - Graphs</a>";
                            $reports = new LcKPIs ($dbutil, $current_term,$current_area, $_SESSION['user'], $quarter_in_term, $eot);
                        } else {
                            echo "<a href=".$_SERVER["PHP_SELF"]."?results><b>BSC Results</b></a>&nbsp;&nbsp;&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?lc_kpis>LC's KPIs</a>&nbsp;&nbsp;&nbsp;";
                            echo "<a href=".$_SERVER["PHP_SELF"]."?graphs>Reports - Graphs</a>";
                            $reports = new Results($dbutil, $current_term, $_SESSION['user'], $quarter_in_term, $eot);
                            }
                            echo '<hr width="40%" align="left">';
                            echo "</div>";
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
                    <h3>Reports</h3>
                    <p>TBD</p>

                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
