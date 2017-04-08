<?php
	include("../../db_con.php");
	include("../function.php");
	if(isset($_SESSION['user_id'])){
		if(isset($_GET['rollno']))
		{
			 global $row;
			 $rollno = $_REQUEST['rollno'];
			 $degree = $_REQUEST['degree'];
			 $course = $_REQUEST['course'];
			 $branch = $_REQUEST['branch'];
			
			$query = "SELECT a.*,p.*,c.*,cu.* FROM admission_details a, stu_personal_details p, stu_contact_details c, current_course cu  WHERE a.admission_no = p.admission_no AND p.stu_rollno = c.stu_rollno AND c.stu_rollno = cu.stu_rollno AND cu.stu_rollno = p.stu_rollno AND p.stu_rollno = $rollno";
			
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con))
			{
				$row = mysqli_fetch_array($run_query);
			}
			else{
				echo mysqli_error($con);
			}
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
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
				<h1>Manage Students
					<small>View Student Record</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Students</a></li>
					<li>View Student Record</li>
				</ol>			
			</section><!--./section header -->
			<section class="content">
			 <div class="row">
				<div class="panel panel-info">
					<div class="panel-heading">Add Student Record</div>
					<div class="panel-body" style="font-size:12px;">
						<form class="" id="student_form" name="student" method="post" action="">
						<!-- Student Personal Details -->
							<div class="frm" id="sf1">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border text-info">Step 1 of 4 <span>(Personal Details)</span></legend>
									
									<div class="from-group" style="margin-top:2%;">
										<label class="col-lg-2 control-label" for="admission_no">Admission No <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="admission_no" class="form-control input-sm" id="admission_no" value="<?php echo $row['admission_no'] ?>" autocomplete="off"  />
										</div><!-- ./lg6-->
										
									</div><!-- ./form group for admissionno-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Admission date -->
									<div class="form-group" style="margin-bottom:0px;">
										<label class="col-lg-2 control-label" for="admission_date">Date Of Admission<span class="text-danger">*</span></label>
										<div class="col-lg-6 input-group" style="margin-left:18%;">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div><!-- ./Input group addon -->
											<input type="text" class="form-control input-sm" name="admission_date"value="<?php echo date('d/m/Y', strtotime($row['admission_date'])); ?>" style="width:94%;" data-inputmask="'alias':'dd/mm/yyyy'" data-mask  />
										</div><!-- ./col-lg-6 and input-group-->
										<label for="admission_date" generated="true" class="error" style="margin-left:18%;"></label>
									</div><!-- ./form-group for admission_date -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<!-- Admission qouta -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="admission_qouta">Admission-Quota <span class="text-danger">*</span></label>
										<div class="col-lg-6 col-sm-5">
											<select class="form-control select2" name="admission_quota" id="admission_quota" data-placeholder=""  >
												<option <?php if($row['admission_quota'] == 'Councelling'){echo 'selected';} ?> >Councelling</option>
												<option <?php if($row['admission_quota'] == 'Management'){echo 'selected';} ?> >Management</option>
											</select>
											<label for="admission_quota" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for admission_qouta -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="rollno">Rollno <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="rollno" class="form-control input-sm" id="rollno" autocomplete="off" value="<?php echo $row['stu_rollno']; ?>"  />
										</div><!-- ./lg6-->
										
									</div><!-- ./form group for rollno-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="fname">FirstName <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="fname" id="fname" value="<?php echo $row['stu_firstname']; ?>" autocomplete="off"  />
										</div><!-- ./lg-6-->
									</div><!-- ./form-group for fname -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="lname">LastName <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="lname" id="lname" value="<?php echo $row['stu_lastname']; ?>" autocomplete="off" />
										</div><!-- ./lg-6 -->
									</div><!-- ./form-group for lname -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="gender">Gender <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<label class="Form-label--tick">
												<input type="radio" name="gender" class="Form-label-radio" value="male" style="margin-top:1%;" <?php echo ($row['stu_gender']=='Male')?'checked':'' ?>  />
												<span class="Form-label-text"> Male</span>
											</label>
											<label class="Form-label--tick" style="margin-top:1%;">
												<input type="radio" name="gender" class="Form-label-radio" value="female" style="margin-top:1%;" <?php echo ($row['stu_gender']=='Female')?'checked':'' ?>  />
												<span class="Form-label-text"> Female</span>
											</label>
											<label class="Form-label--tick" style="margin-top:1%;">
												<input type="radio" name="gender" class="Form-label-radio" value="others" style="margin-top:1%;" <?php echo ($row['stu_gender']=='Others')?'checked':'' ?>  />
												<span class="Form-label-text"> Others</span>
											</label>
											
											<label for="gender" generated="true" class="error" style="font-weight:bold;color:#FF0000;margin-left:7%;"></label>

										</div><!-- ./lg-6-->
									</div><!-- ./form-gropu for Gender -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Date Of birth -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="dob">Date of Birth <span class="text-danger">*</span></label>
										<div class="col-lg-6 input-group" style="margin-left:18%;">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div><!-- ./Input group addon -->
											<input type="text" class="form-control input-sm" value="<?php echo date('d/m/Y', strtotime($row['stu_dob'])); ?>" name="dob" style="width:94%;" data-inputmask="'alias':'dd/mm/yyyy'" data-mask  />
										</div><!-- ./col-lg-6 and input-group-->
										<label for="dob" generated="true" class="error" style="margin-left:18%;"></label>
									</div><!-- ./form-group for DOB -->
									
									<!-- Religion -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="religion">Religion <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="religion" data-placeholder="Select a Religion" >
												<option value="default">--Select--</option>
												<option value="Hindu"<?php if($row['stu_religion'] == 'Hindu'){echo 'selected';} ?>>Hindu</option>
												<option value="Christian" <?php if($row['stu_religion'] == 'Christian'){echo 'selected';} ?>>Christian</option>
												<option value="Islam" <?php if($row['stu_religion'] == 'Islam'){echo 'selected';} ?>>Islam</option>
												<option value="Jain" <?php if($row['stu_religion'] == 'Jain'){echo 'selected';} ?>>Jain</option>
												<option value="Sikhism" <?php if($row['stu_religion'] == 'Sikhism'){echo 'selected';} ?>>Sikhism</option>
											</select>
											<label for="religion" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for religion -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Community -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Community">Community <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="community" data-placeholder="Select a Community"   >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_community'] == 'SC'){echo 'selected';} ?>>SC</option>
												<option <?php if($row['stu_community'] == 'ST'){echo 'selected';} ?>>ST</option>
												<option <?php if($row['stu_community'] == 'BC'){echo 'selected';} ?>>BC</option>
												<option <?php if($row['stu_community'] == 'MBC'){echo 'selected';} ?>>MBC</option>
												<option <?php if($row['stu_community'] == 'Converted To Christian From SC'){echo 'selected';} ?>>Converted Christian from SC</option>
												<option <?php if($row['stu_community'] == 'Denotified Community'){echo 'selected';} ?>>Denotified Community</option>
											</select>
											<label for="community" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for Community -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Nationality -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Nationality">Nationality <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="nationality" data-placeholder="Select a Nationality"  >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_nationality'] == 'Indian'){echo 'selected';} ?>>Indian</option>
												<option <?php if($row['stu_nationality'] == 'Foreigners'){echo 'selected';} ?>>Foreigners</option>
											</select>
											<label for="nationality" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for Nationality -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Blood Group -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="blood_group">Blood Group <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="blood_group" data-placeholder="Select a Blood Group"  >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_blood_group'] == 'A+'){echo 'selected';} ?>>A+</option>
												<option <?php if($row['stu_blood_group'] == 'B-'){echo 'selected';} ?>>A-</option>
												<option <?php if($row['stu_blood_group'] == 'B+'){echo 'selected';} ?>>B+</option>
												<option <?php if($row['stu_blood_group'] == 'B-'){echo 'selected';} ?>>B-</option>
												<option <?php if($row['stu_blood_group'] == 'AB+'){echo 'selected';} ?>>AB+</option>
												<option <?php if($row['stu_blood_group'] == 'AB-'){echo 'selected';} ?>>AB-</option>
												<option <?php if($row['stu_blood_group'] == 'O+'){echo 'selected';} ?>>O+</option>
												<option <?php if($row['stu_blood_group'] == 'O-'){echo 'selected';} ?>>O-</option>
											</select> 
											<label for="blood_group" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
									</div><!-- form-group for Blood Group -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother's Maiden Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_maiden_name">Mother's maiden Name</label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mother_maiden_name" value="<?php echo $row['stu_mother_maiden_name']; ?>" id="mother_maiden_name" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother's maiden Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother's Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_name">Mother's Name <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mother_name" value="<?php echo $row['stu_mother_name']; ?>" id="mother_name" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother's Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Father's's Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_name">Father's Name <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="father_name" value="<?php echo $row['stu_father_name']; ?>" id="father_name" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Father's Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Parent's income -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="parent's_income"> Parent's Income<span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<!-- ₹-->
											<input type="text" class="form-control input-sm" name="demoLakh" value="<?php echo $row['stu_parent_income'] ?>" id="demoLakh" class="demo" data-a-sign="Rs. " data-group="2"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for parent_name -->
									
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother tongue -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_name">Mother Tongue <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="mother_tongue" data-placeholder="Select a Mother Tongue"  >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_mother_tongue'] == 'Tamil'){echo 'selected';} ?>>Tamil</option>
												<option <?php if($row['stu_mother_tongue'] == 'English'){echo 'selected';} ?>>English</option>
												<option <?php if($row['stu_mother_tongue'] == 'Hindi'){echo 'selected';} ?>>Hindi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Bengali'){echo 'selected';} ?>>Bengali</option>
												<option <?php if($row['stu_mother_tongue'] == 'Telugu'){echo 'selected';} ?>>Telugu</option>
												<option <?php if($row['stu_mother_tongue'] == 'Marathi'){echo 'selected';} ?>>Marathi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Urdu'){echo 'selected';} ?>>Urdu</option>
												<option <?php if($row['stu_mother_tongue'] == 'Gujarati'){echo 'selected';} ?>>Gujarati</option>
												<option <?php if($row['stu_mother_tongue'] == 'Kannada'){echo 'selected';} ?>>Kannada</option>
												<option <?php if($row['stu_mother_tongue'] == 'Malayalam'){echo 'selected';} ?>>Malayalam</option>
												<option <?php if($row['stu_mother_tongue'] == 'Odia'){echo 'selected';} ?>>Odia</option>
												<option <?php if($row['stu_mother_tongue'] == 'Punjabi'){echo 'selected';} ?>>Punjabi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Assamese'){echo 'selected';} ?>>Assamese</option>
												<option <?php if($row['stu_mother_tongue'] == 'Kashmiri'){echo 'selected';} ?>>Kashmiri</option>
												<option <?php if($row['stu_mother_tongue'] == 'Nepali'){echo 'selected';} ?>>Nepali</option>
												<option <?php if($row['stu_mother_tongue'] == 'Gondi'){echo 'selected';} ?>>Gondi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Sindhi'){echo 'selected';} ?>>Sindhi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Konkani'){echo 'selected';} ?>>Konkani</option>
												<option <?php if($row['stu_mother_tongue'] == 'Dogri'){echo 'selected';} ?>>Dogri</option>
												<option <?php if($row['stu_mother_tongue'] == 'Khandeshi'){echo 'selected';} ?>>Khandeshi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Kurukh'){echo 'selected';} ?>>Kurukh</option>
												<option <?php if($row['stu_mother_tongue'] == 'Tulu'){echo 'selected';} ?>>Tulu</option>
												<option <?php if($row['stu_mother_tongue'] == 'Manipuri'){echo 'selected';} ?>>Manipuri</option>
												<option <?php if($row['stu_mother_tongue'] == 'Bodo'){echo 'selected';} ?>>Bodo</option>
												<option <?php if($row['stu_mother_tongue'] == 'Khasi'){echo 'selected';} ?>>Khasi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Mundari'){echo 'selected';} ?>>Mundari</option>
												<option <?php if($row['stu_mother_tongue'] == 'Rajasthani'){echo 'selected';} ?>>Rajasthani</option>
												<option <?php if($row['stu_mother_tongue'] == 'Chhattisgarhi'){echo 'selected';} ?>>Chhattisgarhi</option>
												<option <?php if($row['stu_mother_tongue'] == 'Marwari'){echo 'selected';} ?>>Marwari</option>
											</select> 
											<label for="mother_tongue" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother Tongue -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Languages Knowns -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="language known">Languages-Known</label>
										<div class="col-md-3">
											<input type="text" name="lang1" class="form-control input-sm" value="<?php echo $row['stu_langknown_1'] ?>" id="lang1" placeholder="Language 1"  />
										</div>
										<div class="col-md-3">
											<input type="text" name="lang2" class="form-control input-sm" value="<?php echo $row['stu_langknown_2'] ?>" id="lang2" placeholder="Language 2"  />
										</div>
									</div><!-- ./ form-group for Languages known -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-primary open1" value="open1" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
									
								</fieldset><!-- ./fieldset -->
							</div><!-- ./sf1 -->
							
							<!-- sf2 Student Contact details-->	
							<div class="frm" id="sf2" style="display: none;">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border text-info">Step 2 of 4 <span>(Contact Details)</span></legend>
									<!-- Student Email -->
									<div class="form-group" style="margin-top:2%;">
										<label class="col-lg-2 control-label" for="email">E-Mail <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="email" value="<?php echo $row['stu_email']; ?>" id="email"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for email -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Alternative Email -->
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="alter_email">Parent E-Mail</label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="alter_email" value="<?php echo $row['stu_parent_email'] ?>" id="alter_email"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for alter-email -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mobile">Mobile <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mobile" value="<?php echo $row['stu_mobile'] ?>" id="mobile" data-inputmask='"mask": "999-999-9999"' data-mask  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mobile -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Alter-Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="alter_mobile">Alternative Mobile </label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="alter_mobile" value="<?php echo $row['stu_alternative_mobile'] ?>" id="alter_mobile" data-inputmask='"mask": "999-999-9999"' data-mask  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for alter_mobile -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Parents-Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="parent_mobile">Parent's Mobile <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="parent_mobile" value="<?php echo $row['stu_parent_mobile']; ?>" id="parent_mobile" data-inputmask='"mask": "999-999-9999"' data-mask  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for parent_mobile -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group"><label class="col-lg-6 control-label"><h4>Present Address</h4></label></div>
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- House/Apartment No -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="house_no">House/Apartment No <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="house_no" class="form-control input-sm" value="<?php echo $row['stu_pre_houseno']; ?>" id="house_no"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./ form-group for house no-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- street -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="street">Road/Street <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="street" value="<?php echo $row['stu_pre_street']; ?>" class="form-control input-sm" id="street" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./ form-group for Street-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- area -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="area">Area/Landmark <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="area" value="<?php echo $row['stu_pre_area']; ?>" class="form-control input-sm" id="area" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for area-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- City -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="city">City <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="city" class="form-control input-sm" value="<?php echo $row['stu_pre_city']; ?>" id="city"  />
										</div><!-- ./col-lg-6 -->
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for city-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- District -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="district">District <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="district" data-placeholder="Select a District" style="width:100%;" >
												<option <?php if($row['stu_pre_district'] == 'Thiruvarur'){echo 'selected';} ?>>Chennai</option>
												<option <?php if($row['stu_pre_district'] == 'Kancheepuram'){echo 'selected';} ?>>Kancheepuram</option>
												<option <?php if($row['stu_pre_district'] == 'Vellore'){echo 'selected';} ?>>Vellore</option>
												<option <?php if($row['stu_pre_district'] == 'Thiruvallur'){echo 'selected';} ?>>Thiruvallur</option>
												<option <?php if($row['stu_pre_district'] == 'Salem'){echo 'selected';} ?>>Salem</option>
												<option <?php if($row['stu_pre_district'] == 'Viluppuram'){echo 'selected';} ?>>Viluppuram</option>
												<option <?php if($row['stu_pre_district'] == 'Coimbatore'){echo 'selected';} ?>>Coimbatore</option>
												<option <?php if($row['stu_pre_district'] == 'Tirunelveli'){echo 'selected';} ?>>Tirunelveli</option>
												<option <?php if($row['stu_pre_district'] == 'Madurai'){echo 'selected';} ?>>Madurai</option>
												<option <?php if($row['stu_pre_district'] == 'Tiruchirappalli'){echo 'selected';} ?>>Tiruchirappalli</option>
												<option <?php if($row['stu_pre_district'] == 'Cuddalore'){echo 'selected';} ?>>Cuddalore</option>
												<option <?php if($row['stu_pre_district'] == 'Tiruppur'){echo 'selected';} ?>>Tiruppur</option>
												<option <?php if($row['stu_pre_district'] == 'Tiruvannamalai'){echo 'selected';} ?>>Tiruvannamalai</option>
												<option <?php if($row['stu_pre_district'] == 'Thanjavur'){echo 'selected';} ?>>Thanjavur</option>
												<option <?php if($row['stu_pre_district'] == 'Erode'){echo 'selected';} ?>>Erode</option>
												<option <?php if($row['stu_pre_district'] == 'Dindigul'){echo 'selected';} ?>>Dindigul</option>
												<option <?php if($row['stu_pre_district'] == 'Virudhunagar'){echo 'selected';} ?>>Virudhunagar</option>
												<option <?php if($row['stu_pre_district'] == 'Krishnagiri'){echo 'selected';} ?>>Krishnagiri</option>
												<option <?php if($row['stu_pre_district'] == 'Kanniyakumari'){echo 'selected';} ?>>Kanniyakumari</option>
												<option <?php if($row['stu_pre_district'] == 'Thoothukkudi'){echo 'selected';} ?>>Thoothukkudi</option>
												<option <?php if($row['stu_pre_district'] == 'Namakkal'){echo 'selected';} ?>>Namakkal</option>
												<option <?php if($row['stu_pre_district'] == 'Pudukkottai'){echo 'selected';} ?>>Pudukkottai</option>
												<option <?php if($row['stu_pre_district'] == 'Nagapattinam'){echo 'selected';} ?>>Nagapattinam</option>
												<option <?php if($row['stu_pre_district'] == 'Dharmapuri'){echo 'selected';} ?>>Dharmapuri</option>
												<option <?php if($row['stu_pre_district'] == 'Ramanathapuram'){echo 'selected';} ?>>Ramanathapuram</option>
												<option <?php if($row['stu_pre_district'] == 'Sivaganga'){echo 'selected';} ?>>Sivaganga</option>
												<option <?php if($row['stu_pre_district'] == 'Thiruvarur'){echo 'selected';} ?>>Thiruvarur</option>
												<option <?php if($row['stu_pre_district'] == 'Theni'){echo 'selected';} ?>>Theni</option>
												<option <?php if($row['stu_pre_district'] == 'Karur'){echo 'selected';} ?>>Karur</option>
												<option <?php if($row['stu_pre_district'] == 'Ariyalur'){echo 'selected';} ?>>Ariyalur</option>
												<option <?php if($row['stu_pre_district'] == 'Nilgiris'){echo 'selected';} ?>>Nilgiris</option>
												<option <?php if($row['stu_pre_district'] == 'Perambalur'){echo 'selected';} ?>>Perambalur</option>
											</select>
										</div><!-- ./col-lg-6 -->
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for district-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- States -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="state">State <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="select2 form-control" name="state" dataplaceholder="Select a State" style="width:100%;" >
												<option <?php if($row['stu_per_state'] == 'Andhra Pradesh'){echo 'selected';} ?>>Andhra Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Arunachal Pradesh'){echo 'selected';} ?>>Arunachal Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Assam'){echo 'selected';} ?>>Assam</option>
												<option <?php if($row['stu_per_state'] == 'Bihar'){echo 'selected';} ?>>Bihar</option>
												<option <?php if($row['stu_per_state'] == 'Chhattisgarh'){echo 'selected';} ?>>Chhattisgarh</option>
												<option <?php if($row['stu_per_state'] == 'Goa'){echo 'selected';} ?>>Goa</option>
												<option <?php if($row['stu_per_state'] == 'Gujarat'){echo 'selected';} ?>>Gujarat</option>
												<option <?php if($row['stu_per_state'] == 'Haryana'){echo 'selected';} ?>>Haryana</option>
												<option <?php if($row['stu_per_state'] == 'Himachal Pradesh'){echo 'selected';} ?>>Himachal Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Jammu & Kashmir'){echo 'selected';} ?>>Jammu & Kashmir</option>
												<option <?php if($row['stu_per_state'] == 'Jharkhand'){echo 'selected';} ?>>Jharkhand</option>
												<option <?php if($row['stu_per_state'] == 'Karnataka'){echo 'selected';} ?>>Karnataka</option>
												<option <?php if($row['stu_per_state'] == 'Kerala'){echo 'selected';} ?>>Kerala</option>
												<option <?php if($row['stu_per_state'] == 'Madhya Pradesh'){echo 'selected';} ?>>Madhya Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Maharashtra'){echo 'selected';} ?>>Maharashtra</option>
												<option <?php if($row['stu_per_state'] == 'Manipur'){echo 'selected';} ?>>Manipur</option>
												<option <?php if($row['stu_per_state'] == 'Meghalaya'){echo 'selected';} ?>>Meghalaya</option>
												<option <?php if($row['stu_per_state'] == 'Mizoram'){echo 'selected';} ?>>Mizoram</option>
												<option <?php if($row['stu_per_state'] == 'Nagaland'){echo 'selected';} ?>>Nagaland</option>
												<option <?php if($row['stu_per_state'] == 'Odisha'){echo 'selected';} ?>>Odisha</option>
												<option <?php if($row['stu_per_state'] == 'Punjab'){echo 'selected';} ?>>Punjab</option>
												<option <?php if($row['stu_per_state'] == 'Rajasthan'){echo 'selected';} ?>>Rajasthan</option>
												<option <?php if($row['stu_per_state'] == 'Sikkim'){echo 'selected';} ?>>Sikkim</option>
												<option <?php if($row['stu_per_state'] == 'Tamil Nadu'){echo 'selected';} ?>>Tamil Nadu</option>
												<option <?php if($row['stu_per_state'] == 'Telangana'){echo 'selected';} ?>>Telangana</option>
												<option <?php if($row['stu_per_state'] == 'Tripura'){echo 'selected';} ?>>Tripura</option>
												<option <?php if($row['stu_per_state'] == 'Uttar Pradesh'){echo 'selected';} ?>>Uttar Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Uttarakhand'){echo 'selected';} ?>>Uttarakhand</option>
												<option <?php if($row['stu_per_state'] == 'West Bengal'){echo 'selected';} ?>>West Bengal</option>
												<option <?php if($row['stu_per_state'] == 'Puducherry'){echo 'selected';} ?>>Puducherry</option>
												<option <?php if($row['stu_per_state'] == 'Dadra and Nagar Haveli'){echo 'selected';} ?>>Dadra and Nagar Haveli</option>
												<option <?php if($row['stu_per_state'] == 'Daman and Diu'){echo 'selected';} ?>>Daman and Diu</option>
												<option <?php if($row['stu_per_state'] == 'Lakshadweep'){echo 'selected';} ?>>Lakshadweep</option>
												<option <?php if($row['stu_per_state'] == 'Andaman and Nicobar Islands'){echo 'selected';} ?>>Andaman and Nicobar Islands</option>
												<option <?php if($row['stu_per_state'] == 'Chandigarh'){echo 'selected';} ?>>Chandigarh</option>
											</select>
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for States -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Country -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="county">Country <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="country" data-placeholder="Select a country" style="width:100%;" >
												<option <?php if($row['stu_per_country'] == 'India'){echo 'selected';} ?>>India</option>
												<option <?php if($row['stu_per_country'] == 'Pakistan'){echo 'selected';} ?>>Pakistan</option>
												<option <?php if($row['stu_per_country'] == 'SriLanka'){echo 'selected';} ?>>SriLanka</option>
												<option <?php if($row['stu_per_country'] == 'England'){echo 'selected';} ?>>England</option>
												<option <?php if($row['stu_per_country'] == 'China'){echo 'selected';} ?>>China</option>
											</select>
										</div>
									</div><!-- ./form-group fo country -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Pincode -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="pincode">Pincode <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" name="pincode" value="<?php echo $row['stu_pre_pincode']  ?>" id="pincode" data-inputmask='"mask": "999-999"' data-mask  />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for pincode-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<?php
										if($row['stu_pre_houseno'] != $row['stu_per_houseno'] || $row['stu_pre_street'] != $row['stu_per_street'] || $row['stu_pre_district'] != $row['stu_per_district'] || $row['stu_pre_pincode'] != $row['stu_per_pincode'] || $row['stu_pre_area'] != $row['stu_per_area'] || $row['stu_pre_state'] != $row['stu_per_state']){
												$address_same = 'no';
										}
										else{
												$address_same = 'yes';
										}
										
									?>	
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="">If present address same For permanent Address?</label>
										<div class="col-lg-6">
											<label class="Form-label--tick">
												<input type="radio" name="address_same" class="Form-label-radio" value="yes" style="margin-top:1%;" <?php echo ($address_same=='yes')?'checked':'' ?>   />
												<span class="Form-label-text"> Yes</span>
											</label>
											<label class="Form-label--tick" style="margin-top:1%;">
												<input type="radio" name="address_same" class="Form-label-radio" value="no" style="margin-top:1%;" <?php echo ($address_same=='no')?'checked':'' ?>  />
												<span class="Form-label-text"> No</span>
											</label>
										</div><!-- ./lg-6-->
									</div>
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- P e r m a n e n t Address -->
									
									<div class="form-group permanent_address"><label class="col-lg-6 control-label"><h4>Permanent Address</h4></label></div>
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- House/Apartment No1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="house_no1">House/Apartment No <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="house_no1" class="form-control input-sm" value="<?php echo $row['stu_per_houseno']; ?>" id="house_no1"  />
										</div><!-- ./col-lg-6 -->
									
									</div><!-- ./ form-group for house no1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- street1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="street1">Road/Street <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="street1" value="<?php echo $row['stu_per_street']; ?>" class="form-control input-sm" id="street1" autocomplete="off"  />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./ form-group for Street1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- area1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="area1">Area <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="area1" value="<?php echo $row['stu_per_area']; ?>" class="form-control input-sm" id="area1"  />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for area1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- City1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="city1">City <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="city1" class="form-control input-sm" value="<?php echo $row['stu_per_city'];?>" id="city1"  />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for city1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- District1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="district1">District <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="district1" data-placeholder="Select a District" style="width:100%;" >
												<option <?php if($row['stu_per_district'] == 'Chennai'){echo 'selected';} ?>>Chennai</option>
												<option <?php if($row['stu_per_district'] == 'Kancheepuram'){echo 'selected';} ?>>Kancheepuram</option>
												<option <?php if($row['stu_per_district'] == 'Vellore'){echo 'selected';} ?>>Vellore</option>
												<option <?php if($row['stu_per_district'] == 'Thiruvallur'){echo 'selected';} ?>>Thiruvallur</option>
												<option <?php if($row['stu_per_district'] == 'Salem'){echo 'selected';} ?>>Salem</option>
												<option <?php if($row['stu_per_district'] == 'Viluppuram'){echo 'selected';} ?>>Viluppuram</option>
												<option <?php if($row['stu_per_district'] == 'Coimbatore'){echo 'selected';} ?>>Coimbatore</option>
												<option <?php if($row['stu_per_district'] == 'Tirunelveli'){echo 'selected';} ?>>Tirunelveli</option>
												<option <?php if($row['stu_per_district'] == 'Madurai'){echo 'selected';} ?>>Madurai</option>
												<option <?php if($row['stu_per_district'] == 'Tiruchirappalli'){echo 'selected';} ?>>Tiruchirappalli</option>
												<option <?php if($row['stu_per_district'] == 'Cuddalore'){echo 'selected';} ?>>Cuddalore</option>
												<option <?php if($row['stu_per_district'] == 'Tiruppur'){echo 'selected';} ?>>Tiruppur</option>
												<option <?php if($row['stu_per_district'] == 'Tiruvannamalai'){echo 'selected';} ?>>Tiruvannamalai</option>
												<option <?php if($row['stu_per_district'] == 'Thanjavur'){echo 'selected';} ?>>Thanjavur</option>
												<option <?php if($row['stu_per_district'] == 'Erode'){echo 'selected';} ?>>Erode</option>
												<option <?php if($row['stu_per_district'] == 'Dindigul'){echo 'selected';} ?>>Dindigul</option>
												<option <?php if($row['stu_per_district'] == 'Virudhunagar'){echo 'selected';} ?>>Virudhunagar</option>
												<option <?php if($row['stu_per_district'] == 'Krishnagiri'){echo 'selected';} ?>>Krishnagiri</option>
												<option <?php if($row['stu_per_district'] == 'Kanniyakumari'){echo 'selected';} ?>>Kanniyakumari</option>
												<option <?php if($row['stu_per_district'] == 'Thoothukkudi'){echo 'selected';} ?>>Thoothukkudi</option>
												<option <?php if($row['stu_per_district'] == 'Namakkal'){echo 'selected';} ?>>Namakkal</option>
												<option <?php if($row['stu_per_district'] == 'Pudukkottai'){echo 'selected';} ?>>Pudukkottai</option>
												<option <?php if($row['stu_per_district'] == 'Nagapattinam'){echo 'selected';} ?>>Nagapattinam</option>
												<option <?php if($row['stu_per_district'] == 'Dharmapuri'){echo 'selected';} ?>>Dharmapuri</option>
												<option <?php if($row['stu_per_district'] == 'Ramanathapuram'){echo 'selected';} ?>>Ramanathapuram</option>
												<option <?php if($row['stu_per_district'] == 'Sivaganga'){echo 'selected';} ?>>Sivaganga</option>
												<option <?php if($row['stu_per_district'] == 'Thiruvarur'){echo 'selected';} ?>>Thiruvarur</option>
												<option <?php if($row['stu_per_district'] == 'Theni'){echo 'selected';} ?>>Theni</option>
												<option <?php if($row['stu_per_district'] == 'Karur'){echo 'selected';} ?>>Karur</option>
												<option <?php if($row['stu_per_district'] == 'Ariyalur'){echo 'selected';} ?>>Ariyalur</option>
												<option <?php if($row['stu_per_district'] == 'Nilgiris'){echo 'selected';} ?>>Nilgiris</option>
												<option <?php if($row['stu_per_district'] == 'Perambalur'){echo 'selected';} ?>>Perambalur</option>
											</select>
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for district1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- States -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="state1">State <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="select2 form-control input-sm" name="state1" dataplaceholder="Select a State1" style="width:100%;" >
												<option <?php if($row['stu_per_state'] == 'Andhra Pradesh'){echo 'selected';} ?>>Andhra Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Arunachal Pradesh'){echo 'selected';} ?>>Arunachal Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Assam'){echo 'selected';} ?>>Assam</option>
												<option <?php if($row['stu_per_state'] == 'Bihar'){echo 'selected';} ?>>Bihar</option>
												<option <?php if($row['stu_per_state'] == 'Chhattisgarh'){echo 'selected';} ?>>Chhattisgarh</option>
												<option <?php if($row['stu_per_state'] == 'Goa'){echo 'selected';} ?>>Goa</option>
												<option <?php if($row['stu_per_state'] == 'Gujarat'){echo 'selected';} ?>>Gujarat</option>
												<option <?php if($row['stu_per_state'] == 'Haryana'){echo 'selected';} ?>>Haryana</option>
												<option <?php if($row['stu_per_state'] == 'Himachal Pradesh'){echo 'selected';} ?>>Himachal Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Jammu & Kashmir'){echo 'selected';} ?>>Jammu & Kashmir</option>
												<option <?php if($row['stu_per_state'] == 'Jharkhand'){echo 'selected';} ?>>Jharkhand</option>
												<option <?php if($row['stu_per_state'] == 'Karnataka'){echo 'selected';} ?>>Karnataka</option>
												<option <?php if($row['stu_per_state'] == 'Kerala'){echo 'selected';} ?>>Kerala</option>
												<option <?php if($row['stu_per_state'] == 'Madhya Pradesh'){echo 'selected';} ?>>Madhya Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Maharashtra'){echo 'selected';} ?>>Maharashtra</option>
												<option <?php if($row['stu_per_state'] == 'Manipur'){echo 'selected';} ?>>Manipur</option>
												<option <?php if($row['stu_per_state'] == 'Meghalaya'){echo 'selected';} ?>>Meghalaya</option>
												<option <?php if($row['stu_per_state'] == 'Mizoram'){echo 'selected';} ?>>Mizoram</option>
												<option <?php if($row['stu_per_state'] == 'Nagaland'){echo 'selected';} ?>>Nagaland</option>
												<option <?php if($row['stu_per_state'] == 'Odisha'){echo 'selected';} ?>>Odisha</option>
												<option <?php if($row['stu_per_state'] == 'Punjab'){echo 'selected';} ?>>Punjab</option>
												<option <?php if($row['stu_per_state'] == 'Rajasthan'){echo 'selected';} ?>>Rajasthan</option>
												<option <?php if($row['stu_per_state'] == 'Sikkim'){echo 'selected';} ?>>Sikkim</option>
												<option <?php if($row['stu_per_state'] == 'Tamil Nadu'){echo 'selected';} ?>>Tamil Nadu</option>
												<option <?php if($row['stu_per_state'] == 'Telangana'){echo 'selected';} ?>>Telangana</option>
												<option <?php if($row['stu_per_state'] == 'Tripura'){echo 'selected';} ?>>Tripura</option>
												<option <?php if($row['stu_per_state'] == 'Uttar Pradesh'){echo 'selected';} ?>>Uttar Pradesh</option>
												<option <?php if($row['stu_per_state'] == 'Uttarakhand'){echo 'selected';} ?>>Uttarakhand</option>
												<option <?php if($row['stu_per_state'] == 'West Bengal'){echo 'selected';} ?>>West Bengal</option>
												<option <?php if($row['stu_per_state'] == 'Puducherry'){echo 'selected';} ?>>Puducherry</option>
												<option <?php if($row['stu_per_state'] == 'Dadra and Nagar Haveli'){echo 'selected';} ?>>Dadra and Nagar Haveli</option>
												<option <?php if($row['stu_per_state'] == 'Daman and Diu'){echo 'selected';} ?>>Daman and Diu</option>
												<option <?php if($row['stu_per_state'] == 'Lakshadweep'){echo 'selected';} ?>>Lakshadweep</option>
												<option <?php if($row['stu_per_state'] == 'Andaman and Nicobar Islands'){echo 'selected';} ?>>Andaman and Nicobar Islands</option>
												<option <?php if($row['stu_per_state'] == 'Chandigarh'){echo 'selected';} ?>>Chandigarh</option>
											</select>
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./form-group for States1 -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Country -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="county1">Country <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="country1" data-placeholder="Select a country" style="width:100%;" >
												<option <?php if($row['stu_per_country'] == 'India'){echo 'selected';} ?>>India</option>
												<option <?php if($row['stu_per_country'] == 'Pakistan'){echo 'selected';} ?>>Pakistan</option>
												<option <?php if($row['stu_per_country'] == 'SriLanka'){echo 'selected';} ?>>SriLanka</option>
												<option <?php if($row['stu_per_country'] == 'England'){echo 'selected';} ?>>England</option>
												<option <?php if($row['stu_per_country'] == 'China'){echo 'selected';} ?>>China</option>
											</select>
										</div>
									</div><!-- ./form-group fo country -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Pincode1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="pincode1">Pincode <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" name="pincode1" value="<?php echo $row['stu_per_pincode']; ?>" id="pincode1" data-inputmask='"mask": "999-999"' data-mask  />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for pincode1-->
									
									<!-- ./Permanent Address -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back2" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<button class="btn btn-primary open2" value="open2" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
									
								</fieldset><!-- ./fieldset -->
							</div><!-- ./sf2 -->
							
							<!-- sf3 Academic Details -->
							<div class="frm" id="sf3">
								<fieldset class="scheduler-border">
									<legend class="scheduler-border text-info">Step 3 of 4 <sapn>(Academic Details)</sapn></legend>
									
									<!-- University Register Number -->
									<div class="form-group" style="margin-top:2%;">
										<label class="col-lg-2 control-label" for="Univ_regno">University Reg.no <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" name="univ_regno" class="form-control input-sm" value="<?php echo $row['stu_univ_regno'] ?>" id="univ_regno"  />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for Univ Reg no -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="join_mode">Joined <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="join_mode" id="join_mode" data-placeholder="" >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_joined'] == 'Regular'){echo 'selected';} ?>>Regular</option>
												<option <?php if($row['stu_joined'] == 'Lateral Entry'){echo 'selected';} ?>>Lateral Entry</option>
											</select>
											<label for="curr_degree" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for join_mode-->
									
									<div class="clearfix" style="height: 8px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="course_type">Course-Type <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="course_type" id="course_type" data-placeholder="" >
												<option value="default">--Select--</option>
												<option <?php if($row['stu_course_type'] == 'Fulltime'){echo 'selected';} ?>>Fulltime</option>
												<option <?php if($row['stu_course_type'] == 'Part Time'){echo 'selected';} ?>>Part Time</option>
											</select>
											<!--<label for="curr_degree" generated="true" class="error"></label>-->
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for course_type-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Degree This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="degree">Degree <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_degree" id="curr_degree" data-placeholder="" >
												<option value="default">--Select--</option>
												<?php
													$query1 = "SELECT degree_id,degree_name FROM degree WHERE degree_name != 'X' AND degree_name != 'XII';";
													$run_query1 = mysqli_query($con, $query1);
													while($row1 = mysqli_fetch_array($run_query1))
													{	
														echo $degree; 
														if($row1['degree_name'] == $degree){
															$degree_id = $row1['degree_id'];
															echo "<option value=".$row1['degree_id']." name = '".$row1['degree_name']."' selected>".$row1['degree_name']."</option>";
														}															
														else{
															echo "<option value=".$row1['degree_id']." name = '".$row1['degree_name']."'>".$row1['degree_name']."</option>";
														}
													}
												?>
											</select>
											
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for degree-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Course This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="course">Course <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_course" id="curr_course" data-placeholder="" >
												<option value="default">--Select--</option>
													<?php
														$query2 = "SELECT course_id,course_name FROM courses WHERE degree_id=$degree_id";
														$run_query2 = mysqli_query($con, $query2);
														
														while($row2 = mysqli_fetch_array($run_query2))
														{	
															if($row2['course_name'] == $course){
																$course_id = $row2['course_id'];
																echo "<option value=".$row2['course_id']." name = '".$row2['course_name']."' selected>".$row2['course_name']."</option>";
															}
															else{
																echo "<option value=".$row2['course_id']." name = '".$row2['course_name']."'>".$row2['course_name']."</option>";
															}
														}			
														
													?>
											  </select>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for course-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Branch This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="branch">Branch <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_branch" id="curr_branch" data-placeholder="" >
												<option value="default">--Select--</option>
												<?php
													$query3 = "SELECT branch_id,branch_name FROM branch WHERE course_id=$course_id ";
													$run_query3 = mysqli_query($con, $query3);
													
													while($row3 = mysqli_fetch_array($run_query3))
													{
														if($row3['branch_name'] == $branch){
															echo "<option value = ".$row3['branch_id']." selected>".$row3['branch_name']."</option>";
														}
														else{
														echo "<option value = ".$row3['branch_id'].">".$row3['branch_name']."</option>";
														}
													}			
													
												?>
											</select>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for branch-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="section">Section</label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" value="<?php echo $row['stu_section'] ?>" name="curr_section" id="curr_section"  />
										</div><!-- ./col-lg-3 -->
									</div><!-- ./form-group for section -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back3" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<button class="btn btn-primary open3" value="open3" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
								</fieldset><!--./fieldset -->
							</div><!-- ./sf3 -->
							<!-- ./sf3 end here-->
							
							<!-- sft4 Start Here for Student perivious Academic details -->
							<div class="frm" id="sf4">
								<fieldset id="" class="scheduler-border" style="width:auto">
									<legend class="scheduler-border text-info">Step 4 of 4 <sapn>(Previous Academic Details)</sapn></legend>
									<!-- Rollno -->
									<!--<div class="form-group">
										<button class="btn btn-info" type="button" name="add_row" id="add_row" >Add Row</button>
										<button class="btn btn-warning" type="button" name="remove_row" id="remove_row">Remove Row</button>
									</div>--><!-- ./form-group for buttons -->	
									<div class="form-group">
										<table class="table table-bordered" id="example1" style="margin-top:1px;">
											<thead>
												<tr>
													<td>Rollno</td>
													<td colspan=""><input type="text" class="form-control input-sm" disabled="disabled" value="<?php echo $row['stu_rollno'] ?>" /></td>
													<td colspan="9">
														<button class="btn btn-info" type="button" name="add_row" id="add_row" >Add Row</button>
														<button class="btn btn-warning" type="button" name="remove_row" id="remove_row">Remove Row</button>
													</td>
												</tr>
												<tr>
													<th>Degree</th>
													<th>Course</th>
													<th>Branch</th>
													<th>Yr of Passing</th>
													<th>Course Type</th>
													<th>Name Of the Institution</th>
													<th>Board of Education/University Name</th>
													<th>CGPA/Marks Obtained</th>
													<th>Total Marks/CGPA</th>
													<th>Percentage</th>
												</tr>
												
											</thead>
											<tbody>
												<?php
													 $query4 = "SELECT * FROM `prev_academic_details` WHERE stu_rollno = ".$row['stu_rollno'];
													$run_query4 = mysqli_query($con, $query4);
													$j = 10;
													while($rows = mysqli_fetch_array($run_query4)){
																										
														?>
														
														<tr>
															<td><select class="form-control select2" name="<?php echo 'prev_degree'.$j?>" style="width:100%">
																<option selected = "selected"><?php echo $rows['prev_degree']; ?></option>
															</select></td>
															<?php
															if($rows['prev_degree'] == 'X'){
															?>
																
															<td><select class="form-control select2 input-sm" name="<?php echo "prev_course".$j; ?>" id="<?php echo $rows['prev_degree']."_course"; ?>" style="width:100%">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_course']=='Secondary'){echo "selected";} ?>>Secondary</option>
																</select>
															</td>	
															<td ><select class="form-control select2 input-sm" name="<?php echo "prev_branch".$j; ?>" id="<?php echo $rows['prev_degree']."_branch"; ?>" style="width:100%;">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_branch']=='Common'){echo "selected";} ?>>Common</option>
																</select>
															</td>
																
														<?php	
														} // if close for X
														else if($rows['prev_degree'] == 'XII')	{
															?>
															
															<td><select class="form-control select2 input-sm" name="<?php echo "prev_course".$j; ?>" id="<?php echo $rows['prev_degree']."_course"; ?>" style="width:100%">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_course']=='Higher Secondary'){echo "selected";} ?>>Higher Secondary</option>
																</select>
															</td>
															<td ><select class="form-control select2 input-sm" name="<?php echo "prev_branch".$j; ?>" id="<?php echo $rows['prev_degree']."_branch"; ?>" style="width:100%;">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_branch']=='Physics, Chemistry, Maths, Biology(PCMB)'){echo "selected";} ?>>Physics, Chemistry, Maths, Biology(PCMB)</option>
																	<option <?php if($rows['prev_branch']=='Physics, Chemistry, Biology(PCB)'){echo "selected";} ?>>Physics, Chemistry, Biology(PCB)</option>
																	<option <?php if($rows['prev_branch']=='Physics, Chemistry, Maths(PCM)'){echo "selected";} ?>>Physics, Chemistry, Maths(PCM)</option>
																	<option <?php if($rows['prev_branch']=='Chemistry, Maths, Computerscience'){echo "selected";} ?>>Chemistry, Maths, Computerscience</option>
																	<option <?php if($rows['prev_branch']=='Economics, commerce'){echo "selected";} ?>>Economics, commerce</option>
																	<option></option>
																</select>
															</td>
															
														<?php
														}// Else if close for XII	
														else if($rows['prev_degree'] == 'UG'){
															
															?>
															<td><select class="form-control select2 input-sm" name="<?php echo "prev_course".$j; ?>" id="<?php echo $rows['prev_degree']."_course"; ?>" style="width:100%">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_course']=='Bachelor Hotel Management and Catering Technology(B.H.M.C.T)'){echo "selected";} ?>>Bachelor Hotel Management and Catering Technology(B.H.M.C.T)</option>
																	<option <?php if($rows['prev_course']=='Bachelor Library Science(B.L.Sc)'){echo "selected";} ?>>Bachelor Library Science(B.L.Sc)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Applied Sciences(B.A.S)'){echo "selected";} ?>>Bachelor of Applied Sciences(B.A.S)</option> 
																	<option <?php if($rows['prev_course']=='Bachelor of Architecture(B.Arch)'){echo "selected";} ?>>Bachelor of Architecture(B.Arch)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Education(B.Ed)'){echo "selected";} ?>>Bachelor of Education(B.Ed)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Law(LLB)'){echo "selected";} ?>>Bachelor of Law(LLB)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Arts(B.A)'){echo "selected";} ?>>Bachelor of Arts(B.A)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Audiology and Speech Language Pathology(B.A.S.L.P)'){echo "selected";} ?>>Bachelor of Audiology and Speech Language Pathology(B.A.S.L.P)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Ayurvedic Medicine and Surgery(B.A.M.S)'){echo "selected";} ?>>Bachelor of Ayurvedic Medicine and Surgery(B.A.M.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Business Administration Bachelor of Law(B.B.A LL.B)'){echo "selected";} ?>>Bachelor of Business Administration Bachelor of Law(B.B.A LL.B)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Business Administration(B.B.A)'){echo "selected";} ?>>Bachelor of Business Administration(B.B.A)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Business Management(B.B.M)'){echo "selected";} ?>>Bachelor of Business Management(B.B.M)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Business Studies(B.B.S)'){echo "selected";} ?>>Bachelor of Business Studies(B.B.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Commerce(B.Com)'){echo "selected";} ?>>Bachelor of Commerce(B.Com)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Communication Journalism(B.C.J)'){echo "selected";} ?>>Bachelor of Communication Journalism(B.C.J)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Computer Applications(B.C.A)'){echo "selected";} ?>>Bachelor of Computer Applications(B.C.A)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Computer Science(B.C.S)'){echo "selected";} ?>>Bachelor of Computer Science(B.C.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Dental Surgery(B.D.S)'){echo "selected";} ?>>Bachelor of Dental Surgery(B.D.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Design(B.Des)'){echo "selected";} ?>>Bachelor of Design(B.Des)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of education in Artificial Intelligence(B.Ed AI)'){echo "selected";} ?>>Bachelor of education in Artificial Intelligence(B.Ed AI)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Electronic Science(B.E.S)'){echo "selected";} ?>>Bachelor of Electronic Science(B.E.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Elementary Education(B.EL.Ed)'){echo "selected";} ?>>Bachelor of Elementary Education(B.EL.Ed)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Engineering(B.E)'){echo "selected";} ?>>Bachelor of Engineering(B.E)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Fashion Technology(B.F.Tech)'){echo "selected";} ?>>Bachelor of Fashion Technology(B.F.Tech)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Financial Investment and Analysis(B.F.I.A)'){echo "selected";} ?>>Bachelor of Financial Investment and Analysis(B.F.I.A)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Fine Arts(B.F.A)'){echo "selected";} ?>>Bachelor of Fine Arts(B.F.A)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Fishery Sciences(B.F.S)'){echo "selected";} ?>>Bachelor of Fishery Sciences(B.F.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of General Law(B.G.L)'){echo "selected";} ?>>Bachelor of General Law(B.G.L)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Homeopathic Medicine & Surgery(B.H.M.S)'){echo "selected";} ?>>Bachelor of Homeopathic Medicine & Surgery(B.H.M.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Hospitality and Tourism Management(B.H.T.M)'){echo "selected";} ?>>Bachelor of Hospitality and Tourism Management(B.H.T.M)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Hotel Management(B.H.M)'){echo "selected";} ?>>Bachelor of Hotel Management(B.H.M)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Information Systems Management(B.I.S.M)'){echo "selected";} ?>>Bachelor of Information Systems Management(B.I.S.M)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Labour Management(B.L.M)'){echo "selected";} ?>>Bachelor of Labour Management(B.L.M)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Law(LL.B)'){echo "selected";} ?>>Bachelor of Law(LL.B)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Laws(B.L)'){echo "selected";} ?>>Bachelor of Laws(B.L)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Library and Information Science(B.L.I.S)'){echo "selected";} ?>>Bachelor of Library and Information Science(B.L.I.S)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Literature(B.Lit)'){echo "selected";} ?>>Bachelor of Literature(B.Lit)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Medical Laboratory Technology(B.M.L.T)'){echo "selected";} ?>>Bachelor of Medical Laboratory Technology(B.M.L.T)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Medical Record Science(B.M.R.Sc)'){echo "selected";} ?>>Bachelor of Medical Record Science(B.M.R.Sc)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Medical Technology(B.M.T)'){echo "selected";} ?>>Bachelor of Medical Technology(B.M.T)</option>
																	<option <?php if($rows['prev_course']=='Bachelor of Science(B.Sc)'){echo "selected";} ?>>Bachelor of Science(B.Sc)</option>
																	<option <?php if($rows['prev_course']=='Bachelors of Technology(B.Tech)'){echo "selected";} ?>>Bachelors of Technology(B.Tech)</option>
																</select>
															</td>
															<td ><input type="text" class="form-control input-sm" name="<?php echo "prev_branch".$j; ?>" id="<?php echo $rows['prev_degree']."_branch"; ?>" value="<?php echo $rows['prev_branch'] ?>" style="width:100%;" />
											
															</td>
														<?php
														} // Else if close for UG
														else if($rows['prev_degree'] == 'PG'){
															?>
															<td><select class="form-control select2 input-sm" name="<?php echo "prev_course".$j; ?>" id="<?php echo $rows['prev_degree']."_course"; ?>" style="width:100%">
																
																	<?php 
																		
																		$fo = fopen('../txt_files/pg_courses.txt', 'r');
																		while(!feof($fo)){
																			if($rows['prev_course']== fgets($fo)){
																				echo "<option value = ".fgets($fo)." selected>".fgets($fo)."</option>";
																			}
																			else{
																				echo "<option value = ".fgets($fo).">".fgets($fo)."</option>";
																			}
																		} // While close here
																	?>
																</select>
															</td>
															<td ><select class="form-control select2 input-sm" name="<?php echo "prev_branch".$j; ?>" id="<?php echo $rows['prev_degree']."_branch"; ?>" style="width:100%;">
																	<option value="default">--Select--</option>
																	<option></option>
																</select>
															</td>
														<?php	
														}// Else if close for pg
														else if($rows['prev_degree'] == 'DIPLOMA'){
															?>
															<td><input type="text" class="form-control input-sm" name="<?php echo "prev_course".$j; ?>" value="<?php echo $rows['prev_course']; ?>" />
															</td>
															<td ><select class="form-control select2 input-sm" name="<?php echo "prev_branch".$j; ?>" id="<?php echo $rows['prev_degree']."_branch"; ?>" style="width:100%;">
																	<option value="default">--Select--</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Mechanical Engineering'){echo "selected";} ?>>Diploma in Mechanical Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Civil Engineering'){echo "selected";} ?>>Diploma in Civil Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Electrical Engineering'){echo "selected";} ?>>Diploma in Electrical Engineering</option> 
																	<option <?php if($rows['prev_branch']=='Diploma In Computer Engineering'){echo "selected";} ?>>Diploma in Computer Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Aeronatical Engineering'){echo "selected";} ?>>Diploma in Aeronatical Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Chemical Engineering'){echo "selected";} ?>>Diploma in Chemical Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Software Engineering'){echo "selected";} ?>>Diploma in Software Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Mining Engineering'){echo "selected";} ?>>Diploma in Mining Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Petroleum Engineering'){echo "selected";} ?>>Diploma in Petroleum Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Fine Arts Engineering'){echo "selected";} ?>>Diploma in Fine Arts Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Mechatronics'){echo "selected";} ?>>Diploma in Mechatronics</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Texttile Technology'){echo "selected";} ?>>Diploma in Texttile Technology</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Automobile Engineering'){echo "selected";} ?>>Diploma in Automobile Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Biomedical Engineering'){echo "selected";} ?>>Diploma in Biomedical Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Electrical and Electronics Engineering'){echo "selected";} ?>>Diploma in Electrical and Electronics Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Environmental Engineering'){echo "selected";} ?>>Diploma in Environmental Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Fasion Technology'){echo "selected";} ?>>Diploma in Fasion Technology</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Fire Engineering'){echo "selected";} ?>>Diploma in Fire Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Fire Safety Engineering'){echo "selected";} ?>>Diploma in Fire Safety Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Architeture Engineering'){echo "selected";} ?>>Diploma in Architeture Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Ceramic Engineering'){echo "selected";} ?>>Diploma in Ceramic Engineering</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Computer Science and Technology'){echo "selected";} ?>>Diploma in Computer Science and Technology</option>
																	<option <?php if($rows['prev_branch']=='Diploma In Computer Science and Engineering'){echo "selected";} ?>>Diploma in Computer Science and Engineering</option>
																	<option></option>
																</select>
															</td>
														<?php	
														}// Else if close for Diploma
															?>
															<td><input type="text" name="<?php echo "prev_duration_from".$j; ?>" value="<?php echo $rows['year_of_passing'] ?>" id="<?php echo $rows['prev_degree']."_duration_from"; ?>" class="form-control input-sm year_mask" /></td>
															
															<td><select class="form-control select2 input-sm" name="<?php echo "prev_course_type".$j; ?>" id="<?php echo $rows['prev_degree']."_course_type";?>"  style="width:100%;">
																<option value="default">--Select--</option>
																<option <?php if($rows['course_type']=='Fulltime'){echo 'selected';} ?>>Fulltime</option>
																<option <?php if($rows['course_type']=='Part Time'){echo 'selected';} ?>>Part Time</option>
															</select></td>
															<td><input type="text" name="<?php echo "prev_ins_name".$j; ?>" id="<?php echo $rows['prev_degree']."_ins_name" ?>" value="<?php echo $rows['ins_name'] ?>" class="form-control input-sm" /></td>
															<?php
															/* This followinf if check Wheter Previous degree X or XII which purpose of These Two degrees Belongs to Board of edcation */
																if($rows['prev_degree'] == 'XII' || $rows['prev_degree'] == 'X'){
																	?>
																	<td><select class="form-control select2 input-sm" name="<?php echo "prev_board".$j; ?>" id="<?php echo $rows['prev_degree']."_board" ?>" style="width:100%;">
																<option value="default">--Select--</option>
																<option <?php if($rows['board_of_education']=='State Board'){echo 'selected';} ?>>State Board</option>
																<option <?php if($rows['board_of_education']=='CBSE'){echo 'selected';} ?>>CBSE</option>
																<option <?php if($rows['board_of_education']=='Anglo Indian'){echo 'selected';} ?>>Anglo Indian</option>
															</select></td>
																
																<?php
																} // If close here
																if($rows['prev_degree'] == 'UG' || $rows['prev_degree'] == 'PG' || $rows['prev_degree'] == 'DIPLOMA'){
																
																	?>
																	<td><input type="text" class="form-control input-sm" name="<?php echo "prev_board".$j; ?>" value="<?php echo $rows['board_of_education']; ?>" /></td>	
																<?php
																	
																}
															?>
															
															<td><input type="text" name="<?php echo "prev_cgpa_marks".$j; ?>" id="<?php echo $rows['prev_degree']."_cgpa_marks"; ?>" value="<?php echo $rows['cgpa_obtained'] ?>" class="form-control input-sm" /></td>
															<td><input type="text" name="<?php echo "prev_total_cgpa_marks".$j; ?>" id="<?php echo $rows['prev_degree']."_total_cgpa_marks"; ?>" value="<?php echo $rows['total_marks'] ?>" class="form-control input-sm" /></td>
															<td><input type="text" name="<?php echo "prev_percentage".$j; ?>" id="<?php echo $rows['prev_degree']."_percentage"; ?>" value="<?php echo $rows['percentage'] ?>" class="form-control input-sm" /></td>
												</tr>
														
													<?php	
													$j++;
													} // While Looop Close Here
												
												?>
												
											</tbody>
											<tfoot>
												
											</tfoot>
										</table>
									</div>
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back4" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<img src="../../dist/img/ajax-loader.gif" alt="" id="loader" style="display: none">
										</div>
									</div><!-- ./form group for button -->
								
								</fieldset>
							</div><!-- ./sf4 -->
						</form><!-- ./form -->
					</div><!-- ./panel-body -->
					<div class="panel-footer">
						<?php
							//var_dump($ug_course);
						?>
					</div><!-- ./panel footer -->
				</div><!-- ./panel -->
			</div><!-- ./row -->	
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
		  $("#example1").find("input,button,textarea,select").attr("disabled", "disabled");
		  $("#sf1").find("input,textarea,select").attr("disabled", "disabled");
		  $("#sf2").find("input,textarea,select").attr("disabled", "disabled");
		  $("#sf3").find("input,textarea,select").attr("disabled", "disabled");
	  	var scroll=$(window).scrollTop();
		var scrollbottom = $(window).scrollTop() + $(window).height();
		var icnt = 0;
        //Initialize Select2 Elements
        $(".select2").select2();
		
		 //Money Euro
        $("[data-mask]").inputmask();
        $(".year_mask").inputmask("y", {
			alias: "date",    
			placeholder: "yyyy",
			yearrange: { minyear: 1900, maxyear: (new Date()).getFullYear() }
		});
       
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
			 $('#demoLakh').autoNumeric('init'); 
			 var radio_value = $('input:radio[name=address_same]:checked').val();	
				if(radio_value == "no")
				{
					//alert(radio_value);
					$(".permanent_address").show();
				}
				else if(radio_value == "yes")
				{
					//alert(radio_value);
					$(".permanent_address").hide();
				}
			//$(".permanent_address").hide();
			$("#sf3").hide();
			$("#sf4").hide();
			$(".open1, .open2, .open3, .open4").click(function() {
			
				var clicked = $(this).attr("value");
				//alert(clicked);
				// define Custom Methods these methods always placed on before Validate();
				jQuery.validator.addMethod("lettersonly", function(value, element) {
				  return this.optional(element) || /^[a-z\s]+$/i.test(value);
				}, "Letters only please"); 
				
				jQuery.validator.addMethod("valueNotEquals", function(value, element, arg){
				  return arg != value;
				 }, "Value must not equal arg.");
				 
				 $.validator.addMethod(
						"indianDate",
						function(value, element) {
							// put your own logic here, this is just a (crappy) example
							return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
						},
						"Please enter a date in the format dd/mm/yyyy."
					);
				 
				 $.validator.addMethod("email_not_same", function(value, element) {
   					return $('#email').val() != $('#alter_email').val()
					},
					"E-Mail and parent e-mail Should not be same."
				);
				
				$.validator.addMethod("mobile_not_same", function(value, element) {
   					return $('#mobile').val() != $('#parent_mobile').val()
					},
					"Mobile and parent mobile should not be same."
				); 
				
				 var ruleSet1 = {
									required: true,
									minlength: 3,
									lettersonly: true
								};
				 							
				// validate form on keyup and submit
				
				if(clicked == "open1")
				{
					$(window).scrollTop(scroll);
					$(".frm").hide("fast");
					$("#sf2").show("slow");
				}
				else if(clicked == "open2")
				{
					$(window).scrollTop(scroll);
					$(".frm").hide("fast");
					$("#sf3").show("slow");
				}
				else if(clicked == "open3")
				{
					$(window).scrollTop(scroll);
					$(".frm").hide("fast");
					$("#sf4").show("slow");
				}
				else
				{
					
				}	
			
			});// click event close
			
			$(".back2").click(function() {
			  $(".frm").hide("fast");
			  $("#sf1").show("slow");
			});
		
			$(".back3").click(function() {
			  $(".frm").hide("fast");
			  $("#sf2").show("slow");
			});	
			$(".back4").click(function() {
			  $(".frm").hide("fast");
			  $("#sf3").show("slow");
			});
			
			/*$('#remove_row').attr('disabled',true);
			$('#add_row').click(function(){
	  		//alert("clicked");
	  		if(icnt <= 3)
			{
				alert(icnt);
				icnt=icnt+1;
				var append_element = '<tr id="row'+icnt+'"><td style="text-align:center;font-weight: bold;"><select class="form-control input-sm select2" name="prev_degree'+icnt+'"><option>PG</option><option>UG</option><option>Diplomo</option></select></td><td><select class="form-control select2 input-sm" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;"><option value="default">--Select--</option><option>Bachelor of Computer Science</option><option>Common</option></select></td><td><select class="form-control select2 input-sm" name="prev_branch'+icnt+'" id="prev_branch'+icnt+'" style="width:100%;"><option value="default">--Select--</option><option>Common</option><option>Common</option></select></td> <td><input type="text" name="prev_duration_from'+icnt+'" id="prev_duration_from'+icnt+'" class="form-control input-sm year_mask" data-inputmask='+'"'+"'alias':'dd/mm/yyyy'"+'"'+' data-mask /></td><td><select class="form-control select2 input-sm" name="prev_course_type'+icnt+'" id="prev_course_type'+icnt+'" style="width:100%;"><option value="default">--Select--</option><option>Fulltime</option></select></td><td><input type="text" name=prev_ins_name'+icnt+'" id="prev_ins_name'+icnt+'" class="form-control input-sm" /></td><td><select class="form-control select2 input-sm" name="prev_board'+icnt+'" id="prev_board'+icnt+'" style="width:100%;"><option value="default">--Select--</option><option>State Board</option></select></td><td><input type="text" name="prev_cgpa_marks'+icnt+'" id="prev_cgpa_marks'+icnt+'" value="" class="form-control input-sm" /></td><td><input type="text" name="prev_total_cgpa_marks'+icnt+'" id="prev_total_cgpa_marks'+icnt+'" value="" class="form-control input-sm" /></td><td><input type="text" name="prev_percentage'+icnt+'" id="prev_percentage'+icnt+'" class="form-control input-sm" /></td></tr>';
				//alert(append_element);
				$('#example1').append(append_element);
				$(".select2").select2();
				$("[data-mask]").inputmask();
				$(".year_mask").inputmask("y", {
					alias: "date",    
					placeholder: "yyyy",
					yearrange: { minyear: 1900, maxyear: (new Date()).getFullYear() }
				});
				$('#remove_row').attr('disabled',false);
			}
			else
			{
			
			}
	  	});
		$("#remove_row").click(function(){
				if(icnt!=0)
				{
					$("#row"+icnt).remove();
					icnt=icnt-1;
				}
		});
		$("#add_another_one").click(function(){
			//alert("clcik");
			//window.location.replace("/report_builder/pages/manage_students/add.php");
		});*/
		$('#example1').DataTable({
			/*fixedColumns: {
				leftColumns: 0,
				rightColumns: 2
			}*/
			bFilter: false,
			"paging":   false,
			"ordering": false,
			"info":     false
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