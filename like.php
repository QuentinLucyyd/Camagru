<?php
	opcache_reset();
	session_start();
	include('database/config.php');
	$id = $_GET['image'];
	$username = $_SESSION['username'];
	var_dump($username);
	echo "<br>";
	$query = "SELECT likes FROM images WHERE ID=?";
	$statement = $con->prepare($query);
	$statement->execute(array($id));
	$row = $statement->fetch();
	$likes = $row['likes'];
	$likes_array = explode('*', $likes);
	if (!in_array($username, $likes_array)){
		$final = $likes.$username.'*';
		var_dump($final);
		$sql = "UPDATE images SET likes=? WHERE ID=?";
		$statement = $con->prepare($sql);
		$statement->execute(array($final, $id));
		header('location: gallery.php');
	}else{
		$pos = array_search($username, $likes_array);
		unset($likes_array[$pos]);
		$final = implode('*', $likes_array);
		$sql = "UPDATE images SET likes=? WHERE ID=?";
		$statement = $con->prepare($sql);
		$statement->execute(array($final, $id));
		header('location: gallery.php');
	}
?>