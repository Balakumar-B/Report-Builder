<?php
if(isset($_POST['key']) == 'form_data_update'){
			echo $_REQUEST['key'];
			echo $_REQUEST['prev_course'.'10'];
			/*U P D A T E  Q U E R Y   F R O M    S T U D E N T   P E R S O N A L   D E T A I L S*/
			$query = "UPDATE stu_personal_details SET stu_rollno = ".$_POST['rollno'].", stu_firstname = '".capitalize($_POST['fname'])."',stu_lastname = '".capitalize($_POST['lname'])."',stu_gender = '".capitalize($_POST['gender'])."',stu_dob = '".db_date($_POST['dob'])."',stu_religion = '".capitalize($_POST['religion'])."',stu_community = '".capitalize($_POST['community'])."',stu_mother_maiden_name = '".capitalize($_POST['mother_maiden_name'])."', stu_mother_name = '".capitalize($_POST['mother_name'])."',stu_father_name = '".capitalize($_POST['father_name'])."', stu_parent_income = ".moneytodouble($_POST['demoLakh']).",stu_nationality = '".capitalize($_POST['nationality'])."', stu_blood_group = '".$_POST['blood_group']."', stu_mother_tongue = '".capitalize($_POST['mother_tongue'])."', stu_langknown_1 = '".capitalize($_POST['lang1'])."', stu_langknown_2 = '".capitalize($_POST['lang2'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			
			/* Q U E R Y   F R O M   C O N T A C T   D E T A I L S */
			if($_POST['address_same'] == 'no'){
				echo "<br><br>";
				$query = "UPDATE stu_contact_details SET stu_rollno = ".$_POST['rollno'].", stu_email = '".$_POST['email']."', stu_parent_email = '".$_POST['alter_email']."', stu_mobile = '".$_POST['mobile']."',stu_alternative_mobile = '".$_POST['alter_mobile']."', stu_parent_mobile = '".$_POST['parent_mobile']."', stu_pre_houseno = '".$_POST['house_no']."', stu_pre_street = '".capitalize($_POST['street'])."', stu_pre_area = '".capitalize($_POST['area'])."', stu_pre_city = '".capitalize($_POST['city'])."', stu_pre_district = '".capitalize($_POST['district'])."', stu_pre_state = '".capitalize($_POST['state'])."', stu_pre_pincode = ".$_POST['pincode'].", stu_pre_country = '".capitalize($_POST['country'])."', stu_per_houseno = '".$_POST['house_no1']."', stu_per_street = '".capitalize($_POST['street1'])."', stu_per_area = '".capitalize($_POST['area1'])."', stu_per_city = '".capitalize($_POST['city1'])."', stu_per_district = '".capitalize($_POST['district1'])."', stu_per_state = '".capitalize($_POST['state1'])."', stu_per_pincode = ".moneytodouble($_POST['pincode1']).", stu_per_country = '".capitalize($_POST['country1'])."' WHERE stu_rollno = ".$_POST['rollno']."";	
			}
			else{
				echo "<br><br>";
				$query = "UPDATE stu_contact_details SET stu_rollno = ".$_POST['rollno'].", stu_email = '".$_POST['email']."', stu_parent_email = '".$_POST['alter_email']."', stu_mobile = '".$_POST['mobile']."',stu_alternative_mobile = '".$_POST['alter_mobile']."', stu_parent_mobile = '".$_POST['parent_mobile']."', stu_pre_houseno = '".$_POST['house_no']."', stu_pre_street = '".capitalize($_POST['street'])."', stu_pre_area = '".capitalize($_POST['area'])."', stu_pre_city = '".capitalize($_POST['city'])."', stu_pre_district = '".capitalize($_POST['district'])."', stu_pre_state = '".capitalize($_POST['state'])."', stu_pre_pincode = ".moneytodouble($_POST['pincode']).", stu_pre_country = '".capitalize($_POST['country'])."', stu_per_houseno = '".$_POST['house_no']."', stu_per_street = '".capitalize($_POST['street'])."', stu_per_area = '".capitalize($_POST['area'])."', stu_per_city = '".capitalize($_POST['city'])."', stu_per_district = '".capitalize($_POST['district'])."', stu_per_state = '".capitalize($_POST['state'])."', stu_per_pincode = ".moneytodouble($_POST['pincode']).", stu_per_country = '".capitalize($_POST['country'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			}
			
			/* U P D A T E   Q U E R Y   F R O M   A C A D E M I C   D E T A I L S */
			
			$query = "UPDATE current_course SET stu_rollno = ".$_POST['rollno'].", stu_univ_regno = '".$_POST['univ_regno']."', stu_course = ".capitalize($_POST['curr_course']).", stu_branch = ".capitalize($_POST['curr_branch']).", stu_degree = ".capitalize($_POST['curr_degree']).", stu_section = '".capitalize($_POST['curr_section'])."', stu_joined = '".capitalize($_POST['join_mode'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			
			echo "<br><br>";
			
			/*  Q U E R Y   F R O M   P R E V I O U S   A C A D E M I C   D E T A I L S */
			
			//echo $query = "UPDATE prev_academic_details SET stu_rollno = ".$_POST['rollno'].",prev_course = '".$_POST['X_course']."', prev_branch = '".$_POST['X_branch']."', year_of_passing = '".$_POST['X_duration_from']."',course_type = '".capitalize($_POST['X_course_type'])."', ins_name = '".capitalize($_POST['X_ins_name'])."', board_of_education = '".capitalize($_POST['X_board'])."', cgpa_obtained = ".$_POST['X_cgpa_marks'].",total_marks = ".$_POST['X_total_cgpa_marks'].", percentage = ".$_POST['X_percentage']." WHERE stu_rollno = ".$_POST['rollno']." AND prev_degree = 'X'";
			
			echo "<br><br>";
			$i = 10;
			echo $_POST['prev_degree'.$i];
			while(!empty($_POST['prev_degree'.$i]))
			{
					echo "inside while".$_POST['prev_degree'.$i];
					echo $query = "UPDATE prev_academic_details SET 
								stu_rollno = ".$_POST['rollno'].", 
								prev_degree = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".$_POST['prev_degree'.$i]."' END, 
								prev_course = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".capitalize($_POST['prev_course'.$i])."' END, 
								prev_branch = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".capitalize($_POST['prev_branch'.$i])."' END, 
								year_of_passing = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".$_POST['prev_duration_from'.$i]."' END,  
								course_type = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".capitalize($_POST['prev_course_type'.$i])."' END, 
								ins_name = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".capitalize($_POST['prev_ins_name'.$i])."' END, 
								board_of_education = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN '".capitalize($_POST['prev_board'.$i])."' END,  
								cgpa_obtained = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN ".$_POST['prev_cgpa_marks'.$i]." END,  
								total_marks = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN ".$_POST['prev_total_cgpa_marks'.$i]." END, 
								percentage = CASE WHEN prev_degree = '".$_POST['prev_degree'.$i]."' THEN ".$_POST['prev_percentage'.$i]." END
							WHERE stu_rollno = ".$_POST['rollno']."";
					//$run_query = mysqli_query($con, $query);
					echo "<br><br>";
					$i++;
			}
			
		}// Else if close for Update from (edit.php)
		
	
	else{
		echo "Invalid Request";
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