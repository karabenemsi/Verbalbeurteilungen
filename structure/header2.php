<?php
$hostname = $_SERVER ['HTTP_HOST'];
if (isset($_SESSION)) {
	$user = $_SESSION ['USER'];
}else {
	$user = 'Login';
}
$query = "SELECT T_cat_name FROM vb_text WHERE T_USE='sitetitle'";
$result = mysqli_fetch_array ( mysqli_query ( $db, $query ) );
$title = $result [0];
?>
		<link rel="stylesheet" type="text/css" href="//<?php echo $hostname; ?>/style/style.css" />
		<link rel="shortcut icon" href="//<?php echo $hostname; ?>/pictures/site/favicon.ico" type="image/x-icon">
		<link rel="icon" href="//<?php echo $hostname; ?>/pictures/site/favicon.ico" type="image/x-icon">
		<script type="text/javascript"
			src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js?ver=1.4.2"></script>
		<!--<script type="text/javascript"
			src="//<?php echo $hostname; ?>/script/jquery-2.1.3.min.js"></script>-->
		<script type="text/javascript" src="//<?php echo $hostname; ?>/script/main.js"></script>
	</head>

	<body>
		<div class="wrapper">

		<header>
		<h1 id="header_title"><a href="//<?php echo $hostname; ?>/index.php"><?php echo $title; ?></a></h1>
		<div id="ajaxrequest"></div>
		

		<input type="checkbox" id="menu" class="checkboxmenu">
		<label for="menu" onclick></label>
		<nav role="off-canvas">
		    <ul>
				<li><a href="//<?php echo $hostname; ?>/index.php">Home</a></li>
<?php

if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1 || isset($_SESSION['CLASSTEACHER'])) {
		echo '<li class = "cat2"><a href="//' . $hostname . '/admin/printalarm.php">Drucken</a></li>';
	}
}
echo '
				<li><a href="//' . $hostname . '/login.php">Login</a></li>
				<li><a href="//' . $hostname . '/logout.php">Logout</a></li>
				<li><a href="//' . $hostname . '/changepw.php">Passwort &auml;ndern</a></li>
				';
if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1) {
		echo '<li><a href="//' . $hostname . '/customize.php">Anpassen</a></li>
						';
	}
}
echo '
			</ul>
		</nav>


		<nav>
			<ul>
				<li class = "cat1">
					<a href="//' . $hostname . '/index.php">Home</a>
				</li>
				';
if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1 || isset($_SESSION['CLASSTEACHER'])) {
		echo '<li class = "cat2"><a href="//' . $hostname . '/admin/printalarm.php">Drucken</a></li>';
	}
}
echo '
				<li class = "cat3">
					<a href="#">' . $user . '</a>
						<ul>
							<li><a href="//' . $hostname . '/login.php">Login</a></li>
							<li><a href="//' . $hostname . '/logout.php">Logout</a></li>
							<li><a href="//' . $hostname . '/changepw.php">Passwort &auml;ndern</a></li>
							';
if (isset ( $_SESSION ['ADMIN'] )) {
	if ($_SESSION ['ADMIN'] == 1) {
		echo '<li><a href="//' . $hostname . '/customize.php">Anpassen</a></li>
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
?>