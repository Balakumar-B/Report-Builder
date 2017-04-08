<?php
	session_start();
	error_reporting(0);
	global $con;
	$con = mysqli_connect('localhost','root','','report_builder1') or die(mysqli_error());
	define("path","http://localhost/report_builder/");
	
	global $designation;
	$access_permission_manage_student = explode(',', $_SESSION['access_permission'][0]);
	$dept_permission_manage_student = explode(',', $_SESSION['dept_permission'][0]);
	
	$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
	$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);
	error_reporting(0);
	
	$query = "SELECT DISTINCT s.staff_id,s.staff_name,s.staff_gender, st.designation, l.username, l.password, b.branch_name,b.branch_id FROM staff_details s, staff_teaching st, staff_non_teaching snt, login_info l, access_permission acc, branch b WHERE s.staff_id = st.staff_id AND st.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username AND st.branch = b.branch_id AND s.staff_id = ".$_SESSION['staff_id']."";
			$run_query = mysqli_query($con, $query);
			if(mysqli_affected_rows($con) == 0)
			{
				$query1 = "SELECT DISTINCT s.staff_id,s.staff_name, s.staff_gender, snt.designation, snt.department, l.username, l.password FROM staff_details s, staff_teaching st, staff_non_teaching snt, login_info l, access_permission acc WHERE s.staff_id = snt.staff_id AND snt.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username AND s.staff_id = ".$_SESSION['staff_id']."";
				$run_query1 = mysqli_query($con, $query1);
				if(mysqli_affected_rows($con) != 0){
					$working_type = "Non-Teaching";
					$non_teaching = mysqli_fetch_array($run_query1);
					$designation = $non_teaching['designation'];
					$_SESSION['$staff_gender'] = $non_teaching['staff_gender'];
				}
				else{
					echo "No record found both teaching and non-teaching";
				}
			}
			else{
				$working_type = "Teaching";
				$teaching = mysqli_fetch_array($run_query);	
				$designation = $teaching['designation'];
				$_SESSION['$staff_gender'] = $teaching['staff_gender'];
			}
	
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<title>Report-builder Student result</title>

	<!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo path ?>bootstrap/css/bootstrap.min.css">

	<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo path ?>dist/css/font-awesome.css">
	
	<!-- Ionicons -->
		<link rel="stylesheet" href="<?php echo path ?>bootstrap/css/ionicons.min.css">
	
	<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo path ?>dist/css/AdminLTE.min.css">
	
	<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?php echo path ?>dist/css/skins/_all-skins.min.css">
	<!-- Include all Necessary Jquery Plugins -->
	<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="../resources/syntax/shCore.css">
	<!--<link rel="stylesheet" type="text/css" href="../resources/demo.css">-->
	
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="../../js/jquery-1.12.3.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../../js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../../js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../../js/dataTables.editor.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="../resources/syntax/shCore.js">
	</script>
	<script type="text/javascript" language="javascript" src="../resources/demo.js">
	</script>
	<script type="text/javascript" language="javascript" src="../resources/editor-demo.js">
	</script>
	<!-- Bootstrap 3.3.5 -->
   	<script src="<?php echo path ?>bootstrap/js/bootstrap.min.js"></script>
	
	<!-- toTop Smooth scrolling -->
	<script src="<?php echo path ?>plugins/totop/jquery.totop.js"></script>
	

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
	
	<!-- AdminLTE App -->
    <script src="<?php echo path ?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo path ?>dist/js/demo.js"></script>
	
