<?php
	include("../../db_con.php");
	include("../functions.php");
	error_reporting(0);
	if(isset($_SESSION['user_id'])){
	//data: [70, 37, 55, 90, 103, 14],
		$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
		$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);
	
		$degree_customize = array();
		$course_customize = array();
		$branch_customize = array();
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
				$degree_customize[] = $result['degree_id'];	
				$course_customize[] = $result['course_id'];
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
				$degree_customize[] = $result['degree_id'];	
				$course_customize[] = $result['course_id'];
				$branch_customize[] = $result['branch_id'];
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
				//$degree_customize[] = $result['degree_id'];	
				$course_customize[] = $result['course_id'];
			} // while() close here
			$query = "select branch_id from branch";
			$run_query = mysqli_query($con, $query);
			while($result = mysqli_fetch_array($run_query)){
				$degree_customize[] = $result['degree_id'];	
				$branch_customize[] = $result['branch_id'];
			} // while() close here
		}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Advanced form elements</title>
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
			width:16px;
			height:16px;
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
		label{margin-top: 8px;}
</style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
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
					<small>Customize Your Report</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="#">Report</a></li>
					<li>Customization</li>
				</ol>
			</section><!-- ./content header -->
			<!-- Main content -->
			<section class="content">
				<div class="row">
				<?php //print_r($degree_customize); ?>
					<div class ="box box-primary collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Customization your Report</h3>
							<div class="box-tools pull-right">
      							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    						</div><!-- /.box-tools -->
						</div><!--./ box-header -->
					<form role="form" action="" method="post">	
						<div class="box-body">
						  <fieldset class="scheduler-border">
							<legend class="scheduler-border">Admission/Persoanl/Contact Details</legend>
							<div class = "row" style = "font-size: 11px;"> <!-- Personal/admission details -->
								<!--<div class="row" style="margin-left:1%;">Personal/admission Details</div>-->
								<div class = "col-lg-4">
									<div class="form-group">
										<div class ="col-md-2"><label class="control-label">Rollno</label></div>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<div class="col-md-6">
												<input type="text" name="custo_rollno_from" value="" class="form-control input-sm" placeholder="From" />
											</div><!-- col-md-5-->
											<div class="col-md-6">
												<input type="text" name="custo_rollno_to" value="" class="form-control input-sm" placeholder="to" />
											</div><!-- col-md-5-->
										</div>	
									</div><!-- ./form-group for rollno-->
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									<div class="form-group">
										<!--<div class ="col-md-2"><label class="control-label">Gender</label></div>-->
										<label class="col-lg-2 control-label" for="gender">Gender </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_gender[]" class="Form-label-checkbox" value="male" />
												<span class="Form-label-text"> Male</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_gender[]" class="Form-label-checkbox" value="female" />
												<span class="Form-label-text"> Female</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_gender[]" class="Form-label-checkbox" value="others" />
												<span class="Form-label-text"> Others</span>
											</label>
										</div>	
									</div><!-- ./form-group for gender-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="religion">Religion </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_religion[]" class="Form-label-checkbox" value="Hindu" />
												<span class="Form-label-text"> Hindu</span>
											</label> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_religion[]" class="Form-label-checkbox" value="Christian" />
												<span class="Form-label-text"> Christian</span>
											</label><br /> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_religion[]" class="Form-label-checkbox" value="Islam" />
												<span class="Form-label-text"> Islam</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_religion[]" class="Form-label-checkbox" value="Jain" />
												<span class="Form-label-text"> Jain</span>
											</label><br /> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_religion[]" class="Form-label-checkbox" value="Sikhism" />
												<span class="Form-label-text"> Sikhism</span>
											</label><br /> 
										</div>	
									</div> <!-- ./form-group for Religion-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="community">Community </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="SC" />
												<span class="Form-label-text"> SC</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="ST" />
												<span class="Form-label-text"> ST</span>
											</label><br /> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="BC" />
												<span class="Form-label-text"> BC</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="MBC" />
												<span class="Form-label-text"> MBC</span>
											</label><br /> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="Converted Christian from SC" />
												<span class="Form-label-text"> Converted Christian from SC</span>
											</label><br /> 
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_community[]" class="Form-label-checkbox" value="Denotified Community" />
												<span class="Form-label-text"> Denotified Community</span>
											</label><br /> 
										</div>	
									</div> <!-- ./form-group for Community-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="nationality">Nationality </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_nationality[]" class="Form-label-checkbox" value="Indian" />
												<span class="Form-label-text"> Indian</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_nationality[]" class="Form-label-checkbox" value="Foreigner" />
												<span class="Form-label-text"> Foreigner</span>
											</label>
										</div>	
									</div> <!-- ./form-group for Nationality-->
									
								</div> <!-- ./ col-lg-4 for student admission and personal details close here-->
								<div class = "col-lg-4">
									<div class="form-group">
										<!--<div class ="col-md-2"><label class="control-label">Gender</label></div>-->
										<label class="col-lg-2 control-label" for="blood-group">Blood-Grp </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="A+" />
												<span class="Form-label-text"> A+</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="A-" />
												<span class="Form-label-text"> A-</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="B+" />
												<span class="Form-label-text"> B+</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="B-" />
												<span class="Form-label-text"> B-</span>
											</label><br />
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="AB+" />
												<span class="Form-label-text"> AB+</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="AB-" />
												<span class="Form-label-text"> AB-</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="O-" />
												<span class="Form-label-text"> O-</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_blood_group[]" class="Form-label-checkbox" value="O+" />
												<span class="Form-label-text"> O+</span>
											</label>
										</div>	
									</div><!-- ./form-group for Blood-Grp-->
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="mother_tongue">Mother Tongue </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<select class="form-control select2 input-sm" multiple = "multiple" name="custo_mother_tongue[]" data-placeholder="Select a Mother Tongue" style = "width:100%">
												<option>Tamil</option>
												<option>English</option>
												<option>Hindi</option>
												<option>Bengali</option>
												<option>Telugu</option>
												<option>Marathi</option>
												<option>Urdu</option>
												<option>Gujarati</option>
												<option>Kannada</option>
												<option>Malayalam</option>
												<option>Odia</option>
												<option>Punjabi</option>
												<option>Assamese</option>
												<option>Kashmiri</option>
												<option>Nepali</option>
												<option>Gondi</option>
												<option>Sindhi</option>
												<option>Konkani</option>
												<option>Dogri</option>
												<option>Khandeshi</option>
												<option>Kurukh</option>
												<option>Tulu</option>
												<option>Meitei/Manipuri</option>
												<option>Bodo</option>
												<option>Khasi</option>
												<option>Mundari</option>
												<option>Rajasthani</option>
												<option>Chhattisgarhi</option>
												<option>Marwari</option>
											</select> 
										</div><!-- ./ col-lg-9-->
									</div><!-- ./form group for Mothet Tongue -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="language_known">Languages-Known </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<select class="form-control select2 input-sm" multiple="multiple" name="custo_lang_known[]" data-placeholder="Languages Known" style = "width:100%">
												<option>Tamil</option>
												<option>English</option>
												<option>Hindi</option>
												<option>Bengali</option>
												<option>Telugu</option>
												<option>Marathi</option>
												<option>Urdu</option>
												<option>Gujarati</option>
												<option>Kannada</option>
												<option>Malayalam</option>
												<option>Odia</option>
												<option>Punjabi</option>
												<option>Assamese</option>
												<option>Kashmiri</option>
												<option>Nepali</option>
												<option>Gondi</option>
												<option>Sindhi</option>
												<option>Konkani</option>
												<option>Dogri</option>
												<option>Khandeshi</option>
												<option>Kurukh</option>
												<option>Tulu</option>
												<option>Meitei/Manipuri</option>
												<option>Bodo</option>
												<option>Khasi</option>
												<option>Mundari</option>
												<option>Rajasthani</option>
												<option>Chhattisgarhi</option>
												<option>Marwari</option>
											</select> 
										</div><!-- ./ col-lg-9-->
									</div><!-- ./form group for Languages-Known -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="dob">DOB </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<div class = "col-lg-6">
												<input type="text" class="form-control input-sm" name="custo_dob_from" style="width:100%;" data-inputmask="'alias':'dd/mm/yyyy'" placeholder = "from" data-mask />
											</div>
											<div class = "col-lg-6">
												<input type="text" class="form-control input-sm" name="custo_dob_to" style="width:100%;" data-inputmask="'alias':'dd/mm/yyyy'" placeholder = "to" data-mask />
											</div>
										</div> <!-- ./col-lg-9 -->
									</div>	<!-- ./form group for DOB -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="admission_no">Admission-No </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<div class = "col-lg-6">
												<input type="text" name="admission_from" class="form-control input-sm" id="admission_from" placeholder = "From"  autocomplete="off" />
											</div>
											<div class = "col-lg-6">
												<input type="text" name="admission_to" class="form-control input-sm" id="admission_to" placeholder = "to" autocomplete="off" />
											</div>
										</div> <!-- ./col-lg-9 -->
									</div>	<!-- ./form group for Admission no -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="admission_date">Admission-Date </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<div class = "col-lg-6">
												<input type="text" class="form-control input-sm" name="doa_from" style="width:100%;" data-inputmask="'alias':'dd/mm/yyyy'" placeholder = "from" data-mask />
											</div>
											<div class = "col-lg-6">
												<input type="text" class="form-control input-sm" name="doa_to" style="width:100%;" data-inputmask="'alias':'dd/mm/yyyy'" placeholder = "to" data-mask />
											</div>
										</div> <!-- ./col-lg-9 -->
									</div>	<!-- ./form group for DOB -->
								</div> <!-- ./ col-lg-4 BOX 2-->
								<div class = "col-lg-4">
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="address">Admission Quota </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_admission_quota[]" class="Form-label-checkbox" value="Councelling" />
												<span class="Form-label-text"> Councelling</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_admission_quota[]" class="Form-label-checkbox" value="Management" />
												<span class="Form-label-text"> Management</span>
											</label>
										</div>	
									</div> <!-- ./form-group for admission_quota-->
								
									<div class="clearfix" style="height: 5px;clear: both;"></div>
								
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="address">Address </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_add[]" class="Form-label-checkbox" value="per_add" />
												<span class="Form-label-text"> Permanent address</span>
											</label>
											<label class="Form-label--tick">
												<input type="checkbox" name="custo_add[]" class="Form-label-checkbox" value="pre_add" />
												<span class="Form-label-text"> Present address</span>
											</label>
										</div>	
									</div> <!-- ./form-group for Address-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="country">Country </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<select class="form-control select2" multiple = "multiple" name="custo_country[]" data-placeholder="Select a country" style="width:100%;">
												<option>India</option>
												<option>Pakistan</option>
												<option>SriLanka</option>
												<option>England</option>
												<option>China</option>
												<option>Others</option>
											</select>
										</div><!-- ./col-lg-9 -->
									</div>	<!-- ./form group for country-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="state">State </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<select class="form-control select2" multiple = "multiple" name="custo_state[]" data-placeholder="Select a state" style="width:100%;">
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
										</div><!-- ./col-lg-9 -->
									</div>	<!-- ./form group for state-->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<div class = "form-group">
										<label class="col-lg-2 control-label" for="district">District </label>
										<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<select class="form-control select2" multiple = "multiple" name="custo_district[]" data-placeholder="Select a district" style="width:100%;">
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
										</div><!-- ./col-lg-9 -->
									</div>	<!-- ./form group for district-->
									
								</div> <!-- ./ col-lg-4 BOX 3-->
							</div><!-- ./row for personal/admission details-->
						   </fieldset>	
						   <fieldset class="scheduler-border">
								<legend class="scheduler-border">Current/Pervious Academic Details</legend>
								<div class = "row" style = "font-size: 11px;"> <!-- Current/Previous Academic details details -->
									<div class="col-lg-4">
										<div class="form-group">
										  <div class ="col-md-2"><label class="control-label">Register No</label></div>
										  <div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											<div class="col-md-6">
												<input type="text" name="custo_regno_from" value="" class="form-control input-sm" placeholder="From" />
											</div><!-- col-md-5-->
											<div class="col-md-6">
												<input type="text" name="custo_regno_to" value="" class="form-control input-sm" placeholder="to" />
											</div><!-- col-md-5-->
										  </div>	<!-- ./col-lg-9 -->
										</div><!-- ./form-group for register no-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_degree">Degree </label>
											<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_degree[]" id = "custo_ug" class="Form-label-checkbox custo_degree" value="3" <?php if(!in_array(3, $degree_customize) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>/>
													<?php if(!in_array(3, $degree_customize) && !in_array('all', $dept_permission_reports)){echo '<span class="Form-label-text" style="color: rgba(0,0,0,0.2);"> UG</span>';}else{echo '<span class="Form-label-text"> UG</span>';} ?>
													
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_degree[]" id = "custo_pg" class="Form-label-checkbox custo_degree" value="2" <?php if(!in_array(2, $degree_customize) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>/>
													<?php if(!in_array(2, $degree_customize) && !in_array('all', $dept_permission_reports)){echo '<span class="Form-label-text" style="color: rgba(0,0,0,0.2);"> PG</span>';}else{echo '<span class="Form-label-text"> PG</span>';} ?>
												</label>
											</div>	<!-- ./col-lg-9 -->
										</div> <!-- ./form-group for Degree-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_course">Course </label>
											<div class  = "col-lg-9 pull-right" id = "custo_course_ug" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<?php
													 $query = "SELECT course_id,course_name FROM courses WHERE degree_id= 3";
													$run_query = mysqli_query($con, $query);
													while($row = mysqli_fetch_array($run_query)){
														?>
														<label class="Form-label--tick">
						<input type="checkbox" name="custo_course[]" class="Form-label-checkbox custo_course" value=<?php echo $row['course_id'] ?> <?php if(!in_array($row['course_id'], $course_customize) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?> />
						<?php if(!in_array($row['course_id'], $course_customize) && !in_array('all', $dept_permission_reports)){echo '<span class="Form-label-text custo_course_ug" style="color: rgba(0,0,0,0.2);">'.$row['course_name'].'</span>';}else{echo '<span class="Form-label-text custo_course_ug">'.$row['course_name'].'</span>';} ?>
						</label>
							 
					
											<?php
													}
													 $query = "SELECT course_id,course_name FROM courses WHERE degree_id= 2";
													$run_query = mysqli_query($con, $query);
													while($row = mysqli_fetch_array($run_query)){
														?>
														<label class="Form-label--tick">
						<input type="checkbox" name="custo_course[]" class="Form-label-checkbox custo_course_pg custo_course" value=<?php echo $row['course_id'] ?> <?php if(!in_array($row['course_id'], $course_customize) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?> />
						
						<?php if(!in_array($row['course_id'], $course_customize) && !in_array('all', $dept_permission_reports)){echo '<span class="Form-label-text custo_course_pg" style="color: rgba(0,0,0,0.2);">'.$row['course_name'].'</span>';}else{echo '<span class="Form-label-text custo_course_pg" >'.$row['course_name'].'</span>';} ?>
					</label>
											<?php
													}
												?>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Courses-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_branch">Branch </label>
											<div class  = "col-lg-9 pull-right" id = "custo_branch" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
											
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for branches-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_section">Section </label>
											<div class  = "col-lg-9 pull-right" id = "custo_section" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<select class="form-control select2" multiple = "multiple" name="custo_section[]" data-placeholder="Select a section" style="width:100%;">
												<option>A</option>
												<option>B</option>
												<option>C</option>
												<option>D</option>
												<option>E</option>
												<option>AA</option>
											</select>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for sections-->
										
									</div><!-- ./ col-lg-4 -->
									<div class="col-lg-4">
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_batch">Batch </label>
											<div class  = "col-lg-9 pull-right" id = "custo_batch" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<div class = "col-lg-6">
												<input type="text" name="custo_batch_from" class="form-control input-sm" id="batch_from" placeholder = "From"  autocomplete="off" />
											</div>
											<div class = "col-lg-6">
												<input type="text" name="custo_batch_to" class="form-control input-sm" id="batch_to" placeholder = "to" autocomplete="off" />
											</div>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Batch-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_join_mode">Join </label>
											<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_join_mode[]" id = "custo_join_mode_regular" class="Form-label-checkbox" value="Regular" />
													<span class="Form-label-text"> Regular</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_join_mode[]" id = "custo_join_mode_lateral" class="Form-label-checkbox" value="Lateral Entry" />
													<span class="Form-label-text"> Lateral Entry</span>
												</label>
											</div>	<!-- ./col-lg-9 -->
										</div> <!-- ./form-group for Join-Mode-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_semester">Semester </label>
											<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester_1" class="Form-label-checkbox" value= 1 />
													<span class="Form-label-text"> 1</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester2" class="Form-label-checkbox" value= 2 />
													<span class="Form-label-text"> 2</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester3" class="Form-label-checkbox" value= 3 />
													<span class="Form-label-text"> 3</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester4" class="Form-label-checkbox" value= 4 />
													<span class="Form-label-text"> 4</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester5" class="Form-label-checkbox" value= 5 />
													<span class="Form-label-text"> 5</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester6" class="Form-label-checkbox" value= 6 />
													<span class="Form-label-text"> 6</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester7" class="Form-label-checkbox" value= 7 />
													<span class="Form-label-text"> 7</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_semester[]" id = "custo_semester8" class="Form-label-checkbox" value= 8 />
													<span class="Form-label-text"> 8</span>
												</label>
											</div>	<!-- ./col-lg-9 -->
										</div> <!-- ./form-group for semester -->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_cgpa">CGPA </label>
											<div class  = "col-lg-9 pull-right" id = "custo_cgpa" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<div class = "col-lg-6">
												<input type="text" name="custo_cgpa_from" class="form-control input-sm" id="custo_cgpa_from" placeholder = "From"  autocomplete="off" />
											</div>
											<div class = "col-lg-6">
												<input type="text" name="custo_cgpa_to" class="form-control input-sm" id="custo_cgpa_to" placeholder = "to" autocomplete="off" />
											</div>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Batch-->
										
									</div><!-- ./ col-lg-4 -->
									<div class="col-lg-4">
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_prev_degree">prev-Degree </label>
											<div class  = "col-lg-9 pull-right" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_prev_degree[]" id = "custo_prev_degree_X" class="Form-label-checkbox" value= "X" />
													<span class="Form-label-text"> X</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_prev_degree[]" id = "custo_prev_degree_XII" class="Form-label-checkbox" value= "XII" />
													<span class="Form-label-text"> XII</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_prev_degree[]" id = "custo_prev_degree_dploma" class="Form-label-checkbox" value= "DIPLOMA " />
													<span class="Form-label-text"> DIPLOMA</span>
												</label>
												<label class="Form-label--tick">
													<input type="checkbox" name="custo_prev_degree[]" id = "custo_prev_degree_ug" class="Form-label-checkbox" value= "UG" />
													<span class="Form-label-text"> UG</span>
												</label>
											</div>	<!-- ./col-lg-9 -->
										</div> <!-- ./form-group for semester -->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_year_passing">Yr of passing </label>
											<div class  = "col-lg-9 pull-right" id = "custo_year_passing" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<div class = "col-lg-6">
												<input type="text" name="custo_year_passing_from" class="form-control input-sm" id="custo_year_passing_from" placeholder = "From"  autocomplete="off" />
											</div>
											<div class = "col-lg-6">
												<input type="text" name="custo_year_passing_to" class="form-control input-sm" id="custo_year_passing_to" placeholder = "to" autocomplete="off" />
											</div>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Batch-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_percentage">Percentage </label>
											<div class  = "col-lg-9 pull-right" id = "custo_percentage" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<div class = "col-lg-6">
												<input type="text" name="custo_percentage_from" class="form-control input-sm" id="custo_percentage_from" placeholder = "From"  autocomplete="off" />
											</div>
											<div class = "col-lg-6">
												<input type="text" name="custo_percentage_to" class="form-control input-sm" id="custo_percentage_to" placeholder = "to" autocomplete="off" />
											</div>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Batch-->
										
										<div class="clearfix" style="height: 5px;clear: both;"></div>
										
										<div class = "form-group">
											<label class="col-lg-2 control-label" for="custo_prev_cgpa">Prev-CGPA </label>
											<div class  = "col-lg-9 pull-right" id = "custo_prev_cgpa" style = "border: 1px solid rgba(0, 0, 0, 0.08);padding: 2%;">
												<div class = "col-lg-6">
													<input type="text" name="custo_prev_cgpa_from" class="form-control input-sm" id="custo_prev_cgpa_from" placeholder = "From"  autocomplete="off" />
												</div>
												<div class = "col-lg-6">
													<input type="text" name="custo_prev_cgpa_to" class="form-control input-sm" id="custo_prev_cgpa_to" placeholder = "to" autocomplete="off" />
												</div>
											</div> <!-- ./col-lg-9 -->
										</div>	<!-- ./form-group for Batch-->
										
									</div><!-- ./ col-lg-4 -->
								</div><!--./row -->
						   <fieldset>
						</div><!-- ./ box-body -->
					
						<div class = "box-footer">
							<center><button type="submit" name="customize_button" id = "customize_button" class="btn btn-primary btn-flat" style = "width: 15%;">Submit</button></center>
						</div><!-- ./ box-footer -->
					</form>	 <!-- form Close here -->	
					</div><!-- ./box -->	
				</div><!-- ./row -->
			<?php 
				if(isset($_POST['customize_button'])){
					//echo admin_index."plugins/select2/select2.full.min.js";
				?>	
				<div class="row">
					<div class="box box-primary" id="customize_generated_report">
						<div class="box-header with-border">
							<h3 class="box-title">Generated Report</h3>
							<!--<h4>Show Result for</h4>-->
							<p></p>
						</div>
						<div class="box-body">
							<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;width:100%;">
								<thead>
									<tr>
										<th id="admission_no"></th>
										<th id="admission_date"></th>
										<th id="admission_qouta"></th>
										<th id="status"></th>
										<th id="joined"></th>
										<th id="rollno"></th>
										<th id="fname"></th>
										<th id="lname"></th>
										<th id="gender"></th>
										<th id="dob"></th>
										<th id="religion"></th>
										<th id="community"></th>
										<th id="mother_maiden_name"></th>
										<th id="mother_name"></th>
										<th id="father_name"></th>
										<th id="parent_income"></th>
										<th id="nationality"></th>
										<th id="blood_group"></th>
										<th id="mother_tongue"></th>
										<th id="language_known"></th>
										<th id="email"></th>
										<th id="mobile"></th>
										<th id="alter_mobile"></th>
										<th id="parent_email"></th>
										<th id="parent_mobile"></th>
										<th id="present_address"></th>
										<th id="permanent_address"></th>
										<th id="univ_regno"></th>
										<th id="degree"></th>
										<th id="course"></th>
										<th id="branch"></th>
										<th id="section"></th>
										<th id="year"></th>
										<th id="batch"></th>
										<th id="prev_degree"></th>
										<th id="prev_course"></th>
										<th id="prev_branch"></th>
										<th id="yr_of_passing"></th>
										<th id="course_type"></th>
										<th id="ins_name"></th>
										<th id="board_of_education"></th>
										<th id="cgpa_obtained"></th>
										<th id="percentage"></th>
									</tr>
									<tr class="">
										<th id="">Admission-no</th>
										<th id="">Admission-date</th>
										<th id="">Admission-qouta</th>
										<th id="">Status</th>
										<th id="">Joined</th>
										<th id="">Rollno</th>
										<th id="">Firstname</th>
										<th id="">Lastname</th>
										<th id="">Gender</th>
										<th id="">DOB</th>
										<th id="">Religion</th>
										<th id="">Community</th>
										<th id="">Mother's maiden name</th>
										<th id="">Mother's name</th>
										<th id="">Father's name</th>
										<th id="">Parent-income</th>
										<th id="">Nationality</th>
										<th id="">Blood-Grp</th>
										<th id="">Mother-tongue</th>
										<th id="">Languages-Known</th>
										<th id="">Email</th>
										<th id="">Mobile</th>
										<th id="">Alter-Mobile</th>
										<th id="">Parent-Email</th>
										<th id="">Parent-Mobile</th>
										<th id="">Present-address</th>
										<th id="">Permanent-address</th>
										<th id="">Univ-regno</th>
										<th id="">Degree</th>
										<th id="">Course</th>
										<th id="">Branch</th>
										<th id="">Section</th>
										<th id="">Year</th>
										<th id="">Batch</th>
										<th id="">Prev-Degree</th>
										<th id="">Prev-Course</th>
										<th id="">Prev-Branch</th>
										<th id="">yr-of-passing</th>
										<th id="">Course-type</th>
										<th id="">Ins-name</th>
										<th id="">Board</th>
										<th id="">CGPA/MARK</th>
										<th id="">Percentage</th>
									</tr>
								</thead><!-- ./thead  -->
								<tbody>
									<?php
										$query = "SELECT a.*, p.*, co.*, curr.*,CONCAT('[',GROUP_CONCAT(DISTINCT prev.prev_degree),']') prev_degree,CONCAT('[',GROUP_CONCAT(DISTINCT prev.prev_course),']') prev_course,CONCAT('[',GROUP_CONCAT(DISTINCT prev.prev_branch),']') prev_branch,CONCAT('[',GROUP_CONCAT(DISTINCT  prev.year_of_passing),']') yr_of_passing,CONCAT('[',GROUP_CONCAT(DISTINCT  prev.course_type),']') 	course_type,CONCAT('[',GROUP_CONCAT(DISTINCT  prev.ins_name),']') ins_name,CONCAT('[',GROUP_CONCAT(DISTINCT  prev.board_of_education),']') board_of_education,CONCAT('[',GROUP_CONCAT(DISTINCT  prev.cgpa_obtained),']') cgpa,CONCAT('[',GROUP_CONCAT(DISTINCT prev.percentage),']') percentage, d.*, c.*, b.* FROM admission_details a, stu_personal_details p, stu_contact_details co, current_course curr, prev_academic_details prev, degree d, courses c, branch b, stu_results r WHERE 1=1 AND a.admission_no = p.admission_no AND p.stu_rollno = co.stu_rollno AND co.stu_rollno = curr.stu_rollno AND curr.stu_rollno = prev.stu_rollno AND prev.stu_rollno = r.stu_rollno AND r.stu_rollno = p.stu_rollno AND(d.degree_id = curr.stu_degree AND c.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) ";
										$query_str = "";
										//$query_str = "";
										if(!empty($_POST['custo_rollno_from']) && !empty($_POST['custo_rollno_to'])){
											$query_str= "AND (p.stu_rollno BETWEEN ".$_POST['custo_rollno_from']." AND ".$_POST['custo_rollno_to'].")";
											$query .= $query_str;
										} //if(rollno) close here
										if(isset($_POST['custo_gender'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_gender'] as $i=> $value){
												$query_str .= "p.stu_gender = '".capitalize($value)."' OR ";
												"<br />";
											}
											$query_str = rtrim($query_str, " OR ");
											$query .= $query_str.")";
										} //if(gender) close here
										if(isset($_POST['custo_religion'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_religion'] as $i=> $value){
												$query_str .= "p.stu_religion = '".capitalize($value)."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										}//if(religions) close here
										if(isset($_POST['custo_community'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_community'] as $i=> $value){
												$query_str .= "p.stu_community = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(community) close here
										if(isset($_POST['custo_nationality'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_nationality'] as $i=> $value){
												$query_str .= "p.stu_nationality = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(nationality) close here
										if(isset($_POST['custo_blood_group'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_blood_group'] as $i=> $value){
												$query_str .= "p.stu_blood_group = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(blood_group) close here
										if(isset($_POST['custo_mother_tongue'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_mother_tongue'] as $i=> $value){
												$query_str .= "p.stu_mother_tongue = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(mother_tongue) close here
										if(isset($_POST['custo_lang_known'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_lang_known'] as $i=> $value){
												$query_str .= "p.stu_langknown_1 = '".$value."' OR p.stu_langknown_2 = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(lang_known) close here
										if(!empty($_POST['custo_dob_from']) && !empty($_POST['custo_dob_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "p.stu_dob BETWEEN '".db_date($_POST['custo_dob_from'])."' AND '".db_date($_POST['custo_dob_to'])."'";
											$query .= $query_str.")";
										} //if(DOB) close here
										if(!empty($_POST['admission_from']) && !empty($_POST['admission_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "a.admission_no BETWEEN ".$_POST['admission_from']." AND ".$_POST['admission_to']."";
											$query .= $query_str.")";
										} //if(admission_no) close here
										if(!empty($_POST['doa_from']) && !empty($_POST['doa_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "a.admission_date BETWEEN '".db_date($_POST['doa_from'])."' AND '".db_date($_POST['doa_to'])."'";
											$query .= $query_str.")";
										} //if(DOJ) close here
										if(isset($_POST['custo_admission_quota'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_admission_quota'] as $i=> $value){
												$query_str .= "a.admission_quota = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} // if(admission_quota)
										if(isset($_POST['custo_country'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_country'] as $i=> $value){
												$query_str .= "co.stu_pre_country = '".$value."' OR co.stu_per_country = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(country) close here
										if(isset($_POST['custo_state'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_state'] as $i=> $value){
												$query_str .= "co.stu_pre_state = '".$value."' OR co.stu_per_state = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											echo $query .= $query_str.")";
										} //if(state) close here
										if(isset($_POST['custo_district'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_district'] as $i=> $value){
												$query_str .= "co.stu_pre_district = '".$value."' OR p.stu_per_district = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(district) close here
										if(!empty($_POST['custo_regno_from']) && !empty($_POST['custo_regno_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_univ_regno BETWEEN ".$_POST['custo_regno_from']." AND ".$_POST['custo_regno_to']."";
											$query .= $query_str.")";
										} //if(univ_regno) close here
										if(isset($_POST['custo_degree'])){
											$degree_customize = implode(',',$_POST['custo_degree']);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_degree IN (".$degree_customize.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(district) close here
										if(isset($_POST['custo_course'])){
											$course_customize = implode(',',$_POST['custo_course']);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_course IN (".$course_customize.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(course) close here
										else{
											$course_customize = implode(',',$course_customize);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_course IN (".$course_customize.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										}
										if(isset($_POST['custo_branch'])){
											$branch_customize = implode(',',$_POST['custo_branch']);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_branch IN (".$branch_customize.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(branch) close here
										else{
											$branch_customize = implode(',',$branch_customize);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_branch IN (".$branch_customize.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										}
										if(isset($_POST['custo_section'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_section'] as $i=> $value){
												$query_str .= "curr.stu_section = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(section) close here
										if(!empty($_POST['custo_batch_from']) && !empty($_POST['custo_batch_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "curr.stu_batch BETWEEN ".$_POST['custo_batch_from']." AND ".$_POST['custo_batch_to']."";
											$query .= $query_str.")";
										} //if(batch) close here
										if(isset($_POST['custo_join_mode'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_join_mode'] as $i=> $value){
												$query_str .= "curr.stu_joined = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(join_mode) close here
										if(isset($_POST['custo_semester'])){
											$semester = implode(',',$_POST['custo_semester']);
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "r.semester IN (".$semester.")"; 
											//$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(semester) close here
										if(!empty($_POST['custo_cgpa_from']) && !empty($_POST['custo_cgpa_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "r.cgpa BETWEEN ".$_POST['custo_cgpa_from']." AND ".$_POST['custo_cgpa_to']."";
											$query .= $query_str.")";
										} //if(cgpa) close here
										if(isset($_POST['custo_prev_degree'])){
											$query_str = "";
											$query_str = " AND (";
											foreach($_POST['custo_prev_degree'] as $i=> $value){
												$query_str .= "prev.prev_degree = '".$value."' OR "; 
											}
											$query_str = rtrim($query_str," OR ");
											$query .= $query_str.")";
										} //if(prev_degree) close here
										if(!empty($_POST['custo_year_passing_from']) && !empty($_POST['custo_year_passing_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "prev.year_of_passing BETWEEN ".$_POST['custo_year_passing_from']." AND ".$_POST['custo_year_passing_to']."";
											$query .= $query_str.")";
										} //if(year_passing) close here
										if(!empty($_POST['custo_percentage_from']) && !empty($_POST['custo_percentage_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "prev.percentage BETWEEN ".$_POST['custo_percentage_from']." AND ".$_POST['custo_percentage_to']."";
											$query .= $query_str.")";
										} //if(percentage) close here
										if(!empty($_POST['custo_prev_cgpa_from']) && !empty($_POST['custo_prev_cgpa_to'])){
											$query_str = "";
											$query_str = " AND (";
											$query_str .= "prev.cgpa_obtained BETWEEN ".$_POST['custo_prev_cgpa_from']." AND ".$_POST['custo_prev_cgpa_to']."";
											$query .= $query_str.")";
										} //if(prev_cgpa) close here
										$query.=" GROUP BY a.admission_no, p.stu_rollno";
										$run_query = mysqli_query($con, $query);
										while($row = mysqli_fetch_array($run_query)){
												if((date('Y')-$row['stu_batch'] == 1) || (date('Y')-$row['stu_batch'])== 0){
												$stu_year = 1;		
											}
											else{
											$stu_year = date('Y')-$row['stu_batch'];
											}
											echo "
												<tr>
													<td>".$row['admission_no']."</td>
													<td>".date('d-m-Y',strtotime($row['admission_date']))."</td>
													<td>".$row['admission_quota']."</td>
													<td>".$row['status']."</td>
													<td>".$row['stu_joined']."</td>
													<td>".$row['stu_rollno']."</td>
													<td>".$row['stu_firstname']."</td>
													<td>".$row['stu_lastname']."</td>
													<td>".$row['stu_gender']."</td>
													<td>".date('d-m-Y',strtotime($row['stu_dob']))."</td>
													<td>".$row['stu_religion']."</td>
													<td>".$row['stu_community']."</td>
													<td>".$row['stu_mother_maiden_name']."</td>
													<td>".$row['stu_mother_name']."</td>
													<td>".$row['stu_father_name']."</td>
													<td>".$row['stu_parent_income']."</td>
													<td>".$row['stu_nationality']."</td>
													<td>".$row['stu_blood_group']."</td>
													<td>".$row['stu_mother_tongue']."</td>
													<td>".$row['stu_langknown_1'].", ".$row['stu_langknown_2']."</td>
													<td>".$row['stu_email']."</td>
													<td>".$row['stu_mobile']."</td>
													<td>".$row['stu_alternative_mobile']."</td>
													<td>".$row['stu_parent_email']."</td>
													<td>".$row['stu_parent_mobile']."</td>
													<td>".$row['stu_pre_houseno'].", ".$row['stu_pre_street'].", ".$row['stu_pre_area'].", ".$row['stu_pre_district'].", ".$row['stu_pre_state'].", ".$row['stu_pre_country'].", pincode: ".$row['stu_pre_pincode']."</td>
													<td>".$row['stu_per_houseno'].", ".$row['stu_per_street'].", ".$row['stu_per_area'].", ".$row['stu_per_district'].", ".$row['stu_per_state'].", ".$row['stu_per_country'].", pincode: ".$row['stu_per_pincode']."</td>
													<td>".$row['stu_univ_regno']."</td>
													<td>".$row['degree_name']."</td>
													<td>".$row['course_name']."</td>
													<td>".$row['branch_name']."</td>
													<td>".$row['stu_section']."</td>
													<td>".$stu_year."</td>
													<td>".$row['stu_batch']."</td>
													<td>".$row['prev_degree']."</td>
													<td>".$row['prev_course']."</td>
													<td>".$row['prev_branch']."</td>
													<td>".$row['yr_of_passing']."</td>
													<td>".$row['course_type']."</td>
													<td>".$row['ins_name']."</td>
													<td>".$row['board_of_education']."</td>
													<td>".$row['cgpa']."</td>
													<td>".$row['percentage']."</td>
												</tr>
											";	
										}
									?>
								</tbody>
								<tfoot>
									<tr class="">
										<th id="">Admission-no</th>
										<th id="">Admission-date</th>
										<th id="">Admission-qouta</th>
										<th id="">Status</th>
										<th id="">Joined</th>
										<th id="">Rollno</th>
										<th id="">Firstname</th>
										<th id="">Lastname</th>
										<th id="">Gender</th>
										<th id="">DOB</th>
										<th id="">Religion</th>
										<th id="">Community</th>
										<th id="">Mother's maiden name</th>
										<th id="">Mother's name</th>
										<th id="">Father's name</th>
										<th id="">Parent-income</th>
										<th id="">Nationality</th>
										<th id="">Blood-Grp</th>
										<th id="">Mother-tongue</th>
										<th id="">Languages-Known</th>
										<th id="">Email</th>
										<th id="">Mobile</th>
										<th id="">Alter-Mobile</th>
										<th id="">Parent-Email</th>
										<th id="">Parent-Mobile</th>
										<th id="">Present-address</th>
										<th id="">Permanent-address</th>
										<th id="">Univ-regno</th>
										<th id="">Degree</th>
										<th id="">Course</th>
										<th id="">Branch</th>
										<th id="">Section</th>
										<th id="">Year</th>
										<th id="">Batch</th>
										<th id="">Prev-Degree</th>
										<th id="">Prev-Course</th>
										<th id="">Prev-Branch</th>
										<th id="">yr-of-passing</th>
										<th id="">Course-type</th>
										<th id="">Ins-name</th>
										<th id="">Board</th>
										<th id="">CGPA/MARK</th>
										<th id="">Percentage</th>
									</tr>
								</tfoot>
							</table>
						</div><!-- ./box-body -->
						<div class="box-footer">
							<?php
								/*echo "Rollno_from".$_POST['custo_rollno_from']."<br />";
								echo "Rollno_to".$_POST['custo_rollno_to']."<br />";
								echo "Gender: </br>";
								print_r($_POST['custo_gender']);
								echo "Religion <br />";
								print_r($_POST['custo_religion']);
								print_r($_POST['custo_community'])."community <br />";
								print_r($_POST['custo_nationality'])	."<br />";
								print_r($_POST['custo_blood_group'])."<br />";
								print_r($_POST['custo_mother_tongue'])."<br />";
								print_r($_POST['custo_lang_known'])."<br />";
								echo "dob.from: ".$_POST['custo_dob_from']."<br />";
								echo "dob to: ".$_POST['custo_dob_to']."<br />";
								echo "admission_from: ".$_POST['admission_from']."<br />";
								echo "admission to: ".$_POST['admission_to']."<br />";
								echo "dateof admission_from: ".$_POST['doa_from']."<br />";
								echo "admission_date_to: ".$_POST['doa_to']."<br />";
								print_r($_POST['custo_add'])."<br />";
								print_r($_POST['custo_country'])."<br />";
								print_r($_POST['custo_state'])."<br />";
								print_r($_POST['custo_district'])."<br />";
								echo "regno_from: ".$_POST['custo_regno_from']."<br />";
								echo "regno_to: ".$_POST['custo_regno_to']."<br />";
								print_r($_POST['custo_degree'])."<br />";
								print_r($_POST['custo_course'])."<br />";
								print_r($_POST['custo_branch'])."<br />";
								print_r($_POST['custo_section'])."<br />";
								echo "batch_from: ".$_POST['custo_batch_from']."<br />";
								echo "batch_to: ".$_POST['custo_batch_to']."<br />";
								print_r($_POST['custo_join_mode'])."<br />";
								print_r($_POST['custo_semester'])."<br />";
								echo "cgpa_from: ".$_POST['custo_cgpa_from']."<br />";
								echo "cgpa_to: ".$_POST['custo_cgpa_to']."<br />";
								print_r($_POST['custo_prev_degree'])."<br />";
								echo "passing_from".$_POST['custo_year_passing_from']."<br />";
								echo "passing_to".$_POST['custo_year_passing_to']."<br />";	
								echo "percentage from: ".$_POST['custo_percentage_from']."<br />";
								echo "percentage_to: ".$_POST['custo_percentage_to']."<br />";	
								echo "cgpa_from: ".$_POST['custo_prev_cgpa_from']."<br />";
								echo "cgpa_to: ".$_POST['custo_prev_cgpa_to']."<br />";	
								*/
							?>
						</div>
					</div><!-- ./box-primary -->	
				</div><!-- ./row-->	
			<?php
				} // if() close here
				else{
					
				}
				?>
			</section><!-- ./ main content Section-->
		</div>
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper ->
	<!--J Q U E R Y   P L U G  I N S   I N C L U  D E D   B E L O W -->
	
	<!-- InputMask -->
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo path ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
	
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
				//$('#community_generated_report').hide();
				$("[data-mask]").inputmask();
				
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
				//$('#example1').hide();
				$(".select2").select2();
				$('#example1').dataTable({
						"sDom": 'Bfrtip',
						//stateSave: true,
						lengthMenu: [
            				[ 10, 25, 50,100, -1 ],
            				[ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        				],
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
								extend: 'copyHtml5',
								exportOptions: {columns: ':visible'},
								text:      '<i class="fa fa-clipboard"></i>',
                				titleAttr: 'Copy'
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
								collectionLayout: 'fixed four-column'
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
					 			{sSelector:"#admission_no",type:"number-range"},
								{sSelector:"#admission_date",type:"number-range"},
								{sSelector:"#admission_qouta",type:"select"},
								{sSelector:"#status",type:"select"},
								{sSelector:"#joined",type:"select"},
								{sSelector:"#rollno",type: "number-range"},
								{sSelector:"#fname",type:"text"},
								{sSelector:"#lname",type:"text"},
								{sSelector:"#gender",type:"select"},
								{sSelector:"#dob",type:"number-range"},
								{sSelector:"#religion",type:"select"},
								{sSelector:"#community",type:"select"},
								{sSelector:"#mother_maiden_name",type:"text"},
								{sSelector:"#mother_name",type:"text"},
								{sSelector:"#father_name",type:"text"},
								{sSelector:"#parent_income",type:"number-range"},
								{sSelector:"#nationality",type:"select"},
								{sSelector:"#blood_group",type:"select"},
								{sSelector:"#mother_tongue",type:"select"},
								{sSelector:"#language_known",type:"text"},
								{sSelector:"#email",type:"text"},
								{sSelector:"#mobile",type:"text"},
								{sSelector:"#alter_mobile",type:"text"},
								{sSelector:"#parent_email",type:"text"},
								{sSelector:"#parent_mobile",type:"text"},
								{sSelector:"#present_address",type:"text"},
								{sSelector:"#permanent_address",type:"text"},
								{sSelector:"#univ_regno",type:"number-range"},
								{sSelector:"#degree",type:"select"},
								{sSelector:"#course",type:"select"},
								{sSelector:"#branch",type:"select"},
								{sSelector:"#section",type:"select"},
								{sSelector:"#year",type:"select"},
								{sSelector:"#batch",type:"select"},
								{sSelector:"#prev_degree",type:"select"},
								{sSelector:"#prev_course",type:"select"},
								{sSelector:"#prev_branch",type:"select"},
								{sSelector:"#yr_of_passing",type:"number-range"},
								{sSelector:"#course_type",type:"select"},
								{sSelector:"#ins_name",type:"text"},
								{sSelector:"#board_of_education",type:"select"},
								{sSelector:"#cgpa_obtained",type:"number-range"},
								{sSelector:"#percentage",type:"number-range"},
								
					 ]
				});
				//$('#example').hide();
				$('.custo_course_ug').hide();
				$('.custo_course_pg').hide();
				var j = 1;
				$('.custo_degree').change(function(){
					//alert("change");
					$(".custo_degree").each(function(){
						var $this = $(this);
						//alert(j);
						if($this.is(":checked") && $this.attr("id") == 'custo_ug' && j == 1){
							//alert($this.is(":checked") && $this.attr("id") == 'custo_ug');
							$('.custo_course_ug').show();
							//alert(j);
							j++;
							exit;
						}
						else if($this.is(":checked") && $this.attr("id") == 'custo_ug'){
							//alert($this.is(":checked") && $this.attr("id") == 'custo_ug');
							$('.custo_course_ug').show();
						}
						else if($this.is(":checked") && $this.attr("id") == 'custo_pg' && j == 1){
							$('.custo_course_pg').show();
							//alert(j);
							j++;
							exit;
						}
						else if($this.is(":checked") && $this.attr("id") == 'custo_pg'){
							$('.custo_course_pg').show();
						}
						else{
							$('.custo_course_ug').hide();
							$('.custo_course_pg').hide();
						}
					});
			
					/*if (this.id === "custo_ug" && this["name"] === "custo_degree" && this.checked) {
						$('.custo_course_ug').show();
					}
					else{
						$('.custo_course_ug').hide();
					}
					if(this.id === "custo_pg" && this["name"] === "custo_degree" && this.checked){
						$('.custo_course_pg').show();
					}
					else{
						$('.custo_course_pg').hide();
					}*/
				
					$.post('../live_search.php',{key: 'custo_degree',degree_id: $(this).val()},function(data){
						
						//$('#custo_course').append('<label class="Form-label--tick"><input type="checkbox" name="custo_course" class="Form-label-checkbox" value="3" /><span class="Form-label-text"> '+value+'</span></label>');
						$('#custo_course').empty();
						$('#custo_course').append(data);
					}); // $.post() close here
				});
				$('.custo_course').click(function(){
					//alert($(this).val());
					$.post('../live_search.php',{key: 'custo_course',course_id: $(this).val()},function(data){
						$('#custo_branch').append(data);
					}); // $.post() close here
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