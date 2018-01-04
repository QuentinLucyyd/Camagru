<?php
	
	session_start();
	include('database/config.php');
	if (isset($_POST['email'])){
		if (!strchr( $_POST['email'], '@'))
			$result = "Invalid Email Address";
		$check_query = "SELECT * FROM users WHERE user_email=?";
		$check_stmt = $con->prepare($check_query);
		$check_stmt->execute(array($_POST['email']));
		$count = $check_stmt->rowCount();
		if ($count == 0){
			$result = "Sorry, your email is not associated with any account on this website";
		}else{
			$email = $_POST['email'];
			$email_hash = md5($email);
			$temp = rand(999, 9999);
			$code = $email[2].$email_hash[2].$temp;
			$message = "Greeting.\n\nThis is your Camagru password Reset Code\n\nCode: ".$code;
			mail($email, "Camagru: Reset Code", $message, $header);
			$_SESSION['email'] = $email;
			$sqlQuery = "UPDATE users SET password_verify=? WHERE user_email=?";
			$statement = $con->prepare($sqlQuery);
			$statement->execute(array($code,$email));
			header("Location: verify.php");
		}
	}
?>
<html>
<head>
		<title>Reset Password | RushStore</title>
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
		<center><h1 class="header-products">Reset</h1>
		<p class="title">Enter Your Email Address</p>
		<p><?php echo $result?></p>
		<form method="post" name="reset-form">
			<p><input type="text" name="email" value="" placeholder="Email"></p>
			<p class="submit"><input type="submit" name="commit" value="Login"></p>
		</form>
	</div>
	</center>
</div>
<?php include('database/footer.php')?>
</body>
</html>
