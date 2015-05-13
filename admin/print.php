<?php
include ('../authadminorct.php');
include ('../structure/dbconnect.php');

$id;

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$id = $_POST ['id'];
}


$query = ' SELECT T_cat_name, T_mark_1, T_mark_2, T_mark_3, T_mark_4, T_mark_5 FROM vb_text WHERE T_USE="markcat"';
$result = mysqli_query ( $db, $query );
while ( $row = $result->fetch_array () ) {
	$rows [] = $row;
}
$k = 0;
foreach ( $rows as $value ) {
	for($j = 0; $j < Sizeof ( $value ) / 2; $j ++) {
		
		$arrcatmark [$k] [$j] = $value [$j];
	}
	$k ++;
}


if (empty($id)) {
	$query= 'SELECT count(S_Nr) FROM vb_schueler';
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
		$strid='WHERE S_Nr= '.$id;
	} else {
		$strid="WHERE S_Nr=". ($i+1) . "";
	}


	unset($student);
	$results = 0;
	$rows1 = [];
	$row1 = 0;
	$query2 = "SELECT
			 S_Nr, S_Vorname, S_Name
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
		for ($k = 0; $k < sizeof($value1)/2; $k++) {
			$student [$k] = $value1 [$k];
		}
	}


	unset($arrmarks);
	$results = 0;
	$rows1 = [];
	$row1 = 0;
	$query2 = "SELECT
			 S_Deutsch_1, S_Deutsch_2, S_Deutsch_3, S_Deutsch_4, S_Deutsch_5, S_Deutsch_6, S_Deutsch_7, S_Deutsch_8,
			 S_Mathematik_1, S_Mathematik_2, S_Mathematik_3, S_Mathematik_4, S_Mathematik_5, S_Mathematik_6, S_Mathematik_7, S_Mathematik_8,
			 S_Englisch_1, S_Englisch_2, S_Englisch_3, S_Englisch_4, S_Englisch_5, S_Englisch_6, S_Englisch_7, S_Englisch_8,
			 S_Biologie_1, S_Biologie_2, S_Biologie_3, S_Biologie_4, S_Biologie_5, S_Biologie_6, S_Biologie_7, S_Biologie_8,
			 S_Naturphaenomene_1, S_Naturphaenomene_2, S_Naturphaenomene_3, S_Naturphaenomene_4, S_Naturphaenomene_5, S_Naturphaenomene_6, S_Naturphaenomene_7, S_Naturphaenomene_8,
			 S_Sport_1, S_Sport_2, S_Sport_3, S_Sport_4, S_Sport_5, S_Sport_6, S_Sport_7, S_Sport_8,
			 S_Musik_1, S_Musik_2, S_Musik_3, S_Musik_4, S_Musik_5, S_Musik_6, S_Musik_7, S_Musik_8,
			 S_Geschichte_1, S_Geschichte_2, S_Geschichte_3, S_Geschichte_4, S_Geschichte_5, S_Geschichte_6, S_Geschichte_7, S_Geschichte_8,
			 S_Erdkunde_1, S_Erdkunde_2, S_Erdkunde_3, S_Erdkunde_4, S_Erdkunde_5, S_Erdkunde_6, S_Erdkunde_7, S_Erdkunde_8,
			 S_Religion_1, S_Religion_2, S_Religion_3, S_Religion_4, S_Religion_5, S_Religion_6, S_Religion_7, S_Religion_8,
			 S_Kunst_1, S_Kunst_2, S_Kunst_3, S_Kunst_4, S_Kunst_5, S_Kunst_6, S_Kunst_7, S_Kunst_8,
			 S_Physik_1, S_Physik_2, S_Physik_3, S_Physik_4, S_Physik_5, S_Physik_6, S_Physik_7, S_Physik_8
			  FROM vb_schueler ".$strid;
	$results = mysqli_query ( $db, $query2 );
	if (empty ( $results )) {
		echo 'Datenbankfehler2';
		exit ();
	}
	while ( $row1 = $results->fetch_array () ) {
		$rows1 [] = $row1;
	}
	
	foreach ( $rows1 as $value1 ) {
		for ($k = 0; $k < sizeof($value1)/2; $k++) {
			$arrmarks [$k] = $value1 [$k];
		}
	}
	
	
	
