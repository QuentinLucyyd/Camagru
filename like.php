<?php
	
	session_start();
	include('database/config.php');
	$id = $_GET['image'];
	$username = $_SESSION['username'];
	echo "<br>";
	$query = "SELECT likes FROM images WHERE ID=?";
	$statement = $con->prepare($query);
	$statement->execute(array($id));
	$row = $statement->fetch();
	$likes = $row['likes'];
	$likes_array = explode('*', $likes);
	if (!in_array($_SESSION['id'], $likes_array)){
		$final = $likes.$_SESSION['id'].'*';
		$sql = "UPDATE images SET likes=? WHERE ID=?";
		$statement = $con->prepare($sql);
		$statement->execute(array($final, $id));
		header('location: gallery.php');
	}else{
		$pos = array_search($_SESSION['id'], $likes_array);
		unset($likes_array[$pos]);
		$final = implode('*', $likes_array);
		$sql = "UPDATE images SET likes=? WHERE ID=?";
		$statement = $con->prepare($sql);
		$statement->execute(array($final, $id));
		header('location: gallery.php');
	}
?>