<?php
include ('../authadmin.php');
include ('../structure/dbconnect.php');
include ('../structure/header1.php');
?>

<?php
echo '<title>Admins</title>';
// Header
include ('../structure/header2.php');

// Body
$error = '';
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$add = $_POST ['add'];
	
	$remove = $_POST ['remove'];
	
	if ($add == 'empty') {
		$error = 'Niemand hinzugef&uuml;gt';
	} else {
		if (mysqli_query ( $db, "UPDATE verbalbeurteilungen.vb_lehrer SET L_Admin=1 WHERE L_ID=" . $add . "" )) {
			echo 'Saved';
		} else {
			echo 'Error';
		}
		$error = "Lehrer erfolgreich hinzugef&uuml;gt";
	}
	
	if ($remove == 'empty') {
		$error = $error . ', Niemand entfernt';
	} else {
		if (mysqli_query ( $db, "UPDATE verbalbeurteilungen.vb_lehrer SET L_Admin=0 WHERE L_ID=" . $remove . "" )) {
			echo 'Saved';
		} else {
			echo 'Error';
		}
		$error = $error . ", Lehrer erfolgreich entfernt";
	}
}

$arradmins = [ 
		[ ] 
];
$arrnoadmins = [ 
		[ ] 
];
// Teachers with Admin
$result = mysqli_query ( $db, "SELECT L_ID, L_Vorname, L_Name FROM vb_lehrer WHERE L_Admin=1" );
while ( $row = $result->fetch_array () ) {
	$rows [] = $row;
}
$i = 0;
foreach ( $rows as $value ) {
	$arradmins [$i] [0] = $value [0];
	$arradmins [$i] [1] = $value [1];
	$arradmins [$i] [2] = $value [2];
	$i ++;
}

unset ( $result );
unset ( $row );
unset ( $rows );
unset ( $value );

// Teachers without Admin
$result = mysqli_query ( $db, "SELECT L_ID, L_Vorname, L_Name FROM vb_lehrer WHERE L_Admin=0" );
while ( $row = $result->fetch_array () ) {
	$rows [] = $row;
}
$i = 0;
foreach ( $rows as $value ) {
	$arrnoadmins [$i] [0] = $value [0];
	$arrnoadmins [$i] [1] = $value [1];
	$arrnoadmins [$i] [2] = $value [2];
	$i ++;
}
unset ( $result );
unset ( $row );
unset ( $rows );
unset ( $value );

echo '
			<div class="container">
				<a href="../customize.php"><div class="back"></div></a>
			</div>
<div class="container">
<form method="post">
<p>Admin hinzuf&uuml;gen:</p><select name="add">
		<option value="empty">Lehrer w&auml;hlen</option>';
for($i = 0; $i < sizeof ( $arrnoadmins ); $i ++) {
	echo '<option value="' . $arrnoadmins [$i] [0] . '">' . $arrnoadmins [$i] [1] . ' ' . $arrnoadmins [$i] [2] . '</option>';
}

echo '</select>
	<input type="submit" value="hinzuf&uuml;gen" action="admins.php"><br><br>

';

echo '


<p>Admin entfernen:</p><select name="remove">
		<option value="empty">Lehrer w&auml;hlen</option>';
for($i = 0; $i < sizeof ( $arradmins ); $i ++) {
	echo '<option value="' . $arradmins [$i] [0] . '">' . $arradmins [$i] [1] . ' ' . $arradmins [$i] [2] . '</option>';
}
echo '</select>
			<input type="submit" value="entfernen" action="admins.php">

</form><br><br>
			<p>' . $error . '</p>
</div><!-- Box -->
';

// Footer
include ('../structure/footer.php');
?>
