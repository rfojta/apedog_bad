<?php
include('init.php');

$report = new Report($dbres, $_SESSION['user']);

if( isset( $_POST['posted'])) {
    $planning->submit( $_POST );
}
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
<?php
$page='reports';
include('components/menu.php');
?>


<div id="content">
	<div id="colOne">
		<h2 class="section">Reports</h2>
		<div class="content">
			<?php

                        include('components/select_area.php');
                        echo '<br>';
                        if ($chosen_area==null){
                            $chosen_area=1;
                        }
                        $report->get_form_content($chosen_area);
                        ?>
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
    
<?php include('components/footer.php'); ?>
</body>
</html>
