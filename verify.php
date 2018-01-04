<?php
	session_start();
	include('database/config.php');
	if (isset($_POST['code'])){
		$unhash = $_POST['new_password'];
		$email = $_SESSION['email'];
		$password = password_hash($unhash, PASSWORD_DEFAULT);
		$sqlQuery = "SELECT * FROM users WHERE user_email=?";
		$statement = $con->prepare($sqlQuery);
		$statement->execute(array($email));
		$count = $statement->rowCount();
		if ($count == 1){
			$row = $statement->fetch();
			if ($row['password_verify'] != $_POST['code'])
				$result = "Codes do not match, Please try again";
			else{
				$cquery = "UPDATE users SET user_pass=? WHERE user_email=?";
				$stmt = $con->prepare($cquery);
				$stmt->execute(array($password,$email));
				$result = "Password changed, You May now log in, You will be redirected in a few seconds";
				header('Refresh: 4; URL=http://localhost:8080/Camagru/signin.php');
			}
		}
	}
?>
<html>
<head>
		<title>Change Password | RushStore</title>
		<link rel="stylesheet" type="text/css" href="css/full.css">
		<link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
 <div class="navigation-bar">
		<div id="navigation-container">
			<a href="index.php"><img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png"></a>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="register.php">Register</a></li>
				<li class="active"><a href="signin.php">Sign in</a></li>
			</ul>
		</div>
		<div class="login-container">
	<div class="login">
		<center><h1 class="header-products">Change</h1>
		<p><?php echo $result;?></p>
		<form method="post" name="reset-form">
			<p><input type="text" name="code" value="" placeholder="Code"></p>
			<p><input type="password" name="new_password" value="" placeholder="New Password"></p>
			<p><input type="password" name="confirm_password" value="" placeholder="Confirm Password"></p>
			<p class="submit"><input type="submit" name="commit" value="Change"></p>
		</form>
	</div>
	</center>
</div>
<?php include('database/footer.php')?>
</body>
</html>
