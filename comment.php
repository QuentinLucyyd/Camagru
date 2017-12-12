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
	if (isset($_POST['comment-submit'])){
		$comment = $_POST['comment'];
		$query = "INSERT INTO comments (user, comment, image) VALUES (:user, :comment, :image)";
		$idFetch = "SELECT * FROM comments WHERE image = :image ORDER BY date DESC";
		$stmt = $con->prepare($query);
		$stmt->bindParam(':user', $username);
		$stmt->bindParam(':comment', $comment);
		$stmt->bindParam(':image', $image);
		$stmt->execute();
		$fetchstmt = $con->prepare($idFetch);
		$fetchstmt->bindParam(':image', $image);
		$fetchstmt->execute();
		$row = $fetchstmt->fetch();
		$comment_id = $row['ID'];
		$user_name = $row['user'];
		$query = "SELECT user_email FROM users WHERE user_name=?";
		$stmt = $con->prepare($query);
		$stmt->execute(array($_SESSION['username']));
		$rowfetch = $stmt->fetch();
		$email = $rowfetch['user_email'];
		$message = "http://localhost:8080/Camagru/comment.php?image=".$_GET['image'];
		mail($email, "You have a new Comment on Your Picture:\n\n", $message, $header);
	}
	if (isset($comment_id)){
		$sel = "SELECT * FROM images WHERE ID=?";
		$statement = $con->prepare($sel);
		$statement->execute(array($_GET['image']));
		$row = $statement->fetch();
		$comment_arr = explode('#', $row['comment_id']);
		array_push($comment_arr, $comment_id);
		$comment_id = implode('#', $comment_arr);
		$query = "UPDATE images SET comment_id=:comment_id WHERE ID=:id";
		$statement = $con->prepare($query);
		$statement->bindParam(':comment_id', $comment_id);
		$statement->bindParam(':id', $_GET['image']);
		$statement->execute();
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
			<img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png">
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
	$statement->execute(array($id));
	$row = $statement->fetch();
	?>
	<div class="thumb">
	<figure class="cap-left">
		<a href="#"><img src="<?php echo $row['file_name']?>" alt=""></a>
			<figcaption><a href="<?php echo"like.php?image=".$row['ID']?>">
			<p><?php
				$likes = "SELECT likes FROM images WHERE ID=?";
				$stmt = $con->prepare($likes);
				$stmt->execute(array($row['ID']));
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
	<?php
		$sel = "SELECT * FROM images WHERE ID=?";
		$statement = $con->prepare($sel);
		$statement->execute(array($_GET['image']));
		$sect = $statement->fetch();
		$comment_arr = explode('#', $sect['comment_id']);
		unset($comment_arr[0]);
		foreach($comment_arr as $value){
			$sel = "SELECT * FROM comments WHERE ID=?";
			$stmt = $con->prepare($sel);
			$stmt->execute(array($value));
			$row = $stmt->fetch();
	?>
		<div class="profile-sect">
		<?php
			$imgquery = "SELECT profile_image FROM users WHERE user_name=?";
			$imgstmt = $con->prepare($imgquery);
			$imgstmt->execute(array($row['user']));
			$imgrow = $imgstmt->fetch();
		?>
			<img class="profile-image" src="<?php echo $imgrow['profile_image'] ?>"/>
			<p class="grey"><?php echo $row['user']?></p>
			<p class="white sml"><?php echo $row['comment']?></p>
		</div>
		<?php }?>
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
<?php include('database/footer.php')?>
</body>
</html>
