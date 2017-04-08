<?php
	include("../../db_con.php");
	if(isset($_SESSION['user_id'])){
	//header('Cache-Control: max-age=1200');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report-Builder | Manage Staff</title>
	<!-- Custom css For Form Styling -->
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>dist/css/style.css" />
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/select2/select2.min.css">
	
	<!-- Internal CSS  Defined Here--->
	<style>
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
		table.dataTable th,
		table.dataTable td {
        white-space: nowrap;
   	 }
	 
	 /*This is For Fiedlset and legend style*/
	 
	 fieldset.scheduler-border {
   	 border: 2px groove rgba(0,0,0,0.1) !important;
     padding: 0 1.4em 1.4em 1.4em !important;
     margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;		
	}
	.dataTables_wrapper {
	   		overflow: auto;
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
	}
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
	td.details-control {
    background: url('../../dist/img/iconPlus.gif') no-repeat center center;
    cursor: pointer;
	}
	tr.shown td.details-control {
		background: url('../../dist/img/Icon_minus.gif') no-repeat center center;
	}
	</style>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="loader"></div> <!-- div from loader  -->
	<div class="wrapper">
		<?php
			include("../../header.php");
			include("../../sidebar.php");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Manage Staffs
					<small>View Staff access-permission</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Staffs</a></li>
					<li>View Staff Record</li>
				</ol>	
				<?php
					//echo $_SERVER['REQUEST_URI'];
					//echo $_SERVER['QUERY_STRING'];
				?>
			</section><!-- ./section content-header -->
			<section class="content">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">View staff access-permission</h3>
						<form action="" role="" method="post" id="">
							<!--<div class="input-group input-group-sm col-md-5" style="float:right;margin-top:-2%;">
              					<input type="text" name="view_stu_search" class="form-control" placeholder="Search..." autocomplete="off">
              					<span class="input-group-btn">
               						<button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat view_search_btn">Search</button>
             					</span>
            				<!--</div> ./input-group -->
						</form><!-- ./form-->
					</div><!-- ./box-heading -->
					<div class="box-body">
					
						<table id="example1" class="table table-bordered table-striped display" style="font-size:12px;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Staff-ID</th>
									<th>Staff-Name</th>
									<th>Staff-Type No</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Module</th>
									<th>Access-Permission</th>
									<th>Dept-permission</th>
									<th>Function</th>
								</tr>
							</thead>
							<tbody class="table_body_data">
								<?php
									//$non_teaching = array();
									$query = "SELECT acc.id, s.staff_id, s.staff_name, snt.department, snt.designation,CONCAT('[',GROUP_CONCAT(DISTINCT acc.access_permission),']') access_permission,CONCAT('[',GROUP_CONCAT(DISTINCT acc.module),']') module,CONCAT('[',GROUP_CONCAT(DISTINCT acc.dept_permission),']') dept_permission FROM staff_details s, access_permission acc,staff_non_teaching snt, login_info l WHERE (s.staff_id = snt.staff_id) AND s.staff_id = l.staff_id AND l.username = acc.username AND (s.status = 'active') GROUP BY s.staff_id order by acc.id desc";
									$run_query = mysqli_query($con, $query);
									/*while($row = mysqli_fetch_array($run_query)){
										$non_teaching[] = $row;
									}
									echo $query1 = "SELECT DISTINCT s.staff_id, s.staff_name, snt.department, snt.designation FROM staff_details s, access_permission acc, staff_non_teaching snt, login_info l WHERE s.staff_id = snt.staff_id AND snt.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username";
									$run_query1 = mysqli_query($con, $query1);*/
									while($result = mysqli_fetch_array($run_query)){
										echo "
										<tr id='r_".$result['staff_id']."'>
											<td>".$result['id']."</td>
											<td>".$result['staff_id']."</td>
											<td>".$result['staff_name']."</td>
											<td>Non-Teaching</td>
											<td>".$result['department']."</td>
											<td>".$result['designation']."</td>
											<td>".$result['module']."</td>
											<td>".$result['access_permission']."</td>
											<td>".$result['dept_permission']."</td>
											<td align='center'><a href='edit.php?staff_id=".$result['staff_id']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a><button type='button' id=".$result['staff_id']." class='btn btn-danger btn-sm btn-flat delete_record' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm' href=''><i class='fa fa-close'></i> Delete</button></td>
										</tr>
									";
									}
									$query = "SELECT acc.id, s.staff_id, s.staff_name, b.branch_name, st.designation,CONCAT('[',GROUP_CONCAT(DISTINCT acc.access_permission),']') access_permission,CONCAT('[',GROUP_CONCAT(DISTINCT acc.module),']') module,CONCAT('[',GROUP_CONCAT(DISTINCT acc.dept_permission),']') dept_permission FROM staff_details s, access_permission acc,staff_teaching st,login_info l, branch b WHERE (s.staff_id = st.staff_id) AND s.staff_id = l.staff_id AND l.username = acc.username AND st.branch = b.branch_id AND (s.status = 'active') GROUP BY s.staff_id order by acc.id desc";
									$run_query = mysqli_query($con, $query);
									
									$run_query = mysqli_query($con, $query);
									
									while($result = mysqli_fetch_array($run_query)){
										echo "
										<tr id='r_".$result['staff_id']."'>
											<td>".$result['id']."</td>
											<td>".$result['staff_id']."</td>
											<td>".$result['staff_name']."</td>
											<td>Teaching</td>
											<td>".$result['branch_name']."</td>
											<td>".$result['designation']."</td>
											<td>".$result['module']."</td>
											<td>".$result['access_permission']."</td>
											<td>".$result['dept_permission']."</td>
											<td align='center'><a href='edit.php?staff_id=".$result['staff_id']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a><button type='button' id=".$result['staff_id']." class='btn btn-danger btn-sm btn-flat delete_record' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm' href=''><i class='fa fa-close'></i> Delete</button></td>
										</tr>
									";
									}
								?>
								
							</tbody>
							<tfoot>
								<tr>
									<th>S.No</th>
									<th>Staff-ID</th>
									<th>Staff-Name</th>
									<th>Staff-Type No</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Module</th>
									<th>Access-Permission</th>
									<th>Dept-permission</th>
									<th>Function</th>
								</tr>
							</tfoot>
						</table>
						<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						  <div class="modal-dialog modal-sm">
							<div class="modal-content">
							 	<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       								<h4 class="modal-title" id="gridSystemModalLabel">Are you sure</h4>
								</div><!-- ./modal-footer -->
								<div class="modal-footer">
									<form action="delete.php" method="post">
									<input type="hidden" name="hidden_staff_id" value="" />
									<button type="button" name="delete" id="delete_record_id" class="btn btn-primary">Yes</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									</form>
								</div><!-- ./modal-footer -->
							</div>< <!-- ./modal-content -->
						  </div><!-- ./modal-dialog -->
						</div>
					</div><!-- ./box-body -->
					<div class="box-footer">
					
					</div>	
				</div><!-- ./box -->
			</section>
		</div><!-- ./content-wrapper -->
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	
	<!-- J Q U E R Y   P L U G I N S   I N C L U D E D   H E R E  -->
	
	<!-- Select2 -->
    <script src="<?php echo path ?>plugins/select2/select2.full.min.js"></script>

	<!-- DataTables -->
    <script src="<?php echo path ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo path ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo path ?>plugins/datatables/dataTables.responsive.min.js"></script>
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
		$(document).ready(function(){
			$("#example1").DataTable();
		}); // document close here
		$('.delete_record').click(function(){
				$('input[name=hidden_staff_id]').val(this.id);
			});// Click event close here*/
		$('#delete_record_id').click(function(){
				var hidden_staff_id = $('input[name=hidden_staff_id]').val();
				//alert(hidden_staff_id);
				$.post('live_search.php',{key: 'delete',hidden_staff_id: hidden_staff_id},function(data){
					//var data='delete';
					alert(data);
					if(data == 'delete'){
						var remove_row_string = '#r_'+hidden_staff_id;
						//alert(remove_row_string);
						$(remove_row_string).hide();
						$('.modal').modal('hide');
					}
					else{
						
					}
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