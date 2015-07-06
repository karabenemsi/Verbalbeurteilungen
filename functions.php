<?php

// 1. DB-Connection
// 2. getheader($title)
// 3. getfooter()






$db = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if(!$db)
{
	exit('Vebindungsfehler: ' . mysqli_error());
}



function getheader($title){

if (isset($_SESSION)) {
	$user = $_SESSION ['USER'];
}else {
	$user = 'Login';
}

if(!isset($title)){
	$title='Verbalbeurteilungen';
}
echo '
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" >
		<meta name="author" content="Florian Lubitz, Marcel Killinger, Leander Eger" >
		<meta name="description" content="PHP and SQL based Application for students mark management" >
		<meta name="keywords" content="Gymnasium Balingen, Verbalbeurteilungen, Unterstufe, Textbeurteilungen" >
		<title>' . $title . '</title>
		<link rel="stylesheet" type="text/css" href="//' . $_SERVER['HTTP_HOST'] . '/style/style.css" />
		<link rel="shortcut icon" href="//' . $_SERVER['HTTP_HOST'] . '/pictures/site/favicon.ico" type="image/x-icon">
		<link rel="icon" href="//' . $_SERVER['HTTP_HOST'] . '/pictures/site/favicon.ico" type="image/x-icon">
		<script type="text/javascript"
			src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
		<!--<script type="text/javascript"
			src="//' . $_SERVER['HTTP_HOST'] . '/script/jquery-2.1.3.min.js"></script>-->
		<script type="text/javascript" src="//' . $_SERVER['HTTP_HOST'] . '/script/main.js"></script>
	</head>

	<body>
		<div class="wrapper">

		<header>
		<h1 id="header_title"><a href="//' . $_SERVER['HTTP_HOST'] . '/index.php">' . SITEHEADING . '</a></h1>
		<div id="ajaxrequest"></div>


		<input type="checkbox" id="menu" class="checkboxmenu">
		<label for="menu" onclick></label>
		<nav role="off-canvas">
		    <ul>
				<li><a href="//' . $_SERVER['HTTP_HOST'] . '/index.php">Home</a></li>';

if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1 || isset($_SESSION['CLASSTEACHER'])) {
		echo '<li class = "cat2"><a href="//' . $_SERVER['HTTP_HOST'] . '/admin/printalarm.php">Drucken</a></li>';
	}
}
echo '
				<li><a href="//' . $_SERVER['HTTP_HOST'] . '/login.php">Login</a></li>
				<li><a href="//' . $_SERVER['HTTP_HOST'] . '/logout.php">Logout</a></li>
				<li><a href="//' . $_SERVER['HTTP_HOST'] . '/changepw.php">Passwort &auml;ndern</a></li>
				';
// if (isset ( $_SESSION ['ADMIN'] )) {
// 	if ($_SESSION ['ADMIN'] == 1) {
// 		echo '<li><a href="//' . $_SERVER['HTTP_HOST'] . '/admintools.php">Admin</a></li>
// 						';
// 	}
// }
echo '
			</ul>
		</nav>


		<nav>
			<ul>
				<li class = "cat1">
					<a href="//' . $_SERVER['HTTP_HOST'] . '/index.php">Home</a>
				</li>
				';
if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1 || isset($_SESSION['CLASSTEACHER'])) {
		echo '<li class = "cat2"><a href="//' . $_SERVER['HTTP_HOST'] . '/admin/printalarm.php">Drucken</a></li>';
	}
}
echo '
				<li class = "cat3">
					<a href="#">' . $user . '</a>
						<ul>
							<li><a href="//' . $_SERVER['HTTP_HOST'] . '/login.php">Login</a></li>
							<li><a href="//' . $_SERVER['HTTP_HOST'] . '/logout.php">Logout</a></li>
							<li><a href="//' . $_SERVER['HTTP_HOST'] . '/changepw.php">Passwort &auml;ndern</a></li>
							';
if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1) {
		echo '<li><a href="//' . $_SERVER['HTTP_HOST'] . '/admintools.php">Admin</a></li>
						';
	}
}
echo '</ul>
				</li>
           	 	</ul>
       	 	</nav>

		</header>

		<div id="margin_box_top" >
		</div>


		<div class="content">';

unset ( $query );
unset ( $result );
}




function getfooter()
{
	echo '
					<footer>

						<div class="footercontent">
							<img src="//' . $_SERVER['HTTP_HOST'] . '/pictures/site/Footer/Logo_FCG_003_400.png" width="100" alt="FlowR Logo" ><p>FlowR Coding</p>
						</div>
						<div class="footercontent">
							<p><span id="copyright">Copyright: Marcel Killinger, Florian Lubitz, Leander Eger</span></p>
						</div>
						<div class="footercontent">
							<p>

	    							<img style="border:0;width:88px;height:31px"
	       							 src="//' .$_SERVER['HTTP_HOST'] . '/pictures/site/Footer/vcss-blue.gif"
	       							alt="CSS ist valide!" />

							</p>
						</div>


					</footer>
				</div>
			</div>

		</body>
	</html>
	';
}


?>
