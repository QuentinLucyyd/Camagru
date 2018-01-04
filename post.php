<?php
include('database/config.php');
session_start();
if (!isset($_SESSION['id']))
	header('Location: signin.php');
	$file_name = $_SESSION['file_name'];
	$user_id = $_SESSION['id'];
	$username = $_SESSION['username'];
	if (isset($_POST['comment'])){
		$comment = $_POST['comment'];
		$queryimg = "INSERT INTO images (file_name, user, caption, user_id) VALUES (?, ?, ?, ?)";
		$statement = $con->prepare($queryimg);
		$statement->execute(array($file_name, $username, $comment, $user_id));
		header('location: gallery.php');
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Camagru | Post</title>

	<link href="css/full.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="img/logo.png">
	</head>

	<body>

		<!-- Navigation -->
		<div class="navigation-bar">
		<div id="navigation-container">
			<a href="index.php"><img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png"></a>
			<ul>
				<li><a href="picture.php">Picture</a></li>
				<li><a href="gallery.php">Gallery</a></li>
					<li><a href="account.php">Account</a></li>
					<li><a href="signout.php">Sign out</a></li>
			</ul>
		</div>
	<div class="container-full">
	<center>
		<img src=<?php echo '"'.$file_name.'"'?>/>
		<form method="post" name="submit_form">
		Type your Caption here:<br>
		<textarea name="comment" rows="4" cols="50">
		</textarea>
		<p class="submit"><input type="submit" name="commit" value="Done"></p>
		</form>
		<a href="picture.php"><p class="grey">Back</p></a>
	</center>
	</div>
	<?php include('database/footer.php')?>
	</body>
</html>
