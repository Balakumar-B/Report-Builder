<?php	
	include("db_con.php");
	if(isset($_SESSION['user_id'])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report-Builder| Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 
    <link rel="stylesheet" href="http://localhost/report_builder/bootstrap/css/bootstrap.min.css">-->
    <!-- Font Awesome 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
    <!-- Ionicons 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
    <!-- Theme style 
    <link rel="stylesheet" href="http://localhost/report_builder/dist/css/AdminLTE.min.css">-->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. 
    <link rel="stylesheet" href="http://localhost/report_builder/dist/css/skins/_all-skins.min.css">-->
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/daterangepicker/daterangepicker-bs3.css">
   
	<style>
		.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('dist/img/ajax-loader_trans.gif') 50% 50% no-repeat rgba(249, 249, 249, 0.76);
	}
	</style>
  </head>
  <body class="hold-transition skin-blue-light sidebar-mini">
  <div class="loader"></div> <!-- div from loader  -->	
   <div class="wrapper">
		<?php
			include("header.php");
			include("sidebar.php");
		?>
      
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
		<?php
			include("db_con.php");
			$query = "SELECT COUNT(*) FROM stu_personal_details WHERE Status = 'pursing';";
			$run_query = mysqli_query($con, $query);
			$total_students = mysqli_fetch_array($run_query);
			
			$query = "SELECT COUNT(*) FROM stu_personal_details p, degree d, courses c, branch b, current_course curr WHERE status = 'pursing' AND p.stu_rollno = curr.stu_rollno AND (d.degree_id = curr.stu_degree AND c.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) AND curr.stu_degree = 3";
			$run_query = mysqli_query($con, $query);
			$ug_students = mysqli_fetch_array($run_query);
			
			$query = "SELECT COUNT(*) FROM stu_personal_details p, degree d, courses c, branch b, current_course curr WHERE status = 'pursing' AND p.stu_rollno = curr.stu_rollno AND (d.degree_id = curr.stu_degree AND c.course_id = curr.stu_course AND b.branch_id = curr.stu_branch) AND curr.stu_degree = 2";
			$run_query = mysqli_query($con, $query);
			$pg_students = mysqli_fetch_array($run_query);
			
			$query = "SELECT COUNT(*) FROM staff_details WHERE status='active'";
			$run_query = mysqli_query($con, $query);
			$tot_staffs = mysqli_fetch_array($run_query);
		?>
		<section class="content">
			<!-- Small boxes (Total-student STUDENTS) -->
			  <div class="row">
				<div class="col-lg-3 col-xs-6">
				  <!-- small box -->
				  <div class="small-box bg-aqua">
					<div class="inner">
					  <h3><?php echo $total_students[0]; ?></h3>
					  <p>Total Students</p>
					</div>
					<div class="icon">
					 	<i class="fa fa-user"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
              <!-- small box (UG STUDENTS)-->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3><?php echo $ug_students[0]; ?><sup style="font-size: 20px"></sup></h3>
					  <p>UG STUDENTS</p>
					</div>
					<div class="icon">
					  <i class="fa fa-user"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
              <!-- small box (PG STUDENTS)-->
				  <div class="small-box bg-green">
					<div class="inner">
					  <h3><?php echo $pg_students[0] ?><sup style="font-size: 20px"></sup></h3>
					  <p>PG STUDENTS</p>
					</div>
					<div class="icon">
					  	<i class="fa fa-user"></i>
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
				
				<div class="col-lg-3 col-xs-6">
              <!-- small box (UG STUDENTS)-->
				  <div class="small-box bg-yellow">
					<div class="inner">
					  <h3><?php echo $tot_staffs[0]; ?> <sup style="font-size: 20px"></sup></h3>
					  <p>STAFFS</p>
					</div>
					<div class="icon">
					  <!--<i class="ion ion-stats-bars"></i>-->
					</div>
					<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				  </div>
				</div><!-- ./col -->
			   </div><!--./row -->
			   <div class="row">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">About</h3>
						<!--<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->	
					</div><!-- ./box-header --->
					<div class="box-body">
						<p><b><i>1. MANAGE STUDENTS:</i></b>
	In this module super admin has full privilege of adding new student to all the departments, modifying student information, further updates or deletion can be done only by the super admin. Staffs can also view the student record of their respective department and based on the privileging rights given by the super admin to the staff. Staff can modify or delete the student record from the database.
	<br /><br /></p>
						<p><b><i>2. REPORTS:</i></b>
	Reports are customized document. There are predefined categories based on that the information needed, the data’s are retrieved from the database and that can be generated as a report and also based on the user requirement. The categories can be customized and the data are retrieved as per the requirement from the database and the reports are generated the different types of charts are generated from the report and the user can select type of the chart according to their wish. The generated report can be downloaded in the various formats like pdf, excel, docx and csv. Super admin can able to view all the department records whereas staffs can view only their privileged departments. Super admin can able to generate the report from all the departments, staff can generate the report only from their department.
	<br /><br /></p>
					<p><b><i>3. LOAD EXCEL FILE:</i></b>
	This module can be accessed by both super admin and staffs. Here reports are generated from the external excel file. Once the user login into the system can only able access this module. Even the data from the excel file can be customized as per the requirement and the report are generated based on the data required.
	<br /><br /></p>
					<p><b><i>4. MANAGE STAFFS:</i></b>
This module fully controlled by super admin. To manage all the staff login process and giving access privilege is done super admin using in this module. Access privilege in the sense each staff may belong to one department there is no need of accessing other department process or information. So cut down those privilege super admin will give the access privilege to only the department they belong to. So the staff cannot access other department. This process is done by the super admin. Super admin may able to give access privilege to one or more department if there is need of accessing. Super admin can also change there or modify the access privilege whenever is a need.</p>

					</div><!-- ./box-body -->
				</div><!-- ./box -->
			<br><br>
			   </div>
		  </section><!-- ./section-content -->

        <?php
			include("sidepane.php");
		?>
      </div><!-- /.content-wrapper -->
      <?php
	  	include("footer.php");
	  ?>
    </div><!-- ./wrapper -->
	
    <script>
	  $(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		$.widget.bridge('uibutton', $.ui.button);
    </script>
 
    <script src="<?php echo path ?>plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo path ?>plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo path ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo path ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo path ?>plugins/knob/jquery.knob.js"></script>
   
   <!-- <script src="<?php echo path ?>plugins/daterangepicker/daterangepicker.js"></script>
     datepicker 
    <script src="<?php echo path ?>plugins/datepicker/bootstrap-datepicker.js"></script>-->
    <!-- Bootstrap WYSIHTML5 
    <script src="<?php echo path ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>-->
    
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo path ?>dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo path ?>dist/js/demo.js"></script>
  </body>
</html>
<?php
	}
	else{
		header("location:login.php");
		//echo "<h2>404 Page not Found !</h2>";
	}
?>