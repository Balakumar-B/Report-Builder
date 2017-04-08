<?php
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title><link rel="shortcut icon" href="dist/img/user2-160x160 copy.jpg" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
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
	
	<!-- jQuery 2.1.4 -->
    <script src="<?php echo path ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>

	<!-- Bootstrap 3.3.5 -->
   	<script src="<?php echo path ?>bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Select2 -->
    <script src="<?php echo path ?>plugins/select2/select2.full.min.js"></script>
	
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
	
	<!-- Form validation Plugin -->
	<script src="<?php echo path ?>plugins/formvalidation/jquery.validate.js"></script>
	
  </head>
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
                  <!-- Menu Body -->
                  <!--<li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>-->
                  <!-- Menu Footer-->
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

</body>
</html>
