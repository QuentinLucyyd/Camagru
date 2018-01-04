<?php
	session_start();
	include('database/config.php');
	if (isset($_POST['edit-submit'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$id = $_SESSION['id'];

		$cquery = "UPDATE users SET first_name=? last_name=> $email=? WHERE ID=?";
		$stmt = $con->prepare($cquery);
		$stmt->execute(array($first_name, $last_name, $email, $id));
	}
?>