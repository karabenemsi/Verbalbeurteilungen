<?php
include ('auth.php');
include ('structure/dbconnect.php');
include ('structure/header1.php');
?>

<?php
echo '		<title>Verbalbeurteilungen</title>';
// Header
include ('structure/header2.php');

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
		case 'Religion evangelisch' :
			$query2 = "SELECT S_Nr, S_Vorname, S_Name FROM vb_schueler WHERE S_Klasse='" . $class [$i] . "' AND S_Konfession='ev'";
		case 'Religion katholisch' :
			$query2 = "SELECT S_Nr, S_Vorname, S_Name FROM vb_schueler WHERE S_Klasse='" . $class [$i] . "' AND S_Konfession='kath'";
		default :
			$query2 = "SELECT S_Nr, S_Vorname, S_Name FROM vb_schueler WHERE S_Klasse='" . $class [$i] . "'";
	}
	
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

$results->close();
// $arrstudents[0][i] contains the names of all students visiting the class $class[0] and so on

// Get Text

$query7 = ' SELECT T_cat_name, T_mark_1, T_mark_2, T_mark_3, T_mark_4, T_mark_5 FROM vb_text WHERE T_USE="markcat"';
$result7 = mysqli_query ( $db, $query7 );
while ( $row7 = $result7->fetch_array () ) {
	$rows7 [] = $row7;
}
$k = 0;
foreach ( $rows7 as $value7 ) {
	for($j = 0; $j < Sizeof ( $value7 ) / 2; $j ++) {
		
		$arrcatmark [$k] [$j] = $value7 [$j];
	}
	$k ++;
}
$result7->close();
$arrmarks = [ ];

for($i = 0; $i < sizeof ( $class ); $i ++) {
	for($j = 0; $j < Sizeof ( $arrstudents [$i] ); $j ++) {
		if (($subject [$i] == 'Religion evangelisch') || ($subject [$i] == 'Religion katholisch')) {
			$sub = 'Religion';
		} else {
			$sub = $subject [$i];
		}
		
		$query = 'SELECT S_Nr, S_' . $sub . '_1, S_' . $sub . '_2, S_' . $sub . '_3, S_' . $sub . '_4, S_' . $sub . '_5, S_' . $sub . '_6, S_' . $sub . '_7, S_' . $sub . '_8 FROM vb_schueler WHERE S_Nr=' . $arrstudents [$i] [$j] [0];
		
		$result3 = mysqli_query ( $db, $query );
		
		if (empty ( $result3 )) {
			echo 'Datenbankfehler2';
			exit ();
		}
		while ( $row3 = $result3->fetch_array () ) {
			$rows3 [] = $row3;
		}
		
		foreach ( $rows3 as $value3 ) {
			
			for($k = 0; $k < 9; $k ++) {
				$arrmarks [$i] [$j] [$k] = $value3 [$k];
			}
		}
	}
}
$result3->close();
// $arrmarks[class][student][S_Nr,S_$Subjekt_1,...]

// Big Table for Chosing Class
function bigtablechoseclass($numclass, $arg_2, $arg_3) {
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
		
		echo '
					<div class=" classes ';
		if (($i % 2) == 0) {
			echo 'grid6_col-2'; //
		} else { // Every second colum is in a different color
			echo ' grid6_col-2-mid'; //
		}
		echo '" id="' . ($i + 1) . '">
						<h1>' . $arg_2 [$i] . '</h1>
						<p>' . $arg_3 [$i] . '</p>
					</div>
				';
		
		$gridrow += 1;
	}
	
	echo '</div></div>';
}


bigtablechoseclass ( $numclass, $class, $subject ); // Call the big Table

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
		for($l = 0; $l < sizeof ( $arrcatmark ); $l ++) {
			echo '<div class="grid8_col-1">
										<form method="POST">
										<div class="mark_cat">' . $arrcatmark [$l] [0] . '</div>';
			
			for($m = 0; $m < arraylength ( $arrcatmark [$l] ); $m ++) {
				echo '
										<div class="student_marks-row">
										<p>' . $arrcatmark [$l] [$m + 1] . '</p>	 <input type="checkbox" name="' . ($l + 1) . ($m + 1) . '" value="' . $arrmarks [$i] [$k] [0] . '" data-sub="' . $subject [$i] . '"';
				if ($arrmarks [$i] [$k] [$l+1] == ($m + 1)) {
					echo ' checked';
				}
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
include ('structure/footer.php');
?>
