<?php
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

include('config.php');
// Create `comments` Table
$create = "CREATE TABLE IF NOT EXISTS `comments` (
	`ID` int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user` varchar(256) NOT NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`comment` text NOT NULL,
	`image` varchar(255) NOT NULL,
	`user_id` int(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$create_stmt = $con->prepare($create);
$create_stmt->execute();

// Create `images` Table

$create = "CREATE TABLE IF NOT EXISTS `images` (
	`ID` int(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`user_id` int(255) NOT NULL,
	`file_name` text NOT NULL,
	`user` varchar(250) NOT NULL,
	`post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`comment_id` text NOT NULL,
	`caption` text NOT NULL,
	`likes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$create_stmt = $con->prepare($create);
$create_stmt->execute();

// Table structure for table `likes`

$create = "CREATE TABLE IF NOT EXISTS `likes` (
	`ID` int(255) NOT NULL,
	`user` varchar(256) NOT NULL,
	`post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$create_stmt = $con->prepare($create);
$create_stmt->execute();

// Table structure for table `users`

$create = "CREATE TABLE IF NOT EXISTS `users` (
	`user_id` int(100) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`first_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`user_name` varchar(15) NOT NULL,
	`user_email` varchar(40) NOT NULL UNIQUE KEY,
	`user_pass` varchar(255) NOT NULL,
	`profile_image` varchar(500) NOT NULL DEFAULT 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png',
	`joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`confirm_check` text NOT NULL,
	`password_verify` text NOT NULL,
	`email_pref` varchar(7) NOT NULL DEFAULT 'true'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$create_stmt = $con->prepare($create);
$create_stmt->execute();
header("Location: http://localhost:8080/Camagru/setup.php");
?>