<?php
include ('authadmin.php');
include 'settings.php';
include 'functions.php';
getheader('Admintools');

// Body

echo '
	<div class="grid6_box">
		<div class="grid6_row">
			<a href="admin/import.php"><div class="grid6_col-2">
				<h1>Importieren</h1>
				<p>CSV-Dateien importieren</p>
			</div></a><!--Col-->
			<a href="#"><div class="grid6_col-2-mid">
				<h1>Arangieren</h1>
				<p>F&auml;cher und Klassen zuweisen</p>
			</div></a><!--Col-->
			<a href="#"><div class="grid6_col-2">
				<h1>Neu anlegen</h1>
				<p>Neue Klassen, Lehrer, Sch&uuml;ler anlegen</p>
			</div><!--Col-->
		</div><!--Row-->
		<div class="grid6_row">
			<a href="#"><div class="grid6_col-2-mid">
				<h1>Importieren</h1>
				<p>CSV-Dateien importieren</p>
			</div></a><!--Col-->
			<a href="#"><div class="grid6_col-2">
				<h1>Arangieren</h1>
				<p>F&auml;cher und Klassen zuweisen</p>
			</div></a><!--Col-->
			<a href="#"><div class="grid6_col-2-mid">
				<h1>Neu anlegen</h1>
				<p>Neue Klassen, Lehrer, Sch&uuml;ler anlegen</p>
			</div><!--Col-->
		</div><!--Row-->
	</div><!--Box-->';

// Footer
mysqli_close($db);
getfooter();
?>
