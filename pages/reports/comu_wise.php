<?php
	include("../../db_con.php");
	if(isset($_SESSION['user_id'])){
		$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
		$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);
		error_reporting(0);
		
		$degree = array();
		$course = array();
		$branch = array();
		$branch_id = "";
		$working_type = "";
		unset($_SESSION['temp_branch']);
		
		$query = "SELECT staff_id,branch FROM staff_teaching WHERE staff_id = ".$_SESSION['staff_id']."";
		$run_query = mysqli_query($con, $query);
		$row = mysqli_fetch_array($run_query);
		if(mysqli_affected_rows($con) == 0)
		{
			$working_type = "Non-Teaching";
		}
		else{
			$branch_id = $row['branch'];
			$working_type = "Teaching";
		}
		if(count($dept_permission_reports)!=1){
			if($working_type == 'Teaching' && in_array('own', $dept_permission_reports)){
				if (($key = array_search('own', $dept_permission_reports)) !== false) {
					unset($dept_permission_reports[$key]);
					array_push($dept_permission_reports, $branch_id);
				}	
			}
			else{
				if (($key = array_search('own', $dept_permission_reports)) !== false) {
					unset($dept_permission_reports[$key]);
					//array_push($cart, $branch);
				}
			} //working_type
			$dept_permission_reports = implode(',',$dept_permission_reports);
			$query = "SELECT d.degree_id, d.degree_name, c.course_id, c.course_name, b.branch_id, b.branch_name FROM degree d, courses c, branch b WHERE d.degree_id = c.degree_id AND c.course_id = b.course_id AND b.branch_id IN(".$dept_permission_reports.")";
			$run_query = mysqli_query($con, $query);
			while($result = mysqli_fetch_array($run_query)){
				$degree[] = $result['degree_id'];	
				$course[] = $result['course_id'];
			} // while() close here
			$_SESSION['temp_branch'] = $dept_permission_reports;
		} // if(dept_permission_reports != 1) close here
		
		else if(count($dept_permission_reports) == 1 && in_array('own', $dept_permission_reports)){
			
			if($working_type == 'Teaching' && in_array('own', $dept_permission_reports)){
				
				if (($key = array_search('own', $dept_permission_reports)) !== false) {
					unset($dept_permission_reports[$key]);
					array_push($dept_permission_reports, $branch_id);
				}	
			}
			else{
				if (($key = array_search('own', $dept_permission_reports)) !== false) {
					unset($dept_permission_reports[$key]);
					//array_push($cart, $branch);
				}
			} //working_type
			$dept_permission_reports = implode(',',$dept_permission_reports);
			  $query = "SELECT d.degree_id, d.degree_name, c.course_id, c.course_name, b.branch_id, b.branch_name FROM degree d, courses c, branch b WHERE d.degree_id = c.degree_id AND c.course_id = b.course_id AND b.branch_id IN(".$branch_id.")";
			$run_query = mysqli_query($con, $query);
			while($result = mysqli_fetch_array($run_query)){
				$degree[] = $result['degree_id'];	
				$course[] = $result['course_id'];
			} // while() close here
			$_SESSION['temp_branch'] = $dept_permission_reports;
		} // else if() close here
		else if(count($dept_permission_reports) == 1 && in_array('all', $dept_permission_reports)){
			if (($key = array_search('all', $dept_permission_reports)) !== false) {
				unset($dept_permission_reports[$key]);
				//array_push($cart, $branch);
			}
			$query = "select course_id from courses";
			$run_query = mysqli_query($con, $query);
			while($result = mysqli_fetch_array($run_query)){
				//$degree[] = $result['degree_id'];	
				$course[] = $result['course_id'];
			} // while() close here
			$query = "select branch_id from branch";
			$run_query = mysqli_query($con, $query);
			while($result = mysqli_fetch_array($run_query)){
				//$degree[] = $result['degree_id'];	
				$branch[] = $result['branch_id'];
			} // while() close here
		}		
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report-Builder | Community-wise</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
   	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/datatables/dataTables.bootstrap.css">
	<!-- Select2 -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/select2/select2.min.css">
	<!-- File Export Buttons Style sheet -->
	<link rel="stylesheet" href="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.dataTables.min.css">

	<!-- Internal CSS  Defined Here--->
	<style>
		
		.Form-label,.Form-label--tick
		{
			display:block;
		}
		.Form-label--tick{
			position:relative;
			display:inline-block;
			margin-left:1em;
		}
		.Form-label-radio,.Form-label-checkbox{
			position:absolute;
			z-index:-1;
			width:1px;
			height:1px;
			opacity:0;
			overflow:hidden;
		}
		.Form-label-radio+.Form-label-text,.Form-label-checkbox+.Form-label-text{
			cursor:pointer;
			margin-right:1em;
		}
		.Form-label-radio+.Form-label-text::before,.Form-label-checkbox+.Form-label-text::before{
			font-size:.875em;
			display:inline-block;
			width:20px;
			height:20px;
			line-height:1.5;
			border:1px solid #ccc;
			margin-right:.25em;
			content:"\00a0";
			color:white;
			background-clip:padding-box;
			background-color:white;
			text-align:center;
		}
		.Form-label-radio+.Form-label-text:hover::before,.Form-label-checkbox+.Form-label-text:hover::before{
			border-color:black !important;
			box-shadow:0 0 0 0 black !important					
		}
		.Form-label-radio:checked+.Form-label-text::before,.Form-label-checkbox:checked+.Form-label-text::before{
			background-color:black;
			border-color:black;
			box-shadow:0 0 0 0 black;
			font-family:FontAwesome;
			content:"\f00c";
		}
	.Form-label-radio:focus+.Form-label-text::before,.Form-label-checkbox:focus+.Form-label-text::before,.Form-label-radio:active+.Form-label-text::before,.Form-label-checkbox:active+.Form-label-text::before{
		border-color:#3bb8ff;
		box-shadow:0 0 2px 0 rgba(0,135,212,0.2);
		}
		.Form-label-radio+.Form-label-text::before{
			border-radius:100%
		}
	
		.dataTables_wrapper {
	   		overflow: auto;
		}
		#totopscroller {
		position: fixed;
		right: 30px;
		bottom: 30px;
		width: 43px;
		}
		#totopscroller div {
		width: 49px;
		height: 43px;
		position: relative;
		}
		#totopscroller a {
		display: none;
		background: url('../../dist/img/totopicons.png');
		width: 49px;
		height: 43px;
		display: block;
		text-decoration: none;
		border: medium none;
		margin: 0 0 -1px;
		border: 1px solid #949494;
		}
		.totopscroller-top {
		background-position: 0 0 !important;
		}
		.totopscroller-lnk {
		background-position: 0 -43px !important;
		}
		.totopscroller-prev {
		background-position: 0 -129px !important;
		position: absolute;
		top: 0;
		left: 0;
		}
		.totopscroller-bottom {
		background-position: 0 -86px !important;
		position: absolute;
		top: 0;
		left: 0;
		}
	.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('../../dist/img/ajax-loader_trans.gif') 50% 50% no-repeat rgba(249, 249, 249, 0.76);
	}
