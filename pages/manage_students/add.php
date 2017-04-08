<?php
	include("../../db_con.php");
	if(isset($_SESSION['user_id'])){

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
				<h1>Manage Students
					<small>Add Student Record</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Students</a></li>
					<li>Add Student Record</li>
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
								<fieldset>
									<legend>Step 1 of 4 <span>(Admission/Personal Details)</span></legend>
									
									<div class="from-group">
										<label class="col-lg-2 control-label" for="admission_no">Admission No <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="admission_no" class="form-control input-sm" id="admission_no" autocomplete="off" />
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
											<input type="text" class="form-control input-sm" name="admission_date" style="width:94%;" data-inputmask="'alias':'dd/mm/yyyy'" data-mask />
										</div><!-- ./col-lg-6 and input-group-->
										<label for="admission_date" generated="true" class="error" style="margin-left:18%;"></label>
									</div><!-- ./form-group for admission_date -->
									
									<div class="clearfix" style="height: 5px;clear: both;"></div>
									
									<!-- Admission qouta -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="admission_qouta">Admission-Quota <span class="text-danger">*</span></label>
										<div class="col-lg-6 col-sm-5">
											<select class="form-control select2 input-sm" name="admission_quota" data-placeholder="Select a admission_quota">
												<option value="default">--Select--</option>
												<option>Councelling</option>
												<option>Management</option>
											</select>
											<label for="admission_quota" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for religion -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="from-group">
										<label class="col-lg-2 control-label" for="rollno">Rollno <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="rollno" class="form-control input-sm" id="rollno" autocomplete="off" />
										</div><!-- ./lg6-->
										
									</div><!-- ./form group for rollno-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="fname">FirstName <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="fname" id="fname" autocomplete="off" />
										</div><!-- ./lg-6-->
									</div><!-- ./form-group for fname -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="lname">LastName <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="lname" id="lname" autocomplete="off" />
										</div><!-- ./lg-6 -->
									</div><!-- ./form-group for lname -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="gender">Gender <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<label class="Form-label--tick">
												<input type="radio" name="gender" class="Form-label-radio" value="male" />
												<span class="Form-label-text"> Male</span>
											</label>
											<label class="Form-label--tick">
												<input type="radio" name="gender" class="Form-label-radio" value="female" />
												<span class="Form-label-text"> Female</span>
											</label>
											<label class="Form-label--tick">
												<input type="radio" name="gender" class="Form-label-radio" value="others" />
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
											<input type="text" class="form-control input-sm" name="dob" style="width:94%;" data-inputmask="'alias':'dd/mm/yyyy'" data-mask />
										</div><!-- ./col-lg-6 and input-group-->
										<label for="dob" generated="true" class="error" style="margin-left:18%;"></label>
									</div><!-- ./form-group for DOB -->
									
									<!-- Religion -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Religion">Religion <span class="text-danger">*</span></label>
										<div class="col-lg-6 col-sm-5">
											<select class="form-control select2 input-sm" name="religion" data-placeholder="Select a Religion">
												<option value="default">--Select--</option>
												<option>Hindu</option>
												<option>Christian</option>
												<option>Islam</option>
												<option>Jain</option>
												<option>Sikhism</option>
											</select>
											<label for="religion" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for religion -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Community -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Community">Community <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="community" data-placeholder="Select a Community">
												<option value="default">--Select--</option>
												<option>SC</option>
												<option>ST</option>
												<option>BC</option>
												<option>MBC</option>
												<option>Converted To Christian From SC</option>
												<option>Denotified Community</option>
											</select>
											<label for="community" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for Community -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Nationality -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Community">Nationality <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="nationality" data-placeholder="Select a Nationality">
												<option value="default">--Select--</option>
												<option>Indian</option>
												<option>Foreigner</option>
											</select>
											<label for="nationality" generated="true" class="error"></label>
										</div>
									</div><!-- ./form-group for Nationality -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Blood Group -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Blood_group">Blood Group <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="blood_group" data-placeholder="Select a Blood Group">
												<option value="default">--Select--</option>
												<option>A+</option>
												<option>A-</option>
												<option>B+</option>
												<option>B-</option>
												<option>AB+</option>
												<option>AB-</option>
												<option>O+</option>
												<option>O-</option>
											</select> 
											<label for="blood_group" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
									</div><!-- form-group for Blood Group -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother's Maiden Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_maiden_name">Mother's maiden Name</label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mother_maiden_name" id="mother_maiden_name" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother's maiden Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother's Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_name">Mother's Name <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mother_name" id="mother_name" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother's Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Father's's Name -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="father's_name">Father's Name <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="father_name" id="father_name" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Father's Name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Parent's income -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="parent's_income"> Parent's Income<span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<!-- ₹-->
											<input type="text" class="form-control input-sm" name="demoLakh" id="demoLakh" class="demo" data-a-sign="Rs. " data-group="2" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for parent_name -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mother tongue -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mother's_name">Mother Tongue <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2 input-sm" name="mother_tongue" data-placeholder="Select a Mother Tongue">
												<option value="default">--Select--</option>
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
											<label for="mother_tongue" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mother Tongue -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Languages Knowns -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="language known">Languages-Known</label>
										<div class="col-md-3">
											<input type="text" name="lang1" class="form-control input-sm" id="lang1" placeholder="Language 1" />
										</div>
										<div class="col-md-3">
											<input type="text" name="lang2" class="form-control input-sm" id="lang2" placeholder="Language 2"  />
										</div>
									</div><!-- ./ form-group for Languages known -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-primary open1 form_button" value="open1" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
									
								</fieldset><!-- ./fieldset -->
							</div><!-- ./sf1 -->
							
							<!-- sf2 Student Contact details-->	
							<div class="frm" id="sf2" style="display: none;">
								<fieldset>
									<legend>Step 2 of 4 <span>(Contact Details)</span></legend>
									<!-- Student Email -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="email">E-Mail <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="email" id="email" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for email -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Alternative Email -->
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="alter_email">Parent's E-Mail</label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="alter_email" id="alter_email" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for alter-email -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="mobile">Mobile <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="mobile" id="mobile" data-inputmask='"mask": "999-999-9999"' data-mask />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for Mobile -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Alter-Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="alter_mobile">Alternative Mobile </label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="alter_mobile" id="alter_mobile" data-inputmask='"mask": "999-999-9999"' data-mask />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for alter_mobile -->	
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Parents-Mobile -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="parent_mobile">Parent's Mobile <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" class="form-control input-sm" name="parent_mobile" id="parent_mobile" data-inputmask='"mask": "999-999-9999"' data-mask />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./form-group for parent_mobile -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group"><label class="col-lg-6 control-label"><h4>Present Address</h4></label></div>
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- House/Apartment No -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="house_no">House/Apartment No <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="house_no" class="form-control input-sm" id="house_no" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for house no-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- street -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="street">Road/Street <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="street" class="form-control input-sm" id="street" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./ form-group for Street-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- area -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="area">Area/Landmark <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="area" class="form-control input-sm" id="area" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for area-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- City -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="city">City <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="city" class="form-control input-sm" id="city" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for city-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- District -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="District">District <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="district" data-placeholder="Select a District" style="width:100%;">
												<option value="default">--Select--</option>
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
											<label for="district" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
										<div class="col-lg-4" id="other_district">
											<input type="text" class="form-control input-sm" name="other_district" style="float:left" />
										</div>
										<!--<span  class="text-danger">Error Message</span>-->
									</div><!-- ./ form-group for district-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- States -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="State">State <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="select2 form-control" name="state" dataplaceholder="Select a State" style="width:100%;">
												<option value="default">--Select--</option>
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
											<label for="state" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
										<div class="col-lg-4" id="other_state">
											<input type="text" class="form-control input-sm" name="other_state" style="float:left" />
										</div>
									</div><!-- ./form-group for States -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Country -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Country">Country <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="country" data-placeholder="Select a country" style="width:100%;">
												<option value="default">--Select--</option>
												<option>India</option>
												<option>Pakistan</option>
												<option>SriLanka</option>
												<option>England</option>
												<option>China</option>
												<option>Others</option>
											</select>
											<label for="country" generated="true" class="error"></label>
										</div>
										
									</div><!-- ./form-group fo country -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Pincode -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="pincode">Pincode <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" name="pincode" id="pincode" data-inputmask='"mask": "999-999"' data-mask />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for pincode-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="">If present address same For permanent Address?</label>
										<div class="col-lg-6">
											<label class="Form-label--tick">
												<input type="radio" name="address_same" class="Form-label-radio" value="yes" />
												<span class="Form-label-text"> Yes</span>
											</label>
											<label class="Form-label--tick">
												<input type="radio" name="address_same" class="Form-label-radio" value="no" />
												<span class="Form-label-text"> No</span>
											</label>
											<!--<label class="radio-inline">
												<input type="radio" name="address_same" value="yes" style="margin-top:1%;" />Yes
											</label>
											<label class="radio-inline" style="margin-top:1%;">
												<input type="radio" name="address_same" value="no" style="margin-top:1%;" />No
											</label>-->
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
											<input type="text" name="house_no1" class="form-control input-sm" id="house_no1" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for house no1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- street1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="street1">Road/Street <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="street1" class="form-control input-sm" id="street1" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
									</div><!-- ./ form-group for Street1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- area1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="area1">Area <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="area1" class="form-control input-sm" id="area1" />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for area1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- City1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="city1">City <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<input type="text" name="city1" class="form-control input-sm" id="city1" autocomplete="off" />
										</div><!-- ./col-lg-6 -->
										
									</div><!-- ./ form-group for city1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- District1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="District1">District <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="district1" data-placeholder="Select a District" style="width:100%;">
												<option value="default">--Select--</option>
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
											<label for="district1" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
										<div class="col-lg-4" id="other_district1">
											<input type="text" class="form-control input-sm" name="other_district1" style="float:left" />
										</div>
									</div><!-- ./ form-group for district1-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- States -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="State1">State <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="select2 form-control input-sm" name="state1" dataplaceholder="Select a State1" style="width:100%;">
												<option value="default">--Select--</option>
												<option>Andhra Pradesh</option>
												<option>Arunachal Pradesh</option>
												<option>Assam</option>
												<option>Bihar</option>
												<option>Chhattisgarh</option>
												<option>Goa</option>
												<option>Gujarat</option>
												<option>Haryana</option>
												<option>Himachal Pradesh</option>
												<option>Jammu & Kashmir</option>
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
											<label for="state1" generated="true" class="error"></label>
										</div><!-- ./col-lg-6 -->
										<div class="col-lg-4" id="other_state1">
											<input type="text" class="form-control input-sm" name="other_state1" style="float:left" />
										</div>
									</div><!-- ./form-group for States1 -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Country -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="county1">Country <span class="text-danger">*</span></label>
										<div class="col-lg-6">
											<select class="form-control select2" name="country1" data-placeholder="Select a country" style="width:100%;">
												<option value="default">--Select--</option>
												<option>India</option>
												<option>Pakistan</option>
												<option>SriLanka</option>
												<option>England</option>
												<option>China</option>
												<option>Others</option>
											</select>
											<label for="country1" generated="true" class="error"></label>
										</div>
										
									</div><!-- ./form-group fo country -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Pincode1 -->
									<div class="form-group permanent_address">
										<label class="col-lg-2 control-label" for="pincode1">Pincode <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" name="pincode1" id="pincode1" data-inputmask='"mask": "999-999"' data-mask />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for pincode1-->
									
									<!-- ./Permanent Address -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back2" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<button class="btn btn-primary open2 form_button" value="open2" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
									
								</fieldset><!-- ./fieldset -->
							</div><!-- ./sf2 -->
							
							<!-- sf3 Academic Details -->
							<div class="frm" id="sf3">
								<fieldset>
									<legend>Step 3 of 4 <sapn>(Academic Details)</sapn></legend>
									
									<!-- University Register Number -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Univ_regno">University Reg.no <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<input type="text" name="univ_regno" class="form-control input-sm" id="univ_regno" autocomplete="off" />
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for Univ Reg no -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Join_mode">Joined <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="join_mode" id="join_mode" data-placeholder="">
												<option value="default">--Select--</option>
												<option>Regular</option>
												<option>Lateral Entry</option>
											</select>
											<label for="join_mode" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for join_mode-->
									
									<div class="clearfix" style="height: 8px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="Course_type">Course-Type <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="course_type" id="course_type" data-placeholder="">
												<option value="default">--Select--</option>
												<option>Fulltime</option>
												<option>Part Time</option>
											</select>
											<label for="course_type" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for course_type-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Degree This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="degree">Degree <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_degree" id="curr_degree" data-placeholder="">
												<option value="default">--Select--</option>
												<?php
													$query = "SELECT degree_id,degree_name FROM degree WHERE degree_name != 'X' AND degree_name != 'XII';";
													$run_query = mysqli_query($con, $query);
													while($row = mysqli_fetch_array($run_query))
													{
														echo "<option value=".$row['degree_id']." name = '".$row['degree_name']."'>".$row['degree_name']."</option>";
													}
												?>
											</select>
											<label for="curr_degree" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for degree-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Course This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="course">Course <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_course" id="curr_course" data-placeholder="Select a Course">
												<option value='default'>--Select--</option>
												
											</select>
											<label for="curr_course" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for course-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<!-- Current Branch This is Fetched From DB -->
									<div class="form-group">
										<label class="col-lg-2 control-label" for="branch">Branch <span class="text-danger">*</span></label>
										<div class="col-lg-5">
											<select class="form-control select2" name="curr_branch" id="curr_branch" data-placeholder="Select a branch">
												<option value='default'>--Select--</option>
												
											</select>
											<label for="curr_branch" generated="true" class="error"></label>
										</div><!-- ./col-lg-5 -->
									</div><!-- ./form-group for branch-->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" for="section">Section</label>
										<div class="col-lg-5">
											<input type="text" class="form-control input-sm" name="curr_section" id="curr_section" />
										</div><!-- ./col-lg-3 -->
									</div><!-- ./form-group for section -->
									
									<div class="clearfix" style="height: 10px;clear: both;"></div>
									
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back3" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<button class="btn btn-primary open3 form_button" value="open3" type="button">Next &nbsp;<span class="fa fa-arrow-right"></span></button>
										</div>
									</div><!-- ./form group for button -->
								</fieldset><!--./fieldset -->
							</div><!-- ./sf3 -->
							<!-- ./sf3 end here-->
							
							<!-- sft4 Start Here for Student perivious Academic details -->
							<div class="frm" id="sf4">
								<fieldset id="">
									<legend>Step 4 of 4 <sapn>(Previous Academic Details)</sapn></legend>
									<!-- Rollno -->
									<!--<div class="form-group">
										<button class="btn btn-info" type="button" name="add_row" id="add_row" >Add Row</button>
										<button class="btn btn-warning" type="button" name="remove_row" id="remove_row">Remove Row</button>
									</div>--><!-- ./form-group for buttons -->
									<div class="form-group">
										<table class="table table-bordered prev_academic" id="example1" style="margin-top:1px;">
											<thead>
												<tr>
													<td colspan="2"><input type="text" name = 'step4_rollno' class="form-control input-sm" disabled="disabled" value="" /></td>
													<td colspan="9" style="text-align:left;">
														<button class="btn btn-info btn-flat" type="button" name="add_row" id="add_row" ><i class="fa fa-plus-circle"></i> Add Row</button>
														<button class="btn btn-warning btn-flat" type="button" name="remove_row" id="remove_row"><i class="fa fa-minus-circle"></i> Remove Row</button>	
														<span class="text-warning" id="maxmium_addrow" style="font-size:12px;"></span>
													</td>
												</tr>
												<tr>
													<th>Degree</th>
													<th>Course</th>
													<th>Branch</th>
													<th>Year-of-passing</th>
													<th>Course Type</th>
													<th>Name Of the Institution</th>
													<th>Board of Education/University Name</th>
													<th>CGPA/Marks Obtained</th>
													<th>Total Marks/CGPA</th>
													<th>Percentage</th>
												</tr>
												
											</thead>
											<tbody>
												<tr>
													<td style="text-align:center;font-weight:bold;">X</td>
													<td ><select class="form-control select2 input-sm" name="X_course" id="X_course" style="width:100%;">
															<option value="default">--Select--</option>
															<option>Secondary</option>
														</select>
														<label for="X_course" generated="true" class="error"></label>
													</td>
													<td ><select class="form-control select2 input-sm" name="X_branch" id="X_branch" style="width:100%;">
															<option value="default">--Select--</option>
															<option>Common</option>
														</select>
														<label for="X_branch" generated="true" class="error"></label>
													</td>
													<td><input type="text" name="X_duration_from" value="" id="X_duration_from" class="form-control input-sm year_mask" data-inputmask="'alias':'yyyy'" data-mask /></td>
													
													<td><select class="form-control select2 input-sm" name="X_course_type" id="X_course_type" style="width:100%;">
														<option value="default">--Select--</option>
														<option>Fulltime</option>
														<option>Part Time</option>
													</select>
													<label for="X_course_type" generated="true" class="error"></label>
													</td>
													<td><input type="text" name="X_ins_name" id="X_ins_name" value="" class="form-control input-sm" /></td>
													<td><select class="form-control select2 input-sm" name="X_board" id="X_board" style="width:100%;">
														<option value="default">--Select--</option>
														<option>State Board</option>
														<option>CBSE</option>
														<option>Anglo-Indian</option>
													</select>
														<label for="X_board" generated="true" class="error"></label>
													</td>
													<td><input type="text" name="X_cgpa_marks" id="X_cgpa_marks" value="" class="form-control input-sm" /></td>
													<td><input type="text" name="X_total_cgpa_marks" id="X_total_cgpa_marks" value="" class="form-control input-sm" /></td>
													<td><input type="text" name="X_percentage" id="X_percentage" value="" class="form-control input-sm" /></td>
												</tr>
												
											</tbody>
											<tfoot>
											
											</tfoot>
										</table>
									</div>
									<div class="form-group">
										<div class="col-md-10 col-lg-offset-2">
											<button class="btn btn-warning back4" type="button"><span class="fa fa-arrow-left">&nbsp;</span>Back</button>
											<button class="btn btn-primary open4 form_button" name="add_student" value="open4" type="button">Submit &nbsp;<span class="fa fa-arrow-right"></span></button>
											<img src="../../dist/img/ajax-loader.gif" alt="" id="loader" style="display: none">
										</div>
									</div><!-- ./form group for button -->
									
								</fieldset>
							</div><!-- ./sf4 -->
							<div id="ajax_error" style="margin-top:1%;"></div>
						</form><!-- ./form -->
					</div><!-- ./panel-body -->
					<div class="panel-footer">
					
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
		 //Money Euro
		
        $("[data-mask]").inputmask();
		$(".year_mask").inputmask("y", {
			alias: "date",    
			placeholder: "yyyy",
			yearrange: { minyear: 1900, maxyear: (new Date()).getFullYear() }
		});
		
        $('#example1').DataTable({
			bFilter: false,
			"paging":   false,
			"ordering": false,
			"info":     false
		});
		 //alert("document ready");
		// CURRENCY FORMAT
		 $('#demoLakh').autoNumeric('init');  
		
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
				
			$('#other_district').hide();
			$('#other_state').hide();
			$('#other_district1').hide();
			$('#other_state1').hide();
			$('select[name=district]').change(function(){
				//alert($(this).val());
				if($(this).val() == 'Others'){
					$('#other_district').show();	
				}
				else{
					$('#other_district').hide();
				}
			});	
			$('select[name=state]').change(function(){
				//alert($(this).val());
				if($(this).val() == 'Others'){
					$('#other_state').show();	
				}
				else{
					$('#other_state').hide();
				}
			});	
			
			$('select[name=district1]').change(function(){
				//alert($(this).val());
				if($(this).val() == 'Others'){
					$('#other_district1').show();	
				}
				else{
					$('#other_district1').hide();
				}
			});	
			$('select[name=state1]').change(function(){
				//alert($(this).val());
				if($(this).val() == 'Others'){
					$('#other_state1').show();	
				}
				else{
					$('#other_state1').hide();
				}
			});	
			 
			$(".permanent_address").hide();
			$("#sf3").hide();
			$("#sf4").hide();
			
			$(".open1, .open2, .open3, .open4").click(function() {
				
				var clicked = $(this).attr("value");
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
				var v = $('#student_form');
				v.validate({
				rules:{
					admission_no:{
						required: true,
						number: true
					},
					admission_date:{
						required: true,
						indianDate: true
					},
					admission_quota:{
						valueNotEquals: "default"
					},
					rollno:{
						required: true,
						number: true,
						minlength: 9,
						maxlength: 10
					},
					fname: ruleSet1,
					lname:{
						required: true,
						minlength: 1,
						lettersonly: true
					},
					gender:{
						required: true
					},
					dob:{
						required: true,
						indianDate: true
					},
					religion:{
						valueNotEquals: "default"
					},
					community: {
						valueNotEquals: "default"
					},
					nationality:{
						valueNotEquals: "default"
					},
					blood_group:{
						valueNotEquals: "default"
					},
					mother_maiden_name: ruleSet1,
					mother_name: ruleSet1,
					father_name: ruleSet1,
					mother_tongue:{
						valueNotEquals: "default"
					},
					demoLakh:{
						required: true
					},
					// Contact Details Form Validation
					email:{
						required : true,
						email: true
					},
					alter_email:{
						email: true,
						email_not_same: true
					},
					alter_mobile:{
						minlength:12,
						maxlength:12,
						mobile_not_same: true
					},
					mobile:{
						required: true,
						minlength:10,
					},
					parent_mobile:{
						required: true,
						minlength:12,
						maxlength:12,
						mobile_not_same: true
					},
					house_no:{required: true},
					street:{required: true},
					area:{required: true},
					city:{required: true,lettersonly: true},
					district:{
						valueNotEquals: "default"
					},
					state:{
						valueNotEquals: "default"
					},
					country:{
						valueNotEquals: "default"
					},
					pincode:{
						required: true,
						minlength: 7,
						maxlength: 7
					},
					// Permanent Address Validation
					house_no1:{required: true},
					street1:{required: true},
					area1:{required: true},
					city1:{required: true, lettersonly: true},
					district1:{
						valueNotEquals: "default"
					},
					state1:{
						valueNotEquals: "default"
					},
					country1:{
						valueNotEquals: "default"
					},
					pincode1:{
						required: true,
						minlength: 7,
						maxlength: 7
					},
					//Academic Details
					univ_regno:{
						required: true,
						number: true
					},
					join_mode:{
						required: true
					},
					course_type:{
						valueNotEquals: "default"
					},
					curr_degree:{
						valueNotEquals: "default"
					},
					curr_course:{
						valueNotEquals: "default"
					},
					curr_branch:{
						valueNotEquals: "default"
					},
					curr_section: {
						required: true,
						lettersonly: true
					},
					
					//PREVIOUS ACADEMIC DETAILS
					X_course:{
						valueNotEquals: "default"
					},
					X_branch:{
						valueNotEquals: "default"
					},
					X_duration_from:{
						required: true
					},
					X_course_type:{
						valueNotEquals: "default"
					},
					X_ins_name:{
						required: true
					},
					X_board:{
						valueNotEquals: "default"
					},
					X_cgpa_marks:{
						required: true,
						number: true
					},
					X_total_cgpa_marks:{
						required: true,
						number: true
					},
					X_percentage:{
						required: true,
						number: true
					},
					
					XII_course:{
						valueNotEquals: "default"
					},
					XII_branch:{
						valueNotEquals: "default"
					},
					XII_duration_from:{
						required: true
					},
					XII_duration_to:{
						required: true
					},
					XII_course_type:{
						valueNotEquals: "default"
					},
					XII_ins_name:{
						required: true
					},
					XII_board:{
						valueNotEquals: "default"
					},
					XII_cgpa_marks:{
						required: true,
						number: true
					},
					XII_total_cgpa_marks:{
						required: true,
						number: true
					},
					XII_percentage:{
						required: true,
						number: true
					}
					
				},
				
				// Error Messages
				messages:{
					rollno:{
						required: "This field is required.",
						number: "Please enter Numeric value Only!",
						minlength: "Rollno should be 9 digit"
					},
					admission_quota:{
						valueNotEquals: "Please select a admission_quota!"
					},
					fname:{
						required: "This field is required.",
						minlength: "Firstname should be more than 3 characters",
						lettersonly: "Firstname should contain only letters."
					},
					lname:{
						required: "This field is required",
						minlength: "Lastname should be more than 3 characters.",
						lettersonly: "Lastname should contain only letters."
					},
					gender:{
						required: "Select student gender."
					},
					dob:{
						required: "Date of birth field is required."
					},
					religion:{
						valueNotEquals: "Please select a religion!"
					},
					community:{
						valueNotEquals: "Please select a community!"
					},
					nationality:{
						valueNotEquals: "Please select a nationality!"
					},
					blood_group:{
						valueNotEquals: "Please select a Blood group!"
					},
					mother_tongue:{
						valueNotEquals: "Please select a Mother tongue!"
					},
					
					//Contact Details Error Messages
					
					mobile:{
						minlength: "Mobile number should be 10 digit",
					},
					alter_mob:{
						minlength: "Mobilde number should be 10 digit"
					},
					parent_mobile: {minlength: "Mobile number should be 10 digit"},
					district:{
						valueNotEquals: "Please select a District!"
					},
					state:{
						valueNotEquals: "Please select a State!"
					},
					country:{
						valueNotEquals: "Please select a Country!"
					},
					district1:{
						valueNotEquals: "Please select a District!"
					},
					state1:{
						valueNotEquals: "Please select a State!"
					},
					country1:{
						valueNotEquals: "Please select a Country!"
					},
					
					// Academic Error Messages
					
					curr_degree:{
						valueNotEquals: "Please select degree."
					},
					curr_course:{
						valueNotEquals: "Please select course"
					},
					curr_branch:{
						valueNotEquals: "Please select branch"
					},
					course_type:{
						valueNotEquals: "Please select course-type"
					},
					XII_course:{
						valueNotEquals: "Please select course"
					},
					XII_branch:{
						valueNotEquals: "Please select branch"
					},
					XII_course_type:{
						valueNotEquals: "Please select course-type"
					},
					XII_board:{
						valueNotEquals: "Please select board"
					}
					
				}
			});
			
				if(clicked == "open1")
				{
					if (v.valid()== true) {
						$(window).scrollTop(scroll);
						$(".frm").hide("fast");
						$("#sf2").show("slow");
					}
					else{$(window).scrollTop(scroll);}
				}
				else if(clicked == "open2")
				{
					if (v.valid()== true) {
						$(window).scrollTop(scroll);
						$(".frm").hide("fast");
						$("#sf3").show("slow");
					}
					else{$(window).scrollTop(scroll);}
				}
				else if(clicked == "open3")
				{
					var step_rollno = $('input[name=rollno]').val();
					$('input[name=step4_rollno]').val(step_rollno);
					
					if(v.valid()==true)
					{
						$(window).scrollTop(scroll);
						$(".frm").hide("fast");
						$("#sf4").show("slow");
					}
					else{$(window).scrollTop(scroll);}
				}
				else
				{
					if(v.valid() == true)
					{
						//alert("sbmited");	
						$(window).scrollTop(scroll);
						$.ajax({
							type: 'post',
							cache: false,
							url: 'live_search.php',
							data: $("#student_form").serialize() + "&key=form_data",
							beforeSend: function(){
								$("#loader").show();
							},
							success: function(resp)
							{
								//alert(resp);
								if(resp == "inserted"){
									//alert("inside if");
									$("#loader").hide();
									$("#student_form").html('<h3 class="text-success">'+$("input[name=rollno]").val()+ ' Record has been Inserted Successfully!</h3>');
									var but = $('<button/>', {
									text: 'Add another record', //set text 1 to 10
									id: 'add_another_one',
									class: 'btn btn-info btn-flat input-sm',
									click: function () { location.reload(); }//location.reload();
								});
								$("#student_form").append(but);
									/*$('#ajax_error').removeClass("alert alert-danger").addClass("alert alert-success");
									//$('#ajax_error').addClass("alert alert-success");
									$("#ajax_error").html('<strong>Inserted! </strong>'+$("input[name=rollno]").val()+ ' Record Inserted Sucessfully! </div>');
									var but = $('<button/>', {
										type: 'button',
										text: 'Add another record', //set text 1 to 10
										id: 'add_another_one',
										class: 'btn btn-info btn-flat input-sm',
										click: function () { 
											location.reload();
											$('#student_form').find(':input').each(function() {
											switch(this.type) {
												case 'password':
												case 'select-multiple':
												case 'select-one':
												case 'text':
												case 'textarea':
													$(this).val('');
													break;
												case 'checkbox':
												case 'radio':
													this.checked = false;
											}
											/* $("#sf4").hide("fast");
											 $("#sf1").show("slow");
											 //$(".select2").select2();
											 $("#ajax_error").html("");
											 $('#ajax_error').removeClass("alert alert-success").removeClass("alert alert-danger");
										});
									 }//location.reload();
									});
									 $("#ajax_error").append(but);*/
								} // if close
								else {
									//alert("inside else");
									$("#loader").hide();
									$('#ajax_error').removeClass("alert alert-success").addClass("alert alert-danger");
									$('#ajax_error').html(resp)
								}
							},
							error: function (xhr, ajaxOptions, thrownError) {
									$("#loader").hide();
									$('#ajax_error').html("Error" + opt.url + ": " + xhr.status + " " + xhr.statusText);
							  }
						});<!-- ./ajax call close-->
						$(".select2").select2();
					}
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
			
			/* Following Change event Handle Address Same or not Stuation from add student contact details form add.php script
			if present address and permanent address same "YES" permanent address div hide if "NO" permanent address Part display to 
			User . this event Handled by following script*/
			$("input:radio[name=address_same]").on('change',function(){
				var radio_value = $('input:radio[name=address_same]:checked').val();	
				if(radio_value == "no")
				{
					$('body,html').animate({scrollTop: $('body').height()}, 1000);
					$(".permanent_address").show("slow");
				}
				else if(radio_value == "yes")
				{
					$(".permanent_address").hide("slow");
				}
			}); // Address same change event close here
			
			/* Following Script Handle Addrow and remove row from Student prevoius academic details from Add.php(student record)*/
			$('#remove_row').attr('disabled',true);
			$('#add_row').click(function(){
	  		if(icnt <= 3)
			{
				icnt=icnt+1;
				
				var append_element = '<tr id="row'+icnt+'"><td style="text-align:center;font-weight: bold;"><select class="form-control input-sm select2 degree_select" name="prev_degree'+icnt+'" id="prev_degree'+icnt+'" style="width: 100%;"><option value="default">--select--</option><option>XII</option><option>DIPLOMA</option><option>UG</option><option>PG</option></select></td><td id="prev_course_txt'+icnt+'"><select class="form-control select2 input-sm prev_course" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;"></select></td><td id="prev_branch_txt'+icnt+'"></td> <td><input type="text" name="prev_duration_from'+icnt+'" id="prev_duration_from'+icnt+'" class="form-control input-sm year_mask" /></td><td><select class="form-control select2 input-sm" name="prev_course_type'+icnt+'" id="prev_course_type'+icnt+'" style="width:100%;"><option value="default">--Select--</option><option>Fulltime</option><option>Part Time</option></select></td><td><input type="text" name="prev_ins_name'+icnt+'" id="prev_ins_name'+icnt+'" class="form-control input-sm" /></td><td id="prev_board_txt'+icnt+'"></td><td><input type="text" name="prev_cgpa_marks'+icnt+'" id="prev_cgpa_marks'+icnt+'" value="" class="form-control input-sm" /></td><td><input type="text" name="prev_total_cgpa_marks'+icnt+'" id="prev_total_cgpa_marks'+icnt+'" value="" class="form-control input-sm" /></td><td><input type="text" name="prev_percentage'+icnt+'" id="prev_percentage'+icnt+'" class="form-control input-sm" /></td></tr>';
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
				$('#maxmium_addrow').html("  Maximum four degree to allow!");
			}
			$('#prev_degree'+icnt).change(function(){
				<?php 
					$fo_courses = fopen('../txt_files/courses.txt', 'r');
					$arr_Courses = file("../txt_files/courses.txt");
					//fclose($fo_courses);
					$fo_univ = fopen('../txt_files/univ.txt','r');
					$arr_univ = file("../txt_files/courses.txt");
					//fclose($fo_univ);
				?>
				var arrayFromPHP = <?php echo json_encode($arr_Courses); fclose($fo_courses)?>;	
				var array_univ = <?php echo json_encode($arr_univ); ?>;
					if($(this).val() == 'XII'){
						$('#prev_branch'+icnt).html('<option value="default">--Select--</option>');
						$('#prev_course_txt'+icnt).empty();
						$('#prev_course_txt'+icnt).append('<select class="form-control select2 input-sm prev_course" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;">');
						$('#prev_course'+icnt).html("");	
						$('#prev_course'+icnt).append("<option>"+'Higher Secondary'+"</option>");
						$('#prev_branch_txt'+icnt).empty("");
						$('#prev_branch_txt'+icnt).append("<select class='form-control select2 input-sm' name='prev_branch"+icnt+"' id='prev_branch"+icnt+"' style='width:100%;'><option>Physics, Chemistry, Maths, Biology(PCMB)</option><option>Physics, Chemistry, Biology(PCB)</option><option>Physics, Chemistry, Maths(PCM)</option><option>Chemistry, maths, computerscience</option><option>Economics, commerce</option></select>");
						$('#prev_board_txt'+icnt).empty();
						$('#prev_board_txt'+icnt).append("<select class='form-control select2 input-sm' name='prev_board"+icnt+"' id='prev_board"+icnt+"' style='width:100%;'><option value='default'>--Select--</option><option>"+'State Board'+"</option><option>"+'CBSE'+"</option><option>"+'Anglo-Indian'+"</option></select>");	
					}
					if($(this).val() == 'UG'){
						//alert("ug");
						$('#prev_course'+icnt).html('<option value="default">--Select--</option>');
						$('#prev_course_txt'+icnt).empty();
						$('#prev_course_txt'+icnt).append('<select class="form-control select2 input-sm prev_course" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;">');
						$('#prev_branch_txt'+icnt).empty("");
						$('#prev_branch_txt'+icnt).append('<input type="text" class="form-control input-sm" name="prev_branch'+icnt+'" style="width:100%;"/>');
						$('#prev_course'+icnt).html("");	
						for(var j=1; j < 70; j++){
							$('#prev_course'+icnt).append("<option>"+arrayFromPHP[j]+"</option>");							
						}//for close
						$('#prev_board_txt'+icnt).empty("");
						$('#prev_board_txt'+icnt).append('<input type="text" class="form-control input-sm" name="prev_board'+icnt+'" />');
						/*for(var k=1; k < 20; k++){
							$('#prev_board'+icnt).append("<option>"+array_univ[k]+"</option>");
						}*/
					} // if() UG close
					else if($(this).val() == 'PG'){
						//alert(pg);
						$('#prev_course'+icnt).html('<option value="default">--Select--</option>');
						$('#prev_course_txt'+icnt).empty();
						$('#prev_course_txt'+icnt).append('<select class="form-control select2 input-sm prev_course" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;">');
						$('#prev_course'+icnt).html("");	
						$('#prev_branch_txt'+icnt).empty("");
						$('#prev_branch_txt'+icnt).append('<input type="text" class="form-control input-sm" name="prev_branch'+icnt+'" />');
						for(var j=73; j < 140; j++){
							$('#prev_course'+icnt).append("<option>"+arrayFromPHP[j]+"</option>");							
						}
						$('#prev_board_txt'+icnt).empty("");
						$('#prev_board_txt'+icnt).append('<input type="text" class="form-control input-sm" name="prev_board'+icnt+'" />');
						/*for(var k=1; k < 20; k++){
							$('#prev_board'+icnt).append("<option>"+array_univ[k]+"</option>");
						}*/
					} // if() PG Close
					else if($(this).val() == 'DIPLOMA'){
						$('#prev_course_txt'+icnt).html('<input type="text" class = "form-control input-sm" name="prev_course'+icnt+'" id="prev_course'+icnt+'" style="width:100%;" />')
						$('#prev_branch'+icnt).html("");	
						for(var j=144; j < 167; j++){
							$('#prev_branch'+icnt).append("<option>"+arrayFromPHP[j]+"</option>");							
						}
						$('#prev_board_txt'+icnt).empty("");
						$('#prev_board_txt'+icnt).append('<input type="text" class="form-control input-sm" name="prev_board'+icnt+'" />');
						/*for(var k=1; k<array_univ.length; k++){
							$('#prev_board'+icnt).append("<option>"+array_univ[k]+"</option>");
						}*/
					}	
				$(".select2").select2();
			});// degree change event close
	  	});// Addrow click event close here
		$("#remove_row").click(function(){
				if(icnt!=0)
				{
					$('#maxmium_addrow').html("");
					$("#row"+icnt).remove();
					icnt=icnt-1;
				}
		});// remove row click event close here
      }); /* $(document).ready close here*/
	  $('.select2').change(function(){
		  alert($(this).val());
			if($(this).val() != ""){
				$('label[for="' + $(this).attr("name") + '"]').css("display","none");
			}	
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
?>