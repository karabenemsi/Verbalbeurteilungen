<?php
include ('auth.php');
include ('settings.php');
include ('functions.php');
getheader('Verbalbeurteilungen');



// Body
function arraylength($arg1) {
	$bool = true;
	$i = sizeof ( $arg1 );
	$check = $arg1 [$i - 1];
	$j = 0;
	do {
		$i --;
		if (! empty ( $check )) {
			$bool = false;
		} else {
			$check = $arg1 [$i - 1];
		}
		$j ++;
	} while ( $bool );
	return (sizeof ( $arg1 ) - $j);
	;
}

// Get number of classes the teacher teachs
$query = 'SELECT count(FZ_Klasse) FROM `vb_fachzuweisung` WHERE FZ_Lehrer = ' . $_SESSION ['L_ID'] . '';
$limitar = mysqli_fetch_array ( mysqli_query ( $db, $query ) );
$numclass = $limitar [0];

// Get class and the subject the teacher teachs
$query = 'SELECT FZ_Klasse, FZ_Fach FROM vb_fachzuweisung WHERE FZ_Lehrer = ' . $_SESSION ['L_ID'] . '';
$result = mysqli_query ( $db, $query );
while ( $row = $result->fetch_array () ) {
	$rows [] = $row;
}
$i = 0;
foreach ( $rows as $value ) {

	$class [$i] = $value [0]; // $class contains the classes
	$subject [$i] = $value [1]; // $subject contains the subject
	$i ++;
}
$result->close();
// Get Names of students for each class
for($i = 0; $i < sizeof ( $class ); $i ++) {
	$results = 0;
	$rows1 = [ ];
	$row1 = 0;
	switch ($subject [$i]) {
		case 'religion1':
			$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "' AND S_Konfession='religion1'";
			break;
		case 'religion2' :
			$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "' AND S_Konfession='religion2'";
			break;
		case 'religion3' :
				$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "' AND S_Konfession='religion3'";
				break;
		case 'religion4' :
				$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "' AND S_Konfession='religion4'";
				break;
		case 'religion5' :
				$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "' AND S_Konfession='religion5'";
				break;
		default :
			$query2 = "SELECT S_ID, S_prename, S_name FROM vb_schueler WHERE S_class='" . $class [$i] . "'";
	}

	$results = mysqli_query ( $db, $query2 );
	if (empty ( $results )) {
		echo '<strong>Database-error</strong> while trying to get the subject and classes.<br> Probably your database is not set up properly.';
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

$results->close();
// $arrstudents[0][i] contains the names of all students visiting the class $class[0] and so on

// Get Text
$arrmarks = [ ];

for($i = 0; $i < sizeof ( $class ); $i ++) {

	for($j = 0; $j < Sizeof ( $arrstudents [$i] ); $j ++) {

		$query = 'SELECT S_ID, S_marks FROM vb_schueler WHERE S_ID=' . $arrstudents [$i] [$j] [0];
		$result3 = mysqli_query ( $db, $query );

		while ( $row3 = $result3->fetch_array () ) {
			$rows3 [] = $row3;
		}

		foreach ( $rows3 as $value3 ) {
			$temp_id = $value3 [0];
			$temp_markscsv = $value3 [1];
		}


		if (!($temp_markscsv == '')) {

			$temparr_marks = explode(';', $temp_markscsv);
		}

		if (strpos($subject[$i],'religion') !== FALSE) {
			$temp_marks = $temparr_marks[$RELIGION['subreligion']];

		} else {
			$temp_marks = $temparr_marks[intval($subject[$i])];
		}
		unset($temparr_marks);
		$temparr_marks = str_split($temp_marks);
		$k=1;
		foreach ($temparr_marks as $value) {
			$arrmarks [$i] [$j] [$k] = $value[0];
			$k++;
		}

		$arrmarks [$i] [$j] [0]= $temp_id;

		unset($temp_id);
		unset($temp_marks);
		unset($temparr_marks);
	}
}
$result3->close();
// $arrmarks[class][student][S_ID,valofcat1,valofcat2,valofcat3...]

// Big Table for Chosing Class



	$gridrow = 6;
	echo '	<div class="grid6_box">
		';
	for($i = 0; $i < $numclass; $i ++) {
		// checks for Begin and End of Row / 3 Colums a Row
		if ($gridrow > 2) {
			if ($gridrow == 6) { // $gridrow only gets 6 at the beginning
				echo '
				<div class="grid6_row">
				';
			} else {
				echo '</div>';
				echo '
					<div class="grid6_row">
					';
			}

			$gridrow = 0;
		}

		//Transform number into text
		$temp_subject = $subject[$i];
		if (strpos($temp_subject,'religion') !== FALSE) {
			$temp_subject = $SUBJECTS[$RELIGION['subreligion']] .' '. $RELIGION[$temp_subject];
		} else {
			$temp_subject = $SUBJECTS[intval($temp_subject)];
		}

		echo '
					<div class=" classes ';
		if (($i % 2) == 0) {
			echo 'grid6_col-2'; //
		} else { // Every second colum is in a different color
			echo ' grid6_col-2-mid'; //
		}
		echo '" id="' . ($i + 1) . '">
						<h1>' . $class [$i] . '</h1>
						<p>' . $temp_subject . '</p>
					</div>
				';

		$gridrow += 1;
	}

	echo '</div></div>';

//The smaller Tables

for($i = 0; $i < $numclass; $i ++) {

	echo '<section class="bg-245" id="name_box-' . ($i + 1) . '">
		';
	echo '	<div class="grid6_box">

				<div class="namebox_close">
					<h3>Close</h3>
				</div>

		';

	$students = Sizeof ( $arrstudents [$i] );
	$gridrow = 10;
	$k = 0;
	for($j = 0; $j < $students; $j ++) {

		if ($gridrow > 5) {
			if ($gridrow == 10) {
				echo '<div class="grid6_row grid6_row_margin">';
			} else {
				echo '</div>';
				echo '<div class="grid6_row grid6_row_margin">';
			}

			$gridrow = 0;
		}
		$gridrow += 1;
		echo '
			<div class="';
		if (($j % 2) == 0) {
			echo 'grid6_col-1';
		} else {
			echo 'grid6_col-1-mid';
		}

		echo '" style="z-index:' . ($j + 10) . '">
					<h3>' . $arrstudents [$i] [$k] [1] . ' ' . $arrstudents [$i] [$k] [2] . '</h3>
					<div class="student_marks name_column-' . $gridrow . '" >
							<div class="grid8_box">
								<div class="grid8_row">';
		for($l = 0; $l < sizeof ( $CATEGORIES ); $l ++) {
			echo '<div class="grid8_col-1">
										<form method="POST">
										<div class="mark_cat">' . $CATEGORIES [$l] [0] . '</div>';

			for($m = 0; $m < arraylength ( $CATEGORIES [$l] ); $m ++) {
				echo '
										<div class="student_marks-row">
										<p>' . $CATEGORIES [$l] [$m + 1] . '</p>	 <input type="checkbox" name="' . ($l + 1) . ($m + 1) . '" value="' . $arrmarks [$i] [$k] [0] . '" data-sub="' . $subject [$i] . '"';
				if (isset($arrmarks [$i] [$k] [$l+1])){
				if ($arrmarks [$i] [$k] [$l+1] == ($m + 1)) {
					echo ' checked';
				}}
				echo '>
										</div>';
			}
			echo '</form>
							</div>';
		}

		echo '</div>
						</div>
					</div>
				</div>';

		$k ++;
	}

	echo '</div><div class="namebox_close"><h3>Close</h3></div>
</div></section>';
}

// Footer
mysqli_close($db);
getfooter();
?>
