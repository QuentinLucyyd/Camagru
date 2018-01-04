<?php
	
	include('database/config.php');
	include('database/function.php');
	session_start();
	$username = $_SESSION['username'];
	$sqlquery = "SELECT * FROM images ORDER BY post_date";
	$statement = $con->prepare($sqlquery);
	$statement->execute();
	$count = $statement->rowCount();
	$limit = 6;
	$start = 0;
	$end = $limit;
	$round = floor($count / 6);
	if (is_float($count / 6))
		$round = $round + 1;
	if (isset($_GET['page'])){
		$page = $_GET['page'];
		$page = $page -1;
		$start = $page * $limit;
	}else{
	}
?>
<html>
<head>
		<title>Galley | RushStore</title>
		<link rel="stylesheet" type="text/css" href="css/full.css">
		<link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
		<!-- Navigation -->
		<div class="navigation-bar">
		<div id="navigation-container">
			<a href="index.php"><img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png"></a>
			<ul>
				<?php
					if (isset($_SESSION['id'])){
				?>
				<li><a href="picture.php">Picture</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="account.php">Account</a></li>
				<li><a href="signout.php">Sign out</a></li>
					<?php }else{?>
						<li><a href="gallery.php">Gallery</a></li>
						<li><a href="register.php">Register</a></li>
						<li><a href="signin.php">Sign in</a></li>
					<?php }?>
			</ul>
		</div>
		<div class="login-container">
	<div class="login">
	<h1 class="header-products grey center">Gallery</h1>
	<center>
	<div id="portfolio">
	<?php
	$sqlquery = "SELECT * FROM images ORDER BY ID DESC LIMIT $start,$end";
	$statement = $con->prepare($sqlquery);
	$statement->execute();
	while ($row = $statement->fetch())
	{?>
	<div class="thumb">
	<figure class="cap-left">
		<a href="#"><img class="thumb-image" src="<?php echo $row['file_name']?>" alt=""></a>
			<figcaption><a href="<?php if (isset($_SESSION['id'])){echo"like.php?image=".$row['ID'];}else{echo "#";}?>">
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
			if (isset($_SESSION['id'])){
				if (!in_array($_SESSION['id'], $num_arr))
					echo'img/icons/heart.png';
				else
					echo 'https://vignette.wikia.nocookie.net/victorious/images/d/d9/Heart.png';
			}else{
				echo 'img/icons/heart.png';
			}
			?>
			"/></a>
			<a href="<?php if (isset($_SESSION['id'])){echo"comment.php?image=".$row['ID'];}else{echo "#";}?>">
			<img class="love-button" src="http://rinjanihero.com/wp-content/uploads/2016/08/icon-contact-white.png"></a>
			<?php if ($row['user'] == $_SESSION['username']){?>
			<a href="<?php echo "delete.php?image=".$row['ID']?>"><p class="sml">Delete</p>
			<?php }?>
			</figcaption>
		</figure>
	</div>
<?php
	}
	?>
	</div>
</center>
	</div>
</div>
<center>
<?php include('database/pagination.php')?>
</center>
<?php include('database/footer.php')?>
</body>
</html>