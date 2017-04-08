<?php
include('../../db_con.php');
if(isset($_POST['key'])){
	if($_POST['key'] == 'Teaching'){
		$query = "SELECT * FROM `branch`";
		$run_query = mysqli_query($con, $query);
		while($row = mysqli_fetch_array($run_query)){
			echo "<option value='".$row['branch_id']."'>".$row['branch_name']."</option>";
		} // close here
	} // if(key == 'value') close here
	else if($_POST['key'] == 'Non-Teaching'){
		$query = "SELECT DISTINCT department AS dept FROM `staff_non_teaching` GROUP BY department";
		$run_query = mysqli_query($con, $query);
		while($row = mysqli_fetch_array($run_query)){
			echo "<option>".$row['dept']."</option>";
		} // while close here
	} // else if(key == 'value') close here
	else if($_POST['key'] == 'display_staff'){
		echo $_POST['working_type'];
		echo $_POST['department'];
		if($_POST['working_type'] == 'Teaching'){
			$query = "SELECT s.staff_id, s.staff_name, st.designation, b.branch_name FROM staff_details s, staff_teaching st, branch b WHERE s.staff_id = st.staff_id AND b.branch_id = st.branch AND s.status = 'active' AND st.branch = ".$_POST['department']."";
		} // if() checking for teaching close here
		else{
			 $query = "SELECT s.staff_id, s.staff_name, snt.designation FROM staff_details s, staff_non_teaching snt WHERE s.staff_id = snt.staff_id AND s.status = 'active' AND snt.department = '".$_POST['department']."'";
		}
		$run_query = mysqli_query($con, $query);
		while($row = mysqli_fetch_array($run_query)){
			$query1 = "SELECT * FROM `login_info` WHERE staff_id = ".$row['staff_id']."";
			$run_query1 = mysqli_query($con, $query1);
			if(mysqli_affected_rows($con) == 1){
				$available = "disabled";
			}
			else{
				$available = "";
			}
			echo "<option value = ".$row['staff_id']." ".$available.">".$row['staff_name']." (".$row['staff_id'].", ".$row['designation'].")</option>";
		}// while close here
	} // else if()
	else if($_POST['key'] == 'staff_login_form_data'){
		//echo $_POST['staff']."<br />";
		//echo $_POST['username']."<br />";
		//echo $_POST['password']."<br />";
		mysqli_autocommit($con, FALSE);
		$access_permission = "";
		$dept_permission = "";
		$query = "";
		foreach($_POST['manage_student'] as $key=>$value){
			$access_permission .= $value.',';
		}
		foreach($_POST['manage_student_dept_perm'] as $key=>$value){
			$dept_permission .= $value.',';
		}
		$access_permission = rtrim($access_permission,',');
		$dept_permission = rtrim($dept_permission,',');
		$query = "INSERT INTO `login_info` (`staff_id`, `username`, `password`) VALUES (".$_POST['staff'].", '".$_POST['username']."', MD5('".$_POST['password']."'));";
		$run_query = mysqli_query($con, $query);
		if(mysqli_affected_rows($con)>0){
			
		}
		else{
			mysqli_rollback($con);
			echo die(mysqli_error($con));
		}
		$query = "";
		$query .= "INSERT INTO `access_permission` (`id`, `username`, `access_permission`, `module`, `dept_permission`) VALUES (NULL, '".$_POST['username']."', '".$access_permission."', 'manage_student', '".$dept_permission."'),";
		
		$access_permission = "";
		$dept_permission = "";
		foreach($_POST['reports'] as $key=>$value){
			$access_permission .= $value.",";
		}
		$access_permission = rtrim($access_permission, ",");
		if($access_permission != 'hide'){
			foreach($_POST['reports_dept_perm'] as $key=>$value){
			$dept_permission .= $value.",";
			}
		} // if() close here
		else{
			$dept_permission = 'no';
		}
		
		$access_permission = rtrim($access_permission, ",");
		$dept_permission = rtrim($dept_permission, ",");
		$query .= "(NULL, '".$_POST['username']."', '".$access_permission."', 'reports', '".$dept_permission."');";
		
		//echo $query;
		$run_query = mysqli_query($con, $query);
		//echo mysqli_affected_rows($con);
		if(mysqli_affected_rows($con)>0){
			echo "ok";
		}
		else{
			mysqli_rollback($con);
			echo die(mysqli_error($con));
		}
		mysqli_commit($con);
		//$query = "INSERT INTO `login_info` (`staff_id`, `username`, `password`) VALUES (".$_POST['staff'].", '".$_POST['username']."', MD5('".$_POST['password']."'));INSERT INTO `access_permission` (`id`, `username`, `access_permission`, `module`, `dept_permission`) VALUES (NULL, '".$_POST['username']."', '".$access_permission."', 'manage_student', '".$dept_permission."'), (NULL, 'renukha_21038', 'show_without_cus ', 'reports', 'all');";
	}	
	else if($_POST['key'] == 'update_staff_login_form_data'){
		
		mysqli_autocommit($con, FALSE);
		$access_permission_manage_student = "";
		$dept_permission_manage_student = "";
		$access_permission_reports = "";
		$dept_permission_reports = "";
		//$query = "";
		foreach($_POST['manage_student'] as $key=>$value){
			$access_permission_manage_student .= $value.',';
		}
		foreach($_POST['manage_student_dept_perm'] as $key=>$value){
			$dept_permission_manage_student .= $value.',';
		}
		$access_permission_manage_student = rtrim($access_permission_manage_student,',');
		$dept_permission_manage_student = rtrim($dept_permission_manage_student,',');
		
		//$access_permission = "";
		$dept_permission = "";
		foreach($_POST['reports'] as $key=>$value){
			$access_permission_reports .= $value.",";
		}
		$access_permission_reports = rtrim($access_permission_reports, ",");
		if($access_permission_reports != 'hide'){
			foreach($_POST['reports_dept_perm'] as $key=>$value){
				$dept_permission_reports .= $value.",";
			}
		} // if() close here
		else{
			$dept_permission_reports = 'no';
		}
		
		$access_permission_reports = rtrim($access_permission_reports, ",");
		$dept_permission_reports = rtrim($dept_permission_reports, ",");
	
		$query = "UPDATE access_permission acc, login_info l SET 
						acc.username = '".$_POST['username']."',
						l.username = '".$_POST['username']."',
						acc.access_permission = (case when acc.module = 'manage_student' then '".$access_permission_manage_student."'
											when acc.module = 'reports' then '".$access_permission_reports."'
										end), 
						acc.module = (case when acc.module = 'manage_student' then 'manage_student'
											when acc.module = 'reports' then 'reports'
										end),
						acc.dept_permission = (case when acc.module = 'manage_student' then '".$dept_permission_manage_student."'
											when acc.module = 'reports' then '".$dept_permission_reports."'
										end)
					WHERE l.username = acc.username AND l.staff_id = ".$_POST['staff']."";
		//echo $query;
		$run_query = mysqli_query($con, $query);
		//echo mysqli_affected_rows($con);
		if(mysqli_affected_rows($con)>=0){
			echo "update";
		}
		else{
			mysqli_rollback($con);
			echo die(mysqli_error($con));
		}
		mysqli_commit($con);
	}
	else if($_POST['key']=='delete'){
		//echo "delete";
		mysqli_autocommit($con, FALSE);
		
		$query = "SELECT username FROM login_info WHERE staff_id = ".$_POST['hidden_staff_id']."";
		$run_query = mysqli_query($con, $query);
		$row = mysqli_fetch_array($run_query);
		$username = $row['username'];
		
		$query = "DELETE FROM access_permission WHERE username = '".$username."'";
		$run_query = mysqli_query($con, $query);
		if(mysqli_affected_rows($con)>=0){
			//mysqli_commit($con);
			//echo "delete";
		}
		else{
			mysqli_rollback($con);
			die('Error:access_permission  ' .mysqli_error($con));
		}
		
		$query = "DELETE FROM login_info WHERE username = '".$username."'";
		$run_query = mysqli_query($con, $query);
		if(mysqli_affected_rows($con)>=0){
			//mysqli_commit($con);
			//echo "delete";
		}
		else{
			mysqli_rollback($con);
			die('Error:login_info  ' .mysqli_error($con));
		}
		
		$query = "UPDATE staff_details SET status = 'resign' WHERE staff_id = ".$_POST['hidden_staff_id']."";
		$run_query = mysqli_query($con, $query);
			
		if(mysqli_affected_rows($con)>=0){
			mysqli_commit($con);
			echo "delete";
		}
		else{
			mysqli_rollback($con);
			die('Error:  ' .mysqli_error($con));
		}
	} // else if() close here
} // if(isset()) close here
else{
	echo "Un-Authorize access";
}
?>