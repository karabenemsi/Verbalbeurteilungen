<?php
include 'settings.php';
include 'functions.php';

// Body
$error = '';

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

	$pwold = $_POST ['oldpassword'];  //String with old pw
	$pwnew = $_POST ['newpassword'];	//String with new pw
	$pwrepeat = $_POST ['repeatpassword']; //String with new pw
	$change = false;
  $user = $_POST['nickname'];




//---- Get Teacher-ID --BEGIN----//
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
		exit('K&uuml;rzel nicht gefunden oder<br>Passwort nicht korrekt');
	}
  //---- Get Teacher-ID --END----//


///////---------------Start Comment Here ------------------------///////
  // Query for USER
  $queryPW = "SELECT L_PW FROM vb_logindata WHERE L_ID=" . $lehrerid . "";
  $result = mysqli_query ( $db, $queryPW );

  // Make Array out of $result
  while ( $row = $result->fetch_array () ) {
    $rows [] = $row;
  }

  //Get Arrays out of $rows
	foreach ($rows as $row) {
		$pwmd5 = $row[0];
	}

	$result->close();

	// Validate
	if (md5($pwold)== $pwmd5 ) {
		$_SESSION['login'] = true;
    $change = true;
	}/* Hier fehlt noch das Passwort ist falsch */
///////---------------Stop Comment Here ------------------------///////
//----And decomment the following line!!!-----//
//$change =true;


	if ($pwnew != $pwrepeat) {
		$error = 'Das Wiederholte Passwort stimmt nicht &uuml;berein';
	} elseif (!$change) {
	  $error = 'Das alte Passwort ist falsch';
	} else {
		$newpw = password_hash( $pwnew, PASSWORD_DEFAULT );
		if (password_verify($pwnew, $newpw)) {
		$queryChange = "UPDATE vb_logindata SET L_PW='" . $newpw . "' WHERE L_ID=" . $lehrerid;
		if (mysqli_query ( $db, $queryChange )) {
      $hostname = $_SERVER['HTTP_HOST'];
      $path = dirname($_SERVER['PHP_SELF']);
      header('Location://'.$hostname.($path == '/' ? '' : $path).'/login.php?sucess=true');
      exit;
		}
	}else {
		exit('Es gab Problem beim erstellen des neuen Password. Ihr altes Passwort ist noch gültig');
	}
	}
}
echo '
		<div class="container">
<form action="newpw.php" method="post">
      <input type="text" placeholder="K&uuml;rzel" name="nickname"><br>
			<input type="password" placeholder="Altes Passwort/Nich eingeben!!" name="oldpassword"><br>
			<input type="password" placeholder="Neues Passwort" name="newpassword"><br>
			<input type="password" placeholder="Passwort wiederholen" name="repeatpassword"><br>
			<input type="Submit" value="Passwort &auml;ndern">
			<form>
		<p> ' . $error . '</p></div>';
//Footer
mysqli_close($db);

?>
