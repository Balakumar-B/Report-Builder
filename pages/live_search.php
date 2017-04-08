<?php
	include("../db_con.php");
	include("functions.php");
	error_reporting(0);
	$temp_branch = explode(',', $_SESSION['temp_branch']);
	$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);

	if(isset($_REQUEST['key']))
	{
		global $view_student_search_key;
		$key_value = $_REQUEST['key'];
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
		else if($key_value == 'reports')
		{
			//echo "inside reports";
				$selected_course = implode(',',$_POST['selected_course']);
				echo $query = "SELECT branch_id,branch_name FROM branch WHERE course_id IN (".$selected_course.")";
				$run_query = mysqli_query($con, $query);
				while($row = mysqli_fetch_array($run_query)){
					?>
						<option value=<?php echo $row['branch_id'] ?> <?php if(!in_array($row['branch_id'], $temp_branch) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>><?php echo $row['branch_name'] ?></option>
					<?php
				}
				//while(list($key, $value) = each($selected_course)){
					//echo $query = "SELECT branch_id,branch_name FROM branch WHERE course_id=".$selected_course[$_POST['index_value']];
				//}
				
		}
		else if($key_value == 'custo_course'){
			
			$query = "SELECT branch_id,branch_name FROM branch WHERE course_id=".$_POST['course_id'];
			$run_query = mysqli_query($con, $query);
			
			while($row = mysqli_fetch_array($run_query))
			{
				?>
					<label class="Form-label--tick">
						<input type="checkbox" name="custo_branch[]" class="Form-label-checkbox" value=<?php echo $row['branch_id'] ?> <?php if(!in_array($row['branch_id'], $temp_branch) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>/>
						<?php if(!in_array($row['branch_id'], $temp_branch) && !in_array('all', $dept_permission_reports)){echo '<span class="Form-label-text" style="color:rgba(0,0,0,0.2);"> '.$row['branch_name'] .'</span>';}else{echo '<span class="Form-label-text"> '.$row['branch_name'] .'</span>';} ?>
						
					</label>
			<?php
			}
			//echo print_r($custo_degree_returns);
		}
	}// ./if(isset())
	else{
		//echo "Invalid Request";
	}
	/*function search_keyword($view_student_search_key)
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
	}*/
?>
