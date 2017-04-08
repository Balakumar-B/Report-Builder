<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Advanced form elements</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
   	<!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
	<!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
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


	</style>
  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">
		
		<?php
			include("../../header.php");
		?>	
      
      <!-- Left side column. contains the logo and sidebar -->
      <?php
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
				<div class="box box-primary" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Student Community Report</h3>
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
								<select class="form-control select2" multiple="multiple" data-placeholder="Select a course" style="width: 100%;">
									<option>BE</option>
									<option>B.Tech</option>
									<option>MBA</option>
									<option>MCA</option>
									<option>M.Tech</option>
									<option>ME</option>
								</select>
							</div>
							
							<!-- Branch List -->
							<div class="form-group col-md-10">
								<label>Select a Branch</label>
								<select class="form-control select2" multiple="multiple" data-placeholder="Select a Brach" style="width: 100%;">
									<option>Master of Computer Application</option>
									<option>Master of Business Administration</option>
									<option>Civil Engineering</option>
									<option>Mechanical Engineering</option>
									<option>Software Engineering</option>
									<option>Information Technology</option>
								</select>
							</div>
							
							<!-- Community List -->
							<div class="form-group col-md-10">
								<label>Select a Community</label>
								<select class="form-control select2" data-placeholder="Select a Brach" style="width: 100%;">
									<option selected="selected">--Select--</option>
									<option>BC(Backward Class)</option>
									<option>MBC(Most Backward class)</option>
									<option>ST/SC(Scheduled Cast)</option>
									<option>Denotified Community</option>
									<option>Converted Christian from SC</option>
								</select>
								<div class="text-info" style="font-size:11px;">Leave Blank to be display all Community</div>
							</div>
							
						</div><!-- ./box-body -->
						
						<div class="box-footer">
							<center><button type="submit" class="btn btn-primary">Submit</button></center>
						</div>
					</form><!-- ./form -->
				</div><!-- ./box-primary -->
			<!--</div><!-- ./col-md-11 -->
		   </div><!-- ./row -->
		   <div class="row">
		   		<div class="box box-primary">
					<div class="box-body">
						<div class="col-md-5">
							<select multiple="multiple" name="" id="selected_field" style="width:100%;">
					
							</select>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<button type="button" class="btn btn-default btn-block" id="add_field" name="add" value="add">Add</button>
								<button type="button" class="btn btn-default btn-block" name="Remove" value="remove">Remove</button>
							</div>
						</div>
						<div class="col-md-5" style="overflow-y:scroll;">
							<select multiple="multiple" name="" id="table_field" style="width: 100%;">
								<option>Rollno</option>
								<option>Name</option>
								<option>Mobile</option>
								<option>Email</option>
								<option>Parent's Mobile</option>
								<option>Area</option>
								<option>District</option>
							</select>
						</div>
					</div><!-- ./box-body -->
				</div>
		   </div><!-- ./row-->
		   	<div class="row">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Generated Report</h3>
					</div>
					<div class="box-body">
						
						<table id="example1" class="table table-bordered table-striped" style="font-size: 12px;width:100%;">
							<thead>
								<tr>
									<th id="Rollno"></th>
									<th id="F-name"></th>
									<th id="L-name"></th>
									<th id="Course"></th>
									<th id="Branch"></th>
									<th id="Section"></th>
									<th id="Year"></th>
									<th id="Community"></th>
									<th id="Email"></th>
								</tr>
								<tr class="table_heading">
									<!--<th>Rollno</th>
									<th>F-name</th>
									<th>L-name</th>
									<th>Course</th>
									<th>Branch</th>
									<th>Section</th>
									<th>Year</th>
									<th>Community</th>
									<th>Email</th>-->
								</tr>
							</thead><!-- ./thead  -->
							<tbody>
								<tr class="">
									<td>201308002</td>
									<td>Balakumar</td>
									<td>B</td>
									<td>MCA</td>
									<td>Computer Application</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>stsbsathish@gmail.com</td>
								</tr>
								<tr>
									<td>201305006</td>
									<td>Gowri</td>
									<td>V</td>
									<td>ME</td>
									<td>Software Engineering</td>
									<td>B</td>
									<td>1</td>
									<td>MBC</td>
									<td>gowri@gmail.com</td>
								</tr>
								<tr>
									<td>20130712</td>
									<td>Keerthi</td>
									<td>Vasan</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Mechanical Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Keerthi@gmail.com</td>
								</tr>
								<tr>
									<td>201214051</td>
									<td>Selvakumar </td>
									<td>L</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Computer Science and Engineering</td>
									<td>C</td>
									<td>4</td>
									<td>BC</td>
									<td>selvakumar@gmail.com</td>
								</tr>
								<tr>
									<td>201214052</td>
									<td>Poornima</td>
									<td>D</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>poornimadilliraja@gmail.com</td>
								</tr>
								<tr>
									<td>201214047</td>
									<td>Muthu </td>
									<td>L</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electrical and Electronic Engineering(EEE)</td>
									<td>B</td>
									<td>2</td>
									<td>BC</td>
									<td>Muthu@gmail.com</td>
								</tr>
								<tr>
									<td>201214042</td>
									<td>Saravanan </td>
									<td>k</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electronics and Communication Engineering(ECE)</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>Saravanan@gmail.com</td>
								</tr>
								<tr>
									<td>201214001</td>
									<td>Abhi Dharshan</td>
									<td>T K</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>BC</td>
									<td>Abhidharsan002@gmail.com</td>

								</tr>
								<tr>
									<td>201214003</td>
									<td>Anitha</td>
									<td>M</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>B</td>
									<td>2</td>
									<td>BC</td>
									<td>Anitha@gmail.com</td>

								</tr>
								<tr>
									<td>201214003</td>
									<td>Suganya</td>
									<td>M</td>
									<td>MBA</td>
									<td>Bussiness Administration</td>
									<td>A</td>
									<td>2</td>
									<td>MBC</td>
									<td>suganya@gmail.com</td>

								</tr>
								<tr>
									<td>201214005</td>
									<td>Arjun</td>
									<td>S D</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>MBC</td>
									<td>Arunj992@gmail.com</td>
								</tr>
								<tr>
									<td>201214006</td>
									<td>Balaji </td>
									<td>A</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>balaji5@gmail.com</td>
								</tr>
								<tr>
									<td>201214009</td>
									<td>Dhamodharan </td>
									<td>G</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Aeronautical Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>dhamodharan6@gmail.com</td>
								</tr>
								<tr>
									<td>201220001</td>
									<td>Abdul Kadar </td>
									<td>S</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Automobile Engineering</td>
									<td>B</td>
									<td>4</td>
									<td>MBC</td>
									<td>abdulkadar42@gmail.com</td>
								</tr>
								<tr>
									<td>201220003</td>
									<td>Abishek </td>
									<td>R</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Automobile Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>abishek43@gmail.com</td>
								</tr>
								<tr>
									<td>201220006</td>
									<td>Arvind Raj </td>
									<td>B</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Automobile Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>BC</td>
									<td>arvindraj44@gmail.com</td>
								</tr>
								<tr>
									<td>201220009</td>
									<td>Balendran </td>
									<td>R</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Automobile Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>BC</td>
									<td>balendran45@gmail.com</td>
								</tr>
								<tr>
									<td>201220011</td>
									<td>Bheshma Yogendra Kiran </td>
									<td>K</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Automobile Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>bheshmayogendrakiran46@gmail.com</td>
								</tr>
								<tr>
									<td>201221001</td>
									<td>Aashik Kader Mohideen </td>
									<td>S</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Biomedical Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>aashikkadermohideen74@gmail.com</td>
								</tr>
								<tr>
									<td>201221002</td>
									<td>Adithya </td>
									<td>V</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Biomedical Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>MBC</td>
									<td>adithya75@gmail.com</td>
								</tr>
								<tr>
									<td>201221003</td>
									<td>Ahamed Nashath Qudhisiya </td>
									<td>L T</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Biomedical Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>ahamednashathqudhisiya76@gmail.com</td>
								</tr>
								<tr>
									<td>201221005</td>
									<td>Akshya </td>
									<td>B</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Biomedical Engineering</td>
									<td>B</td>
									<td>3</td>
									<td>BC</td>
									<td>akshya77@gmail.com</td>
								</tr>
								<tr>
									<td>201210001</td>
									<td>Aarthi </td>
									<td>S</td>
									<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
									<td>Bio Technology</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>aarthi120@gmail.com</td>
								</tr>
								<tr>
									<td>201210003</td>
									<td>Abynasha </td>
									<td>T</td>
									<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
									<td>Bio Technology</td>
									<td>B</td>
									<td>3</td>
									<td>MBC</td>
									<td>abynasha122@gmail.com</td>
								</tr>
								<tr>
									<td>201210002</td>
									<td>Abhinaya </td>
									<td>K</td>
									<td>BACHELOR OF TECHNOLOFY(B.Tech.)</td>
									<td>Bio Technology</td>
									<td>B</td>
									<td>2</td>
									<td>BC</td>
									<td>abhinaya121@gmail.com</td>
								</tr>
								<tr>
									<td>201228003</td>
									<td>Aravindh</td>
									<td>R</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Civil Engineering</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>aravindh218@gmail.com</td>
								</tr>
								<tr>
									<td>201228005</td>
									<td>Balaji</td>
									<td>S</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Civil Engineering</td>
									<td>B</td>
									<td>4</td>
									<td>BC</td>
									<td>balaji219@gmail.com</td>
								</tr>
								<tr>
									<td>201201001</td>
									<td>Abinaya</td>
									<td>V</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Computer Science and Engineering</td>
									<td>A</td>
									<td>4</td>
									<td>BC</td>
									<td>abinaya242@gmail.com</td>
								</tr>
								<tr>
									<td>201201002</td>
									<td>Abirami</td>
									<td>E</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Computer Science and Engineering</td>
									<td>B</td>
									<td>2</td>
									<td>MBC</td>
									<td>abirami243@gmail.com</td>
								</tr>
								<tr>
									<td>201202002</td>
									<td>Abdul Tizzer </td>
									<td>A W</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electronics and Communication Engineering(ECE)</td>
									<td>A</td>
									<td>4</td>
									<td>BC</td>
									<td>abdultizzer327@gmail.com</td>
								</tr>
								<tr>
									<td>201202188</td>
									<td>Abinand </td>
									<td>N</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electronics and Communication Engineering(ECE)</td>
									<td>B</td>
									<td>3</td>
									<td>MBC</td>
									<td>abinand328@gmail.com</td>
								</tr>
								<tr>
									<td>201202001</td>
									<td>Abul Kalam Azad </td>
									<td>R S</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electronics and Communication Engineering(ECE)</td>
									<td>A</td>
									<td>4</td>
									<td>MBC</td>
									<td>abulkalamazad329@gmail.com</td>
								</tr>
								<tr>
									<td>201202008</td>
									<td>Ambika </td>
									<td>A A</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electronics and Communication Engineering(ECE)</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>ambika330@gmail.com</td>
								</tr>
								<tr>
									<td>201205001</td>
									<td>Abdul Azeem</td>
									<td>R</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electrical and Electronic Engineering(EEE)</td>
									<td>B</td>
									<td>4</td>
									<td>BC</td>
									<td>abdulazeem448@gmail.com</td>
								</tr>
								<tr>
									<td>201205002</td>
									<td>Aishwarya Rathna</td>
									<td>M</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electrical and Electronic Engineering(EEE)</td>
									<td>A</td>
									<td>4</td>
									<td>MBC</td>
									<td>aishwaryarathna449@gmail.com</td>
								</tr>
								<tr>
									<td>201205003</td>
									<td>Akshay</td>
									<td>S</td>
									<td>BACHELOR OF ENGINEERING(B.E)</td>
									<td>Electrical and Electronic Engineering(EEE)</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>akshay450@gmail.com</td>
								</tr>
								<tr>
									<td>201308018</td>
									<td>Poornima</td>
									<td>D</td>
									<td>MCA</td>
									<td>Computer Application</td>
									<td>A</td>
									<td>3</td>
									<td>BC</td>
									<td>Poornima14@gmail.com</td>
								</tr>
								<tr>
									<td>201423001</td>
									<td>Ayeshaarveen</td>
									<td>M</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Communication System</td>
									<td>B</td>
									<td>1</td>
									<td>BC</td>
									<td>Ayeshaarveen26@gmail.com</td>
								</tr>
								<tr>
									<td>201423002</td>
									<td>Bakyalakshmi</td>
									<td>V</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Communication System</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Bakyalakshmi27@gmail.com</td>
								</tr>
								<tr>
									<td>201423003</td>
									<td>Carolinheshma</td>
									<td>A</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Communication System</td>
									<td>A</td>
									<td>2</td>
									<td>MBC</td>
									<td>Carolinheshma28@gmail.com</td>
								</tr>
								<tr>
									<td>201412001</td>
									<td>Abirami</td>
									<td>R</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Computer science and Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Abirami41@gmail.com</td>
								</tr>
								<tr>
									<td>201412002</td>
									<td>Anish</td>
									<td>D</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Computer science and Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Anish42@gmail.com</td>
								</tr>
								<tr>
									<td>201432001</td>
									<td>Abrahamnthony</td>
									<td>D</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Engineering Design</td>
									<td>B</td>
									<td>2</td>
									<td>MBC</td>
									<td>Abrahamnthony50@gmail.com</td>
								</tr>
								<tr>
									<td>201432002</td>
									<td>Aravindh</td>
									<td>M</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Engineering Design</td>
									<td>A</td>
									<td>1</td>
									<td>BC</td>
									<td>Aravindh51@gmail.com</td>
								</tr>
								<tr>
									<td>201425002</td>
									<td>Banuchithra</td>
									<td>A R</td>
									<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
									<td>Biotechnology</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Banuchithra94@gmail.com</td>
								</tr>
								<tr>
									<td>201425004</td>
									<td>Lokeshumar</td>
									<td>V</td>
									<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
									<td>Biotechnology</td>
									<td>A</td>
									<td>2</td>
									<td>MBC</td>
									<td>Lokeshumar96@gmail.com</td>
								</tr>
								<tr>
									<td>201425003</td>
									<td>Divya</td>
									<td>A S</td>
									<td>MASTER OF TECHNOLOGY(M.Tech.)</td>
									<td>Biotechnology</td>
									<td>B</td>
									<td>1</td>
									<td>BC</td>
									<td>Divya95@gmail.com</td>
								</tr>
								<tr>
									<td>201422002</td>
									<td>Muthu Lakshmi</td>
									<td>A</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Software Engineering</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Muthu Lakshmi88@gmail.com</td>
								</tr>
								<tr>
									<td>201422003</td>
									<td>Nalarubiga</td>
									<td>E</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Software Engineering</td>
									<td>A</td>
									<td>1</td>
									<td>BC</td>
									<td>Nalarubiga89@gmail.com</td>
								</tr>
								<tr>
									<td>201433001</td>
									<td>Anitha</td>
									<td>M</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Embedded Systems Technologies</td>
									<td>A</td>
									<td>2</td>
									<td>BC</td>
									<td>Anitha57@gmail.com</td>
								</tr>
								<tr>
									<td>201433002</td>
									<td>Balaji</td>
									<td>M C</td>
									<td>MASTER OF ENFINEERING(ME)</td>
									<td>Embedded Systems Technologies</td>
									<td>A</td>
									<td>1</td>
									<td>BC</td>
									<td>Balaji58@gmail.com</td>
								</tr>
							</tbody><!-- ./tbody -->
							<tfoot>
								<tr>
									<th>Rollno</th>
									<th>F-name</th>
									<th>L-name</th>
									<th>Course</th>
									<th>Branch</th>
									<th>Section</th>
									<th>Year</th>
									<th>Community</th>
									<th>Email</th>
								</tr>
							</tfoot><!-- ./tfoot -->
							<!--<tfoot>
								<tr>
									<td colspan="9"><button class="btn btn-default" id="btnClear">Clear Filter</button></td>
								</tr>
							</tfoot>-->
						</table><!-- ./table -->
						
					</div><!-- box-body -->
				</div><!-- ./box-primary -->
		   </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="totopscroller"></div>
	  <?php
		include("../../footer.php");
		include("../../sidepane.php");
	  ?>
		
    </div><!-- ./wrapper -->

     <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>

	<!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.columnFilter.js"></script>
	
	<!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
	
    <!-- Page script -->
	
		<script>
			$(document).ready(function(){

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
				$('#example1').dataTable().columnFilter({
					//"sPlaceHolder" : "head:before",
					 aoColumns:[
					 			{sSelector:"#Rollno",type:"text"},
								{sSelector:"#F-name",type:"text"},
								{sSelector:"#L-name",type:"text"},
								{sSelector:"#Course",type:"select"},
								{sSelector:"#Branch",type:"select"},
								{sSelector:"#Section",type:"select"},
								{sSelector:"#Year",type:"select"},
								{sSelector:"#Community",type:"select"}
					 ]
				});
				$('#add_field').click(function(){
					var selected_field = $('#table_field').val();
					$('#selected_field').append('<option>'+selected_field+'</option>');
				});
				/*$('#btnClear').on('click',function(){
					$('.filters'').val([]);
					table.columns().search("");
					table.draw();
				});*/
			});	
		</script>

  </body>
</html>
