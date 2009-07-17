<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Apedog - Planning</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="header">
	<div id="menu">
		<ul>
			<li><a href="main_page.html" accesskey="1" title="">Home</a></li>
			<li><a href="main_page.html" accesskey="2" title="">Logout</a></li>
			<li><a href="useful_links.html" accesskey="3" title="">Useful Links</a></li>
		</ul>
	</div>
</div>
<div id="splash"><img src="images/img02.jpg" alt="" width="1024" height="140" /></div>
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
<div id="footer">
	<p>Copyright &copy; 2009 <strong>Apedog 1.0 </strong> Voght, Skittles</a></p>
</div>
</body>
</html>
