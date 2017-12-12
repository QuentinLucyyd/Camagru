<?php
opcache_reset();
include('config.php');
$user = 'root';
$pass = 'zprcRfED';
$dsn = 'mysql:host=localhost';
try{
	$concreate = new PDO($dsn, $user, $pass);

	$concreate->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
	echo '<h3>Connection Failed '.$e->getMessage().'</h3>';
}

$create = "CREATE DATABASE IF NOT EXISTS `camagru`";
$create_stmt = $concreate->prepare($create);

$create_stmt->execute();
$table = "CREATE TABLE IF NOT EXISTS `comments` (
	`ID` int(255) NOT NULL,
	`user` varchar(256) NOT NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`comment` text NOT NULL,
	PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$table_stmt = $con->prepare($table);
$table_stmt->execute();

$table = "CREATE TABLE IF NOT EXISTS `images` (
	`ID` int(255) NOT NULL AUTO_INCREMENT,
	`file_name` text NOT NULL,
	`user` varchar(250) NOT NULL,
	`post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`comment_id` text NOT NULL,
	`caption` text NOT NULL,
	`likes` text NOT NULL,
	PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$table_stmt = $con->prepare($table);
$table_stmt->execute();

$table = "CREATE TABLE IF NOT EXISTS `likes` (
	`ID` int(255) NOT NULL,
	`user` varchar(256) NOT NULL,
	`post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$table_stmt = $con->prepare($table);
$table_stmt->execute();

$table = "CREATE TABLE IF NOT EXISTS `users` (
	`user_id` int(100) NOT NULL AUTO_INCREMENT,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`user_name` varchar(15) NOT NULL,
	`user_email` varchar(40) NOT NULL,
	`user_pass` varchar(255) NOT NULL,
	`profile_image` varchar(500) NOT NULL DEFAULT 'http://www.lemmens.com/content/uploads/2015/12/avatar.pnghttps://www.hostechsupport.com/admin/testimonial/avtar.pnghttps://www.hostechsupport.com/admin/testimonial/avtar.png',
	`joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`confirm_check` text NOT NULL,
	`password_verify` text NOT NULL,
	PRIMARY KEY (`user_id`),
	UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
$table_stmt = $con->prepare($table);
$table_stmt->execute();
?>
