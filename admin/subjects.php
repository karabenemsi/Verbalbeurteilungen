<?php
include ('../authadmin.php');
include '../functions.php';


getheader();

// Body
echo '
			<div class="container">
				<a href="../admintools.php"><div class="back"></div></a>
			</div>
		<div class="container">
				<p>You need to change the Database in <a href="http://localhost/phpmyadmin/">phpMyAdmin</a></p>
		</div>';

// Footer
mysqli_close($db);
getfooter();
?>