echo '<h1 style="page-break-before:always">Sch&uuml;ler: '.$student[1].' '.$student[2].'</h1>';
echo '
<table>
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Beurteilung</th>
				<th>D</th>
				<th>M</th>
				<th>E&nbsp;</th>
				<th>Bio&nbsp;</th>
				<th>Nat&nbsp;</th>
				<th>Sp&nbsp;</th>
				<th>Mu&nbsp;</th>
				<th>BG&nbsp;</th>
				<th>Geo&nbsp;</th>
				<th>R&nbsp;</th>
				<th>BK&nbsp;</th>
				<th>P&nbsp;</th>
			</tr>
		</thead>';


		for ($i=0; $i<8 ; $i++) { 
		
		
		echo '
		<tr class="big-border">
			<th rowspan="4">'. $arrcatmark[$i][0]. '</th>
			<td>'. $arrcatmark[$i][1]. '</td>
			<!-- Beurteilung -->
			<td>';if ($arrmarks[0+$i]==1) {echo("x");} echo '</td>
			<!-- Religion -->
			<td>';if ($arrmarks[8+$i]==1) {echo("x");} echo '</td>
			<!-- Deutsch -->
			<td>';if ($arrmarks[16+$i]==1) {echo("x");} echo '</td>
			<!-- Englisch -->
			<td>';if ($arrmarks[24+$i]==1) {echo("x");} echo '</td>
			<!-- Physik -->
			<td>';if ($arrmarks[32+$i]==1) {echo("x");} echo '</td>
			<!-- Geschichte -->
			<td>';if ($arrmarks[40+$i]==1) {echo("x");} echo '</td>
			<!-- Erdkunde -->
			<td>';if ($arrmarks[48+$i]==1) {echo("x");} echo '</td>
			<!-- Mathematik -->
			<td>';if ($arrmarks[56+$i]==1) {echo("x");} echo '</td>
			<!-- Biologie -->
			<td>';if ($arrmarks[64+$i]==1) {echo("x");} echo '</td>
			<!-- Sport -->
			<td>';if ($arrmarks[72+$i]==1) {echo("x");} echo '</td>
			<!-- Bildende Kunst -->
			<td>';if ($arrmarks[80+$i]==1) {echo("x");} echo '</td>
			<!-- Musik -->
			<td>';if ($arrmarks[88+$i]==1) {echo("x");} echo '</td>
			<!-- Naturphänomene -->
		</tr>
		<tr>
			<td>'. $arrcatmark[$i][2]. '</td>
			<!-- Beurteilung -->
			<td>';if ($arrmarks[0+$i]==2) {echo("x");} echo '</td>
			<!-- Religion -->
			<td>';if ($arrmarks[8+$i]==2) {echo("x");} echo '</td>
			<!-- Deutsch -->
			<td>';if ($arrmarks[16+$i]==2) {echo("x");} echo '</td>
			<!-- Englisch -->
			<td>';if ($arrmarks[24+$i]==2) {echo("x");} echo '</td>
			<!-- Physik -->
			<td>';if ($arrmarks[32+$i]==2) {echo("x");} echo '</td>
			<!-- Geschichte -->
			<td>';if ($arrmarks[40+$i]==2) {echo("x");} echo '</td>
			<!-- Erdkunde -->
			<td>';if ($arrmarks[48+$i]==2) {echo("x");} echo '</td>
			<!-- Mathematik -->
			<td>';if ($arrmarks[56+$i]==2) {echo("x");} echo '</td>
			<!-- Biologie -->
			<td>';if ($arrmarks[64+$i]==2) {echo("x");} echo '</td>
			<!-- Sport -->
			<td>';if ($arrmarks[72+$i]==2) {echo("x");} echo '</td>
			<!-- Bildende Kunst -->
			<td>';if ($arrmarks[80+$i]==2) {echo("x");} echo '</td>
			<!-- Musik -->
			<td>';if ($arrmarks[88+$i]==2) {echo("x");} echo '</td>
			<!-- Naturphänomene -->
		</tr>
		<tr>
			<td>'. $arrcatmark[$i][3]. '</td>
			<!-- Beurteilung -->
			<td>';if ($arrmarks[0+$i]==3) {echo("x");} echo '</td>
			<!-- Religion -->
			<td>';if ($arrmarks[8+$i]==3) {echo("x");} echo '</td>
			<!-- Deutsch -->
			<td>';if ($arrmarks[16+$i]==3) {echo("x");} echo '</td>
			<!-- Englisch -->
			<td>';if ($arrmarks[24+$i]==3) {echo("x");} echo '</td>
			<!-- Physik -->
			<td>';if ($arrmarks[32+$i]==3) {echo("x");} echo '</td>
			<!-- Geschichte -->
			<td>';if ($arrmarks[40+$i]==3) {echo("x");} echo '</td>
			<!-- Erdkunde -->
			<td>';if ($arrmarks[48+$i]==3) {echo("x");} echo '</td>
			<!-- Mathematik -->
			<td>';if ($arrmarks[56+$i]==3) {echo("x");} echo '</td>
			<!-- Biologie -->
			<td>';if ($arrmarks[64+$i]==3) {echo("x");} echo '</td>
			<!-- Sport -->
			<td>';if ($arrmarks[72+$i]==3) {echo("x");} echo '</td>
			<!-- Bildende Kunst -->
			<td>';if ($arrmarks[80+$i]==3) {echo("x");} echo '</td>
			<!-- Musik -->
			<td>';if ($arrmarks[88+$i]==3) {echo("x");} echo '</td>
			<!-- Naturphänomene -->
		</tr>
		<tr>
			<td>'. $arrcatmark[$i][4]. '</td>
			<!-- Beurteilung -->
			<td>';if ($arrmarks[0+$i]==4) {echo("x");} echo '</td>
			<!-- Religion -->
			<td>';if ($arrmarks[8+$i]==4) {echo("x");} echo '</td>
			<!-- Deutsch -->
			<td>';if ($arrmarks[16+$i]==4) {echo("x");} echo '</td>
			<!-- Englisch -->
			<td>';if ($arrmarks[24+$i]==4) {echo("x");} echo '</td>
			<!-- Physik -->
			<td>';if ($arrmarks[32+$i]==4) {echo("x");} echo '</td>
			<!-- Geschichte -->
			<td>';if ($arrmarks[40+$i]==4) {echo("x");} echo '</td>
			<!-- Erdkunde -->
			<td>';if ($arrmarks[48+$i]==4) {echo("x");} echo '</td>
			<!-- Mathematik -->
			<td>';if ($arrmarks[56+$i]==4) {echo("x");} echo '</td>
			<!-- Biologie -->
			<td>';if ($arrmarks[64+$i]==4) {echo("x");} echo '</td>
			<!-- Sport -->
			<td>';if ($arrmarks[72+$i]==4) {echo("x");} echo '</td>
			<!-- Bildende Kunst -->
			<td>';if ($arrmarks[80+$i]==4) {echo("x");} echo '</td>
			<!-- Musik -->
			<td>';if ($arrmarks[88+$i]==4) {echo("x");} echo '</td>
			<!-- Naturphänomene -->
		</tr>
		';
	}
		
echo '</table>';

	$today=date('d.m.Y');	

	echo '
	<div><p class="small">R = Religion, D = Deutsch, E = Englisch, P = Physik, G = Geschichte, Geo = Geographie (GWG: Geographie, Wirtschaft, Gemeinschaftskunde), M = Mathematik, Bio = Biologie, Sp = Sport, BK = Kunst, Mu = Musik, Nat = Naturph&auml;nomene</p></div>
	<div class="subscribe"><p>' .$today. ',</p></div>
	<div><p>Datum, Unterschrift des Klassenlehrers</p></div>';

}?>
</body>
</html>
<?php mysqli_close ( $db );?>