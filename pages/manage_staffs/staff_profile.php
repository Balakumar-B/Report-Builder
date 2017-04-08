<?php
include("../../db_con.php");
if(isset($_SESSION['user_id'])){
	
}
else{
	header("location:/report_builder/login.php");
}
?>