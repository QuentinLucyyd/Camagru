<?php
	$user = 'root';
	$pass = 'zprcRfED';
	$dsn = 'mysql:host=localhost;dbname=camagru';
	$header = "From: qkotsedi@gmail.com\r\n";
	$header.= "MIME-Version: 1.0\r\n";
	$header.= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
	$header.= "X-Priority: 1\r\n";
	
	try{
		$con = new PDO($dsn, $user, $pass);
		
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}catch (PDOException $e){
		echo '<h3>Connection Failed '.$e->getMessage().'</h3>';
	}
?>