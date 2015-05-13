<?php
?><?php
include ('../authadmin.php');
include ('../structure/dbconnect.php');
include ('../structure/header1.php');
?>

<?php
echo '<title>Change</title>';
// Header
include ('../structure/header2.php');

// Body
echo '
			<div class="container">
				<a href="../customize.php"><div class="back"></div></a>
			</div>
		<div class="container">
				<p>You need to change the Database in <a href="http://localhost/phpmyadmin/">phpMyAdmin</a></p>
		</div>';

// Footer
include ('../structure/footer.php');
?>
