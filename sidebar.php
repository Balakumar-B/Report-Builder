<?php
	//session_start();
	global $designation;
	$access_permission_manage_student = explode(',', $_SESSION['access_permission'][0]);
	$dept_permission_manage_student = explode(',', $_SESSION['dept_permission'][0]);
	
	$access_permission_reports = explode(',', $_SESSION['access_permission'][1]);
	$dept_permission_reports = explode(',', $_SESSION['dept_permission'][1]);
	error_reporting(0);

	/*$sql = "select designation from staff_non_teaching where department = 'admin' and designation = 'super-admin' and staff_id = ".$_SESSION['staff_id']."";
	$run_query = mysqli_query($con, $sql);
	if(mysqli_affected_rows($con) == 1){
		$designation = "super-admin"
	}
	else{
		$designation = "staff";
	}*/	
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap 3.3.5 
    <link rel="stylesheet" href="http://localhost/report_builder/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome 
    <link rel="stylesheet" href="http://localhost/report_builder/dist/css/font-awesome.css">
    <!-- Ionicons 
    <link rel="stylesheet" href="http://localhost/report_builder/bootstrap/css/ionicons.min.css">
    <!-- Theme style 
    <link rel="stylesheet" href="http://localhost/report_builder/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. 
    <link rel="stylesheet" href="http://localhost/report_builder/dist/css/skins/_all-skins.min.css">
    <!-- iCheck 
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/iCheck/flat/blue.css">
    <!-- Morris chart 
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/morris/morris.css">
    <!-- jvectormap 
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker 
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker 
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor
    <link rel="stylesheet" href="http://localhost/report_builder/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<!-- Left side column. contains the logo and sidebar -->
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
</html>	  