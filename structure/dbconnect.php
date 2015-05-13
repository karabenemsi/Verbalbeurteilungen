<?php
	$db = mysqli_connect('localhost', 'root', 'root', 'verbalbeurteilungen');
	if(!$db)
	{
		exit('Vebindungsfehler: ' . mysqli_error());
	}
	?>