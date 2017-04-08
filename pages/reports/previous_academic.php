<?php
	include("../../db_con.php");
	//data: [70, 37, 55, 90, 103, 14],
	$mba = 70;
	$me = 37;
	$mtech = 55;
	$mca = 90;
	$be = 103;
	$btech = 14;
	$sc = "[$mba,$me,$mtech,$mca,$be,$btech]";
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
			include("../../sidebar.php");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Report
					<small>Previous Academic Report</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">Report</a></li>
					<li class="active">Previous Academic Report</li>
				 </ol>
			</section><!-- ./content-header -->
			
			<section class="content">
				<div class="box box-primary" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Student Previous Academic Report</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->	
					</div><!-- ./box-header --->
					<!-- form start -->
					<form role="form">
						<div class="box-body">
							<!-- Course list box-->
							<div class="form-group col-md-10">
								<label>Select a Course</label>
								<select class="form-control select2" id="prev_degree_wise_course" name="prev_degree_wise_course[]" multiple="multiple" data-placeholder="Select a course" style="width: 100%;">
									<?php
										$query = "SELECT course_id, degree_id, course_name FROM courses;";
										$run_query = mysqli_query($con, $query);
										while($row = mysqli_fetch_array($run_query))
										{
											echo '<option value='.$row["course_id"].'>'.$row["course_name"].'</option>';
										}
									?>
								</select>
							</div>
							
							<!-- Branch List -->
							<div class="form-group col-md-10">
								<label>Select a Branch</label>
								<select class="form-control select2" id = "prev_degree_wise_branch" name="prev_degree_wise_branch[]" multiple="multiple" data-placeholder="Select a Brach" style="width: 100%;">
									
								</select>
							</div>
							
						</div><!-- ./box-body -->
						
						<div class="box-footer">
							<center><button type="submit" class="btn btn-primary">Submit</button></center>
						</div>
					</form><!-- ./form -->
				</div><!-- ./box-primary -->
				
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Generated Report</h3>
					</div>
					<div class="box-body">
						
						<table id="example1" class="table table-bordered table-striped" style="font-size: 13px;">
								<thead>
									<tr>
										<th id="col-1">Rollno</th>
										<th id="col-2">Name</th>
										<th id="col-3">Degree</th>
										<th id="col-4">Course</th>
										<th id="col-5">Branch</th>
										<th id="col-6">Section</th>
										<th id="col-7">Year</th>
										<th id="col-8">Email</th>
										<th id="col-9">CGPA/Marks Obtained</th>
										<th id="col-10">Percentage</th>
									</tr>
									<tr>
										<th>Rollno</th>
										<th>Name</th>
										<th>Degree</th>
										<th>Course</th>
										<th>Branch</th>
										<th>Section</th>
										<th>Year</th>
										<th>Email</th>
										<th>CGPA/Marks Obtained</th>
										<th>Percentage</th>
									</tr>
								</thead>
								<tbody>
									<!--<tr class="">
										<td>201308002</td>
										<td>Balakumar B</td>
										
										<td>MCA</td>
										<td>Computer Application</td>
										<td>A</td>
										<td>3</td>
										<td>9488416332</td>
										<td>Uppukadai Street</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201305006</td>
										<td>Gowri V</td>
										
										<td>ME</td>
										<td>Software Engineering</td>
										<td>B</td>
										<td>1</td>
										<td>9488416333</td>
										<td>Samarthanam St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>20130712</td>
										<td>Keerthi V</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Mechanical Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>9488416334</td>
										<td>Shanmugapuram st</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214051</td>
										<td>Selvakumar L</td>
										<td>Male</td>
										<td>B-</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Computer Science and Engineering</td>
										<td>C</td>
										<td>4</td>
										<td>9488416335</td>
										<td>Shetti nagar St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214052</td>
										<td>Poornima D</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>9488416336</td>
										<td>Koratur</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214047</td>
										<td>Muthu L</td>
										<td>Male</td>
										<td>B-</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electrical and Electronic Engineering(EEE)</td>
										<td>B</td>
										<td>2</td>
										<td>9488416337</td>
										<td>Tambaram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214042</td>
										<td>Saravanan K</td>
										<td>Male</td>
										<td>B-</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electronics and Communication Engineering(ECE)</td>
										<td>A</td>
										<td>3</td>
										<td>9488416338</td>
										<td>Pallavaram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214001</td>
										<td>Abhi Dharshan T K</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>9488416339</td>
										<td>Vallalar Nagar</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214003</td>
										<td>Anitha M</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>B</td>
										<td>2</td>
										<td>9488416340</td>
										<td>Thirumangai puram</td>
										<td>Kanchepuram</td>
									</tr>
									<tr>
										<td>201214003</td>
										<td>Suganya M</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MBA</td>
										<td>Bussiness Administration</td>
										<td>A</td>
										<td>2</td>
										<td>948841641</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201214005</td>
										<td>Arjun S D</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>948841642</td>
										<td>Poonamalle</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214006</td>
										<td>Balaji A</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>948841643</td>
										<td>Retti St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201214009</td>
										<td>Dhamodharan G</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Aeronautical Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>948841644</td>
										<td>Amalorpavam St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201220001</td>
										<td>Abdul Kadar S</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Automobile Engineering</td>
										<td>B</td>
										<td>4</td>
										<td>948841645</td>
										<td>Sahnmugam St</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201220003</td>
										<td>Abishek R</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Automobile Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>948841646</td>
										<td>Nithish St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201220006</td>
										<td>Arvind Raj B</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Automobile Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>948841647</td>
										<td>kannaki Nagar</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201220009</td>
										<td>Balendran R</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Automobile Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>948841648</td>
										<td>Shanmugam St</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201220011</td>
										<td>Bheshma Yogendra Kiran K</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Automobile Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>948841649</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201221001</td>
										<td>Aashik Kader Mohideen S</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Biomedical Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>948841650</td>
										<td>Retti St</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201221002</td>
										<td>Adithya V</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Biomedical Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>948841651</td>
										<td>Durgapuram</td>
										<td>Kanchepuram</td>
									</tr>
									<tr>
										<td>201221003</td>
										<td>Ahamed Nashath Qudhisiya L T</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Biomedical Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>948841652</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201221005</td>
										<td>Akshya B</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Biomedical Engineering</td>
										<td>B</td>
										<td>3</td>
										<td>948841653</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201210001</td>
										<td>Aarthi S</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
										<td>Bio Technology</td>
										<td>A</td>
										<td>3</td>
										<td>948841654</td>
										<td>Setipet</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201210003</td>
										<td>Abynasha T</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
										<td>Bio Technology</td>
										<td>B</td>
										<td>3</td>
										<td>948841655</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201210002</td>
										<td>Abhinaya K</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
										<td>Bio Technology</td>
										<td>B</td>
										<td>2</td>
										<td>948841656</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201228003</td>
										<td>Aravindh R</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Civil Engineering</td>
										<td>A</td>
										<td>3</td>
										<td>9488416457/td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201228005</td>
										<td>Balaji S</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Civil Engineering</td>
										<td>B</td>
										<td>4</td>
										<td>948841658</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
	
									<tr>
										<td>201201001</td>
										<td>Abinaya V</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Computer Science and Engineering</td>
										<td>A</td>
										<td>4</td>
										<td>948841659</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201201002</td>
										<td>Abirami E</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Computer Science and Engineering</td>
										<td>B</td>
										<td>2</td>
										<td>948841660</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201202002</td>
										<td>Abdul Tizzer A W</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electronics and Communication Engineering(ECE)</td>
										<td>A</td>
										<td>4</td>
										<td>948841661</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201202188</td>
										<td>Abinand N</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electronics and Communication Engineering(ECE)</td>
										<td>B</td>
										<td>3</td>
										<td>948841662</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201202001</td>
										<td>Abul Kalam Azad R S</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electronics and Communication Engineering(ECE)</td>
										<td>A</td>
										<td>4</td>
										<td>948841663</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201202008</td>
										<td>Ambika A A</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electronics and Communication Engineering(ECE)</td>
										<td>A</td>
										<td>2</td>
										<td>948841664</td>
										<td>Durgapuram</td>
										<td>Kanchepuram</td>
									</tr>
									<tr>
										<td>201205001</td>
										<td>Abdul Azeem R</td>
										<td>Male</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electrical and Electronic Engineering(EEE)</td>
										<td>B</td>
										<td>4</td>
										<td>948841665</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201205002</td>
										<td>Aishwarya Rathna M</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electrical and Electronic Engineering(EEE)</td>
										<td>A</td>
										<td>4</td>
										<td>948841666</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201205003</td>
										<td>Akshay S</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>BACHELOR OF ENGINEERING(B.E)</td>
										<td>Electrical and Electronic Engineering(EEE)</td>
										<td>A</td>
										<td>3</td>
										<td>948841667</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201308018</td>
										<td>Poornima D</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MCA</td>
										<td>Computer Application</td>
										<td>A</td>
										<td>3</td>
										<td>948841668</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201423001</td>
										<td>Ayeshaarveen M</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Communication System</td>
										<td>B</td>
										<td>1</td>
										<td>948841669</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201423002</td>
										<td>Bakyalakshmi V</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Communication System</td>
										<td>A</td>
										<td>2</td>
										<td>948841670</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201423003</td>
										<td>Carolinheshma A</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Communication System</td>
										<td>A</td>
										<td>2</td>
										<td>948841671</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201412001</td>
										<td>Abirami R</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Computer science and Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>948841672</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201412002</td>
										<td>Anish D</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Computer science and Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>948841673</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201432001</td>
										<td>Abrahamnthony D</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Engineering Design</td>
										<td>B</td>
										<td>2</td>
										<td>948841674</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201432002</td>
										<td>Aravindh M</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Engineering Design</td>
										<td>A</td>
										<td>1</td>
										<td>948841675</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201425002</td>
										<td>Banuchithra A R</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
										<td>Biotechnology</td>
										<td>A</td>
										<td>2</td>
										<td>948841676</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201425004</td>
										<td>Lokeshumar V</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
										<td>Biotechnology</td>
										<td>A</td>
										<td>2</td>
										<td>948841677</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>
									<tr>
										<td>201425003</td>
										<td>Divya A S</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
										<td>Biotechnology</td>
										<td>B</td>
										<td>1</td>
										<td>948841678</td>
										<td>Durgapuram</td>
										<td>Kanchepuram</td>
									</tr>
									<tr>
										<td>201422002</td>
										<td>Muthu Lakshmi A</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Software Engineering</td>
										<td>A</td>
										<td>2</td>
										<td>948841679</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201422003</td>
										<td>Nalarubiga E</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Software Engineering</td>
										<td>A</td>
										<td>1</td>
										<td>948841680</td>
										<td>Durgapuram</td>
										<td>Kanchepuram</td>
									</tr>
									<tr>
										<td>201433001</td>
										<td>Anitha M</td>
										<td>FeMale</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Embedded Systems Technologies</td>
										<td>A</td>
										<td>2</td>
										<td>948841681</td>
										<td>Durgapuram</td>
										<td>Thiruvallur</td>
									</tr>
									<tr>
										<td>201433002</td>
										<td>Balaji M C</td>
										<td>Male</td>
										<td>B+</td>
										<td>MASTER OF ENFINEERING(ME)</td>
										<td>Embedded Systems Technologies</td>
										<td>A</td>
										<td>1</td>
										<td>948841682</td>
										<td>Durgapuram</td>
										<td>Chennai</td>
									</tr>-->
								</tbody>
								<tfoot>
									<tr>
										<th>Rollno</th>
										<th>Name</th>
										<th>Degree</th>
										<th>Course</th>
										<th>Branch</th>
										<th>Section</th>
										<th>Year</th>
										<th>Email</th>
										<th>CGPA/Marks Obtained</th>
										<th>Percentage</th>
									</tr>
								</tfoot>
							</table>
						
					</div><!-- box-body -->
				</div><!-- ./box-primary -->
				
			</section><!-- ./content -->
		</div><!-- ./content-wrapper -->
		 <div id="totopscroller"></div>
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	<!--J Q U E R Y   P L U G  I N S   I N C L U  D E D   B E L O W -->
	
	<!-- Select2 -->
    <script src="<?php echo path ?>plugins/select2/select2.full.min.js"></script>

	<!-- DataTables -->
    <script src="<?php echo path ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo path ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo path ?>plugins/datatables/jquery.dataTables.columnFilter.js"></script>

	<!-- Export Buttons -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/dataTables.buttons.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.flash.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/jszip.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.html5.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.print.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/pdfmake.min.js"></script>
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/vfs_fonts.js"></script>
	
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
					 			{sSelector:"#col-1",type:"number-range"},
								{sSelector:"#col-2",type:"text"},
								{sSelector:"#col-3",type:"text"},
								{sSelector:"#col-4",type:"select"},
								{sSelector:"#col-5",type: "text"},
								{sSelector:"#col-6",type:"select"},
								{sSelector:"#col-7",type:"select"},
								{sSelector:"#col-8",type:"text"},
								{sSelector:"#col-9",type:"text"},
								{sSelector:"#col-10",type:"number-range"},
								
								
					 ]
				});
				
			});	
		</script>

  </body>
</html>
