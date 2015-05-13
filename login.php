<?php
include('structure/dbconnect.php');

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

	
	
	
	
	include ('structure/header1.php');
	echo '<title>Login</title>';
	//Header
	include ('structure/header2.php');
	//Body
	
echo '<div class="container login">
			<form action="login.php" method="post">
			<input type="text" placeholder="Ihr K&uuml;rzel" name="user"></br>
			<input type="password" placeholder="Passwort" name="password"></br>
			<input type="submit" value="Login">
			</form>
			<p class="error">'. $error .'</p>
			<a href="login-data.php" target="_blank"><input type="submit" value="Login-Daten"></a>
			
			</div>';
			
			
			
			
//Footer
	include ('structure/footer.php');
	?>
		