<?php
	include("../../db_con.php");
	//error_reporting(0);
	if(isset($_SESSION['user_id'])){
		$access_permission_manage_student = explode(',', $_SESSION['access_permission'][0]);
		$dept_permission_manage_student = explode(',', $_SESSION['dept_permission'][0]);
		$query = "SELECT staff_id,branch FROM staff_teaching WHERE staff_id = '".$_SESSION['staff_id']."'";
		$run_query = mysqli_query($con, $query);
		$row = mysqli_fetch_array($run_query);
		if(mysqli_affected_rows($con) == 0)
		{
			$working_type = "Non-Teaching";
		}
		else{
			$branch = $row['branch'];
			$working_type = "Teaching";
		}	
	//header('Cache-Control: max-age=1200');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Managestudents</title>
	<!-- Custom css For Form Styling -->
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>dist/css/style.css" />
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/select2/select2.min.css">
	
	<!-- Internal CSS  Defined Here--->
	<style>
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
		table.dataTable th,
		table.dataTable td {
        white-space: nowrap;
   	 }
	 
	 /*This is For Fiedlset and legend style*/
	 
	 fieldset.scheduler-border {
   	 border: 2px groove rgba(0,0,0,0.1) !important;
     padding: 0 1.4em 1.4em 1.4em !important;
     margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;		
	}

	legend.scheduler-border {
    font-size: 15px !important;
    font-weight: bold !important;
    text-align: left !important;
	border:none;
	width:inherit;
	padding:0px 5px;
	//border-bottom:none;
	margin-bottom:0px;
	}
	 label{margin-top: 8px;}
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
				<h1>Manage Students
					<small>View Student Record</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Students</a></li>
					<li>View Student Record</li>
				</ol>	
				<?php
					//echo $_SERVER['REQUEST_URI'];
					//echo $_SERVER['QUERY_STRING'];
				?>
			</section><!-- ./section content-header -->
			<section class="content">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">View Student</h3><span id="delete_info" style="margin-left:2%;padding:1%;"></span>
						<form action="" role="" method="post" id="">
							<?php 
								if(count($dept_permission_manage_student)!=1){
									?>
									<div class="input-group input-group-sm col-md-5" style="float:right;margin-top:-2%;">
										<select class="form-control select2 input-sm" name="view_stu_search" data-placeholder="Select a admission_quota">
												<option value="default">--Select--</option>
												<?php
													if($working_type = 'Teaching' && in_array('own', $dept_permission_manage_student)){
														if (($key = array_search('own', $dept_permission_manage_student)) !== false) {
															unset($dept_permission_manage_student[$key]);
															array_push($dept_permission_manage_student, $branch);
														}	
													}
													else{
														if (($key = array_search('own', $dept_permission_manage_student)) !== false) {
															unset($dept_permission_manage_student[$key]);
															//array_push($cart, $branch);
														}
													} //working_type
													$dept_permission_manage_student = implode(',',$dept_permission_manage_student);
													$query = "SELECT branch_id, branch_name FROM branch WHERE branch_id IN(".$dept_permission_manage_student.")";
													$run_query = mysqli_query($con, $query);
													while($result = mysqli_fetch_array($run_query)){
														echo "<option value='".$result['branch_name']."'>".$result['branch_name']."</option>";
													}
												?>
										</select>
										<span class="input-group-btn">
											<button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat view_search_btn">Search</button>
										</span>
									</div><!-- ./input-group -->
							<?php
								}
								else if(in_array('all', $_SESSION['dept_permission'])){
									//echo "All";
									?>
									<div class="input-group input-group-sm col-md-5" style="float:right;margin-top:-2%;">
										<input type="text" name="view_stu_search" class="form-control" placeholder="Search..." autocomplete="off">
										<span class="input-group-btn">
											<button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat view_search_btn">Search</button>
										</span>
									</div><!-- ./input-group -->
							<?php
								}
								else if(count($dept_permission_manage_student) == 1 && in_array('own', $_SESSION['dept_permission'])){
									
								}
							?>
							
						</form><!-- ./form-->
					</div><!-- ./box-heading -->
					<div class="box-body">
					
						<table id="example1" class="table table-bordered table-striped display" style="font-size:12px;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Branch</th>
									<th>Batch</th>
									<th>Admission No</th>
									<th>Rollnno</th>
									<th>Student Name</th>
									<th>Email</th>
									<th>Functions</th>
							
								</tr>
							</thead>
							<tbody class="table_body_data">
								<?php
									if(count($dept_permission_manage_student) == 1 && in_array('own', $_SESSION['dept_permission']) && $working_type == 'Teaching'){
										 $query = "SELECT a.admission_no, p.stu_rollno, c.stu_course, c.stu_batch, p.stu_firstname, p.stu_lastname, co.stu_email, b.branch_name, d.degree_name, cu.course_name FROM current_course c, admission_details a,stu_personal_details p, stu_contact_details co, degree d, courses cu, branch b WHERE a.admission_no = p.admission_no AND p.status = 'Pursing' AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = co.stu_rollno AND co.stu_rollno = p.stu_rollno AND (c.stu_degree = d.degree_id AND c.stu_course = cu.course_id AND c.stu_branch = b.branch_id) AND c.stu_branch = ".$branch."";
										
										$run_query = mysqli_query($con, $query);
										
										while($result = mysqli_fetch_array($run_query))
										{
											$concade = "";
											if(in_array('edit', $access_permission_manage_student)){
											    $concade .= "<a href='edit.php?rollno=".$result['stu_rollno']."&degree=".$result['degree_name']."&course=".$result['course_name']."&branch=".$result['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a>";
											}
											if(in_array('delete', $access_permission_manage_student)){
												$concade .= "<button type='button' id=".$result['stu_rollno']." class='btn btn-danger btn-sm btn-flat delete_record' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm'><i class='fa fa-close'></i> Delete</button>";
											}
											if(in_array('view', $access_permission_manage_student) && !in_array('edit', $access_permission_manage_student)){
												$concade = "<a href='view_only.php?rollno=".$result['stu_rollno']."&degree=".$result['degree_name']."&course=".$result['course_name']."&branch=".$result['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> View</a>";
											}
											echo "<tr id='r_".$result['stu_rollno']."'>
													<td>".$result['branch_name']."</td>
													<td>".$result['stu_batch']."</td>
													<td>".$result['admission_no']."</td>
													<td>".$result['stu_rollno']."</td>
													<td>".$result['stu_firstname'].$result['stu_lastname']."</td>
													<td>".$result['stu_email']."</td>
													<td align='center'>".$concade."</td>
												</tr>";
										}// while() close here
										
									}
									else if(isset($_POST['search'])){
										//print_r($access_permission_manage_student);
										if(ctype_digit($_POST['view_stu_search'])){
											$query = "SELECT d.degree_name, c.course_name, b.branch_name, curr.stu_batch, a.admission_no, p.stu_rollno, p.stu_firstname, p.stu_lastname, co.stu_email FROM degree d, courses c, branch b,admission_details a, stu_personal_details p, stu_contact_details co, current_course curr WHERE a.admission_no = p.admission_no AND p.status = 'Pursing' AND p.stu_rollno = co.stu_rollno and co.stu_rollno = curr.stu_rollno AND (p.stu_rollno = ".$_POST['view_stu_search']." OR co.stu_mobile = ".$_POST['view_stu_search']." OR co.stu_alternative_mobile = ".$_POST['view_stu_search']." OR co.stu_parent_mobile = ".$_POST['view_stu_search']." OR curr.stu_univ_regno = ".$_POST['view_stu_search'].") AND (d.degree_id = curr.stu_degree AND c.course_id = curr.stu_course AND b.branch_id = curr.stu_branch)";
											$run_query = mysqli_query($con, $query);
											while($result = mysqli_fetch_array($run_query))
											{
												$concade = "";
												if(in_array('edit', $access_permission_manage_student)){
													$concade .= "<a href='edit.php?rollno=".$result['stu_rollno']."&degree=".$result['degree_name']."&course=".$result['course_name']."&branch=".$result['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a>";
												}
												if(in_array('delete', $access_permission_manage_student)){
													$concade .= "<button type='button' id=".$result['stu_rollno']." class='btn btn-danger btn-sm btn-flat delete_record' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm'><i class='fa fa-close'></i> Delete</button>";
												}
												if(in_array('view', $access_permission_manage_student) && !in_array('edit', $access_permission_manage_student)){
													$concade .= "<a href='view_only.php?rollno=".$result['stu_rollno']."&degree=".$result['degree_name']."&course=".$result['course_name']."&branch=".$result['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> View</a>";
												}
												echo "<tr id='r_".$result['stu_rollno']."'>
														<td>".$result['branch_name']."</td>
														<td>".$result['stu_batch']."</td>
														<td>".$result['admission_no']."</td>
														<td>".$result['stu_rollno']."</td>
														<td>".$result['stu_firstname']." ".$result['stu_lastname']."</td>
														<td>".$result['stu_email']."</td>
														<td align='center'>".$concade."</td>
													</tr>";
											}// while() close here
											
										} //if( ctype_digit() ) close here
										else {
											  $query = "SELECT d.degree_id,d.degree_name,c.course_id,c.course_name,b.branch_id,b.branch_name FROM degree d,courses c,branch b WHERE d.degree_id = c.degree_id AND b.course_id = c.course_id AND (d.degree_name like '%".$_POST['view_stu_search']."%' OR c.course_name like '%".$_POST['view_stu_search']."%' OR b.branch_name like '%".$_POST['view_stu_search']."%')";
											
											$run_query = mysqli_query($con, $query);
										
											$rows = array();
											while($row = mysqli_fetch_array($run_query))
											{
												$rows[] = $row;
											}
											
											foreach($rows as $row)
											{
												 $query = "SELECT a.admission_no, p.stu_rollno, c.stu_course, c.stu_batch, p.stu_firstname, p.stu_lastname, co.stu_email FROM current_course c, admission_details a,stu_personal_details p, stu_contact_details co WHERE a.admission_no = p.admission_no AND p.status = 'Pursing' AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = co.stu_rollno AND co.stu_rollno = p.stu_rollno AND (c.stu_degree = ".$row['degree_id']." AND c.stu_course = ".$row['course_id']." AND c.stu_branch = ".$row['branch_id'].");";
												//echo "<br><br>";
												$run_query = mysqli_query($con, $query);
												while($result = mysqli_fetch_array($run_query))
												{
													$concade = "";
													if(in_array('edit', $access_permission_manage_student)){
														$concade .= "<a href='edit.php?rollno=".$result['stu_rollno']."&degree=".$row['degree_name']."&course=".$row['course_name']."&branch=".$row['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a>";
													}
													if(in_array('delete', $access_permission_manage_student)){
														$concade .= "<button type='button' id=".$result['stu_rollno']." class='btn btn-danger btn-sm btn-flat delete_record' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm'><i class='fa fa-close'></i> Delete</button>";
													}
													if(in_array('view', $access_permission_manage_student) && !in_array('edit', $access_permission_manage_student)){
													$concade .= "<a href='view_only.php?rollno=".$result['stu_rollno']."&degree=".$row['degree_name']."&course=".$row['course_name']."&branch=".$row['branch_name']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> View</a>";
												}
													echo "<tr id='r_".$result['stu_rollno']."'>
															<td>".$row['branch_name']."</td>
															<td>".$result['stu_batch']."</td>
															<td>".$result['admission_no']."</td>
															<td>".$result['stu_rollno']."</td>
															<td>".$result['stu_firstname'].$result['stu_lastname']."</td>
															<td>".$result['stu_email']."</td>
															<td align='center'>".$concade."</td>
														</tr>";
												}// while() close here
											}// foreach() close here
										}
										
									}// isset() close here
								?>	
							</tbody>
							<tfoot>
								<tr>
									<th>Branch</th>
									<th>Batch</th>
									<th>Admission No</th>
									<th>Rollnno</th>
									<th>Student Name</th>
									<th>Email</th>
									<th>Functions</th>
									
								</tr>
							</tfoot>
						</table>
						<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
							 	<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       								<h4 class="modal-title" id="gridSystemModalLabel">Are you sure</h4>
								</div><!-- ./modal-footer -->
								<div class="modal-footer">
									<form action="delete.php" method="post">
									<input type="hidden" name="hidden_rollno" value="" />
									<button type="button" name="delete" id="delete_record_id" class="btn btn-primary">Yes</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									</form>
								</div><!-- ./modal-footer -->
							</div>< <!-- ./modal-content -->
						  </div><!-- ./modal-dialog -->
						</div>
					</div><!-- ./box-body -->
					<div class="box-footer"></div>	
				</div><!-- ./box -->
			</section>
		</div><!-- ./content-wrapper -->
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	
	<!-- J Q U E R Y   P L U G I N S   I N C L U D E D   H E R E  -->
	
	<!-- Select2 -->
    <script src="<?php echo path ?>plugins/select2/select2.full.min.js"></script>

	<!-- DataTables -->
    <script src="<?php echo path ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo path ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo path ?>plugins/datatables/jquery.dataTables.columnFilter.js"></script>
	
    <!-- InputMask -->
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- Currency format -->
	<script src="<?php echo path ?>plugins/currency_format/autoNumeric-min.js"></script>
	<!-- Form validation Plugin -->
	<script src="<?php echo path ?>plugins/formvalidation/jquery.validate.js"></script>
	<!-- Custom Script -->
	<script src="<?php echo path ?>Custom_script/custom_add.js"></script>
	
	<!-- Page script -->
	<script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		$(document).ready(function(){
			$('#example1').dataTable({
				//"bPaginate": true,
			});
			//$('.box-body').hide();
			/*Table = $("#example").DataTable({
				data:[],
				columns: [
				{ "data": "Course" },
				{ "data": "Batch" },
				{ "data": "Admission No" },
				{ "data": "Rollno" },
				{ "data": "Student Name" },
				{ "data": "Email" }
				],
				rowCallback: function (row, data) {},
				filter: false,
				info: false,
				ordering: false,
				processing: true,
				retrieve: true
				});*/
			$('.delete_record').click(function(){
				$('input[name=hidden_rollno]').val(this.id);
			});// Click event close here*/
		}); // document close here
		$('#delete_record_id').click(function(){
				var hidden_rollno = $('input[name=hidden_rollno]').val();
				//alert(hidden_rollno);
				$.post('live_search.php',{key: 'delete',hidden_rollno: hidden_rollno},function(data){
					//alert(data);	
					if(data == 'delete'){
						$('#delete_info').html('Deleted successfully<b><i>  '+hidden_rollno+'</i></b>');
						$('#delete_info').addClass("bg-success");
						var remove_row_string = '#r_'+hidden_rollno;
						//alert(remove_row_string);
						$(remove_row_string).hide();
						$('.modal').modal('hide');
					}
					else{
						
					}
				});
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