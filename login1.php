<?php		
session_start();
include('db_con.php');
	$module = array();
	$access_permission = array();
	$dept_permission = array();
if(isset($_POST['login'])){
		//session_start();
		echo $query = "SELECT * FROM `login_info` WHERE username = '".$_POST['username']."'";
		
		$run_query = mysqli_query($con, $query);
		
		if(mysqli_affected_rows($con) == 1){
			$row = mysqli_fetch_array($run_query);
			if($row['password']!= md5($_POST['password'])){
				echo "<span class='text-danger' style='font-size:16px;'>invalid password</span>";
			}
			else{
				 $query = "SELECT s.staff_id,s.staff_name,acc.module, acc.access_permission, acc.dept_permission FROM access_permission acc, staff_details s, login_info l WHERE acc.username = '".$_POST['username']."' AND s.staff_id = l.staff_id AND l.username = acc.username";
				$run_query = mysqli_query($con, $query);
				while($row1 = mysqli_fetch_array($run_query)){
					$_SESSION['staff_id'] = $row1['staff_id'];
					$_SESSION['staff_name'] = $row1['staff_name'];
					$module[] = $row1['module'];
					$access_permission[] = $row1['access_permission'];
					$dept_permission[] = $row1['dept_permission'];
				} // while() close here
				$_SESSION['module'] = $module; 
				$_SESSION['access_permission'] = $access_permission;
				$_SESSION['dept_permission'] = $dept_permission;
				$_SESSION['user_id'] = $_POST['username'];
				/*if(is_array($_SESSION['dept_permission'])){
					echo "array";
				}
				else{
					echo "not an array";
				}*/
				/*print_r($module);
				echo "<br />";
				print_r($access_permission);
				echo "<br />";
				print_r($dept_permission);*/
				header("location:index.php");
			}
		}
		else{
			echo "<span class='text-danger' style='font-size:16px;'>Invalid Username</span>";
		}
		$query1 =  "AND password = md5('".$_POST['password']."')";
		$query = $query . $query1;
		
	}
	else{
		//echo "Un-Authorize access";
	}
	
?>