<?php 
	include('config.php');
	function checker(){
		if (empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['password']) || empty($_POST['confirm_password'])){
			echo "<h3 class=\"form-error\">Please make sure that all Fields are Filled in before submitting the form</h3>";
			return FALSE;
		}else if (!strstr($_POST['email'], '@')){
			echo "<h3 class=\"form-error\">Not a valid Email Address</h3>";
			return FALSE;
		}else if ($_POST['password'] != $_POST['confirm_password']){
			echo "<h3 class=\"form-error\">Passwords do not match</h3>";
			return FALSE;
		}else if (!preg_match('~[0-9]~', $_POST['password']) || strlen($_POST['password']) < 8){
			echo "<h3 class=\"form-error\">Password should contain a minimum of 8 charecters and at least 1 number</h3>";
			return FALSE;
		}else{
			return TRUE;
		}
	}
	if (isset($_POST['email'])){
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_check = substr($email, 0, 5).substr(md5($username), 0, 4).substr(md5($password), 0, 5);
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$message = "Please follow the following link to confirm http://localhost:8080/Camagru/signin.php?confirm=".$confirm_check;
		$stmt = $con->prepare("SELECT * from users WHERE user_email=?");
		$stmt->execute(array($_POST['email']));
		$check = $stmt->fetchAll();

		if (!checker())
			;
		else if (!empty($check))
			echo "<h3 class=\"form-error\">Email already Exists</h3>";
		else{
			try{
				$sqlInsert = "INSERT INTO users (first_name, last_name, user_name, user_email, user_pass, joining_date, confirm_check) VALUES
				(:first_name, :last_name, :username, :email, :password, now(), :confirm_check)";

				$statement = $con->prepare($sqlInsert);
				$statement->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':username' =>
				$username, ':email' => $email, ':password' => $hashed_password, ':confirm_check' => $confirm_check));

				if ($statement->rowCount() == 1){
					mail($email, "Confirm Registration" , $message, $header);
					$result = "<h3 class=\"header-products\">Confirmation Email has been sent, Check Your Email</h3>";
				}
			}catch(PDOException $e){
				$result = '<h3 class="header-products">An error occurred: '.$e->getMessage().'</h3>';
			}
		}
	}
?>