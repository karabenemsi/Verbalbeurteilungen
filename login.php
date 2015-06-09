<?php
include 'settings.php';
include 'dbconnect.php';

$error= '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();

	$user = $_POST['user'];
	$pw = $_POST['password'];


	$hostname = $_SERVER['HTTP_HOST'];
	$path = dirname($_SERVER['PHP_SELF']);

	$queryID="SELECT L_ID FROM vb_lehrer WHERE L_Kuerzel='" . $user . "'";
	$result = mysqli_query($db,$queryID);

		//Make Array out of $result
		while ($row = $result->fetch_array()) {
			$rows[]= $row;
		}
	if(!empty($rows)){
		//Get Arrays out of $rows
		foreach ($rows as $row) {
			$lehrerid = $row[0];
		}
	} else {
		$error='K&uuml;rzel nicht gefunden oder<br>Passwort nicht korrekt';
	}

	if (isset($lehrerid)) {

	//Query for USER
	$queryPW="SELECT L_PW FROM vb_logindata WHERE L_ID=" . $lehrerid . "";
	$result = mysqli_query($db,$queryPW);

	// Make Array out of $result
	while ($row = $result->fetch_array()) {
		$rows[]= $row;
	}

	//Get Arrays out of $rows
	foreach ($rows as $row) {
		$pwmd5 = $row[0];
	}

	$result->close();

	// Validate
	if (md5($pw)== $pwmd5 ) {
		$_SESSION['login'] = true;
	}/* Hier fehlt noch das Passwort ist falsch */

	$error.='<br>Passwort nicht korrekt5';

		// Redirect
		if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
			if (php_sapi_name() == 'cgi') {
				header('Status: 303 See Other');
			}
			else {
				header('HTTP/1.1 303 See Other');
			}
		}

		$_SESSION['L_ID']= $lehrerid;

		$queryName = 'SELECT L_Vorname, L_Name, L_Admin, L_Klassenlehrer FROM vb_lehrer WHERE L_ID=' . $lehrerid;
		$result = mysqli_query($db,$queryName);
			// Make Array out of $result
			while ($row = $result->fetch_array()) {
			$rows[]= $row;
			}

			//Get Arrays out of $rows
			foreach ($rows as $row) {
				$user= $row[0] . ' ' . $row[1];
				$admin= $row[2];
				$classteacher= $row[3];
			}
			$result->close();

			$_SESSION['ADMIN']= $admin;
			$_SESSION['USER']= $user;
			$_SESSION['CLASSTEACHER'] = $classteacher;
			header('Location://'.$hostname.($path == '/' ? '' : $path).'/index.php');
			exit;

		}
	}

	$hostname= $_SERVER['HTTP_HOST'];
?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8" >
			<meta name="author" content="Florian Lubitz, Marcel Killinger, Leander Eger" >
			<meta name="description" content="PHP and SQL based Application for students mark management" >
			<meta name="keywords" content="Gymnasium Balingen, Verbalbeurteilungen, Unterstufe, Textbeurteilungen" >
			<title>Login</title>
			<link rel="stylesheet" type="text/css" href="//<?php echo $hostname; ?>/style/style.css" />
			<link rel="shortcut icon" href="//<?php echo $hostname; ?>/pictures/site/favicon.ico" type="image/x-icon">
			<link rel="icon" href="//<?php echo $hostname; ?>/pictures/site/favicon.ico" type="image/x-icon">
			<script type="text/javascript"
				src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
			<!--<script type="text/javascript"
				src="//<?php echo $hostname; ?>/script/jquery-2.1.3.min.js"></script>-->
			<script type="text/javascript" src="//<?php echo $hostname; ?>/script/main.js"></script>
		</head>

		<body>
			<div class="wrapper">

			<header>
			<h1 id="header_title"><a href="//<?php echo $hostname; ?>/index.php"> <?php echo SITEHEADING; ?></a></h1>
			<div id="ajaxrequest"></div>


			<input type="checkbox" id="menu" class="checkboxmenu">
			<label for="menu" onclick></label>
			<nav role="off-canvas">
			    <ul>
					<li><a href="//<?php echo $hostname; ?>/index.php">Home</a></li>';
				</ul>
			</nav>
			<nav>
				<ul>
					<li class = "cat1">
						<a href="//<?php echo $hostname; ?>/index.php">Home</a>
					</li>

	           	 	</ul>
	       	 	</nav>

			</header>

			<div id="margin_box_top" >
			</div>


			<div class="content">
<div class="container login">
			<form action="login.php" method="post">
			<input type="text" placeholder="Ihr K&uuml;rzel" name="user"></br>
			<input type="password" placeholder="Passwort" name="password"></br>
			<input type="submit" value="Login">
			</form>
			<p class="error"> <?php echo $error; ?></p>
			<a href="login-data.php" target="_blank"><input type="submit" value="Login-Daten"></a>

			</div>';



<?php
//Footer
	mysqli_close($db);
?>
	<footer>

		<div class="footercontent">
			<img src="//<?php echo $hostname; ?>/pictures/site/Footer/Logo_FCG_003_400.png" width="100" alt="FlowR Logo" ><p>FlowR Coding</p>
		</div>
		<div class="footercontent">
			<p><span id="copyright">Copyright: Marcel Killinger, Florian Lubitz, Leander Eger</span></p>
		</div>
		<div class="footercontent">
			<p>

					<img style="border:0;width:88px;height:31px"
						src="//' .$_SERVER['HTTP_HOST'] . '/pictures/site/Footer/vcss-blue.gif"
					alt="CSS ist valide!" />

			</p>
		</div>


	</footer>
</div>
</div>

</body>
</html>
