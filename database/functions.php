<?php
	include('database/config.php');
	function get_date($arr){
		$month = $arr[1];
		if ($month == "01")
			return $arr[0]." Jan";
		else if ($month == "02")
			return $arr[0]." Feb";
		else if ($month == "03")
			return $arr[0]." March";
		else if ($month == "04")
			return $arr[0]." April";
		else if ($month == "05")
			return $arr[0]." May";
		else if ($month == "06")
			return $arr[0]." June";
		else if ($month == "07")
			return $arr[0]." July";
		else if ($month == "08")
			return $arr[0]." August";
		else if ($month == "09")
			return $arr[0]." September";
		else if ($month == "10")
			return $arr[0]." October";
		else if ($month == "11")
			return $arr[0]." November";
		else if ($month == "12")
			return $arr[0]." December";
	else
		;
	}
?>