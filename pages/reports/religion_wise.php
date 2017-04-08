<?php
	include('../../db_con.php');
	if(isset($_SESSION['user_id'])){
		
		$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
		$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);
		error_reporting(0);
		
		$degree = array();
		$course = array();
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Report Builder|Religion wise</title>
	<!-- Tell the browser to be responsive to screen Width -->
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
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="loader"></div> <!-- div from loader  -->
	<div class="wrapper">
		<?php
			include("../../header.php");
			include("../../sidebar.php");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Report
					<small>Student Religion wise</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Report</a></li>
					<li>Religion wise</li>
				</ol>
			</section><!-- ./content-header -->
			<section class="content">
				<div class="box box-primary" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Religion wise report</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->
					</div><!-- ./box-header -->
					<form role="form" action="" method="post">
					  <div class="box-body">
						<!-- Course list box-->
						<div class="form-group col-md-10">
							<label>Select a Course</label>
							<select class="form-control select2" name="religion_wise_course[]" id="religion_wise_course" multiple="multiple" data-placeholder="Select a course" style="width: 100%;">
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
							<select class="form-control select2" name = "religion_wise_branch[]" id="religion_wise_branch" multiple="multiple" data-placeholder="Select a Brach" style="width: 100%;">
								
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
						
						<!-- Religion list -->
						<div class="form-group col-md-10">
							<label>select a Religion</label>
							<select class="form-control select2" name="selected_religion" >
								<option selected="selected">--Select--</option>
								<option>Hindu</option>
								<option>Christian</option>
								<option>Islam</option>
								<option>Jain</option>
							</select>
							<div class="text-info" style="font-size:11px;">Leave blank to be display all Religion</div>
						</div>		
					  </div><!-- ./box-body -->  
					<div class="box-footer">
						<center><button type="submit" name="religion_wise_button" class="btn btn-primary">Submit</button></center>
					</div>
				 </form> <!-- ./form close here -->
			   </div><!-- ./box-primary -->
			<?php
				if(isset($_POST['religion_wise_button'])){
					
			?>
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Generated Report</h3>
					</div><!-- ./box-header -->
					<div class="box-body">
						<table id="example1" class="table table-bordered table-striped" style="font-size: 13px;">
							<thead>
								<tr>
									<th id="rollno">Rollno</th>
									<th id="name">Name</th>
									<th id="gender">Gender</th>
									<th id="course">Course</th>
									<th id="branch">Branch</th>
									<th id="section">Section</th>
									<th id="year">Year</th>
									<th id="religion">Religion</th>
								</tr>
								<tr>
									<th>Rollno</th>
									<th>Name</th>
									<th>Gender</th>
									<th>Course</th>
									<th>Branch</th>
									<th>Section</th>
									<th>Year</th>
									<th>Religion</th>
								</tr>
							</thead>
							<tbody>
							<?php
								if(in_array('all',$dept_permission_reports)){ 
										if(empty($_POST['religion_wise_course']) && empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$course);
											$religion_wise_branch = implode(',', $branch);
										}
										else if(!empty($_POST['religion_wise_course']) && empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$_POST['religion_wise_course']);
											$religion_wise_branch = implode(',', $branch);
										}
										else if(empty($_POST['religion_wise_course']) && !empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$course);
											$religion_wise_branch = implode(',',$_POST['religion_wise_branch']);
										}
										else{
											$religion_wise_course = implode(',',$_POST['religion_wise_course']);
											$religion_wise_branch = implode(',',$_POST['religion_wise_branch']);
										}
									}
									else{
										if(empty($_POST['religion_wise_course']) && empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$course);
											$religion_wise_branch = $_SESSION['temp_branch'];
										}
										else if(!empty($_POST['religion_wise_course']) && empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$_POST['religion_wise_course']);
											$religion_wise_branch = $_SESSION['temp_branch'];
										}
										else if(empty($_POST['religion_wise_course']) && !empty($_POST['religion_wise_branch'])){
											$religion_wise_course = implode(',',$course);
											$religion_wise_branch = implode(',',$_POST['religion_wise_branch']);
										}
										else{
											$religion_wise_course = implode(',',$_POST['religion_wise_course']);
											$religion_wise_branch = implode(',',$_POST['religion_wise_branch']);
										}
									}
									
									$selected_religion = $_POST['selected_religion'];
									$religion = array();
									$catagories = "";
									$data = "";
									$series = "";
									
								if($selected_religion != '--Select--'){
										//echo "inside if";
										 $query = "SELECT p.stu_rollno, p.stu_firstname, p.stu_lastname,p.stu_gender,p.stu_religion, co.course_name,b.branch_name, curr.stu_section,curr.stu_batch FROM admission_details a, stu_personal_details p,degree d, courses co, branch b, current_course curr WHERE (a.admission_no = p.admission_no) AND p.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_course IN (".$religion_wise_course.") AND curr.stu_branch IN (".$religion_wise_branch.") AND p.stu_religion = '".$selected_religion."' AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch)";
										 
										$query1 = "select count(*) total, sum(case when stu_religion = '".$selected_religion."' then 1 else 0 end) ".$selected_religion.", b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_branch IN (".$religion_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) group by b.branch_name";
										
										$data = "[";
										$run_query1 = mysqli_query($con, $query1);
										
										while($row1 = mysqli_fetch_array($run_query1)){
											//echo "while";
											$catagories .= "'".$row1['branch_name']."',";
											$data .= $row1[$selected_religion].",";
										}
										$data = rtrim($data, ",");
										$catagories = rtrim($catagories, ",");
										$data .= "]";
										//echo "<br />".$catagories;
										$series = "{
											name: '".$selected_religion."',
											data: $data
										}";
									} // if() close here
									else{
										//echo "inside else";
										 $query = "SELECT p.stu_rollno, p.stu_firstname, p.stu_lastname,p.stu_gender,p.stu_religion, co.course_name,b.branch_name, curr.stu_section,curr.stu_batch FROM admission_details a, stu_personal_details p,degree d, courses co, branch b, current_course curr WHERE (a.admission_no = p.admission_no) AND p.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_course IN (".$religion_wise_course.") AND curr.stu_branch IN (".$religion_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch)";
										 
										 $query1 = "select count(*) total, sum(case when stu_religion = 'Hindu' then 1 else 0 end) hindu, sum(case when stu_religion = 'Christian' then 1 else 0 end) christian, sum(case when stu_religion = 'Islam' then 1 else 0 end) islam, sum(case when stu_religion = 'Jain' then 1 else 0 end) jain, b.branch_name FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course curr,degree d, courses co, branch b WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = curr.stu_rollno AND curr.stu_rollno = p.stu_rollno AND (curr.stu_branch IN (".$religion_wise_branch.") AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) group by b.branch_name";
										
										$religion[] = "Hindu";
										$religion[] = "Christian";
										$religion[] = "Islam";
										$religion[] = "Jain";
										
										$run_query1 = mysqli_query($con, $query1);
										$hindu= array();
										$chritian = array();
										$islam = array();
										$jain = array();
										$total = array();
										while($row1 = mysqli_fetch_array($run_query1)){
											//echo "while";
											$catagories .= "'".$row1['branch_name']."',";
											$hindu[] = $row1['hindu'];
											$christian[] = $row1['christian'];
											$islam[] = $row1['islam'];
											$jain[] = $row1['jain'];
										}
										//$data = rtrim($data, ",");
										$catagories = rtrim($catagories, ",");
										
										$series .=  "{
											name: 'Hindu',
											data: [".implode(",", $hindu)."]
										},
										{
											name: 'Christian',
											data: [".implode(",", $christian)."]
										},
										{
											name: 'Islam',
											data: [".implode(",", $islam)."]
										},
										{
											name: 'Jain',
											data: [".implode(",", $jain)."]
										}";
										
										$pie_chart = "{
											name: 'Hindu',
											y: ".array_sum($hindu)."
											
										}, {
											name: 'Christian',
											y: ".array_sum($christian)."
										}, {
											name: 'Islam',
											y: ".array_sum($islam)."
										}, {
											name: 'Jain',
											y: ".array_sum($jain)."
										}";
										
										$combination = "{
										type: 'column',
										name: 'Hindu',
										data: [".implode(",", $hindu)."]
										}, {
											type: 'column',
											name: 'Christian',
											data: [".implode(",", $christian)."]
										}, {
											type: 'column',
											name: 'Islam',
											data: [".implode(",", $islam)."]
										},
										{
											type: 'column',
											name: 'Jain',
											data: [".implode(",", $jain)."]
										}
										"; 
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
												<td>".$result['stu_firstname']." ".$result['stu_lastname']."</td>
												<td>".$result['stu_gender']."</td>
												<td>".$result['course_name']."</td>
												<td>".$result['branch_name']."</td>
												<td>".$result['stu_section']."</td>
												<td>".$stu_year."</td>
												<td>".$result['stu_religion']."</td>
											</tr>
										";
									}// while() close here
							?>
							</tbody>
							<tfoot>
								<tr>
									<th>Rollno</th>
									<th>Name</th>
									<th>Gender</th>
									<th>Course</th>
									<th>Branch</th>
									<th>Section</th>
									<th>Year</th>
									<th>Religion</th>
								</tr>
							</tfoot>
						</table>
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
						
					</div>	<!-- ./box-body -->
				</div><!-- ./box -->
			<?php
				}
				else{
        
				}
			?>
			</section><!-- ./content -->
		</div>
		<div id="totopscroller"></div>
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper-->
	
	<!-- J Q U E R Y   P L U G I N S   I N C L U D E D   H E R E -->
	<!-- high charts Script -->
	<script src="<?php echo path ?>plugins/highcharts/highcharts.js"></script>
	<script src="<?php echo path ?>plugins/highcharts/exporting.js"></script>
	<script src="<?php echo path ?>/plugins/highcharts/export-csv.js"></script>
	
	<!-- Cloumn Visibility Button -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.colVis.min.js"></script>
	
	<!-- My custom script -->
	<script src="<?php echo path ?>Custom_script/reports.js"></script>
	
	<!-- Page Script -->
	<script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		$(document).ready(function(){
		// Smooth Scrolling to top
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
			$(".select2").select2();
			//$('#example').dataTable().columnFilter();
			$('#example1').dataTable({
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
								header: false
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
							{sSelector:"#rollno",type:"text"},
							{sSelector:"#name",type:"text"},
							{sSelector:"#gender",type:"select"},
							{sSelector:"#course",type:"select"},
							{sSelector:"#branch",type:"select"},
							{sSelector:"#section",type:"select"},
							{sSelector:"#year",type:"select"},
							{sSelector:"#religion",type:"select"}
							
				 ]
			});
		}); // document ready close here
		<!-- C H A R T    S C R I P T    S T A R T   H E R E -->
		<?php if(isset($_POST['religion_wise_button'])){ ?>		
			<!-- L I N E    C H A R T -->
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
						text: 'Religion-Wise Report Linechart',
						x: -20 //center
					},
					subtitle: {
						//text: 'Source: WorldClimate.com',
						x: -20
					},
					xAxis: {
						categories: [<?php echo $catagories ?>]
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
						text: 'Religion-Wise Report Area Chart'
					},
					subtitle: {
						//text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
							//'thebulletin.metapress.com</a>'
					},
					xAxis: {
						categories: [<?php echo $catagories ?>]
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
							text: 'Religion-Wise Report Stacked column chart'
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
					$('body,html').animate({scrollTop: $('body').height()}, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
					$('#charts').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false,
							type: 'pie'
						},
						title: {
							text: 'Religion-Wise Report piechart'
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
							text: 'Religion-Wise Report Combination chart'
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
	</script>
</body>
</html>
<?php
	} // if(isset()) close here
	else{
		header("location:/report_builder/login.php");
	}
?>