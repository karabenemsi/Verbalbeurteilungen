<?php
include ('../authadminorct.php');
include '../settings.php';
include '../functions.php';
getheader('Drucken');

// Body

$query = 'SELECT distinct FZ_Klasse FROM vb_fachzuweisung';
$result = mysqli_query ( $db, $query );
while ( $row = $result->fetch_array () ) {
	$rows [] = $row;
}
$i = 0;
foreach ( $rows as $value ) {

	$class [$i] = $value [0]; // $class contains the classes
	$i ++;
}
if ($_SESSION['ADMIN']==1) {
	$numofclasses = sizeof ( $class );
} else {
	$numofclasses = 1;
}


for($i = 0; $i < $numofclasses; $i ++) {
	$results = 0;
	$rows1 = [ ];
	$row1 = 0;
	if ($_SESSION['ADMIN']==1) {
		$queryclass= $class[$i];
	} else {
	$queryclass= $_SESSION['CLASSTEACHER'];
	}
	$query2 = "SELECT  S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "'";

	$results = mysqli_query ( $db, $query2 );
	if (empty ( $results )) {
		echo 'Datenbankfehler';
		exit ();
	}
	while ( $row1 = $results->fetch_array () ) {
		$rows1 [] = $row1;
	}
	$j = 0;

	foreach ( $rows1 as $value1 ) {

		$arrstudents [$i] [$j] [0] = $value1 [0];
		$arrstudents [$i] [$j] [1] = $value1 [1];
		$arrstudents [$i] [$j] [2] = $value1 [2];
		$j += 1;
	}
}

echo '
	<div class="grid6_box">
		<div class="grid6_row">
			<div class="grid6_col-6" style="background:#f3f3f3;color:#525252;">
				<h1>Drucken</h1>
				<h3>Sch&uuml;ler w&auml;hlen:</h3>
					<div class="container">
					<form action="print.php" method="POST" target="_blank">
					<select name="id">';

for($i = 0; $i < sizeof ( $class ); $i ++) {
	echo '<optgroup label="' . $class [$i] . '">';
	for($j = 0; $j < sizeof ( $arrstudents [$i] ); $j ++) {
	echo '<option value="' . $arrstudents [$i] [$j] [0] . '"> ' . $arrstudents[$i][$j][1] . ' ' . $arrstudents[$i][$j][2] . '</option>';
	}
	echo '</optgroup>';
}

echo '</select><br>
				<input type="submit" value="Drucken">
				</form>
				</div>
		';
if ($_SESSION['ADMIN']==1) {
	echo '	<div class="container"><a href="print.php" target="_blank"><input type="submit" value="Alle Drucken"></a></div>';
}
echo'			</div><!--Col-->

		</div><!--Row-->
	</div><!--Box-->
	';

// Footer
mysqli_close($db);
getfooter();
?>
