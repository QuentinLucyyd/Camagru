<?php
	opcache_reset();
	include('database/config.php');
	include('database/functions.php');
	session_start();
	if (!isset($_SESSION['username']))
		header('Location: signin.php');
		if (isset($_POST['edit-submit'])){
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$email = $_POST['email'];
			$id = $_SESSION['id'];

			$query = "UPDATE users SET first_name=:first_name, last_name=:last_name, user_email=:email WHERE user_id=:id";
			$stmt = $con->prepare($query);
			$stmt->bindParam(':first_name', $first_name);
			$stmt->bindParam(':last_name', $last_name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}
		if (isset($_POST['pwd-submit'])){
			$password = $_POST['password'];
			$conf_pass = $_POST['confirm_password'];

			if ($password != $conf_pass)
				$res = "Passwords do not Match";
			else{
				$hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
				$query = "UPDATE users SET user_pass=? WHERE user_id=?";
				$stmt = $con->prepare($query);
				$stmt->execute(array($hashed_pwd, $_SESSION['id']));
			}
		}
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$ext = explode(".", $target_file);
			$length = count($ext);
			$length = $length - 1;
			if($check !== false) {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$sqlQuery = "UPDATE users SET profile_image=? WHERE user_name=?";
					$statement = $con->prepare($sqlQuery);
					$statement->execute(array($target_file, $_SESSION['username']));
			} else {
					$result = "Sorry, there was an error uploading your file.";
			}
			} else {
				$result = "File is not an image.";
			}
			unset($_POST);
	}
	$sqlQuery = "SELECT * FROM users WHERE user_name=:username";
	$statement = $con->prepare($sqlQuery);
	$statement->execute(array(':username' => $_SESSION['username']));

	while($row = $statement->fetch()){
		$username = $row['user_name'];
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$email = $row['user_email'];
	$join_date = $row['joining_date'];
	$start_date = explode(" ", $join_date);
	$start_date = explode("-", $start_date[0]);
	$start_date = get_date($start_date);
	$profile_image = $row['profile_image'];
	}
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Camagru | Account</title>

	<link href="css/full.css" rel="stylesheet">
	<link rel="icon" type="image/png" href="img/logo.png">
	</head>

	<body>

		<!-- Navigation -->
		<div class="navigation-bar">
		<div id="navigation-container">
			<img class="logo" src="https://image.ibb.co/hymeyw/Logomakr_9_TG0_B5.png">
			<ul>
				<li class="active"><a href="picture.php">Home</a></li>
				<li><a href="gallery.php">Gallery</a></li>
					<li><a href="account.php">Account</a></li>
					<li><a href="signout.php">Sign out</a></li>
			</ul>
		</div>
		<div class="container-full">
	<div class="card">
	<div class="container">
		<img src=<?php echo '"'.$profile_image.'"';?> class="profile-picture" style="width:100%">
 	 <div class="middle">
			<div class="text">
				<button id="change_pic" class="change_button">Change</button></input>
		</div>
	</div>
</div>
</post>
	<h1 class="white"><?php echo $first_name." ".$last_name;?></h1>
	<p class="title white ">Joined in <?php echo $start_date?></p>
	<p class="white"><?php echo $email;?></p>	</form>
	<a href="#"><p class="white sml" id="change-pwd">Change Password</p></a>
	<p class="white sml"><?php echo $res?></p>
	<center>
		<div id="submit-image" class="sub-image hide">
			<span id="close-img" class="close-form"><img class="close-img" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Grey_close_x.svg/2000px-Grey_close_x.svg.png"/></span>
		<form method="post" enctype="multipart/form-data">
				<span class="white">Select image to upload:</span>
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" value="Upload Image" name="submit">
		</form>
</div>
	</center>
	<p class="title"><?php echo $result?><p>
	<p><button id="edit">Edit</button></p>
</div>
</div>
<center>
<div id="change-form" class="edit-form hide">
				<form method="post" name="change-pwd">
				<input type="password" name="password" placeholder="Password"/><br>
				<input type="password" name="confirm_password" placeholder="Re-type Password"/><br>
				<input type="submit" value="Change" name="pwd-submit"><br><br>
				</form>
</div>
<div id="edit-form" class="edit-form hide">
<h3 class="white">Edit:</h3>
	<form name="edit-form" method="post">
		<input type="text" name="first_name" placeholder="First Name"/><br>
		<input type="text" name="last_name" placeholder="Last Name"/>
		<br>
		<input type="text" name="email" placeholder="Email"/><br>
	<input type="submit" value="Change" name="edit-submit"><br><br>
		<button class="change_button">Close</button>
</div>
		</center>
		<div class="gal-thumbs">
		</div>
	</body>
	<?php include('database/footer.php')?>
	<script type="text/javascript">
function addClass(el, className) {
	if (el.classList)
		el.classList.add(className);
	else if (!hasClass(el, className)) el.className += " " + className
}

function removeClass(el, className) {
	if (el.classList)
		el.classList.remove(className)
	else if (hasClass(el, className)) {
		var reg = new RegExp('(\\s|^)' + className + '(\\s|$)')
		el.className=el.className.replace(reg, ' ');
	}
}

document.getElementById('change_pic').addEventListener("click", function() {
	removeClass(document.getElementById("submit-image"), "hide");
});

document.getElementById('close-img').addEventListener("click", function () {
	addClass(document.getElementById("submit-image"), "hide");
});

document.getElementById('edit').addEventListener("click", function () {
			class_id = document.getElementById('edit-form');
			removeClass(class_id, "hide");
});
document.getElementById('change-pwd').addEventListener("click", function () {
			class_id = document.getElementById('change-form');
			removeClass(class_id, "hide");
});
</script>
</html>
