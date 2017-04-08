<?php
	include("../../db_con.php");
	if(isset($_SESSION['user_id'])){
		if(isset($_GET['staff_id']))
		{
			 global $row;
			$staff_id = $_REQUEST['staff_id'];
			$working_type_edit_staff = "";
			$access_permission = array();
			$query = "SELECT DISTINCT s.staff_id,s.staff_name, st.designation, l.username, l.password, b.branch_name,b.branch_id FROM staff_details s, staff_teaching st, staff_non_teaching snt, login_info l, access_permission acc, branch b WHERE s.staff_id = st.staff_id AND st.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username AND st.branch = b.branch_id AND s.staff_id = ".$staff_id."";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con) == 0)
			{
				$query1 = "SELECT DISTINCT s.staff_id,s.staff_name, snt.designation, snt.department, l.username, l.password FROM staff_details s, staff_teaching st, staff_non_teaching snt, login_info l, access_permission acc WHERE s.staff_id = snt.staff_id AND snt.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username AND s.staff_id = ".$staff_id."";
				$run_query1 = mysqli_query($con, $query1);
				if(mysqli_affected_rows($con) != 0){
					//$status = "Inside if so it is Non-Teaching";
					$working_type_edit_staff = "Non-Teaching";
					$non_teaching = mysqli_fetch_array($run_query1);
				}
				else{
					echo "No record found both teaching and non-teaching";
				}
			}
			else{
				$working_type_edit_staff = "Teaching";
				$teaching = mysqli_fetch_array($run_query);	
			}
			
			$query = "SELECT acc.access_permission, acc.module, acc.dept_permission FROM access_permission acc, login_info l WHERE l.username = acc.username AND l.staff_id = ".$staff_id." AND acc.module = 'manage_student';";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con)){
				$manage_student = mysqli_fetch_array($run_query);
				$access_permission_student_edit_staff = $manage_student['access_permission'];
				$access_permission_student_edit_staff = explode(',', $access_permission_student_edit_staff);
				$dept_permission_students_edit_staff =  $manage_student['dept_permission'];
				$dept_permission_students_edit_staff = explode(',', $dept_permission_students_edit_staff);
			}
			else{
				echo "No record found!";
			}
			
			$query = "SELECT acc.access_permission, acc.module, acc.dept_permission FROM access_permission acc, login_info l WHERE l.username = acc.username AND l.staff_id = ".$staff_id." AND acc.module = 'reports';";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con)){
				$reports = mysqli_fetch_array($run_query);
				$access_permission_reports_edit_staff = $reports['access_permission'];
				$access_permission_reports_edit_staff = explode(',', $access_permission_reports_edit_staff);
				$dept_permission_reports_edit_staff =  $reports['dept_permission'];
				$dept_permission_reports_edit_staff = explode(',', $dept_permission_reports_edit_staff);
			}
			else{
				echo "No record found!";
			}
			
		}
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Managestaff</title>
	
	<!-- Custom css For Form Styling -->
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>dist/css/style.css" />
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/select2/select2.min.css">
	
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
			width: 17px;
			height: 16px;
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
	
		/*.required{color: #F00;}
		.error{color: #FF0000;}
		.help-inline-error{color:red;}*/
	  ul#stepForm, ul#stepForm li {
		margin: 0;
		padding: 0;
	  }
	  ul#stepForm li {
		list-style: none outside none;
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
		label{margin-top: 8px;}
		table.prev_academic tbody tr td{width: 20%;}
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
			//Include the header.php
			include("../../header.php");
			//Include the sidebar.php
			include("../../sidebar.php");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Manage staffs
					<small>create staff login access</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Staff Details</a></li>
					<li>create staff login access</li>
				</ol>			
			</section><!--./section header -->
			<section class="content">
			<div class="row">
				<div class="panel panel-info">
					<div class="panel-heading">Create Staff Login Process</div>
					<div class="panel-body" style="font-size:12px;">
						<form class="" id="staff_login_create" name="staff_login_create" method="post" action="">
						<!-- Student Personal Details -->
							<div class="frm" id="sf1">
								<fieldset>
									<legend><span>Staff login info</span></legend>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="col-lg-2 control-label" for="staff_type">Working-Type <span class="text-danger"></span></label>
												<div class="col-lg-6">
													<label class="Form-label--tick">
														<input type="radio" name="staff_type" class="Form-label-radio" value="Teaching" <?php if($working_type_edit_staff== 'Teaching'){echo "checked";} ?> />
														<span class="Form-label-text"> Teaching</span>
													</label>
													<label class="Form-label--tick">
														<input type="radio" name="staff_type" class="Form-label-radio" value="Non-Teaching" <?php if($working_type_edit_staff == 'Non-Teaching'){echo "checked";} ?> />
														<span class="Form-label-text"> Non-Teaching</span>
													</label>
													<label for="gender" generated="true" class="error" style="font-weight:bold;color:#FF0000;margin-left:7%;"></label>
												</div><!-- ./lg-6-->
											</div><!-- ./ form-group for working-type -->
											
											<div class="clearfix" style="height: 5px;clear: both;"></div> 
											
											<div class="form-group">
												<label class="col-lg-2 control-label" for="department">Department <span class="text-danger"></span></label>
												<div class="col-lg-6">
													<select class="form-control select2 input-sm" name="staff_department" data-placeholder="Select a Department">
													<?php
														if($working_type_edit_staff == 'Teaching'){
															$query = "SELECT * FROM `branch`";
															$run_query = mysqli_query($con, $query);
															while($row = mysqli_fetch_array($run_query)){
																?>
																<option value='<?php echo $row['branch_id'] ?>' <?php if($teaching['branch_name']== $row['branch_name']){echo "selected";} ?> ><?php echo $row['branch_name'] ?></option>";
																<?php
															} // close here
														} // if(key == 'value') close here
														else if($working_type_edit_staff == 'Non-Teaching'){
															$query = "SELECT DISTINCT department AS dept FROM `staff_non_teaching` GROUP BY department";
															$run_query = mysqli_query($con, $query);
															while($row = mysqli_fetch_array($run_query)){
																?>
																<option <?php if($non_teaching['department']== $row['dept']){echo "selected";} ?>><?php echo $row['dept']; ?></option>;
																<?php
															} // while close here
														} // else if(key == 'value') close here
													?>	
													</select>
												</div>	<!-- ./col-lg-6 -->
											</div> <!-- ./form group for departments -->
											
											<div class="clearfix" style="height: 5px;clear: both;"></div> 
											
											<div class="form-group">
												<label class="col-lg-2 control-label" for="staff">Staff <span class="text-danger"></span></label>
												<div class="col-lg-6">
													<select class="form-control select2 input-sm" name="staff" data-placeholder="Select a staff">
													<?php
														if($working_type_edit_staff == 'Teaching'){
															$query = "SELECT s.staff_id, s.staff_name, st.designation, b.branch_name FROM staff_details s, staff_teaching st, branch b WHERE s.staff_id = st.staff_id AND b.branch_id = st.branch AND st.branch = ".$teaching['branch_id']."";
														} // if() checking for teaching close here
														else{
															 $query = "SELECT s.staff_id, s.staff_name, snt.designation FROM staff_details s, staff_non_teaching snt WHERE s.staff_id = snt.staff_id AND snt.department = '".$non_teaching['department']."'";
														}
														$run_query = mysqli_query($con, $query);
														while($row = mysqli_fetch_array($run_query)){
															$staff_string = $row['staff_name'].'('.$row['staff_id'].', '.$row['designation'].')';
															if($working_type_edit_staff == 'Teaching'){
																$staff_name = $teaching['staff_name'];
																$staff_id = $teaching['staff_id'];
																$staff_designation = $teaching['designation'];
															}
															else{
																$staff_name = $non_teaching['staff_name'];
																$staff_id = $non_teaching['staff_id'];
																$staff_designation = $non_teaching['designation'];
															}
															$match_staff = $staff_name.'('.$staff_id.', '.$staff_designation.')';
															?>
															<option value = <?php echo $row['staff_id']; ?> <?php if($staff_string == $match_staff){echo "selected";} ?>><?php echo $staff_string ?></option>
															<?php
														}// while close here
													?>	
													</select>
												</div>	<!-- ./col-lg-6 -->
											</div> <!-- ./form group for staffs -->
											
											<div class="clearfix" style="height: 5px;clear: both;"></div> 
											
											<div class="form-group">
												<label class="col-lg-2 control-label" for="username">Username <span class="text-danger"></span></label>
												<div class="col-lg-6">
													<input type = "text" class = "form-control input-sm" name="username" value="<?php if($working_type_edit_staff == 'Teaching'){echo $teaching['username'];}else{echo "non".$non_teaching['username'];} ?>" />
												</div>	<!-- ./col-lg-6 -->
											</div> <!-- ./form group for staff_username -->
											
											<div class="clearfix" style="height: 5px;clear: both;"></div> 
											
											<div class="form-group">
												<label class="col-lg-2 control-label" for="password">Password <span class="text-danger"></span></label>
												<div class="col-lg-6">
													<input type = "text" class = "form-control input-sm" name="password" value="" readonly />
												</div>	<!-- ./col-lg-6 -->
											</div> <!-- ./form group for staff_password -->
											
										</div> <!-- ./col-lg-6 for login info -->
									</div> <!-- ./row -->
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<table class="table table-bordered" id="example" style="font-size:12px">
													<thead>
														<tr>
															<td><b>Access Rights</b></td>
															<td>Add</td>
															<td>Edit</td>
															<td>Delete</td>
															<td>View</td>
															<td>Dept-Permission</td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><b>Manage-students</b><input type="hidden" value="manage_students"</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student[]" class="Form-label-checkbox" value="add" <?php if(in_array('add', $access_permission_student_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student[]" class="Form-label-checkbox" value="edit" <?php if(in_array('edit', $access_permission_student_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student[]" class="Form-label-checkbox" value="delete" <?php if(in_array('delete', $access_permission_student_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>	
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student[]" class="Form-label-checkbox" value="view" <?php if(in_array('view', $access_permission_student_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student_dept_perm[]" class="Form-label-checkbox" value="all" <?php if(in_array('all', $dept_permission_students_edit_staff)){echo "checked";} ?>/>
																<span class="Form-label-text">All</span>
																</label>
																<label class="Form-label--tick">
																<input type="checkbox" name="manage_student_dept_perm[]" class="Form-label-checkbox" value="own" <?php if(in_array('own', $dept_permission_students_edit_staff)){echo "checked";} ?> />
																<span class="Form-label-text">Own</span>
																</label> <br />
																<select class="form-control select2 input-sm teaching" multiple = 'multiple' id=""  name="manage_student_dept_perm[]" data-placeholder="Select a dept">
																	<?php
																		$query = "SELECT * FROM `branch`";
																		$run_query = mysqli_query($con, $query);
																		while($row = mysqli_fetch_array($run_query)){ ?>
																			<option value = <?php echo $row['branch_id']; ?> <?php if(in_array($row['branch_id'], $dept_permission_students_edit_staff)){echo 'selected';} ?>><?php echo $row['branch_name']; ?></option>
																			<?php
																		}
																	?>
																</select>
																<!--<select class="form-control select2 input-sm non_teaching" multiple = 'multiple' id="non_teaching"  name="manage_student_dept_perm[]" data-placeholder="Select a dept">
																	<?php
																		/*$query = "SELECT DISTINCT department AS dept FROM `staff_non_teaching` GROUP BY department";
																		$run_query = mysqli_query($con, $query);
																		while($row = mysqli_fetch_array($run_query)){
																			echo "<option>".$row['dept']."</option>";
																		}*/
																	?>
																</select>-->
															</td>
														</tr> <!-- table row for manage student -->
														
													</tbody>
												</table>
											</div>
										</div> <!-- ./col-lg-6 for Access rights -->
										<div class="col-lg-6">
											<div class="form-group">
												<table class="table table-bordered" id="example" style="font-size:12px">
													<thead>
														<tr>
															<td><b>Access Rights</b></td>
															<td>Show with Customize</td>
															<td>Show without Customize</td>
															<td>Hide</td>
															<td>Dept-Permission</td>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><b>Reports</b></td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="reports[]" class="Form-label-checkbox" value="show_with_cus" <?php if(in_array('show_with_cus', $access_permission_reports_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="reports[]" class="Form-label-checkbox" value="show_without_cus" <?php if(in_array('show_without_cus', $access_permission_reports_edit_staff)){echo 'checked';} ?>/>
																<span class="Form-label-text"></span>
																</label> 
															</td>
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="reports[]" class="Form-label-checkbox" value="hide" <?php if(in_array('hide', $access_permission_reports_edit_staff)){echo 'checked';} ?> />
																<span class="Form-label-text"></span>
																</label> 
															</td>	
															
															<td>
																<label class="Form-label--tick">
																<input type="checkbox" name="reports_dept_perm[]" class="Form-label-checkbox" value="all" <?php if(in_array('all', $dept_permission_reports_edit_staff)){echo "checked";} ?>/>
																<span class="Form-label-text">All</span>
																</label>
																<label class="Form-label--tick">
																<input type="checkbox" name="reports_dept_perm[]" class="Form-label-checkbox" value="own" <?php if(in_array('own', $dept_permission_reports_edit_staff)){echo "checked";} ?> />
																<span class="Form-label-text">Own</span>
																</label> <br />
																<select class="form-control select2 input-sm teaching" multiple = 'multiple' id=""  name="reports_dept_perm[]" data-placeholder="Select a dept">
																	<?php
																		$query = "SELECT * FROM `branch`";
																		$run_query = mysqli_query($con, $query);
																		while($row = mysqli_fetch_array($run_query)){
																			?>
																			<option value = <?php echo $row['branch_id']; ?> <?php if(in_array($row['branch_id'], $dept_permission_reports_edit_staff)){echo 'selected';} ?>><?php echo $row['branch_name']; ?></option>
																			<?php
																		}
																	?>
																</select>
																<!--<select class="form-control select2 input-sm non_teaching" multiple = 'multiple' id="non_teaching"  name="manage_student_dept_perm[]" data-placeholder="Select a dept">
																	<?php
																		$query = "SELECT DISTINCT department AS dept FROM `staff_non_teaching` GROUP BY department";
																		$run_query = mysqli_query($con, $query);
																		while($row = mysqli_fetch_array($run_query)){
																			echo "<option>".$row['dept']."</option>";
																		}
																	?>
																</select>-->
															</td>
														</tr> <!-- table row for manage student -->
														
													</tbody>
												</table>
											</div>
										</div> <!-- ./col-lg-6 for Access rights -->
									</div><!--./row -->
									<div class="row">
									
									</div><!-- ./row -->
								</fieldset><!-- ./fieldset -->
							</div><!-- ./sf1 -->
						</form><!-- ./form -->
					</div><!-- ./panel-body -->
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6"><button type="button" class="btn btn-info btn-flat" name="update_login" id="update_login" style="float:right;"><i class = "fa fa-hand-o-right"> Update</i></button></div>
							<div class="col-md-6"><button type="button" name="send_email" class="btn btn-warning btn-flat" id="send_email" style="float:left;"><i class = "fa fa-envelope-o"> Send Email</i></button></div>
						</div>
						<?php
							/*print_r($access_permission_student_edit_staff);
							echo "<br />";
							print_r($dept_permission_students_edit_staff);
							echo "<br />";
							print_r($access_permission_reports_edit_staff);
							echo "<br />";
							print_r($dept_permission_reports_edit_staff);*/
						?>
					</div><!-- ./panel footer -->
				</div><!-- ./panel -->
			 </div><!-- ./ row-->	
			</section><!-- ./section content -->
		</div><!-- ./content wrapper -->
		<div id="totopscroller"></div>
		<?php
			//Include the footer page
			include("../../footer.php");
			//Include the sidepane page
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
	
	<script src="<?php echo path ?>bootstrap/js/moment.min.js"></script>
	
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
      $(function () {
	  	var scroll=$(window).scrollTop();
		var scrollbottom = $(window).scrollTop() + $(window).height();
		var icnt = 0;
        //Initialize Select2 Elements
        $(".select2").select2();
		/*$('#example1').dataTable({
			//bFilter: false, 
			//bInfo: false,
			//"aoColumns": [
				//{ sWidth: '25%' },
				//{ sWidth: '25%' },
				//{ sWidth: '25%' },
				//{ sWidth: '25%' } ]
		});*/
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
		$('input:radio[name=staff_type]').on('change',function(){
			//$('select[name=staff_department]').html('');
			//alert('change');
			var radio_value = $('input:radio[name=staff_type]:checked').val();
			if(radio_value == 'Teaching'){
				$.post('live_search.php',{key: radio_value},function(data){
					$('select[name=staff_department]').empty().append('<option value="default" selected>--select--</option>'+data).selectmenu('refresh');
					//$('select[name=staff_department]').append(data);
				});
			}
			else if(radio_value == 'Non-Teaching'){
				$.post('live_search.php',{key: radio_value},function(data){
					$('select[name=staff_department]').empty().append('<option value="default" selected>--select--</option>'+data).selectmenu('refresh');
					//$('select[name=staff_department]').append(data);
				});
			}
			else{
				alert('Invalid Option');
			}
		}); // Staff working change event close here
		$('select[name=staff_department]').change(function(){
			var working_type = $('input:radio[name=staff_type]:checked').val();
			var department = $(this).val();
			$.post('live_search.php',{key: 'display_staff', working_type: working_type, department: department},function(data){
					$('select[name=staff]').empty().append('<option value="default" selected>--select--</option>'+data).selectmenu('refresh');
			});
		}); // Departmet select change event close here
		$('select[name=staff]').change(function(){
			//alert($(this).val());
			var select_txt = $('select[name=staff] option:selected').text();
			select_txt = select_txt.substr(0, select_txt.indexOf(' (')); 
			var username = select_txt.toLowerCase()+'_'+$(this).val();
			$('input[name=username]').val(username);
			$('input[name=password]').val(username);
		});
		$('#update_login').click(function(){
			//alert($("#staff_login_create").serialize());
			//$('.panel-footer').append($("#staff_login_create").serialize());
			$.ajax({
					type: 'post',
					cache: false,
					url: 'live_search.php',
					data: $("#staff_login_create").serialize() + "&key=update_staff_login_form_data",
					beforeSend: function(){
						$(".loader").show();
					},
					success: function(resp)
					{
						//alert(resp);
						$(".loader").fadeOut("slow");
						var now = moment().format("dddd, MMMM Do, YYYY, h:mm:ss A");
								 // Saturday, June 9th, 2007, 5:46:21 PM
						if(resp == 'update'){
							$('.panel-footer').append('<p class="bg-success" style="margin-top:1%;padding:1%;color:green;">Staff Login details Updated Successfully !".<span style="margin-left:1%;">('+now+')</span></p>');
						}
						else{
							$('.panel-footer').append('<p class="bg-warning" style="margin-top:1%;padding:1%;color:red;">'+resp+'</p>');
						}
					}
			});<!-- ./ajax call close-->		
		});
		$('#send_email').click(function(){
			$.ajax({
					type: 'post',
					cache: false,
					url: 'send_email.php',
					data: $("#staff_login_create").serialize() + "&key=email_send",
					beforeSend: function(){
						$(".loader").show();
					},
					success: function(resp)
					{
						$(".loader").fadeOut("slow");
						alert(resp);
						if(resp == 'sent'){
							$('.panel-footer').append('<p class="bg-success" style="margin-top:1%;padding:1%;color:green;">Email sent! ".</p>');
						}
						else{
							$('.panel-footer').append('<p class="bg-warning" style="margin-top:1%;padding:1%;color:red;">'+resp+'</p>');
						}
					}
			});<!-- ./ajax call close-->
		}); // email send button click event close here
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