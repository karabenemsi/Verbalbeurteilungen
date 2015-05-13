<?php
//For SSL-Connection decomment following lines
//if(($_SERVER['HTTPS'] != "on")|| empty($_SERVER['HTTPS']))
//{
//	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//
//}

session_start();

$hostname = $_SERVER['HTTP_HOST'];
     $path = dirname($_SERVER['PHP_SELF']);

     if ((!isset($_SESSION['login']) || !$_SESSION['login'] || !(isset($_SESSION['CLASSTEACHER']) || $_SESSION['ADMIN']==1)) ) {
     		/*header('Location://'.$hostname.'/index.php');*/
     	echo '';
      exit;
}
?>