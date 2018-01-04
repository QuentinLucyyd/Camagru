<?php 
  include('config.php');
  if (isset($_GET['confirm'])){
		$confirm_check = $_GET['confirm'];
		$bool = 'true';

		$sqlQuery = "UPDATE users SET confirm_check=? WHERE confirm_check=?";
		$statement = $con->prepare($sqlQuery);
		$statement->execute(array($bool,$confirm_check));
		if($statement->rowCount() == 1){
			$result = "<h3 class=\"header-products\">Account Confirmed</h3>";
		}
  }
?>