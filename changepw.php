<?php
include ('auth.php');
include 'settings.php';
include 'functions.php';
getheader('Passwort &auml;ndern',$db);

// Body
$error = '';

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {

	$pwold = $_POST ['oldpassword'];  //String with old pw
	$pwnew = $_POST ['newpassword'];	//String with new pw
	$pwrepeat = $_POST ['repeatpassword']; //String with new pw
	$change = false;

	$lehrerid = $_SESSION ['L_ID']; //Int with Lehrer-ID

	// Query for USER
	$queryPW = "SELECT L_PW FROM vb_logindata WHERE L_ID=" . $lehrerid . "";
	$result = mysqli_query ( $db, $queryPW );

	// Make Array out of $result
	while ( $row = $result->fetch_array () ) {
		$rows [] = $row;
	}

	// Get Arrays out of $rows
	foreach ( $rows as $row ) {
		$pwdb = $row [0];
	}

	$result->close ();




	// Validate
	if (password_verify($pwold, $pwdb)) {
		$change = true;
	}

	if ($pwnew != $pwrepeat) {
		$error = 'Das Wiederholte Passwort stimmt nicht &uuml;berein';
	} elseif ($change == false) {
		$error = 'Falsches altes Passwort';
	} elseif (empty ( $_POST ['oldpassword'] ) || empty ( $_POST ['newpassword'] ) || empty ( $_POST ['repeatpassword'] )) {
		$error = 'Bitte Alle Felder ausf&uuml;llen';
	} else {
		$newpw = password_hash( $pwnew, PASSWORD_DEFAULT );
		if (password_verify($pwnew, $newpw)) {
		$queryChange = "UPDATE vb_logindata SET L_PW='" . $newpw . "' WHERE L_ID=" . $lehrerid;
		if (mysqli_query ( $db, $queryChange )) {
			echo '<div id="changesucess">
				<p>Ihr Passwort wurde erfolgreich ge&auml;ndert<br>
				<a href="index.php">Weiter</a></p>
				</div>';
			exit ();
		}
	}else {
		exit('Es gab Problem beim erstellen des neuen Password. Ihr altes Passwort ist noch gültig');
	}
	}
}
echo '
		<div class="container">
<form action="changepw.php" method="post">
			<input type="password" placeholder="Altes Passwort/Nich eingeben!!" name="oldpassword"><br>
			<input type="password" placeholder="Neues Passwort" name="newpassword"><br>
			<input type="password" placeholder="Passwort wiederholen" name="repeatpassword"><br>
			<input type="Submit" value="Passwort &auml;ndern">
			<form>
		<p> ' . $error . '</p></div>';
//Footer
mysqli_close($db);
getfooter();

?>
