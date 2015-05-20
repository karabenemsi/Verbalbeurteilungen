<?php
include ('../authadminorct.php');
include ('../settings.php');
include ('../functions.php');

$id;

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$id = $_POST ['id'];
}



if (empty($id)) {
	$query= 'SELECT count(S_ID) FROM vb_schueler';
	$limitar = mysqli_fetch_array ( mysqli_query ( $db, $query ) );
	$countstudents = $limitar [0];
} else {
	$countstudents=1;
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Verbalbeurteilung</title>
<link rel="stylesheet" type="text/css" href="../style/print.css">
<script type="text/javascript">
print();
</script>
</head>
<body>

<?php

 for ($i = 0; $i < $countstudents; $i++) {

	if ($countstudents==1) {
		$strid='WHERE S_ID= '.$id;
	} else {
		$strid="WHERE S_ID='". ($i+1) . "'";
	}


	unset($student);
	$results = 0;
	$rows1 = [];
	$row1 = 0;
	$query2 = "SELECT
			 S_ID, S_prename, S_name, S_Konfession
			  FROM vb_schueler ".$strid;
	$results = mysqli_query ( $db, $query2 );
	if (empty ( $results )) {
		echo 'Datenbankfehler1';
		exit ();
	}
	while ( $row1 = $results->fetch_array () ) {
		$rows1 [] = $row1;
	}

	foreach ( $rows1 as $value1 ) {
			$student [0] = $value1 [0];
			$student [1] = $value1 [1];
			$student [2] = $value1 [2];
			$student [3] = $RELIGION[$value1 [3]];

		}
	


	unset($arrmarks);
	$query = 'SELECT S_ID, S_marks FROM vb_schueler ' . $strid ;
	$result3 = mysqli_query ( $db, $query );
	while ( $row3 = $result3->fetch_array () ) {
		$rows3 [] = $row3;
	}
	foreach ( $rows3 as $value3 ) {
		$temp_id = $value3 [0];
		$temp_markscsv = $value3 [1];

	//Tear string to shreds
	if (!($temp_markscsv == '')) {

		$temparr_marks = explode(';', $temp_markscsv);
	}
	$k=0;
	foreach ($temparr_marks as $value) {
		$arrmarks[$k] = str_split($value);
		$k++;
	}

	}
	unset($temparr_marks);
	unset($temp_id);
	unset($temp_marks);
	unset($temparr_marks);


echo '<h1 style="page-break-before:always">Sch&uuml;ler: '.$student[1].' '.$student[2].', ' . $student[3] . '</h1>';
echo '
<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Beurteilung</th>';
				for ($i=0; $i < sizeof($SUBJECTS); $i++) {
					echo "<th>" . str_split($SUBJECTS[$i])[0] . str_split($SUBJECTS[$i])[1] . "</th>";
				}
				echo'
			</tr>
		</thead>';


		for ($i=0; $i<sizeof($CATEGORIES) ; $i++) {
			echo '
			<tr class="big-border">
				<th rowspan="' . (sizeof($CATEGORIES[$i])-1) . '">'. $CATEGORIES[$i][0]. '</th>';

			$firsttime = true;
			for ($j=0; $j < sizeof($CATEGORIES[$i])-1 ; $j++) {

				echo '
					<td>'. $CATEGORIES[$i][$j+1]. '</td>';
				for ($k=0; $k < sizeof($SUBJECTS); $k++) {

						echo'
						<!-- Beurteilung -->
						<td>';
						if (isset($arrmarks[$k][$i])) {
							if ($arrmarks[$k][$i]==($j+1)) {
							echo("x");
							}
						}

			 		echo '</td>';
				}
				if ($firsttime) {
					echo "
					</tr>
					<tr>";

				}
			}
			echo '
			</tr>';
		}



echo '</table>';

	$today=date('d.m.Y');

	echo '
	<div><p class="small">';
	$firsttime=true;
	for ($i=0; $i < sizeof($SUBJECTS); $i++) {
		if($firsttime) {
			$firsttime = false;
		} else {
			echo ", ";
		}
		echo str_split($SUBJECTS[$i])[0] . str_split($SUBJECTS[$i])[1] . " = " . $SUBJECTS[$i];
	}

 echo'</p></div>
 <div class="subscribe"><p>' .$today. ',</p></div>
 <div><p>Datum, Unterschrift des Klassenlehrers</p></div>';

}?>
</body>
</html>
<?php mysqli_close ( $db );?>
