<?php
include ('authadmin.php');
include 'settings.php';
include 'functions.php';
getheader('Customize');

// Body
exit('Still being build');

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

for($i = 0; $i < sizeof ( $class ); $i ++) {
	$results = 0;
	$rows1 = [ ];
	$row1 = 0;
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
			<a href="admin/admins.php"><div class="grid6_col-2" id="admin">
				<h1>Admins</h1>
				<p>Lehrern administrative Rechte geben</p>
			</div></a><!--Col-->
			<a href="admin/subjects.php"><div class="grid6_col-2-mid" id="subjects">
				<h1>Neu anlegen</h1>
				<p>Neue Klassen, F&auml;cher oder Lehrer anlegen</p>
			</div></a><!--Col-->
			<a href="admin/printalarm.php"><div class="grid6_col-2" id="print">
				<h1>Drucken</h1>
				<p>Die Beurteilungen eines oder aller Sch&uuml;ler drucken</p>
			</div><!--Col-->
		</div><!--Row-->
	</div><!--Box-->';

// Footer
mysqli_close($db);
getfooter();
?>
