<?php
include('init.php');
include('classes/View.class.php');
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
		<script type="text/javascript" src="./libs/tablefilter2/paginate.min.js"></script>
		<script type="text/javascript" src="./libs/tablefilter2/tablesort.min.js"></script>
		<script type="text/javascript" src="./libs/tablefilter2/tablefilter.min.js"></script>

		<link href="./libs/tablefilter2/demo.css"       rel="stylesheet" type="text/css" />
		<link href="./libs/tablefilter2/paginate.css"   rel="stylesheet" type="text/css" />

		<!--[if IE]>
		<link href="../css/paginate-ie.css"   rel="stylesheet" type="text/css" />
		<![endif]-->

		<link href="./libs/tablefilter2/filter.css"   rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php include('components/menu.php'); ?>
		<div id="content">
			<div id="colOne">
				<h2 class="section">View</h2>
				<div class="content">
					<form method="POST" action="" >
						<?php
						$reports = new BSC_View($dbutil, $_GET['csfs'], $_SESSION['user']);
						if (isset($_POST['posted'])) {
							$reports->submit($_POST);
						}
						$reports->get_form_content();
						?>
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