<script type="text/javascript" language="javascript" class="init">
var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "../php/staff.php",
		table: "#example",
		fields: [ {
				label: "Rollno:",
				name: "stu_rollno"
			}, {
				label: "Semester:",
				name: "semester"
			}, {
				label: "GPA:",
				name: "gpa"
			}, {
				label: "CGPA:",
				name: "cgpa"
			}, {
				label: "Arrears:",
				name: "arrears"
			}, {
				label: "Backlog:",
				name: "backlog",
			}
		]
	} );

	// Activate an inline edit on click of a table cell
	$('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
		editor.inline( this );
	} );

	$('#example').DataTable( {
		dom: "Bfrtip",
		"pagingType": "full", //numbers, simple, simple_numbers, full, full_numbers
		lengthMenu: [
						[ 10, 25, 50,100, -1 ],
						[ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
					],
		ajax: "../php/staff.php",
		columns: [
			{
				data: null,
				defaultContent: '',
				className: 'select-checkbox',
				orderable: false
			},
			{ data: "stu_rollno" },
			{ data: "semester" },
			{ data: "gpa" },
			{ data: "cgpa" },
			{ data: "arrears" },
			{ data: "backlog"} 
		],
		select: {
			style:    'os',
			selector: 'td:first-child'
		},
		buttons: [
			'pageLength',
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor },
			{
								extend: 'pdf',
								exportOptions: {columns: ':visible'},
								filename: 'Data export',
								text:      '<i class="fa fa-file-pdf-o" style="color:red;"></i>',
								titleAttr: 'PDF',
								orientation: 'landscape',
               					pageSize: 'LEGAL',
								//header: false
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
							}
		],
		columnDefs: [
            			//{
							 { targets: [0, 1], visible: true},
        					 { targets: '_all', visible: true }
                			//targets: [3,4,5,7,8,9,10,11,12,14,15,16,17,18,19],
                			//visible: true,
            			//}
        			]
	});
});



	</script>
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img class="img-responsive" src="/report_builder/dist/img/college logo.jpg" style="width:100%;height:100%;" /></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">REC &nbsp;<b>Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="/report_builder/dist/img/<?php echo $_SESSION['$staff_gender'] ?>.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['staff_name']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header" style="height:auto;">
					
					<img src="/report_builder/dist/img/<?php echo $_SESSION['$staff_gender'] ?>.png" class="img-circle" alt="User Image">
					
                    <p>
                      <?php echo $_SESSION['staff_name']."(".$_SESSION['user_id'].")" ?> - <?php echo $designation ?> 
                      <small>Member since - <?php echo date("d M Y", strtotime($_SESSION['staff_doj'])) ?></small>
                    </p>
                  </li>
                  
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="/report_builder/pages/manage_staffs/staff_profile.php" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="/report_builder/logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
	  
	  <aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="/report_builder/dist/img/<?php echo $_SESSION['$staff_gender'] ?>.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $_SESSION['staff_name'] ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="/report_builder/index.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span></i>
              </a>
              <!--<ul class="treeview-menu">
                <li class=""><a href="index.php"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
              </ul>-->
            </li>
            <!--<li class="treeview">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Layout Options</span>
                <span class="label label-primary pull-right">4</span>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
              </ul>
            </li>
            <li>
              <a href="pages/widgets.html">
                <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">new</small>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Charts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
              </ul>
            </li>-->
            <li class="treeview <?php if('/report_builder/pages/manage_students/add.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_students/view.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_students/edit.php'==$_SERVER['PHP_SELF']){echo 'active';} else{echo '';}?>">
              <a href="#">
                <i class="fa fa-graduation-cap"></i>
                <span>Manage Students</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  <?php
				if(in_array('add', $access_permission_manage_student)){
					?>
					<li class="<?php if('/report_builder/pages/manage_students/add.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/manage_students/add.php"><i class="fa fa-user-plus"></i>Add new Student Record</a></li>
				<?php
				}
				if(in_array('view', $access_permission_manage_student)){
					?>
					<li class="<?php if('/report_builder/pages/manage_students/view.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_students/edit.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/manage_students/view.php"><i class="fa fa-eye"></i> View Student Record</a></li>
				<?php
				}
			?>
				<li class="<?php if('/report_builder/Editor-PHP-1.5.6/examples/inline-editing/simple.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/Editor-PHP-1.5.6/examples/inline-editing/simple.php"><i class="fa fa-eye"></i> University Result</a></li>
                <!--<li><a href="/report_builder/pages/managestudents/edit.php"><i class="fa fa-edit"></i> Edit Student Record</a></li>-->
                <!--<li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>-->
              </ul>
            </li>
			<?php
				if(in_array('hide', $access_permission_reports)){
					?>
					
				<?php	
				} // if(report_access_permission == 'hide') close here
				else{
					?>
					 <li class="treeview <?php if('/report_builder/pages/reports/comu_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/income_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/blood_grp_wise.php'==$_SERVER['PHP_SELF'] ||
'/report_builder/pages/reports/religion_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/nationality_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/branch_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/remark.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/previous_academic.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/city_state_wise.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/reports/customize.php'==$_SERVER['PHP_SELF']){ echo 'active'; } ?>">
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <!--<li class="treeview">
					<a href="#">
						<i class="fa fa-file-o"></i> <span>Mark wise</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="semester_wise.php"><i class="fa fa-clipboard"></i>Semester wise</a></li>
					</ul>
				</li>-->
                <li class="<?php if('/report_builder/pages/reports/comu_wise.php'==$_SERVER['PHP_SELF']){ echo 'active'; } ?>"><a href="/report_builder/pages/reports/comu_wise.php"><i class="fa fa-users"></i> Community wise</a></li>
                <li class="<?php if('/report_builder/pages/reports/income_wise.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/reports/income_wise.php"><i class="fa fa-rupee"></i> Income wise</a></li>
				<li class="<?php if('/report_builder/pages/reports/blood_grp_wise.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/reports/blood_grp_wise.php"><i class="fa fa-circle-o"></i> Blood Group wise</a></li>
				<li class="<?php if('/report_builder/pages/reports/religion_wise.php'==$_SERVER['PHP_SELF']){echo 'active';} ?>"><a href="/report_builder/pages/reports/religion_wise.php"><i class="fa fa-circle-o"></i> Religion Wise</a></li>
				<li class="<?php if('/report_builder/pages/reports/city_state_wise.php'==$_SERVER['PHP_SELF']){echo 'active';} ?>"><a href="/report_builder/pages/reports/city_state_wise.php"><i class="fa fa-circle-o"></i> City/State wise</a></li>
				<li class="<?php if('/report_builder/pages/reports/nationality_wise.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/reports/nationality_wise.php"><i class="fa fa-circle-o"></i> Nationality wise</a></li>
				<!--<li class="<?php if('/report_builder/pages/reports/branch_wise.php'==$_SERVER['PHP_SELF']){echo 'active';} ?>"><a href="/report_builder/pages/reports/branch_wise.php"><i class="fa fa-circle-o"></i> Branch wise</a></li>-->
				<li class="<?php if('/report_builder/pages/reports/remark.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/reports/remark.php"><i class="fa fa-circle-o"></i> Remark (Blackmark)wise</a></li>
				<!--<li class="<?php if('/report_builder/pages/reports/previous_academic.php'==$_SERVER['PHP_SELF']){echo 'active';} ?>"><a href="/report_builder/pages/reports/previous_academic.php"><i class="fa fa-circle-o"></i> Previous Academic wise</a></li>-->
				<?php
					if(in_array('show_with_cus', $access_permission_reports)){
						?>
						<li class="<?php if('/report_builder/pages/reports/customize.php'==$_SERVER['PHP_SELF']){echo 'active';} ?>"><a href="/report_builder/pages/reports/customize.php"><i class="fa fa-circle-o"></i> Customize Report</a></li>
					<?php	
					} // if(show_with_customize option) close here
				?>
				
              </ul>
            </li>
				<?php	
				} // if(report_access_permission != 'hide')
			?>
           
            <li class="treeview">
              <a href="/report_builder/pages/load_file.php">
                <i class="fa fa-table"></i> <span> Load CSV/EXCEL</span>
                <!--<i class="fa fa-angle-left pull-right"></i>-->
              </a>
              <!--<ul class="treeview-menu">
                <!--<li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
              </ul>-->
            </li>
			<?php
			if($_SESSION['designation'] == 'super-admin'){
				?>
					<li class="treeview <?php if('/report_builder/pages/manage_staffs/add.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_staffs/view.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_staffs/edit.php'==$_SERVER['PHP_SELF']){echo 'active';} else{echo '';}?>">
					  <a href="#">
						<i class="fa fa-users"></i>
						<span>Manage Staff</span>
						<i class="fa fa-angle-left pull-right"></i>
					  </a>
					  <ul class="treeview-menu">
						<li class="<?php if('/report_builder/pages/manage_staffs/add.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/manage_staffs/add.php"><i class="fa fa-user-plus"></i>Create staff Login</a></li>
						<li class="<?php if('/report_builder/pages/manage_staffs/view.php'==$_SERVER['PHP_SELF'] || '/report_builder/pages/manage_staffs/edit.php'==$_SERVER['PHP_SELF']){echo 'active';}?>"><a href="/report_builder/pages/manage_staffs/view.php"><i class="fa fa-eye"></i> View staff Access Permission</a></li>
					  </ul>
					</li>
				<?php
			}
			if($_SESSION['designation'] == 'staff'){
				
			}
			?>
			
           <!-- <li>
              <a href="pages/calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
            <li>
              <a href="pages/mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
              </ul>
            </li>
            <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
	  <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
	  
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
           Report
            <small>Result wise</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Report</a></li>
            <li class="active">Result wise</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
			<!--<div class="col-md-11 pull-left">-->
				<div class="box box-primary collapsed-box" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Student Result Report</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->	
					</div><!-- ./box-header --->
					<!-- form start -->
						<div class="box-body">
							<table id="example" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>Rollno</th>
										<th>Semester</th>
										<th>GPA</th>
										<th>CGPA</th>
										<th>Arrears</th>
										<th>Backlog</th>
									</tr>
								</thead>
							</table>
						</div><!-- ./box-body -->
						<div class="box-footer">
									
						</div>
					</form><!-- ./form -->
				</div><!-- ./box-primary -->
		   </div><!-- ./row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="totopscroller"></div>
	  <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016-2017 <a href="http://Abdulkalam_college.com">Rajalakshmi Engineering College</a>.</strong> All rights reserved. <span>Maintained by <strong>e-orchids Techsolution pvt Ltd.</strong></span>
</footer>
</body>
</html>