<?php 
include('database/config.php');
session_start();
if (!isset($_SESSION['id']))
	header('Location: signin.php');
	if(isset($_POST["submit"])) {
		$overlay = "img/memes/pepe.png";
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		$target_dir = "saved_images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$ext = explode(".", $target_file);
		$length = count($ext);
		$length = $length - 1;
		if($check !== false) {
		  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			  $file_name = $target_file;
			  $_SESSION['file_name'] = $file_name;
			  $watermark = imagecreatefrompng($overlay);
			  $watermark_width = imagesx($watermark);
			  $watermark_height = imagesy($watermark);
			  $image = imagecreatefromjpeg($file_name);
			  $size = getimagesize($file_name);
			  imagecopy($image, $watermark, 165, 120, 0, 0, $watermark_width, $watermark_height);
			  imagejpeg($image, $file_name);
			  imagedestroy($image);
			  imagedestroy($watermark);
			  header("location: post.php");
		} else {
			$result = "Sorry, there was an error uploading your file.";
		}
		} else {
		  $result = "File is not an image.";
		}
	}
if (isset($_POST['total'])){
	$overlay = $_POST['overlay'];
	$file_name = $_SESSION['username'].date("h-i-sa");
	$file_name = "saved_images/".$file_name.".jpg";
	$data = explode(',', $_POST["total"]);
	$data = base64_decode($data[1]);
	$_SESSION['file_name'] = $file_name;
	file_put_contents($file_name, $data);
	$watermark = imagecreatefrompng($overlay);
	$watermark_width = imagesx($watermark);
	$watermark_height = imagesy($watermark);
	$image = imagecreatefromjpeg($file_name);
	$size = getimagesize($file_name);
	$dest_x = $size[0] - $watermark_width - 5;
	$dest_y = $size[1] - $watermark_height - 5;
	imagecopy($image, $watermark, 165, 120, 0, 0, $watermark_width, $watermark_height);
	imagejpeg($image, $file_name);
	imagedestroy($image);
	imagedestroy($watermark);
	header("location: post.php");
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Camagru | Home</title>

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
		<section class="container">
			<div class="one">
			<h1 class="div-header">Previously</h1>
			<div class="prev-container">
				<center>
			<?php
			$sqlquery = "SELECT * FROM images WHERE user_id=? ORDER BY post_date DESC LIMIT 0,5";
			$user_name = $_SESSION['username'];
			$statement = $con->prepare($sqlquery);
			$statement->execute(array($_SESSION['id']));
				while ($row = $statement->fetch())
					{?>
					<a href="<?php echo "comment.php?image=".$row['ID']?>">
						<img class="prev-side" src="<?php echo $row['file_name']; ?>" />
					</a>
					<?php }?>
			</div>
					</center>
				<center>
				<br>
				<br>
				</center>
			</div>
			<div class="two">
				<h1 class="div-header">Select and Snap !!</h1>
				<!--<h3 id="prompt" class="div-header select-prompt">Please select an image from the left bar and then snap</h3>-->
				<center>
				<div class="video-container">
						<img id="active-img" class="overlay" src="#"/>
						<video id="video" autoplay></video>
						<canvas id="canvas" class="hide" width="540" height="380"> </canvas>
						<center>
						<button id="snap" class="btn snap back-grey">Snap</button><br>
						<img id="thuglife" class="button-prev" src="img/thuglife.png">
						<img id="pilot" class="button-prev" src="img/pilot.png">
						</center>
					</div>
					<h3 class="div-header grey">Don't have a Webcam ?</h3>
					<span class="grey">Upload to get rare pepe:</span>
					<form method="post" enctype="multipart/form-data">
					<input type="file" name="fileToUpload" id="fileToUpload">
					<input type="submit" value="Upload Image" name="submit">
				</form>
					</center>
			</div>
		</section>
		<section>
			<div class="three">
			</div>
		</section>
		</div>
		<form id="submit-form" method="post" action="picture.php">
			<input type="hidden" name="total" id="total" value="">
			<input type="hidden" name="overlay" id="overlay" value="">
		</form>
</div>
<script type="text/javascript">
var video = document.getElementById('video');
var prompt = document.getElementById('prompt');
var active_img = document.getElementById('active-img');
var objects = [];
var crazy_links = ["http://www.pngmart.com/files/4/Crazy-PNG-Photos.png",
"https://openclipart.org/image/2400px/svg_to_png/169594/ndetavi-lc.png",
"http://vignette3.wikia.nocookie.net/trollpasta/images/1/1c/Squidward-Head-Funny.png/revision/latest?cb=20140924210814",
"http://25.media.tumblr.com/tumblr_mbje14ExV91qmsq48o1_1280.png"];
var x = new Number();
var y = new Number();
// Get access to the camera!
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	// Not adding `{ audio: true }` since we only want video now
	navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
			video.src = window.URL.createObjectURL(stream);
			video.play();
	});
}
// Elements for taking the snapshot
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

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
var snap = document.getElementById("snap");
document.getElementById("thuglife").addEventListener("click", function() {
	active_img.src = "img/thuglife.png";
	objects[0] = ("img/thuglife.png");
	removeClass(snap, "back-grey");
});

document.getElementById("pilot").addEventListener("click", function() {
	active_img.src = "img/pilot.png";
	objects[0] = ("img/pilot.png");
	removeClass(snap, "back-grey");
});

document.getElementById("snap").addEventListener("click", function() {
	if (objects.length == 0){
		alert('Pic an overlay');
	}else{
		addClass(video, "hide");
		removeClass(canvas, "hide");
		var img_1 = video;
		context.drawImage(img_1, 0, 0, canvas.width, canvas.height);
		var img = canvas.toDataURL("image/jpeg");
		var element = document.getElementById("total");
		var overlay = document.getElementById("overlay");
		overlay.value = objects[0];
		element.value = img;
		document.getElementById("submit-form").submit();
	}
});
</script>
<?php include('database/footer.php')?>
	</body>
</html>
