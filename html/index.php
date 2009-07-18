<?php
//  ini_set("session.use_cookies_only","1");
//  session_cache_expire(60);
  session_start();
  $info = "";
  if (isset($_REQUEST['logout'])) {
    unset($_SESSION['user']);
	session_destroy();
	$info = "You were successfully logged out.";
  }

  if (isset($_SESSION['user'])) { header("Location: main_page.php");}

	//$login_query = mysql_query("SELECT email, password FROM adr_person")  or die("Unsuccessful login query.");

	$USERS[] = array("login" => "Praha", "pass" => "brucelee");
        $USERS[] = array("login" => "Plzen", "pass" => "brucelee");
        $USERS[] = array("login" => "Pardubice", "pass" => "brucelee");
        $USERS[] = array("login" => "Brno", "pass" => "brucelee");
        $USERS[] = array("login" => "CZU", "pass" => "brucelee");
        $USERS[] = array("login" => "Ostrava", "pass" => "brucelee");
        $USERS[] = array("login" => "Karvina", "pass" => "brucelee");
        $USERS[] = array("login" => "Zlin", "pass" => "brucelee");
        $USERS[] = array("login" => "Olomouc", "pass" => "brucelee");
	$USERS[] = array("login" => "MC", "pass" => "brucelee");

	/*while ($login_query_line = mysql_fetch_array($login_query)) {

	$USERS[] = array("login" => $login_query_line[0], "pass" => $login_query_line[1]);

  }*/

	if (isset($_POST['userid']))
		for ($i = 0; $i<sizeof($USERS); $i++) {
			if (($_POST['userid']==$USERS[$i]['login']) && (@$_POST['userpass']==$USERS[$i]['pass'])) {
				$_SESSION['user'] = $USERS[$i]['login'];
				if ($USERS[$i]['login']=="admin")	header("Location: admin.php");
				else header("Location: main_page.php");
				break;
			} else $info = "Bad username or password!";
		}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Apedog</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php include('menu2.php'); ?>


<div id="content">
	<div id="colOne">
		<h2 class="section">Welcome to AEISEC CR LC Performance Monitor</h2>
		<div class="content">
			<p>Apedog is a tool, which helps LCs in the Czech Republic to track their plans. It was developed to ensure sustainable growth, improving KPIs and improving AIESEC experience.</p>
			<b>Please login</b>
		
                        <form action="index.php" method="post"><div align="left" >
                                <?php echo $info; ?>
                        <table style="margin: 0pt; padding: 10px; text-align: left; border:0">
                            <tr><td><label for="userid">Login: </label></td><td><input type="text" name="userid" id="userid" size="10" /></td></tr>
                            <tr><td><label for="userpass">Password: </label></td><td><input type="password" name="userpass" id="userpass" size="10" /></td></tr>
                        </table>

                        <input type="submit" name="prihlasit" value="Sign in" />
                        </div></form>
		</div>
	</div>
	
                <?php include('recent_updates.php'); ?>
	
	<div style="clear: both;">&nbsp;</div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
