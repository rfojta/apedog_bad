
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Apedog: Useful Links</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
 session_cache_expire(60);
 session_start();
 if (!isset($_SESSION['user'])) { include('menu2.php'); }
    else include('menu.php');
?>

<div id="content">
	<div id="colOne">
		<h2 class="section">Useful Links</h2>
		<div class="content">
			<p>You might be interested in this</p>
			<ul>
				<li><a href="http://aiesec.vse.cz/links" target="_blank">Page with (not only) Prague links</a></li>
				<li><a href="http://aiesec.vse.cz/address/w" target="_blank">AIESEC WIKI</a></li>
				<li><a href="http://aiesec.cz" target="_blank">AIESEC CR</a></li>
                                <li><a href="http://aiesec.net" target="_blank">multipurpose AIESEC platform</a></li>
                        </ul>
		</div>
	</div>
		<?php include('recent_updates.php'); ?>

	<div style="clear: both;">&nbsp;</div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
