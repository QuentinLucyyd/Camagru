<html>
<head>
		<title>Register | RushStore</title>
		<link rel="stylesheet" type="text/css" href="css/full.css">
		<link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
 <div class="navigation-bar">
		<div id="navigation-container">
			<a href="index.php"><img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png"></a>
			<ul>
				<li><a href="gallery.php">Gallery</a></li>
				<li><a href="register.php">Register</a></li>
				<li class="active"><a href="signin.php">Sign in</a></li>
			</ul>
		</div>
		<div class="login-container">
	<div class="login">
		<center><h1 class="header-products">Register</h1>
		<?php include('database/register.php');?>
		<?php echo "<h3 class=\"header-products\">".$result."</h3>";?>
		<form method="post" name="register-form" action="register.php">
			<p><input type="text" name="first_name" value="" placeholder="First Name"></p>
			<p><input type="text" name="last_name" value="" placeholder="Last Name"></p>
			<p><input type="text" name="username" value="" placeholder="Username"></p>
			<p><input type="text" name="email" value="" placeholder="Email"></p>
			<p><input type="password" name="password" value="" placeholder="Password"><span class="pass-length">Min length (8), and at least one number</span></p>
			<p><input type="password" name="confirm_password" value="" placeholder="Confirm Password"><span class="pass-length"></span></p>
			<p class="remember_me">
				<label>
				 <label>
					<input type="checkbox" name="remember_me" id="remember_me">
					Remember me on this computer
				</label>
				</label>
			</p>
			<p class="submit"><input type="submit" name="commit" value="Register"></p>
		</form>
	</div>
	</center>
</div>
<?php include('database/footer.php')?>
</body>
</html>