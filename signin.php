<html>
<head>
		<title>Sign in | RushStore</title>
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
		<center><h1 class="header-products white">Sign in</h1>
	<?php include('database/signin.php');?>
	<?php include('database/confirm.php');?>
		<?php echo "<h3 class=\"header-products white\">".$result."</h3>";?>
		<form method="post" name="signin-form">
			<p><input type="text" name="email" value="" placeholder="Email"></p>
			<p><input type="password" name="password" value="" placeholder="Password"><a href="forgot.php"><span class="pass-length">Forgot Password ?</span></a></p>
			<p class="remember_me">
				<label>
				 <label>
					<input type="checkbox" name="remember_me" id="remember_me">
					<span class="white">Remember me on this computer</span>
				</label>
				</label>
			</p>
			<p class="white sml">If you do not have an account please <a href="register.php"><span class="grey sml">Register</span></a></p>
			<p class="submit"><input type="submit" name="commit" value="Login"></p>
		</form>
	</div>
	</center>
</div>
<?php include('database/footer.php')?>
</body>
</html>