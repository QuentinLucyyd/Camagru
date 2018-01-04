<?php
	opcache_reset();
	include('database/config.php');
	if (isset($_GET['image'])){
		$image = $_GET['image'];
		$sql = "DELETE FROM images WHERE ID=?";
		$statement = $con->prepare($sql);
		$statement->execute(array($image));
		$url = $_SERVER['HTTP_REFERER'];
		header('location: '.$url);
	}
?>