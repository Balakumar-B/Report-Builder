<?php
include("../db_con.php");
if(isset($_POST['email'])){
	//echo $_POST['email'];
	if($_POST['email']){
		$query = "SELECT username FROM `admin` WHERE username = ".$_POST['email']."";
		$run_query = mysqli_query($con, $query);
		if(mysqli_affected_rows($con)>0){
			$row = mysqli_num_rows($run_query);
			echo $row[0];
		}
		else{
			echo "Invalid_username";
		}
	}
	else if($_POST['pwd']){
		$query = "SELECT pwd FROM `admin` WHERE pwd = ".$_POST['pwd']."";
		$run_query = mysqli_query($con, $query);
		if($row = mysqli_num_rows($con)>0){
			echo $row[0];
		}
		else{
			echo "Invalid_pwd";
		}
	}
}
else{
	//header("404_error.php");
}
?>