<?php
include ('structure/dbconnect.php');

$id=$_GET['id'];
$name=$_GET['changed'];
$subject =$_GET['sub'];

if (($subject == 'Religion evangelisch') || ($subject == 'Religion katholisch')) {
			$subject = 'Religion';
		}
	
		
$mark;
$cat;
if ($name<20){
	$cat=1;
	switch ($name){
		case 11:
			$mark=1;
			break;
		case 12:
			$mark=2;
			break;
		case 13:
			$mark=3;
			break;
		case 14:
			$mark=4;
			break;
	}

}elseif ($name<30) {
	$cat=2;
	switch ($name){
		case 21:
			$mark=1;
			break;
		case 22:
			$mark=2;
			break;
		case 23:
			$mark=3;
			break;
		case 24:
			$mark=4;
			break;
	}

}
elseif ($name<40) {
	$cat=3;
	switch ($name){
		case 31:
			$mark=1;
			break;
		case 32:
			$mark=2;
			break;
		case 33:
			$mark=3;
			break;
		case 34:
			$mark=4;
			break;
	}

}
elseif ($name<50) {
	$cat=4;
	switch ($name){
		case 41:
			$mark=1;
			break;
		case 42:
			$mark=2;
			break;
		case 43:
			$mark=3;
			break;
		case 44:
			$mark=4;
			break;
	}

}elseif ($name<60) {
	$cat=5;
	switch ($name){
		case 51:
			$mark=1;
			break;
		case 52:
			$mark=2;
			break;
		case 53:
			$mark=3;
			break;
		case 54:
			$mark=4;
			break;
	}

}elseif ($name<70) {
	$cat=6;
	switch ($name){
		case 61:
			$mark=1;
			break;
		case 62:
			$mark=2;
			break;
		case 63:
			$mark=3;
			break;
		case 64:
			$mark=4;
			break;
	}

}elseif ($name<80) {
	$cat=7;
	switch ($name){
		case 71:
			$mark=1;
			break;
		case 72:
			$mark=2;
			break;
		case 73:
			$mark=3;
			break;
		case 74:
			$mark=4;
			break;
	}

}elseif ($name<90) {
	$cat=8;
	switch ($name){
		case 81:
			$mark=1;
			break;
		case 82:
			$mark=2;
			break;
		case 83:
			$mark=3;
			break;
		case 84:
			$mark=4;
			break;
	}

}elseif ($name<100) {
	$cat=9;
	switch ($name){
		case 91:
			$mark=1;
			break;
		case 92:
			$mark=2;
			break;
		case 93:
			$mark=3;
			break;
		case 94:
			$mark=4;
			break;
	}

}

$query="UPDATE `vb_schueler` SET `S_" . $subject . "_" . $cat . "` = '" . $mark . "' WHERE `vb_schueler`.`S_Nr` = " . $id . ";";

if (mysqli_query($db, $query)){
	echo 'Saved';
}else {
	echo 'Error';
}
?>