</style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
  <body class="hold-transition skin-blue-light sidebar-mini">
	<div class="loader"></div> <!-- div from loader  -->
    <div class="wrapper">
		<?php
			include("../../header.php");
			//Left side column. contains the logo and sidebar 
			include("../../sidebar.php");
	  ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Report
            <small>Community wise</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Report</a></li>
            <li class="active">Community wise</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
			<!--<div class="col-md-11 pull-left">-->
				<div class="box box-primary collapsed-box" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Student Community Report</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->	
					</div><!-- ./box-header --->
					<!-- form start -->
					<form role="form" action="" method="post" id = "comu_form">
						<div class="box-body">
							<!-- Course list box-->
							<div class="form-group col-md-10">
								<label>Select a Course</label>
								<select class="form-control select2" id="com_wise_course" name="com_wise_course[]" multiple="multiple" data-placeholder="Select a course" style="width: 100%;">
			
									<?php
										$query = "SELECT course_id, degree_id, course_name FROM courses;";
										$run_query = mysqli_query($con, $query);
										while($row = mysqli_fetch_array($run_query))
										{ 
											?>
											<option value=<?php echo $row["course_id"] ?> <?php if(!in_array($row['course_id'], $course) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>><?php echo $row["course_name"]; ?></option>
										<?php	
										}
									?>
								</select>
								<?php
								if(in_array('all', $dept_permission_reports)){
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all Courses</div>';
								}
								else{
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all your access rights Courses</div>';
								}
							?>
							</div>
							<!-- Branch List -->
							<div class="form-group col-md-10">
								<label>Select a Branch</label>
								<select class="form-control select2" id="com_wise_branch" multiple="multiple" name="com_wise_branch[]" data-placeholder="Select a Brach" style="width: 100%;">
									
								</select>
								<?php
								if(in_array('all', $dept_permission_reports)){
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all branches</div>';
								}
								else{
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all your access rights branches</div>';
								}
							?>
							</div>
							<!-- Community List -->
							<div class="form-group col-md-10">
								<label>Select a Community</label>
								<select class="form-control select2" name="com_wise_community" data-placeholder="Select a Brach" style="width: 100%;">
									<option selected="selected">--Select--</option>
									<option>SC</option>
									<option>BC</option>
									<option>MBC</option>
									<option>ST</option>
									<option>Denotified Community</option>
									<option>Converted Christian from SC</option>
								</select>
								<div class="text-info" style="font-size:11px;">Leave Blank to be display all Community</div>
							</div>	
						</div><!-- ./box-body -->
						<div class="box-footer">
							<center><button type="submit" name="cummunity_wise_button" id="cummunity_wise_button" class="btn btn-primary">Submit</button></center>			
						</div>
					</form><!-- ./form -->
				</div><!-- ./box-primary -->
			<!--</div><!-- ./col-md-11 -->
		   </div><!-- ./row -->
		   <?php 
				if(isset($_POST['cummunity_wise_button'])){
				
				?>
			   <div class="row">
					<div class="box box-primary" id="community_generated_report">
						<div class="box-header with-border">
							<h3 class="box-title">Generated Report</h3>
							<!--<h4>Show Result for</h4>-->
							<p></p>
						</div>
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped compact" style="font-size: 12px;width:100%;">
								<thead>
									<tr>
										<th id="rollno"></th>
										<th id="fname"></th>
										<th id="lname"></th>
										<th id="gender"></th>
										<th id="dob"></th>
										<th id="religion"></th>
										<th id="community"></th>
										<th id="mother_name"></th>
										<th id="father_name"></th>
										<th id="parent_income"></th>
										<th id="nationality"></th>
										<th id="blood_group"></th>
										<th id="mother_tongue"></th>
										<th id="email"></th>
										<th id="mobile"></th>
										<th id="alter_mobile"></th>
										<th id="parent_email"></th>
										<th id="parent_mobile"></th>
										<th id="univ_regno"></th>
										<th id="degree"></th>
										<th id="course"></th>
										<th id="branch"></th>
										<th id="section"></th>
										<th id="year"></th>
										<th id="batch"></th>
										<th id="joined"></th>
										<th id="admission_quota">Admission-quota</th>
									</tr>
									<tr class="">
										<th id="">Rollno</th>
										<th id="">Fname</th>
										<th id="">Lname</th>
										<th id="">Gender</th>
										<th id="">DOB</th>
										<th id="">Religion</th>
										<th id="">Community</th>
										<th id="">Mother Name</th>
										<th id="">Father Name</th>
										<th id="">P-Incme</th>
										<th id="">Nationality</th>
										<th id="">Blood-Group</th>
										<th id="">Mother-Tongue</th>
										<th id="">Email</th>
										<th id="">Mobile</th>
										<th id="">Alter-Mobile</th>
										<th id="">Parent-email</th>
										<th id="">Parent-mobile</th>
										<th id="">Univ-Regno</th>
										<th id="">Degree</th>
										<th id="">Course</th>
										<th id="">Branch</th>
										<th id="">Section</th>
										<th id="">Year</th>
										<th id="">Batch</th>
										<th id="">Joined</th>
										<th id="">Admission-quota</th>
									</tr>
								</thead><!-- ./thead  -->
								<tbody>
								<?php 	
							
									if(in_array('all',$dept_permission_reports)){ 
										//echo "inside all";
										if(empty($_POST['com_wise_course']) && empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$course);
											$com_wise_branch = implode(',', $branch);
										}
										else if(!empty($_POST['com_wise_course']) && empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$_POST['com_wise_course']);
											$com_wise_branch = implode(',', $branch);
										}
										else if(empty($_POST['com_wise_course']) && !empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$course);
											$com_wise_branch = implode(',',$_POST['com_wise_branch']);
										}
										else{
											$com_wise_course = implode(',',$_POST['com_wise_course']);
											$com_wise_branch = implode(',',$_POST['com_wise_branch']);
										}
									}
									else{
										if(empty($_POST['com_wise_course']) && empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$course);
											$com_wise_branch = $_SESSION['temp_branch'];
										}
										else if(!empty($_POST['com_wise_course']) && empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$_POST['com_wise_course']);
											$com_wise_branch = $_SESSION['temp_branch'];
										}
										else if(empty($_POST['com_wise_course']) && !empty($_POST['com_wise_branch'])){
											$com_wise_course = implode(',',$course);
											$com_wise_branch = implode(',',$_POST['com_wise_branch']);
										}
										else{
											$com_wise_course = implode(',',$_POST['com_wise_course']);
											$com_wise_branch = implode(',',$_POST['com_wise_branch']);
										}
									}
									$com_wise_community = $_POST['com_wise_community'];
									
									$community = array();
									$catagories = "";
									$data = "";
									$series = "";
									if($com_wise_community != '--Select--'){
										$query = "SELECT p.stu_rollno, a.admission_no, a.admission_date, a.admission_quota, p.stu_firstname, p.stu_lastname, p.stu_gender, p.stu_dob, p.stu_religion, p.stu_community, p.stu_mother_name, p.stu_father_name, p.stu_parent_income, p.stu_nationality, p.stu_blood_group, p.stu_mother_tongue, c.stu_email, c.stu_mobile, c.stu_alternative_mobile, c.stu_parent_email, c.stu_parent_mobile, curr.stu_univ_regno, curr.stu_course,curr.stu_branch, curr.stu_degree, curr.stu_section, curr.stu_batch, curr.stu_joined,d.degree_name,co.course_name, b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_course IN (".$com_wise_course.") AND curr.stu_branch IN (".$com_wise_branch.") AND p.stu_community = '".$com_wise_community."' AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch)";
										
										$query1 = "select count(*) total, sum(case when stu_community = '".$com_wise_community."' then 1 else 0 end) ".$com_wise_community.", b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_branch IN (".$com_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) group by b.branch_name";
										
										$data = "[";
										$run_query1 = mysqli_query($con, $query1);
										
										while($row1 = mysqli_fetch_array($run_query1)){
											//echo "while";
											$catagories .= "'".$row1['branch_name']."',";
											$data .= $row1[$com_wise_community].",";
										}
										$data = rtrim($data, ",");
										$catagories = rtrim($catagories, ",");
										$data .= "]";
										//echo "<br />".$catagories;
										$series = "{
											name: '".$com_wise_community."',
											data: $data
										}";
									} // if()close here
									else{
										 $query = "SELECT p.stu_rollno, a.admission_no, a.admission_date, a.admission_quota, p.stu_firstname, p.stu_lastname, p.stu_gender, p.stu_dob, p.stu_religion, p.stu_community, p.stu_mother_name, p.stu_father_name, p.stu_parent_income, p.stu_nationality, p.stu_blood_group, p.stu_mother_tongue, c.stu_email, c.stu_mobile, c.stu_alternative_mobile, c.stu_parent_email, c.stu_parent_mobile, curr.stu_univ_regno, curr.stu_course,curr.stu_branch, curr.stu_degree, curr.stu_section, curr.stu_batch, curr.stu_joined,d.degree_name,co.course_name, b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_course IN (".$com_wise_course.") AND curr.stu_branch IN (".$com_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch)";
										 
										 $query1 = "select count(*) total, sum(case when stu_community = 'BC' then 1 else 0 end) bc, sum(case when stu_community = 'MBC' then 1 else 0 end) mbc, sum(case when stu_community = 'Converted to Christian From Sc' then 1 else 0 end) converted, sum(case when stu_community = 'Denotified Community' then 1 else 0 end) denotified, sum(case when stu_community = 'ST' then 1 else 0 end) st, sum(case when stu_community = 'SC' then 1 else 0 end) sc, b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_branch IN (".$com_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) group by b.branch_name";
										
										$community[] = "BC";
										$community[] = "MBC";
										$community[] = "Converted to Christian From Sc";
										$community[] = "Denotified Community";
										$community[] = "SC";
										$community[] = "ST";
										
										$run_query1 = mysqli_query($con, $query1);
										$bc= array();
										$mbc = array();
										$converted = array();
										$denotified = array();
										$sc = array();
										$st = array();
										$total = array();
										while($row1 = mysqli_fetch_array($run_query1)){
											//echo "while";
											$catagories .= "'".$row1['branch_name']."',";
											$bc[] = $row1['bc'];
											$mbc[] = $row1['mbc'];
											$converted[] = $row1['converted'];
											$denotified[] = $row1['denotified'];
											$sc[] = $row1['sc'];
											$st[] = $row1['st'];
										}
										//$data = rtrim($data, ",");
										$catagories = rtrim($catagories, ",");
										
										$series .=  "{
											name: 'BC',
											data: [".implode(",", $bc)."]
										},
										{
											name: 'MBC',
											data: [".implode(",", $mbc)."]
										},
										{
											name: 'Converted Christian From Sc',
											data: [".implode(",", $converted)."]
										},
										{
											name: 'Denotified Community',
											data: [".implode(",", $denotified)."]
										},
										{
											name: 'SC',
											data: [".implode(",", $sc)."]
										},
										{
											name: 'ST',
											data: [".implode(",", $st)."]
										}";
										
										$pie_chart = "{
											name: 'SC',
											y: ".array_sum($sc)."
											
										}, {
											name: 'ST',
											y: ".array_sum($st)."
											//sliced: true,
											//selected: true
										}, {
											name: 'BC',
											y: ".array_sum($bc)."
										}, {
											name: 'MBC',
											y: ".array_sum($mbc)."
										}, {
											name: 'Denotified Community',
											y: ".array_sum($denotified)."
										}, {
											name: 'Converted Christian from SC',
											y: ".array_sum($converted)."
										}";
										
										$combination = "{
										type: 'column',
										name: 'SC',
										data: [".implode(",", $sc)."]
										}, {
											type: 'column',
											name: 'ST',
											data: [".implode(",", $st)."]
										}, {
											type: 'column',
											name: 'BC',
											data: [".implode(",", $bc)."]
										},
										{
											type: 'column',
											name: 'MBC',
											data: [".implode(",", $mbc)."]
										},
										{
											type: 'column',
											name: 'Denotified Community',
											data: [".implode(",", $denotified)."]
										},
										{
											type: 'spline',
											name: 'Converted Christian from SC',
											data: [".implode(",", $converted)."],
											marker: {
												lineWidth: 2,
												lineColor: Highcharts.getOptions().colors[3],
												fillColor: 'white'
											}
										}";
									} // else close here
								
									$run_query = mysqli_query($con, $query);
									
									while($result = mysqli_fetch_array($run_query)){
										if((date('Y')-$result['stu_batch'] == 1) || (date('Y')-$result['stu_batch'])== 0){
											$stu_year = 1;		
										}
										else{
											$stu_year = date('Y')-$result['stu_batch'];
										}
										echo "
											<tr>
												<td>".$result['stu_rollno']."</td>
												<td>".$result['stu_firstname']."</td>
												<td>".$result['stu_lastname']."</td>
												<td>".$result['stu_gender']."</td>
												<td>".date('d-m-Y',strtotime($result['stu_dob']))."</td>
												<td>".$result['stu_religion']."</td>
												<td>".$result['stu_community']."</td>
												<td>".$result['stu_mother_name']."</td>
												<td>".$result['stu_father_name']."</td>
												<td>".$result['stu_parent_income']."</td>
												<td>".$result['stu_nationality']."</td>
												<td>".$result['stu_blood_group']."</td>
												<td>".$result['stu_mother_tongue']."</td>
												<td>".$result['stu_email']."</td>
												<td>".$result['stu_mobile']."</td>
												<td>".$result['stu_alternative_mobile']."</td>
												<td>".$result['stu_parent_email']."</td>
												<td>".$result['stu_parent_mobile']."</td>
												<td>".$result['stu_univ_regno']."</td>
												<td>".$result['degree_name']."</td>
												<td>".$result['course_name']."</td>
												<td>".$result['branch_name']."</td>
												<td>".$result['stu_section']."</td>
												<td>".$stu_year."</td>
												<td>".$result['stu_batch']."</td>
												<td>".$result['stu_joined']."</td>
												<td>".$result['admission_quota']."</td>
											</tr>
										";
									}// while() close here
								?>
								</tbody><!-- ./tbody -->
								<tfoot>
									<tr>
										<th id="">Rollno</th>
										<th id="">Fname</th>
										<th id="">Lname</th>
										<th id="">Gender</th>
										<th id="">DOB</th>
										<th id="">Religion</th>
										<th id="">Community</th>
										<th id="">Mother Name</th>
										<th id="">Father Name</th>
										<th id="">P-Incme</th>
										<th id="">Nationality</th>
										<th id="">Blood-Group</th>
										<th id="">Mother-Tongue</th>
										<th id="">Email</th>
										<th id="">Mobile</th>
										<th id="">Alter-Mobile</th>
										<th id="">Parent-email</th>
										<th id="">Parent-mobile</th>
										<th id="">Univ-Regno</th>
										<th id="">Degree</th>
										<th id="">Course</th>
										<th id="">Branch</th>
										<th id="">Section</th>
										<th id="">Year</th>
										<th id="">Batch</th>
										<th id="">Joined</th>
										<th id="">Admission-quota</th>
									</tr>
								</tfoot><!-- ./tfoot -->
							</table><!-- ./table -->
							<div class="col-md-12" id="chart_options">
								<label class="col-md-2" style="padding-top:1%;">Select a Chart type</label>
								<div class="form-group" style="padding-top:1%;">
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="line_chart" />
										<span class="Form-label-text">Line Chart <i class="fa fa-line-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="area_chart" />
										<span class="Form-label-text">Area Chart <i class="fa  fa-area-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="bar_chart" />
										<span class="Form-label-text">Bar Chart <i class="fa fa-bar-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="pie_chart" />
										<span class="Form-label-text">Pie Chart <i class="fa fa-pie-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="combination_chart" />
										<span class="Form-label-text">Combination</span>
									</label>
								</div><!-- ./form-group -->
							</div><!-- ./chart_options -->
							
						<!-- Chart Will be Displying Here -->	
						<div class="col-md-12" id="charts"></div> 
							
						</div><!-- box-body -->
						<div class="box-footer" style="::before{padding-top: .40%}";>
							<!--<div class="col-md-9">
								<div class="col-md-3">
									<label style="margin-top: 4%;float: right;">Export file format</label>
								</div>
								<div class="col-md-4">
									<select class="form-control" width="100%">
										<option value="default">Choose..</option>
										<option value="docx">DOCX</option>
										<option value="doc">DOC</option>
										<option value="pdf">PDF</option>
										<option value="xls">XLS</option>
										<option value="xlsx">XLSX</option>
										<option value="csv">CSV</option>
									</select>
									<div style="font-size:9px;"	>Download default template, Table with Chart..</div>
								</div>
								<form action="" method="post">
								<div class="col-md-2">
									<button type="submit" class="btn btn-success btn-block btn-flat" name="down_doc" id=""><i class="fa fa-download"></i> Download</button>
								</div>
								</form>
								<label style="margin-left: 11%;margin-top: 1%;">OR</label>
							</div>
							<div class="col-md-2">
								<button class="btn btn-info btn-flat btn-block" data-toggle="modal" data-target="#gridSystemModal"><i class="fa fa-edit"></i> Generate Report</button>
								<div style="font-size:9px;">(Only for Pdf & Docx, You can choose Template Or Customize your Report)</div>
							</div>--
							<?php
							if(isset($_POST['down_doc'])){
								echo "downloaded";
								$url=$_SERVER['REQUEST_URI'];
								$a=file_get_contents($url);
								$page = htmlentities($a);
								$filename = "source.doc";
								header('Content-type: application/vnd.ms-word');
								header('Content-Disposition: attachment; filename='.$filename);
								echo $page;
							}
							?>
							<!-- MODEL BOX FOR GENERATE REPORT CUSTOMIZE OPTION -->
							
							<div class="modal fade" tabindex="-1" id="gridSystemModal" role="dialog" aria-labelledby="gridSystemModalLabel">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="gridSystemModalLabel">Customize your Report</h4>
								  </div> <!-- ./modal-header -->
								  <div class="modal-body">
									<div class="row">
										
									</div><!-- ./row -->
								  </div><!-- ./modal-body -->
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary">Save changes</button>
								  </div>
								</div><!-- /.modal-content -->
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<!-- M O D A L   B O X   C L O S E   H E R E  -->
							
						</div><!-- ./box-foooter -->
					</div><!-- ./box-primary -->
		   		</div>
				<?php
					}	// isset() close here
					else{
						
					}
					?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="totopscroller"></div>
	  <?php
		include("../../footer.php");
		include("../../sidepane.php");
	  ?>
		
    </div><!-- ./wrapper -->

	<!--J Q U E R Y   P L U G  I N S   I N C L U  D E D   B E L O W -->

	<!-- high charts Script -->
	<script src="<?php echo path ?>plugins/highcharts/highcharts.js"></script>
	<script src="<?php echo path ?>plugins/highcharts/exporting.js"></script>
	<script src="<?php echo path ?>/plugins/highcharts/export-csv.js"></script>
	
	<!-- Cloumn Visibility Button -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.colVis.min.js"></script>
	<!-- My custom script -->
	<script src="<?php echo path ?>Custom_script/reports.js"></script>
	
    <!-- Page script -->
		<script>
			$(window).load(function() {
				$(".loader").fadeOut("slow");
			});
			$(document).ready(function(){
				//$('#community_generated_report').hide();
				$('#totopscroller').totopscroller({
					showToBottom: true,
					showToPrev: true,
					link: false,
					linkTarget: '_self',
					toTopHtml: '<a href="#"></a>',
					toBottomHtml: '<a href="#"></a>',
					toPrevHtml: '<a href="#"></a>',
					linkHtml: '<a href="#"></a>',
					toTopClass: 'totopscroller-top',
					toBottomClass: 'totopscroller-bottom',
					toPrevClass: 'totopscroller-prev',
					linkClass: 'totopscroller-lnk',
				});
				$('#example').hide();
				$(".select2").select2();
				 var table  = $('#example1').dataTable({
						"sDom": 'Bfrtip',
						//stateSave: true,
						lengthMenu: [
            				[ 10, 25, 50,100, -1 ],
            				[ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        				],
						/*"buttons": [
							{
								extend: 'collection',
								text: 'Export',
								buttons: [
									'copy',
									'excel',
									'csv',
									'pdf',
									'print'
								]
							}
						],*/
						buttons: [
							'pageLength',
							{
								extend: 'pdf',
								exportOptions: {columns: ':visible'},
								filename: 'Data export',
								text:      '<i class="fa fa-file-pdf-o" style="color:red;"></i>',
								titleAttr: 'PDF',
								orientation: 'landscape',
               					pageSize: 'LEGAL',
								//header: false
							},
							
							{
								extend: 'excel',
								exportOptions: {columns: ':visible'},
								text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
								titleAttr: 'Excel'
							},
							{
								extend: 'csv',
								exportOptions: {columns: ':visible'},
								text:      '<i class="fa fa-file-text-o"></i>',
                				titleAttr: 'CSV'
							},
							{
								extend: 'print',
								exportOptions: {columns: ':visible'},
								pageSize: 'LEGAL'
							},
							{
								text: 'Choose Column',
                				extend: 'colvis',
                				postfixButtons: [ 'colvisRestore' ],
								collectionLayout: 'fixed three-column'
							},
					],
					columnDefs: [
            			//{
							 { targets: [0, 1], visible: true},
        					 { targets: '_all', visible: true }
                			//targets: [3,4,5,7,8,9,10,11,12,14,15,16,17,18,19],
                			//visible: true,
            			//}
        			]
					
				}).columnFilter({
					//"sPlaceHolder" : "head:before",
					 aoColumns:[
					 			{sSelector:"#rollno",type:"number-range"},
								{sSelector:"#fname",type:"text"},
								{sSelector:"#lname",type:"text"},
								{sSelector:"#gender",type:"select"},
								{sSelector:"#dob",type: "text"},
								{sSelector:"#religion",type:"select"},
								{sSelector:"#community",type:"select"},
								{sSelector:"#mother_name",type:"text"},
								{sSelector:"#father_name",type:"text"},
								{sSelector:"#parent_income",type:"number-range"},
								{sSelector:"#nationality",type:"select"},
								{sSelector:"#blood_group",type:"select"},
								{sSelector:"#mother_tongue",type:"select"},
								{sSelector:"#email",type:"text"},
								{sSelector:"#mobile",type:"text"},
								{sSelector:"#alter_mobile",type:"text"},
								{sSelector:"#parent_email",type:"text"},
								{sSelector:"#parent_mobile",type:"text"},
								{sSelector:"#univ_regno",type:"number-range"},
								{sSelector:"#degree",type:"select"},
								{sSelector:"#course",type:"select"},
								{sSelector:"#branch",type:"select"},
								{sSelector:"#section",type:"select"},
								{sSelector:"#year",type:"number-range"},
								{sSelector:"#batch",type:"select"},
								{sSelector:"#joined",type:"select"},
								{sSelector:"#admission_quota",type:"select"},	
					 ]
				});
				/* following script table row selection */
				$('#example1 tbody').on( 'click', 'tr', function () {
					alert("select");
					$(this).toggleClass('selected');
				} );
			 
				$('#button').click( function () {
					alert( table.rows('.selected').data().length +' row(s) selected' );
				} );
				/* row selection script close here*/
				$("#comu_form").submit(function( event ) {
					  jQuery.validator.addMethod("valueNotEquals", function(value, element, arg){
						  return arg != value;
						}, "Value must not equal arg.");
						
					 var v = $('#comu_form');
						v.validate({
							rules:{
								com_wise_course:{
									valueNotEquals: ""
								},
							},
							messages:{
								
							}
						});
						if(v.valid() != true)
						{
							event.preventDefault();
						}
				});
					<!-- C H A R T    S C R I P T    S T A R T   H E R E -->
				
				<!-- L I N E    C H A R T -->
			<?php if(isset($_POST['cummunity_wise_button'])){
				
			?>	
        		$('input:radio').click(function(){
					//alert($(this).val());
					if($(this).val() == 'line_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						
						$('#charts').highcharts({
						chart: {
            				type: 'line'
        				},
						title: {
							text: 'Community Report chart',
							x: -20 //center
						},
						subtitle: {
							//text: 'Source: WorldClimate.com',
							x: -20
						},
						xAxis: {
							categories: [<?php echo $catagories; ?>]
						},
						yAxis: {
							title: {
								text: 'No.of Students'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						plotOptions: {
            				series: {
              				  allowPointSelect: true,
							  cursor: 'pointer'
          					  }
        				},
						tooltip: {
							valueSuffix: ' students'
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [<?php echo $series ?>]
					});
					}<!-- ./if -->
					
					<!-- A R E A   |  C H A R T -->
					
					else if($(this).val() == 'area_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						
						$('#charts').highcharts({
						chart: {
							  type: 'area'
						  },
						title: {
							text: 'Community Report Area Chart'
						},
						subtitle: {
							//text: ''
						},
						xAxis: {
							categories: [<?php echo $catagories; ?>]
						},
							/*allowDecimals: false,
							labels: {
								formatter: function () {
									return this.value; // clean, unformatted number for year
								}
							}
						},*/
						yAxis: {
							title: {
								text: 'No.of students'
							},
							
						},
						tooltip: {
							pointFormat: '{series.name} Students <b>{point.y:,.0f}</b><br/>'
						},
						plotOptions: {
							area: {
								//pointStart: 'SC',
								cursor: 'pointer',
								stacking: 'normal'
								/*marker: {
									enabled: false,
									symbol: 'circle',
									radius: 2,
									states: {
										hover: {
											enabled: true
										}
									}
								}*/
							}
						},
						series: [<?php echo $series ?>]
					});
					}<!-- ./else if for area chart-->
					
					<!-- B A R    |   C H A R T -->
					
					else if($(this).val() == 'bar_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							chart: {
								type: 'column'
							},
							title: {
								text: 'Community Report Stacked column chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							yAxis: {
								//min: 0,
								title: {
									text: 'Total students'
								},
								stackLabels: {
									enabled: true,
									style: {
										fontWeight: 'bold',
										color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
									}
								}
							},
							legend: {
								align: 'right',
								x: -30,
								verticalAlign: 'top',
								y: 25,
								floating: true,
								backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
								borderColor: '#CCC',
								borderWidth: 1,
								shadow: false
							},
							tooltip: {
								headerFormat: '<b>{point.x}</b><br/>',
								pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
							},
							plotOptions: {
								column: {
									cursor: 'pointer',
									stacking: 'normal',
									dataLabels: {
										enabled: true,
										color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
										style: {
											textShadow: '0 0 3px black'
										}
									}
								}
							},
							series: [<?php echo $series ?>]
						});
					}<!-- ./else if for bar chart(bar with stacked) -->
					
					<!-- P I E   C H A R T -->
					
					else if($(this).val() == 'pie_chart')
					{
						$('body,html').animate({scrollTop: $('body').height()}, 'slow'); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							chart: {
								plotBackgroundColor: null,
								plotBorderWidth: null,
								plotShadow: false,
								type: 'pie'
							},
							title: {
								text: 'Community wise Student Report chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							tooltip: {
								//pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
							},
							plotOptions: {
								pie: {
									allowPointSelect: true,
									cursor: 'pointer',
									dataLabels: {
										enabled: true,
										format: '<b>{point.name}</b>: {point.y} ',
										style: {
											color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
										}
									},
									showInLegend: true
								}
							},
							series: [{
								name: 'Students',
								colorByPoint: true,
								data: [<?php echo $pie_chart?>]
							}]
						});
					}<!-- ./else if for pie chart -->
					else if($(this).val() == 'combination_chart')
					{	
						$('body,html').animate({scrollTop: $('body').height()}, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							title: {
								text: 'Combination chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							labels: {
								items: [{
									html: '',
									style: {
										left: '50px',
										top: '18px',
										color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
									}
								}]
							},
							series: [<?php echo $combination ?>
							 , {
								type: 'pie',
								name: 'Total consumption',
								data: [<?php echo $pie_chart ?>],
								
								center: [150, 10],
								size: 100,
								showInLegend: false,
								dataLabels: {
									enabled: false
								}
							}]
						});
					}<!-- else if close for combination chart -->
				});	// ./rdion button click event close
			<?php } ?>
				<!-- C H A R T    S C R I P T    E N D   H E R E -->
			});	
		</script>
  </body>
</html>
<?php
	} // if(isset()) close here
	else{
		header("location:/report_builder/login.php");
	}
?>
