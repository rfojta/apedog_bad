<?php
session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
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
        <?php
        $page='main_page';
        include('components/menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">Main Page</h2>
                <div class="content">
                    <p></p>
                    <!-- rozcestnik -->
                    <ul>
                        <li><a href="planning.php" title="Enter plans for each KPI">Planning</a></li>
                        <li><a href="entering_values.php" title="Enter actual values for each KPI">Entering values</a></li>
                        <li><a href="reports.php" title="See reports according to plans and fullfilling">Reports</a></li>

                        <?php if( $_SESSION['user'] == 'Praha'):
                            echo "<li>Configuration: <ul>";
                            foreach( glob('administration/*_conf.php') as $conf_page) {
                                echo "<li>";
                                echo "<a href=\"$conf_page\" title=\"Here you can configure $conf_page\">$conf_page configuration</a>";
                                echo "</li>\n";
                            }
                            echo "</ul></li>";
                        endif; ?>
                    </ul>
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <h3>Main Page</h3>
                    <p>Choose Planning, Entering actual values or Reporting</p>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
