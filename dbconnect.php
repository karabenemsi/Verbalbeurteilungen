<?php


	$db = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
	if(!$db)
	{
		exit('Vebindungsfehler: ' . mysqli_error());
	}
	?>
