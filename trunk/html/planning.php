<?php
 session_cache_expire(60);
 session_start();
 if (!isset($_SESSION['user'])) { header("Location: index.php"); exit; }
 $info = $_SESSION['user'];
 $lc = $_SESSION['user'];
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
<form>
<ul>
<?php
  mysql_connect('mysql.webzdarma.cz','apedog','jachta');
  mysql_select_db('apedog');


  $result = mysql_query('select * from areas');

  while( $row = mysql_fetch_assoc($result) ) {
	  echo '<li>';
	  echo $row['name'] . ': ';
	  echo '<input name="2009-07-17-' . $row['name']  .'" value=123>';
	  echo '</li>';
  }


  mysql_close();
?>
	</ul>
<input type=submit>
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
