<?php
	include('../../db_con.php');
	if(isset($_SESSION['user_id'])){
		
		$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
		$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);

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
		$mba = 70;
		$me = 37;
		$mtech = 55;
		$mca = 90;
		$be = 103;
		$btech = 14;
		$sc = "[$mba,$me,$mtech,$mca,$be,$btech]";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Report-Builder|City-state-district wise</title>
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
					<small>city/state Wise Report</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Report</a></li>
					<li>city/state wise</li>
				</ol>
			</section><!-- ./section header -->
			<section class="content">
			<div class = "row">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">
							City/State Wise Report
						</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->
					</div><!-- ./box-header -->
					<form action = "" method = "post">
					<div class="box-body">
					<!-- State List -->
						<div class="form-group col-md-10">
							<label>Select a state</label>
							<select class="form-control select2" name = "selected_state[]" multiple="multiple" data-placeholder="select a state">
								<option>Andhra Pradesh</option>
								<option>Arunachal Pradesh</option>
								<option>Assam</option>
								<option>Bihar</option>
								<option>Chhattisgarh</option>
								<option>Goa</option>
								<option>Gujarat</option>
								<option>Haryana</option>
								<option>Himachal Pradesh</option>
								<option>Jammu and Kashmir</option>
								<option>Jharkhand</option>
								<option>Karnataka</option>
								<option>Kerala</option>
								<option>Madhya Pradesh</option>
								<option>Maharashtra</option>
								<option>Manipur</option>
								<option>Meghalaya</option>
								<option>Mizoram</option>
								<option>Nagaland</option>
								<option>Odisha (Orissa)</option>
								<option>Punjab</option>
								<option>Rajasthan</option>
								<option>Sikkim</option>
								<option>Tamil Nadu</option>
								<option>Telangana</option>
								<option>Tripura</option>
								<option>Uttar Pradesh</option>
								<option>Uttarakhand</option>
								<option>West Bengal</option>
								<option>Puducherry</option>
								<option>Dadra and Nagar Haveli</option>
								<option>Daman and Diu</option>
								<option>Lakshadweep</option>
								<option>Andaman and Nicobar Islands</option>
								<option>Chandigarh</option>
								<option>Others</option>
							</select>
						</div>
						<!-- District List -->
						<div class="form-group col-md-10">
							<label>Select a district</label>
							<select class="form-control select2" name = "selected_district[]" multiple="multiple" data-placeholder="select a district">
								<option>Chennai</option>
								<option>Kancheepuram</option>
								<option>Vellore</option>
								<option>Thiruvallur</option>
								<option>Salem</option>
								<option>Viluppuram</option>
								<option>Coimbatore</option>
								<option>Tirunelveli</option>
								<option>Madurai</option>
								<option>Tiruchirappalli</option>
								<option>Cuddalore</option>
								<option>Tiruppur</option>
								<option>Tiruvannamalai</option>
								<option>Thanjavur</option>
								<option>Erode</option>
								<option>Dindigul</option>
								<option>Virudhunagar</option>
								<option>Krishnagiri</option>
								<option>Kanniyakumari</option>
								<option>Thoothukkudi</option>
								<option>Namakkal</option>
								<option>Pudukkottai</option>
								<option>Nagapattinam</option>
								<option>Dharmapuri</option>
								<option>Ramanathapuram</option>
								<option>Sivaganga</option>
								<option>Thiruvarur</option>
								<option>Theni</option>
								<option>Karur</option>
								<option>Ariyalur</option>
								<option>Nilgiris</option>
								<option>Perambalur</option>
								<option>Others</option>
							</select>
						</div>
						<!-- -->
						<div class="from-group col-lg-10">
							<label>Select a City</label>
							<select class="form-control select2" name = "selected_city[]" multiple="multiple" data-placeholder="select a city">
								<?php
									$query = "SELECT DISTINCT greatest(stu_per_city,stu_pre_city) AS city FROM `stu_contact_details` GROUP BY stu_per_city,stu_pre_city";
									$run_query = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($run_query)){
										echo "<option value = ".$row['city'].">".$row['city']."</option>";
									}
								?>
							</select>
						</div>
						
						<div class="form-group col-lg-10">
							<label style="margin-top:1%">Select a Course</label>
								<select class="form-control select2" name = "selected_course[]" multiple="multiple" data-placeholder="select a course">
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
					</div><!-- box-body -->
					
					<div class="box-footer">
						<center><button type="submit" name="city_state_wise_button" class="btn btn-primary">Submit</button></center>
					</div><!-- ./box-footer -->	
				</form>	
				</div><!-- ./ box -->
				<!--<div class="row">-->
			<?php
				if(isset($_POST['city_state_wise_button'])){
			?>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Generated Report</h3>
						</div><!-- ./box-header -->
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped" style="font-size: 13px;">
								<thead>
									<tr>
										<th id="rollno">Rollno</th>
										<th id="name">Name</th>
										<th id="course">Course</th>
										<th id="branch">Branch</th>
										<th id="section">Section</th>
										<th id="year">Year</th>
										<th id="pres_add">Pres-Add</th>
										<th id="prem_add">Prem-Add</th>
									</tr>
									<tr>
										<th>Rollno</th>
										<th>Name</th>
										<th>Course</th>
										<th>Branch</th>
										<th>Section</th>
										<th>Year</th>
										<th>Pres-Add</th>
										<th>Perm-Add</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if(in_array('all',$dept_permission_reports)){ 
										if(empty($_POST['selected_course'])){
											$selected_course = implode(',',$course);
										}
										else{
											$selected_course = implode(',',$_POST['selected_course']);
										}
											$hide_branch = implode(',',$branch);
									}
									else{
										if(empty($_POST['selected_course'])){
											$selected_course = implode(',',$course);
										}
										else{
											$selected_course = implode(',',$_POST['selected_course']);
										}
										$hide_branch = $_SESSION['temp_branch'];
									}
									if(!empty($_POST['selected_course'])){
										$query = "SELECT p.stu_rollno, p.stu_firstname, p.stu_lastname, p.stu_gender, co.course_name, b.branch_name, curr.stu_section, curr.stu_batch, c.stu_pre_houseno, c.stu_pre_street, c.stu_pre_area, c.stu_pre_city, c.stu_pre_district, c.stu_pre_state, c.stu_pre_country, c.stu_pre_pincode,c.stu_per_houseno, c.stu_per_street, c.stu_per_area, c.stu_per_city, c.stu_per_district, c.stu_per_state, c.stu_per_country, c.stu_per_pincode FROM admission_details a, stu_personal_details p,stu_contact_details c, degree d, courses co, branch b, current_course curr WHERE (a.admission_no = p.admission_no) AND p.stu_rollno = curr.stu_rollno AND curr.stu_rollno = c.stu_rollno AND c.stu_rollno =  p.stu_rollno AND curr.stu_branch IN(".$hide_branch.") AND curr.stu_course IN (".$selected_course.")";
									}
									else{
										$query = "SELECT p.stu_rollno, p.stu_firstname, p.stu_lastname, p.stu_gender, co.course_name, b.branch_name, curr.stu_section, curr.stu_batch, c.stu_pre_houseno, c.stu_pre_street, c.stu_pre_area, c.stu_pre_city, c.stu_pre_district, c.stu_pre_state, c.stu_pre_country, c.stu_pre_pincode,c.stu_per_houseno, c.stu_per_street, c.stu_per_area, c.stu_per_city, c.stu_per_district, c.stu_per_state, c.stu_per_country, c.stu_per_pincode FROM admission_details a, stu_personal_details p,stu_contact_details c, degree d, courses co, branch b, current_course curr WHERE (a.admission_no = p.admission_no) AND p.stu_rollno = curr.stu_rollno AND curr.stu_rollno = c.stu_rollno AND c.stu_rollno = p.stu_rollno AND curr.stu_branch IN(".$hide_branch.") AND curr.stu_course IN (".$selected_course.")";
									}
									if(!empty($_POST['selected_state'])){
										$selected_state = "'" . implode("','", $_POST['selected_state']) . "'";  
										$query .= "AND (c.stu_pre_state IN(".$selected_state.") OR c.stu_per_state IN(".$selected_state."))";
									}
									if(!empty($_POST['selected_district'])){
										$selected_district = "'" . implode("','", $_POST['selected_district']) . "'";
										$query .= "AND (c.stu_pre_district IN(".$selected_district.") OR c.stu_pre_district IN(".$selected_district."))" ;
									}
									if(!empty($_POST['selected_city'])){
										$selected_city = "'" . implode("','", $_POST['selected_city']) . "'";
										$query .= "AND (c.stu_pre_city IN(".$selected_city.") OR c.stu_per_city IN(".$selected_city."))";
									}
									  $query .= "AND d.degree_id = curr.stu_degree AND co.course_id = curr.stu_course AND b.branch_id = curr.stu_branch";
									//print_r($_SESSION['temp_branch']);echo $hide_branch;
									$run_query = mysqli_query($con, $query);
									
									while($result = mysqli_fetch_array($run_query)){
										if((date('Y')-$result['stu_batch'] == 1) || (date('Y')-$result['stu_batch']) == 0){
											$stu_year = 1;		
										}
										else{
											$stu_year = date('Y')-$result['stu_batch'];
										}
										echo "
											<tr>
												<td>".$result['stu_rollno']."</td>
												<td>".$result['stu_firstname']." ".$result['stu_lastname']."</td>
												<td>".$result['course_name']."</td>
												<td>".$result['branch_name']."</td>
												<td>".$result['stu_section']."</td>
												<td>$stu_year</td>
												<td>".$result['stu_pre_houseno'].", ".$result['stu_pre_street'].", ".$result['stu_pre_area'].", ".$result['stu_pre_district'].", ".$result['stu_pre_state'].", ".$result['stu_pre_country'].", pincode: ".$result['stu_pre_pincode']."</td>
												<td>".$result['stu_per_houseno'].", ".$result['stu_per_street'].", ".$result['stu_per_area'].", ".$result['stu_per_district'].", ".$result['stu_per_state'].", ".$result['stu_per_country'].", pincode: ".$result['stu_per_pincode']."</td>
											</tr>
										";
									}
								?>
								</tbody>
								<tfoot>
									<tr>
										<th>Rollno</th>
										<th>Name</th>
										<th>Course</th>
										<th>Branch</th>
										<th>Section</th>
										<th>Year</th>
										<th>Pres-Add</th>
										<th>Perm-Add</th>
									</tr>
								</tfoot>
							</table>
							<!--<div class="col-md-12" id="chart_options">
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
							<!--</div><!-- ./chart_options -->
							
						<!-- Chart Will be Displying Here -->	
						<!--<div class="col-md-12" id="charts"></div> 
						</div><!-- ./box-body -->	
					<!--</div><!-- ./box -->
			<?php
				}
				else{
					
				}
			?>
			</div><!-- ./row -->	
			</section><!-- ./ section-content -->
		</div><!-- ./content wrapper -->
		<div id="totopscroller"></div>
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	
	<!-- J Q U E R Y  P L U G I N S   I N C L U D E D   H E R E   -->
	
	<!-- high charts Script -->
	<script src="<?php echo path ?>plugins/highcharts/highcharts.js"></script>
	<!--<script src="../../plugins/highcharts/exporting.js"></script>-->
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
							{sSelector:"#course",type:"select"},
							{sSelector:"#branch",type:"select"},
							{sSelector:"#section",type:"select"},
							{sSelector:"#year",type:"select"},
							{sSelector:"#pres_add",},
							{sSelector:"#prem_add",}	
				 ]
			}); // column filter
		}); //document ready close here
	<!-- C H A R T    S C R I P T    S T A R T   H E R E -->
				
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
					text: 'Community Report chart',
					x: -20 //center
				},
				subtitle: {
					//text: 'Source: WorldClimate.com',
					x: -20
				},
				xAxis: {
					categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
				series: [{
					name: 'Chennai',
					data: <?php echo $sc; ?>,
				}, {
					name: 'Kancheepuram',
					data: [4, 19, 55, 22, 11, 97]
				}, {
					name: 'Thiruvallur',
					data: [12, 20, 96, 54, 18, 32]
				}, {
					name: 'Thanjavur',
					data: [120, 160, 45, 76, 67, 89]
				},
				{
					name: 'Thiruvarur',
					data: [3, 6, 5, 0, 10, 0]
				},
				{
					name: 'Tiruvannamalai',
					data: [3, 4, 5, 2, 2, 1]
				},
				{
					name: 'Trichy',
					data: [3, 8, 5, 2, 4, 1]
				},
				{
					name: 'Kanniyakumari',
					data: [3, 8, 5, 2, 5, 1]
				},
				{
					name: 'Tiruppur',
					data: [31, 8, 8, 2, 0, 1]
				},
				{
					name: 'Tirunelveli',
					data: [3, 6, 5, 2, 67, 54]
				},
				{
					name: 'Nagapattinam',
					data: [8, 4, 3, 2, 0, 1]
				},
				{
					name: 'Madurai',
					data: [4, 8, 9, 2, 6, 1]
				},]
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
					//text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
						//'thebulletin.metapress.com</a>'
				},
				xAxis: {
					categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
				series: [{
					name: 'SC',
					data: <?php echo $sc; ?>,
				}, {
					name: 'ST',
					data: [4, 19, 55, 22, 11, 97]
				}, {
					name: 'BC',
					data: [12, 20, 96, 54, 18, 32]
				}, {
					name: 'MBC',
					data: [120, 160, 45, 76, 67, 89]
				},
				{
					name: 'Denotified Community',
					data: [3, 2, 0, 0, 1, 0]
				},
				{
					name: 'Converted Christian from SC',
					data: [3, 8, 5, 2, 0, 1]
				}]
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
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
					series: [{
						name: 'SC',
						data: <?php echo $sc; ?>,
					}, {
						name: 'ST',
						data: [4, 19, 55, 22, 11, 97]
					}, {
						name: 'BC',
						data: [12, 20, 96, 54, 18, 32]
					}, {
						name: 'MBC',
						data: [120, 160, 45, 76, 67, 89]
					},
					{
						name: 'Denotified Community',
						data: [3, 2, 0, 0, 1, 0]
					},
					{
						name: 'Converted Christian from SC',
						data: [3, 8, 5, 2, 0, 1]
					}]
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
						text: 'Community wise Student Report chart'
					},
					xAxis: {
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
						data: [{
							name: 'SC',
							y: 56
							
						}, {
							name: 'ST',
							y: 24,
							//sliced: true,
							//selected: true
						}, {
							name: 'BC',
							y: 10
						}, {
							name: 'MBC',
							y: 4
						}, {
							name: 'Denotified Community',
							y: 4
						}, {
							name: 'Converted Christian from SC',
							y: 8
						}]
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
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
					series: [{
						type: 'column',
						name: 'SC',
						data: <?php echo $sc; ?>,
					}, {
						type: 'column',
						name: 'ST',
						data: [4, 19, 55, 22, 11, 97]
					}, {
						type: 'column',
						name: 'BC',
						data: [12, 20, 96, 54, 18, 32]
					},
					{
						type: 'column',
						name: 'MBC',
						data: [120, 160, 45, 76, 67, 89]
					},
					{
						type: 'column',
						name: 'Denotified Community',
						data: [3, 2, 0, 0, 1, 0]
					},
					 {
						type: 'spline',
						name: 'Converted Christian from SC',
						data: [3, 8, 5, 2, 0, 1],
						marker: {
							lineWidth: 2,
							lineColor: Highcharts.getOptions().colors[3],
							fillColor: 'white'
						}
					}, {
						type: 'pie',
						name: 'Total consumption',
						data: [{
							name: 'SC',
							y: 13,
							//color: Highcharts.getOptions().colors[0] // Jane's color
						}, {
							name: 'ST',
							y: 23,
							//color: Highcharts.getOptions().colors[1] // John's color
						}, {
							name: 'BC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'MBC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'Denotified Community',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'Converted Christian from SC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						}],
						
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