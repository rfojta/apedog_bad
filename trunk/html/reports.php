<?php
 session_cache_expire(60);
 session_start();
 if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
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
<?php include('menu.php'); ?>

<div id="content">
	<div id="colOne">
		<h2 class="section">Reports</h2>
		<div class="content">
			//implementace reportu - tabulky, grafy
			<img src="graphs/layout_matrix_1.3.png">
		</div>
	</div>
	<div id="colTwo">
		<h2 class="section">Help</h2>
		<div class="content">
			<h3>Reports</h3>
			<p>Here you can see the output, plan vs. reality. Hope you are meeting your targets!</p>
			</div>
	</div>
	<div style="clear: both;">&nbsp;</div>
</div>
    
<?php include('footer.php'); ?>
</body>
</html>
