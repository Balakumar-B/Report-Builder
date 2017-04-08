<?php
	include("db_con.php");
	$module = array();
	$access_permission = array();
	$dept_permission = array();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report builder | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="dist/css/font-awesome.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bootstrap/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
	
	<style>
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
  <body class="hold-transition login-page">
	<div class="loader"></div> <!-- div from loader  -->
    <div class="login-box">
      <div class="login-logo">
       Super-admin/Staff <br /> <b>Login</b>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="#" method="post">
          <div class="form-group has-feedback">
            <input type="text" name = "username" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-user form-control-feedback" ></span>
			<span id="username_error" class = "text-danger"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name = "password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback" ></span>
			<span id="pwd_error" class = "text-danger"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name = "login" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
        <!--<div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div><!-- /.social-auth-links -->

        <a href="#">I forgot my password</a><br>
        <!--<a href="register.html" class="text-center">Register a new membership</a>-->
		<?php
			if(isset($_POST['login'])){
				$query = "SELECT * FROM `login_info` WHERE username = '".$_POST['username']."'";
				
				$run_query = mysqli_query($con, $query);
				
				if(mysqli_affected_rows($con) == 1){
					$row = mysqli_fetch_array($run_query);
					if($row['password']!= md5($_POST['password'])){
						echo "<span class='text-danger' style='font-size:16px;'>invalid password</span>";
					}
					else{
						echo $query = "SELECT s.staff_id,s.staff_name,s.staff_doj, acc.module, acc.access_permission, acc.dept_permission FROM access_permission acc, staff_details s, login_info l WHERE acc.username = '".$_POST['username']."' AND s.staff_id = l.staff_id AND l.username = acc.username";
						$run_query = mysqli_query($con, $query);
						while($row1 = mysqli_fetch_array($run_query)){
							$_SESSION['staff_id'] = $row1['staff_id'];
							$_SESSION['staff_doj'] = $row1['staff_doj'];
							$_SESSION['staff_name'] = $row1['staff_name'];
							$module[] = $row1['module'];
							$access_permission[] = $row1['access_permission'];
							$dept_permission[] = $row1['dept_permission'];
						} // while() close here
						$_SESSION['module'] = $module; 
						$_SESSION['access_permission'] = $access_permission;
						$_SESSION['dept_permission'] = $dept_permission;
						$_SESSION['user_id'] = $_POST['username'];
						
						$sql = "select designation from staff_non_teaching where department = 'admin' and designation = 'super-admin' and staff_id = ".$_SESSION['staff_id']."";
						$run_query = mysqli_query($con, $sql);
						if(mysqli_affected_rows($con) == 1){
							$_SESSION['designation'] = "super-admin";
						}
						else{
							$_SESSION['designation'] = "staff";
						}
						header("location:index.php");
					} //else() valid user close here
				}
				else{
					echo "<span class='text-danger' style='font-size:16px;'>Invalid Username</span>";
				}
				//$query1 =  "AND password = md5('".$_POST['password']."')";
				//$query = $query . $query1;
				
			}
			else{
				//echo "Un-Authorize access";
			}
		?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
      $(document).ready(function(){
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
