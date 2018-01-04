<?php
	opcache_reset();
	include('database/config.php');
	include('database/functions.php');
	session_start();
	if (!isset($_SESSION['username'])){
		header('location: signin.php');
	}else{
	$username = $_SESSION['username'];
	$id = $_GET['image'];
	if (isset($_POST['comment'])){
		$comment = htmlspecialchars($_POST['comment']);
		$query = "INSERT INTO comments (user, comment, image, user_id) VALUES (:user, :comment, :image, :user_id)";
		$stmt = $con->prepare($query);
		$stmt->bindParam(':user', $username);
		$stmt->bindParam(':comment', $comment);
		$stmt->bindParam(':image', $id);
		$stmt->bindParam(':user_id', $_SESSION['id']);
		$stmt->execute();
		$get_email_query = "SELECT user FROM images WHERE ID=?";
		$get_email_stmt = $con->prepare($get_email_query);
		$get_email_stmt->execute(array($id));
		$row = $get_email_stmt->fetch();
		$to = $row["user"];
		$query = "SELECT * FROM users WHERE user_name=?";
		$userstmt = $con->prepare($query);
		$userstmt->execute(array($to));
		$row = $userstmt->fetch();
		$email = $row['user_email'];
		if ($row["email_pref"] == "true"){
			$comment_message = "Greetings ". $to ."<br><br>You have recieved a new Comment On Your Image from ".$username.", Please Login to Check The Comment<br><br>
			http://localhost:8080/Camagru/comment.php?image=".$id."<br><br>Kind Regards.";
			mail($email, "You Have a New Comment", $comment_message, $header);
		}
	}
}
?>
<html>
<head>
		<title>Comment | Camagru</title>
		<link rel="stylesheet" type="text/css" href="css/full.css">
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
		<div class="login-container">
	<div class="login">
	<h1 class="header-products grey center">Comment</h1>
	<div id="portfolio">
	<?php
	$sqlquery = "SELECT * FROM images WHERE ID=?";
	$statement = $con->prepare($sqlquery);
	$statement->execute(array($_GET['image']));
	$row = $statement->fetch();
	?>
	<div class="thumb">
	<figure class="cap-left">
		<a href="#"><img src="<?php echo $row['file_name']?>" alt=""></a>
			<figcaption><a href="<?php echo"like.php?image=".$row['ID']?>">
			<p><?php
				$likes = "SELECT likes FROM images WHERE ID=?";
				$stmt = $con->prepare($likes);
				$stmt->execute(array($_GET['image']));
				$arr = $stmt->fetch();
				$num_arr = explode('*', $arr['likes']);
				$num = sizeof($num_arr);
				echo $num - 1;
			?></p>
			<img class="love-button" src="<?php
			if (!in_array($username, $num_arr))
				echo'img/icons/heart.png';
			else
				echo 'https://vignette.wikia.nocookie.net/victorious/images/d/d9/Heart.png';
			?>
			"/></a>
			<a href="<?php echo "comment.php?image=".$row['ID']?>">
			<img class="love-button" src="http://rinjanihero.com/wp-content/uploads/2016/08/icon-contact-white.png"></a>
			</figcaption>
		</figure>
	</div>
	<h3 class="grey"><?php echo $row['user']?></h3>
	<img class="uploader-img" src="<?php 
		$user_name = $row['user'];
		$query = "SELECT * FROM users WHERE user_name=?";
		$stmt = $con->prepare($query);
		$stmt->execute(array($user_name));
		$rowfetch = $stmt->fetch();
		echo $rowfetch['profile_image'];
	?>" />
	<h3 class="white"><?php echo $row['caption']?><h3>
	</div>
	</div>
	<div class="comment-section">
		<div class="profile-sect">
			<!--<img class="profile-image" src="<?php echo $imgrow['profile_image'] ?>"/>-->
			<?php
					$query = "SELECT * FROM comments WHERE image=?";
					$stmt = $con->prepare($query);
					$stmt->execute(array($_GET['image']));
					$comment_arr = $stmt->fetchAll();
					foreach($comment_arr as $value)
					{?>
						<h3 class="grey"><?php echo $value['user']?></h3>
						<p class="white"><?php echo $value['comment'];?></p>
					<?php } ?>
		</div>
	</div><br>
		<div class="comment-form">
		<form method="post" name="submit_form">
	Comment here:<br>
	<textarea name="comment" cols="40">
	</textarea>
	<p class="submit"><input type="submit" name="comment-submit" value="Done"></p>
	</form>
		</div>
</div>
<?php //include('database/footer.php')?>
</body>
</html>
