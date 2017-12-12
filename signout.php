<?php
	session_start();
	if (isset($_COOKIE['logged_in'])){
		setcookie('logged_in', NULL, -1);
	}
	unset($_SESSION['id']);
	session_destroy();
	header("Location: signin.php");
	exit;
?>