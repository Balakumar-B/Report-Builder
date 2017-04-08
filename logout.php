<?php
session_start();
if($_SESSION['user_id'])
{
	/*echo $file = $_SESSION['inputFileName'];
	if (!unlink($file))
	  {
	  echo ("Error deleting $file");
	  }
	else
	  {
	  echo ("Deleted $file");
	  }*/
	unset($_SESSION);
	session_destroy();
	header("location:login.php");
}

?>
