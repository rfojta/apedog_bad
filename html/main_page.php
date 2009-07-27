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
<?php include('menu.php'); ?>
<div id="content">
	<div id="colOne">
		<h2 class="section">Main Page</h2>
		<div class="content">
			<p>bbbbbbbbbbbbllllllllllllllablablabslkjdslkdgjfs;ldfkdtj</p>
			//sem patri rozcestnik do 3 hlavnich vetvi
			<ul>
				<li><a href="planning.php" title="Enter plans for each KPI">Planning</a></li>
				<li><a href="entering_values.php" title="Enter actual values for each KPI">Entering values</a></li>
				<li><a href="reports.php" title="See reports according to plans and fullfilling">Reports</a></li>
<?php if( $_SESSION['user'] == 'Praha'): ?>
                                <li><a href="kpi_conf.php" title="Here you can configure areas and KPIs">KPI Cofiguration</a></li>
                                <?php endif; ?>
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
<?php include('footer.php'); ?>
</body>
</html>
