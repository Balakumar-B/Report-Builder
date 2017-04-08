<?php
	include("../db_con.php");
	error_reporting(0);
	if(isset($_REQUEST['key']))
	{
		global $view_student_search_key;
		$key_value = $_REQUEST['key'];
		//echo $key_value;
		if($key_value >= 1)
		{
			$query = "SELECT course_id,course_name FROM courses WHERE degree_id=".$key_value;
			$run_query = mysqli_query($con, $query);
			
			while($row = mysqli_fetch_array($run_query))
			{
				echo "<option value=".$row['course_id']." name = '".$row['course_name']."'>".$row['course_name']."</option>";
			}			
		}
		else if($key_value == 'current_course')
		{
			$query = "SELECT branch_id,branch_name FROM branch WHERE course_id=".$_REQUEST['course_id'];
			$run_query = mysqli_query($con, $query);
			
			while($row = mysqli_fetch_array($run_query))
			{
				echo "<option value = ".$row['branch_id'].">".$row['branch_name']."</option>";
			}
		}
		// S T U D E N T   R E C O R D   I N S E R T   F O L L O W I N G    S CR I P T
		/* Following queries to store Student details From DB to different Table These student Record info came from add.php file through ajax call , "in add.php" file form
			data's was serialized and pass to URl to "live_search.php(This file) , here we can directly access to $_POST['field_name_attr'], I haven't Used variables instead 
			Directly assign to query
			"
		 */
		else if($key_value == 'form_data')
		{
				mysqli_autocommit($con, FALSE);
			/*Q U E R Y   F R O M   S T U D  E N T   A D M I S S I O N   D E T A I L S*/	
				  $query = "INSERT INTO `admission_details` (`stu_rollno`, `admission_no`, `admission_date`) VALUES (".$_POST['rollno'].", ".$_POST['admission_no'].", '".db_date($_POST['admission_date'])."');";	
				$run_query = mysqli_query($con, $query);
				if(mysqli_affected_rows($con)>0)
				{
					
					//echo "Admission Deatails Inserted<br>";
				}
				else{
					
					mysqli_rollback($con);
					die('Error(admission-details): ' . mysqli_error($con));
				}
				
				//echo "<br><br>";
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
				else{}
				
				  $query = "INSERT INTO `stu_personal_details` (`stu_rollno`, `stu_firstname`, `stu_lastname`, `stu_gender`, `stu_dob`, `stu_religion`, `stu_community`, `stu_mother_maiden_name`, `stu_mother_name`, `stu_father_name`, `stu_parent_income`, `stu_nationality`, `stu_blood_group`, `stu_mother_tongue`, `stu_langknown_1`, `stu_langknown_2`) VALUES (".$_POST['rollno'].", '".capitalize($_POST["fname"])."', '".capitalize($_POST['lname'])."', '".capitalize($_POST['gender'])."', '".db_date($_POST['dob'])."', '".capitalize($_POST['religion'])."', '".$_POST['community']."', '".capitalize($_POST['mother_maiden_name'])."', '".capitalize($_POST['mother_name'])."', '".capitalize($_POST['father_name'])."', ".moneytodouble($_POST['demoLakh']).", '".capitalize($_POST['nationality'])."', '".$_POST['blood_group']."', '".capitalize($_POST['mother_tongue'])."', '".capitalize($_POST['lang1'])."', '".capitalize($_POST['lang2'])."');";
			
				$run_query = mysqli_query($con, $query);
				if(mysqli_affected_rows($con)>0)
				{
					
					//echo "Student-personal Deatails Inserted<br>";
				}
				else{
					
					mysqli_rollback($con);
					die('Error:(personal-details) ' . mysqli_error($con));
				}
			
				
			//echo "<br><br>";
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
							//echo "Student-contact Deatails Inserted<br>";
						}
						else{
							mysqli_rollback($con);
							die('Error:(contact-details) ' . mysqli_error($con));
						}
					//echo "<br><br>";
				} // ./if
				else
				{
						  $query = "INSERT INTO `stu_contact_details` (`stu_rollno`, `stu_email`, `stu_parent_email`, `stu_mobile`, `stu_alternative_mobile`, `stu_parent_mobile`, `stu_pre_houseno`, `stu_pre_street`, `stu_pre_area`, `stu_pre_city`, `stu_pre_district`, `stu_pre_state`, `stu_pre_pincode`, `stu_pre_country`, `stu_per_houseno`, `stu_per_street`, `stu_per_area`, `stu_per_city`, `stu_per_district`, `stu_per_state`, `stu_per_pincode`, `stu_per_country`) VALUES (".$_POST['rollno'].", '".$_POST['email']."', '".$_POST['alter_email']."', '".$_POST['mobile']."', '".$_POST['alter_mobile']."', '".$_POST['parent_mobile']."', '".$_POST['house_no']."', '".capitalize($_POST['street'])."', '".capitalize($_POST['area'])."', '".capitalize($_POST['city'])."', '".capitalize($_POST['district'])."', '".capitalize($_POST['state'])."', ".moneytodouble($_POST['pincode']).", '".capitalize($_POST['country'])."', '".$_POST['house_no']."', '".capitalize($_POST['street'])."', '".capitalize($_POST['area'])."', '".capitalize($_POST['city'])."', '".$_POST['district']."', '".$_POST['state']."', ".moneytodouble($_POST['pincode']).", '".$_POST['country']."');";
					
						$run_query = mysqli_query($con, $query);
						if(mysqli_affected_rows($con)>0)
						{
							//echo "Student-contact Deatails Inserted<br>";
						}
						else{
							mysqli_rollback($con);
							die('Error:(contact-details) ' . mysqli_error($con));
						}
					//echo "<br><br>";
				}
				
				/* Q U E R Y   F R O M   A C A D E M I C   D E T A I L S */
				
					 $query = "INSERT INTO `current_course` (`stu_rollno`, `stu_univ_regno`, `stu_course`, `stu_branch`, `stu_degree`, `stu_section`, `stu_batch`, `stu_joined`) VALUES (".$_POST['rollno'].", '".$_POST['univ_regno']."', ".$_POST['curr_course'].", ".$_POST['curr_branch'].", ".$_POST['curr_degree'].", '".$_POST['curr_section']."', '".date('Y')."', '".$_POST['join_mode']."');";	
					$run_query = mysqli_query($con, $query);
					if(mysqli_affected_rows($con)>0)
					{
						
						//echo "current-course Deatails Inserted<br>";
					}
					else{
						mysqli_rollback($con);
						die('Error:(current-academic-details) ' . mysqli_error($con));
					}				
					//echo "<br><br>";
				/*  Q U E R Y   F R O M   P R E V I O U S   A C A D E M I C   D E T A I L S */
				
					 $query = "INSERT INTO `prev_academic_details` (`stu_rollno`, `prev_degree`, `prev_course`, `prev_branch`, `year_of_passing`, `course_type`, `ins_name`, `board_of_education`, `cgpa_obtained`, `total_marks`, `percentage`) VALUES (".$_POST['rollno'].", 'X', '".$_POST['X_course']."', '".$_POST['X_branch']."', '".db_date($_POST['X_duration_from'])."', '".capitalize($_POST['X_course_type'])."', '".capitalize($_POST['X_ins_name'])."', '".capitalize($_POST['X_board'])."', ".$_POST['X_cgpa_marks'].", ".$_POST['X_total_cgpa_marks'].", ".$_POST['X_percentage'].");";
				
					//echo "<br><br>";
					$run_query = mysqli_query($con, $query);
					if(mysqli_affected_rows($con)>0)
					{
						
						//echo "Previous-academic Deatails Inserted<br>";
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
					//echo "<br><br>";
					$i++;
				}
				if($run_query){
					echo "OK";
				}
				mysqli_commit($con);
		}/* ./else if close here*/
		
		else if($key_value == 'view_student_search_key')
		{
			$view_student_search_key = $_POST['search_keyword'];
			if(ctype_digit($_POST['search_keyword']))
			{
				//echo "given value fully digit".$_POST['search_keyword'];
				$query = "SELECT a.stu_rollno, c.stu_course,c.stu_batch,a.admission_no,p.stu_firstname,p.stu_lastname,co.stu_email FROM current_course c, admission_details a,stu_personal_details p, stu_contact_details co WHERE a.stu_rollno = p.stu_rollno AND c.stu_rollno = co.stu_rollno AND a.stu_rollno = c.stu_rollno AND (a.stu_rollno = $view_student_search_key OR co.stu_mobile = $view_student_search_key OR co.stu_parent_mobile = $view_student_search_key OR co.stu_alternative_mobile = $view_student_search_key OR c.stu_univ_regno = $view_student_search_key);";
			}
			else if(!ctype_digit($_POST['search_keyword'])){
				//echo "given value is string".$_POST['search_keyword'];
				$rows = search_keyword($view_student_search_key);
				//print_r($rows);
				$view_student = array();
				foreach($rows as $row)
				{
					$query = "SELECT a.stu_rollno, c.stu_course,c.stu_batch,a.admission_no,p.stu_firstname,p.stu_lastname,co.stu_email FROM current_course c, admission_details a,stu_personal_details p, stu_contact_details co WHERE a.stu_rollno = p.stu_rollno AND c.stu_rollno = co.stu_rollno AND a.stu_rollno = c.stu_rollno AND (c.stu_degree = ".$row['degree_id']." AND c.stu_course = ".$row['course_id']." AND c.stu_branch = ".$row['branch_id'].");";
					//echo "<br><br>";
					$run_query = mysqli_query($con, $query);
					while($result = mysqli_fetch_array($run_query))
					{
						$view_student[] = $row['course_name'];
						$view_student[] = $result['stu_batch'];
						$view_student[] = $result['admission_no'];
						$view_student[] = $result['stu_rollno'];
						$view_student[] = $result['stu_firstname'].$result['stu_lastname'];
						$view_student[] = $result['stu_email'];
						/*echo "<tr>
								<td>".$row['course_name']."</td>
								<td>".$result['stu_batch']."</td>
								<td>".$result['admission_no']."</td>
								<td>".$result['stu_rollno']."</td>
								<td>".$result['stu_firstname'].$result['stu_lastname']."</td>
								<td>".$result['stu_email']."</td>
								<td align='center'><a href='edit.php?rollno=".$result['stu_rollno']."&degree=".$row['degree_name']."&course=".$row['course_name']."&branch=".$row['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a><button type='button' class='btn btn-danger btn-sm btn-flat' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm'><i class='fa fa-close'></i> Delete</button></td>
							</tr>";*/
						//echo json_encode($view_student); 
					}
				}
				
			}
			//$view_student_search_key = $_POST['search_keyword'];
			//$view_student_search_key = implode('.',str_split($view_student_search_key)); 
			//echo substr($view_student_search_key, 0, -2);
			//echo $view_student_search_key;
		}
		
		// S T U D E N T   R E C O R D   U P D A T E   F O L L O W I N G    S CR I P T
		/* Following queries to store Student details From DB to different Table These student Record info came from add.php file through ajax call , "in add.php" file form
			data's was serialized and pass to URl to "live_search.php(This file) , here we can directly access to $_POST['field_name_attr'], I haven't Used variables instead 
			Directly assign to query
			"
		 */
		else if($key_value == 'form_data_update'){
			mysqli_autocommit($con, FALSE);
			//echo $_REQUEST['key'];
			/* U P D A T E Q U E R Y  F R O M  S T U D E N T A D M I S S I O N  D E T A I L S */
			$query = "UPDATE admission_details SET stu_rollno = ".$_POST['rollno']." WHERE stu_rollno = ".$_POST['rollno']."";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con) == -1){
				mysqli_rollback($con);
				die(mysqli_error($con));
			}
			/* U P D A T E  Q U E R Y   F R O M    S T U D E N T   P E R S O N A L   D E T A I L S*/
			$query = "UPDATE stu_personal_details SET stu_rollno = ".$_POST['rollno'].", stu_firstname = '".capitalize($_POST['fname'])."',stu_lastname = '".capitalize($_POST['lname'])."',stu_gender = '".capitalize($_POST['gender'])."',stu_dob = '".db_date($_POST['dob'])."',stu_religion = '".capitalize($_POST['religion'])."',stu_community = '".capitalize($_POST['community'])."',stu_mother_maiden_name = '".capitalize($_POST['mother_maiden_name'])."', stu_mother_name = '".capitalize($_POST['mother_name'])."',stu_father_name = '".capitalize($_POST['father_name'])."', stu_parent_income = ".moneytodouble($_POST['demoLakh']).",stu_nationality = '".capitalize($_POST['nationality'])."', stu_blood_group = '".$_POST['blood_group']."', stu_mother_tongue = '".capitalize($_POST['mother_tongue'])."', stu_langknown_1 = '".capitalize($_POST['lang1'])."', stu_langknown_2 = '".capitalize($_POST['lang2'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			
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
			
			$query = "UPDATE current_course SET stu_rollno = ".$_POST['rollno'].", stu_univ_regno = '".$_POST['univ_regno']."', stu_course = ".capitalize($_POST['curr_course']).", stu_branch = ".capitalize($_POST['curr_branch']).", stu_degree = ".capitalize($_POST['curr_degree']).", stu_section = '".capitalize($_POST['curr_section'])."', stu_joined = '".capitalize($_POST['join_mode'])."' WHERE stu_rollno = ".$_POST['rollno']."";
			$run_query = mysqli_query($con, $query);
				
				if(mysqli_affected_rows($con) == -1){
					mysqli_rollback($con);
					die('Error: Update Current Academic Details' .mysqli_error($con));
				}
			//echo "<br><br>";
			
			/*  Q U E R Y   F R O M   P R E V I O U S   A C A D E M I C   D E T A I L S */
			
			//echo $query = "UPDATE prev_academic_details SET stu_rollno = ".$_POST['rollno'].",prev_course = '".$_POST['X_course']."', prev_branch = '".$_POST['X_branch']."', year_of_passing = '".$_POST['X_duration_from']."',course_type = '".capitalize($_POST['X_course_type'])."', ins_name = '".capitalize($_POST['X_ins_name'])."', board_of_education = '".capitalize($_POST['X_board'])."', cgpa_obtained = ".$_POST['X_cgpa_marks'].",total_marks = ".$_POST['X_total_cgpa_marks'].", percentage = ".$_POST['X_percentage']." WHERE stu_rollno = ".$_POST['rollno']." AND prev_degree = 'X'";
			
			//echo "<br><br>";
			$i = 10;
			//echo $_POST['prev_degree'.$i];
			while(!empty($_POST['prev_degree'.$i]))
			{
					//echo "inside while".$_POST['prev_degree'.$i];
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
					//echo "<br><br>";
					$i++;
			}
			if($run_query){
				echo "update ok";
			}
		}// Else if close for Update from (edit.php)
		
		else if($key_value = 'reports')
		{
			//echo "inside reports";
				$selected_course = $_POST['selected_course'];
				$query = "SELECT branch_id,branch_name FROM branch WHERE course_id=".$selected_course[$_POST['index_value']];
				$run_query = mysqli_query($con, $query);
				while($row = mysqli_fetch_array($run_query)){
					echo "<option value=".$row['branch_id'].">".$row['branch_name']."</option>";
				}
				//while(list($key, $value) = each($selected_course)){
					//echo $query = "SELECT branch_id,branch_name FROM branch WHERE course_id=".$selected_course[$_POST['index_value']];
				//}
				
		}
		/* Following Php Script for View student search box value */
		
		
	}// ./if(isset())
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
	function search_keyword($view_student_search_key)
	{
		$query = "SELECT d.degree_id,d.degree_name,c.course_id,c.course_name,b.branch_id,b.branch_name FROM degree d,courses c,branch b WHERE d.degree_id = c.degree_id AND b.course_id = c.course_id AND (d.degree_name like '%$view_student_search_key%' OR c.course_name like '%$view_student_search_key%' OR b.branch_name like '%$view_student_search_key%')";
		global $con;
		$run_query = mysqli_query($con, $query);
		
		//Declare the rows to an array
		$rows = array();
		// Insert Each row to an array
		while($row = mysqli_fetch_array($run_query))
		{
			$rows[] = $row;
		}
		// Return the array
		return $rows;
	}
?>
