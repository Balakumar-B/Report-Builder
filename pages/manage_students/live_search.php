<?php
include("../../db_con.php");
	//include("../functions.php");
	error_reporting(0);
	if(isset($_REQUEST['key']))
	{
		//global $view_student_search_key;
		$key_value = $_REQUEST['key'];
		if($key_value == 'form_data')
		{
			mysqli_autocommit($con, FALSE);
			/*Q U E R Y   F R O M   S T U D  E N T   A D M I S S I O N   D E T A I L S*/	
				$query = "INSERT INTO `admission_details` (`admission_no`, `admission_date`,`admission_quota`) VALUES (".$_POST['admission_no'].", '".db_date($_POST['admission_date'])."','".$_POST['admission_quota']."');";	
				$run_query = mysqli_query($con, $query);
				if(mysqli_affected_rows($con)>0)
				{
					
				}
				else{
					mysqli_rollback($con);
					echo mysqli_error($con);
					die(mysqli_errno($con));
				}
				
			
			/*Q U E R Y   F R O M    S T U D E N T   P E R S O N A L   D E T A I L S*/
				
				if($_POST['lang1'] == "" && $_POST['lang2'] == "" ){
					$_POST['lang1'] = "-";
					$_POST['lang2'] = "-";
				}
				else if($_POST['lang1']==""){
					$_POST['lang1']= "-";
				}
				else if($_POST['lang2']==""){
					$_POST['lang2']= "-";
				}
				else{
					
				}
				
				  $query = "INSERT INTO `stu_personal_details` (`admission_no`, `stu_rollno`, `stu_firstname`, `stu_lastname`, `stu_gender`, `stu_dob`, `stu_religion`, `stu_community`, `stu_mother_maiden_name`, `stu_mother_name`, `stu_father_name`, `stu_parent_income`, `stu_nationality`, `stu_blood_group`, `stu_mother_tongue`, `stu_langknown_1`, `stu_langknown_2`, `status`) VALUES (".$_POST['admission_no']." ,".$_POST['rollno'].", '".capitalize($_POST["fname"])."', '".capitalize($_POST['lname'])."', '".capitalize($_POST['gender'])."', '".db_date($_POST['dob'])."', '".capitalize($_POST['religion'])."', '".$_POST['community']."', '".capitalize($_POST['mother_maiden_name'])."', '".capitalize($_POST['mother_name'])."', '".capitalize($_POST['father_name'])."', ".moneytodouble($_POST['demoLakh']).", '".capitalize($_POST['nationality'])."', '".$_POST['blood_group']."', '".capitalize($_POST['mother_tongue'])."', '".capitalize($_POST['lang1'])."', '".capitalize($_POST['lang2'])."', 'Pursing');";
			
				$run_query = mysqli_query($con, $query);
				if(mysqli_affected_rows($con)>0)
				{
					
				}
				else{
					
					mysqli_rollback($con);
					die('Error:(personal-details) ' . mysqli_error($con));
				}
			
				/* Q U E R Y   F R O M   C O N T A C T   D E T A I L S */
				if($_POST['district'] == 'Others'){
						$_POST['district'] = $_POST['other_district'];
				}
				if($_POST['state']=="Others"){
					$_POST['state'] = $_POST['other_state'];
				}
				if($_POST['address_same'] == 'no')
				{
						if($_POST['district1'] == 'Others'){
							$_POST['district1'] = $_POST['other_district1'];
						}
						if($_POST['state1'] == 'Others'){
							$_POST['state1'] = $_POST['other_state1'];
						}
					  $query = "INSERT INTO `stu_contact_details` (`stu_rollno`, `stu_email`, `stu_parent_email`, `stu_mobile`, `stu_alternative_mobile`, `stu_parent_mobile`, `stu_pre_houseno`, `stu_pre_street`, `stu_pre_area`, `stu_pre_city`, `stu_pre_district`, `stu_pre_state`, `stu_pre_pincode`, `stu_pre_country`, `stu_per_houseno`, `stu_per_street`, `stu_per_area`, `stu_per_city`, `stu_per_district`, `stu_per_state`, `stu_per_pincode`, `stu_per_country`) VALUES (".$_POST['rollno'].", '".$_POST['email']."', '".$_POST['alter_email']."', '".$_POST['mobile']."', '".$_POST['alter_mobile']."', '".$_POST['parent_mobile']."', '".$_POST['house_no']."', '".capitalize($_POST['street'])."', '".capitalize($_POST['area'])."', '".capitalize($_POST['city'])."', '".$_POST['district']."', '".$_POST['state']."', ".moneytodouble($_POST['pincode']).", '".$_POST['country']."', '".$_POST['house_no1']."', '".capitalize($_POST['street1'])."', '".capitalize($_POST['area1'])."', '".capitalize($_POST['city1'])."', '".$_POST['district1']."', '".$_POST['state1']."', ".moneytodouble($_POST['pincode1']).", '".$_POST['country1']."');";
						$run_query = mysqli_query($con, $query);
						if(mysqli_affected_rows($con)>0)
						{
							
						}
						else{
							mysqli_rollback($con);
							die('Error:(contact-details) ' . mysqli_error($con));
						}
				} // ./if()
				else
				{
					  $query = "INSERT INTO `stu_contact_details` (`stu_rollno`, `stu_email`, `stu_parent_email`, `stu_mobile`, `stu_alternative_mobile`, `stu_parent_mobile`, `stu_pre_houseno`, `stu_pre_street`, `stu_pre_area`, `stu_pre_city`, `stu_pre_district`, `stu_pre_state`, `stu_pre_pincode`, `stu_pre_country`, `stu_per_houseno`, `stu_per_street`, `stu_per_area`, `stu_per_city`, `stu_per_district`, `stu_per_state`, `stu_per_pincode`, `stu_per_country`) VALUES (".$_POST['rollno'].", '".$_POST['email']."', '".$_POST['alter_email']."', '".$_POST['mobile']."', '".$_POST['alter_mobile']."', '".$_POST['parent_mobile']."', '".$_POST['house_no']."', '".capitalize($_POST['street'])."', '".capitalize($_POST['area'])."', '".capitalize($_POST['city'])."', '".capitalize($_POST['district'])."', '".capitalize($_POST['state'])."', ".moneytodouble($_POST['pincode']).", '".capitalize($_POST['country'])."', '".$_POST['house_no']."', '".capitalize($_POST['street'])."', '".capitalize($_POST['area'])."', '".capitalize($_POST['city'])."', '".$_POST['district']."', '".$_POST['state']."', ".moneytodouble($_POST['pincode']).", '".$_POST['country']."');";
				
					$run_query = mysqli_query($con, $query);
					if(mysqli_affected_rows($con)>0)
					{
					}
					else{
						mysqli_rollback($con);
						die('Error:(contact-details) ' . mysqli_error($con));
					}
				}
				
				/* Q U E R Y   F R O M   A C A D E M I C   D E T A I L S */
					
					if($_POST['join_mode'] == 'Lateral Entry'){
						$batch = date('Y',strtotime("-1 year"));
					}
					else{
						$batch = date('Y');
					}
				
					 $query = "INSERT INTO `current_course` (`stu_rollno`, `stu_univ_regno`, `stu_degree`, `stu_course`, `stu_branch`, `stu_section`, `stu_batch`, `stu_course_type`, `stu_joined`) VALUES (".$_POST['rollno'].", '".$_POST['univ_regno']."', ".$_POST['curr_degree'].", ".$_POST['curr_course'].", ".$_POST['curr_branch'].", '".capitalize($_POST['curr_section'])."', '".$batch."', '".$_POST['course_type']."', '".$_POST['join_mode']."');";	
					$run_query = mysqli_query($con, $query);
					if(mysqli_affected_rows($con)>0)
					{
					
					}
					else{
						mysqli_rollback($con);
						die('Error:(current-academic-details) ' . mysqli_error($con));
					}				
				/*  Q U E R Y   F R O M   P R E V I O U S   A C A D E M I C   D E T A I L S */
				
					 $query = "INSERT INTO `prev_academic_details` (`stu_rollno`, `prev_degree`, `prev_course`, `prev_branch`, `year_of_passing`, `course_type`, `ins_name`, `board_of_education`, `cgpa_obtained`, `total_marks`, `percentage`) VALUES (".$_POST['rollno'].", 'X', '".$_POST['X_course']."', '".$_POST['X_branch']."', '".db_date($_POST['X_duration_from'])."', '".capitalize($_POST['X_course_type'])."', '".capitalize($_POST['X_ins_name'])."', '".capitalize($_POST['X_board'])."', ".$_POST['X_cgpa_marks'].", ".$_POST['X_total_cgpa_marks'].", ".$_POST['X_percentage'].");";
				
					$run_query = mysqli_query($con, $query);
					if(mysqli_affected_rows($con)>0)
					{
					}
					else{
						mysqli_rollback($con);
						die('Error:(prev-academic-details) ' . mysqli_error($con));
					}	
				
				$i = 1;
				while(!empty($_POST['prev_degree'.$i]))
				{
					 $query = "INSERT INTO `prev_academic_details` (`stu_rollno`, `prev_degree`, `prev_course`, `prev_branch`, `year_of_passing`, `course_type`, `ins_name`, `board_of_education`, `cgpa_obtained`, `total_marks`, `percentage`) VALUES (".$_POST['rollno'].", '".$_POST['prev_degree'.$i]."', '".$_POST['prev_course'.$i]."', '".$_POST['prev_branch'.$i]."', '".$_POST['prev_duration_from'.$i]."', '".capitalize($_POST['prev_course_type'.$i])."', '".capitalize($_POST['prev_ins_name'.$i])."', '".capitalize($_POST['prev_board'.$i])."', ".$_POST['prev_cgpa_marks'.$i].", ".$_POST['prev_total_cgpa_marks'.$i].", ".$_POST['prev_percentage'.$i].");";
					$run_query = mysqli_query($con, $query);
					$i++;
				}
				if($run_query){
					echo "inserted";
				}
				mysqli_commit($con);
		}/* ./if close here*/
		
		else if($key_value == 'form_data_update'){
			mysqli_autocommit($con, FALSE);
			//echo $_REQUEST['key'];
			/* U P D A T E Q U E R Y  F R O M  S T U D E N T A D M I S S I O N  D E T A I L S 
			$query = "UPDATE admission_details SET stu_rollno = ".$_POST['rollno']." WHERE stu_rollno = ".$_POST['rollno']."";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con) == -1){
				mysqli_rollback($con);
				die(mysqli_error($con));
			}*/
			/* U P D A T E  Q U E R Y   F R O M    S T U D E N T   P E R S O N A L   D E T A I L S*/
			$query = "UPDATE stu_personal_details SET stu_rollno = ".$_POST['rollno'].", stu_firstname = '".capitalize($_POST['fname'])."',stu_lastname = '".capitalize($_POST['lname'])."',stu_gender = '".capitalize($_POST['gender'])."',stu_dob = '".db_date($_POST['dob'])."',stu_religion = '".capitalize($_POST['religion'])."',stu_community = '".$_POST['community']."',stu_mother_maiden_name = '".capitalize($_POST['mother_maiden_name'])."', stu_mother_name = '".capitalize($_POST['mother_name'])."',stu_father_name = '".capitalize($_POST['father_name'])."', stu_parent_income = ".moneytodouble($_POST['demoLakh']).",stu_nationality = '".capitalize($_POST['nationality'])."', stu_blood_group = '".$_POST['blood_group']."', stu_mother_tongue = '".capitalize($_POST['mother_tongue'])."', stu_langknown_1 = '".capitalize($_POST['lang1'])."', stu_langknown_2 = '".capitalize($_POST['lang2'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			
			$run_query = mysqli_query($con, $query);
			
			if(mysqli_affected_rows($con) == -1){
				mysqli_rollback($con);
				die('Error: Update Personal Details' .mysqli_error($con));
			}
			
			/* U P D A T E  Q U E R Y   F R O M   C O N T A C T   D E T A I L S */
			if($_POST['address_same'] == 'no'){
				//echo "<br><br>";
				$query = "UPDATE stu_contact_details SET stu_rollno = ".$_POST['rollno'].", stu_email = '".$_POST['email']."', stu_parent_email = '".$_POST['alter_email']."', stu_mobile = '".$_POST['mobile']."',stu_alternative_mobile = '".$_POST['alter_mobile']."', stu_parent_mobile = '".$_POST['parent_mobile']."', stu_pre_houseno = '".$_POST['house_no']."', stu_pre_street = '".capitalize($_POST['street'])."', stu_pre_area = '".capitalize($_POST['area'])."', stu_pre_city = '".capitalize($_POST['city'])."', stu_pre_district = '".capitalize($_POST['district'])."', stu_pre_state = '".capitalize($_POST['state'])."', stu_pre_pincode = ".$_POST['pincode'].", stu_pre_country = '".capitalize($_POST['country'])."', stu_per_houseno = '".$_POST['house_no1']."', stu_per_street = '".capitalize($_POST['street1'])."', stu_per_area = '".capitalize($_POST['area1'])."', stu_per_city = '".capitalize($_POST['city1'])."', stu_per_district = '".capitalize($_POST['district1'])."', stu_per_state = '".capitalize($_POST['state1'])."', stu_per_pincode = ".moneytodouble($_POST['pincode1']).", stu_per_country = '".capitalize($_POST['country1'])."' WHERE stu_rollno = ".$_POST['rollno']."";	
				
				$run_query = mysqli_query($con, $query);
				
				if(mysqli_affected_rows($con) == -1){
					mysqli_rollback($con);
					die('Error: Update Contact Details(address-same no) Details' .mysqli_error($con));
				}
			}
			else{
				//echo "<br><br>";
				$query = "UPDATE stu_contact_details SET stu_rollno = ".$_POST['rollno'].", stu_email = '".$_POST['email']."', stu_parent_email = '".$_POST['alter_email']."', stu_mobile = '".$_POST['mobile']."',stu_alternative_mobile = '".$_POST['alter_mobile']."', stu_parent_mobile = '".$_POST['parent_mobile']."', stu_pre_houseno = '".$_POST['house_no']."', stu_pre_street = '".capitalize($_POST['street'])."', stu_pre_area = '".capitalize($_POST['area'])."', stu_pre_city = '".capitalize($_POST['city'])."', stu_pre_district = '".capitalize($_POST['district'])."', stu_pre_state = '".capitalize($_POST['state'])."', stu_pre_pincode = ".moneytodouble($_POST['pincode']).", stu_pre_country = '".capitalize($_POST['country'])."', stu_per_houseno = '".$_POST['house_no']."', stu_per_street = '".capitalize($_POST['street'])."', stu_per_area = '".capitalize($_POST['area'])."', stu_per_city = '".capitalize($_POST['city'])."', stu_per_district = '".capitalize($_POST['district'])."', stu_per_state = '".capitalize($_POST['state'])."', stu_per_pincode = ".moneytodouble($_POST['pincode']).", stu_per_country = '".capitalize($_POST['country'])."' WHERE stu_rollno = ".$_POST['rollno']."";
				$run_query = mysqli_query($con, $query);
				
				if(mysqli_affected_rows($con) == -1){
					mysqli_rollback($con);
					die('Error: Update Contact Details(address-same yes) Details' .mysqli_error($con));
				}
			}
			
			/* U P D A T E   Q U E R Y   F R O M   A C A D E M I C   D E T A I L S */
			
			$query = "UPDATE current_course SET stu_rollno = ".$_POST['rollno'].", stu_univ_regno = '".$_POST['univ_regno']."', stu_course = ".capitalize($_POST['curr_course']).", stu_branch = ".capitalize($_POST['curr_branch']).", stu_degree = ".capitalize($_POST['curr_degree']).",stu_course_type = '".capitalize($_POST['course_type'])."', stu_section = '".capitalize($_POST['curr_section'])."', stu_joined = '".capitalize($_POST['join_mode'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			$run_query = mysqli_query($con, $query);
				
				if(mysqli_affected_rows($con) == -1){
					mysqli_rollback($con);
					die('Error: Update Current Academic Details' .mysqli_error($con));
				}
			
			/*  Q U E R Y   F R O M   P R E V I O U S   A C A D E M I C   D E T A I L S */
			
			//echo $query = "UPDATE prev_academic_details SET stu_rollno = ".$_POST['rollno'].",prev_course = '".$_POST['X_course']."', prev_branch = '".$_POST['X_branch']."', year_of_passing = '".$_POST['X_duration_from']."',course_type = '".capitalize($_POST['X_course_type'])."', ins_name = '".capitalize($_POST['X_ins_name'])."', board_of_education = '".capitalize($_POST['X_board'])."', cgpa_obtained = ".$_POST['X_cgpa_marks'].",total_marks = ".$_POST['X_total_cgpa_marks'].", percentage = ".$_POST['X_percentage']." WHERE stu_rollno = ".$_POST['rollno']." AND prev_degree = 'X'";
			
			//echo "<br><br>";
			$i = 10;
			//echo $_POST['prev_degree'.$i];
			while(!empty($_POST['prev_degree'.$i]))
			{
				$query = "UPDATE prev_academic_details SET 
							stu_rollno = ".$_POST['rollno'].", 
							prev_degree = '".$_POST['prev_degree'.$i]."' , 
							prev_course = '".capitalize($_POST['prev_course'.$i])."' , 
							prev_branch = '".capitalize($_POST['prev_branch'.$i])."' , 
							year_of_passing = '".$_POST['prev_duration_from'.$i]."' ,  
							course_type = '".capitalize($_POST['prev_course_type'.$i])."', 
							ins_name = '".capitalize($_POST['prev_ins_name'.$i])."', 
							board_of_education = '".capitalize($_POST['prev_board'.$i])."',  
							cgpa_obtained = ".$_POST['prev_cgpa_marks'.$i]." ,  
							total_marks = ".$_POST['prev_total_cgpa_marks'.$i]." , 
							percentage = ".$_POST['prev_percentage'.$i]."
						WHERE stu_rollno = ".$_POST['rollno']." AND prev_degree = '".$_POST['prev_degree'.$i]."'";
				
				$run_query = mysqli_query($con, $query);
			
				if(mysqli_affected_rows($con) == -1){
					mysqli_rollback($con);
					die('Error: Update Previous Academic Details' .mysqli_error($con));
				}
				$i++;
			}
			if($run_query){
				mysqli_commit($con);
				echo "update ok";
			}
		}// Else if close for Update from (edit.php)
		else if($key_value == 'delete'){	
			//$_POST['hidden_rollno'];
			mysqli_autocommit($con, FALSE);
			/*$query = "DELETE FROM stu_contact_details WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			if(!mysqli_affected_rows($con)){
				mysqli_rollback($con);
				die('Error: Contact-details' .mysqli_error($con));
			}
			$query = "DELETE FROM current_course WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			if(!mysqli_affected_rows($con)){
				mysqli_rollback($con);
				die('Error: current_course details' .mysqli_error($con));
			}
			$query = "DELETE FROM prev_academic_details WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			if(!mysqli_affected_rows($con)){
				mysqli_rollback($con);
				die('Error: prev_academic_details ' .mysqli_error($con));
			}
			$query = "SELECT admission_no FROM stu_personal_details WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			$row = mysqli_fetch_array($run_query);
			$delete_admission_no = $row['admission_no'];
				
			$query = "DELETE FROM stu_personal_details WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			if(!mysqli_affected_rows($con)){
				mysqli_rollback($con);
				die('Error: stu_personal_details ' .mysqli_error($con));
			}
			$query = "DELETE FROM admission_details WHERE admission_no = ".$delete_admission_no."";
			$run_query = mysqli_query($con, $query);
			if(!mysqli_affected_rows($con)){
				mysqli_rollback($con);
				die('Error: admission-details ' .mysqli_error($con));
			}
			else{
				mysqli_commit($con);
				echo "delete";
			}*/
			
			$query = "UPDATE stu_personal_details SET status = 'discontinue' WHERE stu_rollno = ".$_POST['hidden_rollno']."";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con)>=0){
				mysqli_commit($con);
				echo "delete";
			}
			else{
				mysqli_rollback($con);
				die('Error:  ' .mysqli_error($con));
			}
		}
	}
	else{
		
	}
	function capitalize($var)
	{
		return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($var))));
	}
	function db_date($original_date)
	{
		return date('Y-m-d',strtotime(str_replace('/', '-',$original_date)));
	}
	function moneytodouble($money)
	{
		return str_replace(array(',',' ','Rs.','-'),"",$money);
	}
?>