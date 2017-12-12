<?php opcache_reset();
  include('config.php');
  session_start();
  function checker(){
	if(!strstr($_POST['email'], '@')){
      echo "<h3 class=\"form-error\">Not a valid Email Address</h3>";
	  return FALSE;
	}else
      return TRUE;
  }
  if (isset($_POST['email'])){
    $email = $_POST['email'];
		$password = $_POST['password'];
	
	$sqlQuery = "SELECT * FROM users WHERE user_email=:email";
	$statement = $con->prepare($sqlQuery);
	$statement->execute(array(':email' => $email));

	while ($row = $statement->fetch()){
		$id = $row['user_id'];
		$hashed_password = $row['user_pass'];
		$username = $row['user_name'];

		if ($row['confirm_check'] != 'true')
			$result = "<h3 class=\"header-products\">Check your Email to confirm your account</h3>";
		else if (password_verify($password, $hashed_password)){
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $username;
			if (isset($_POST['remember_me'])){
				$cookie_name = "logged_in";
				$value = $_SESSION['username'];
				setcookie($cookie_name, $value, time() + (86400 * 30));
			}
			header("location: picture.php");
		}else{
			$result = "<h3 class=\"header-products\">Invalid username or password</h3>";
		}
	}
  }
?>