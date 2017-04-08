<?php
	include("../../db_con.php");
	//header('Cache-Control: max-age=1200');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Manage Staff</title>
	<!-- Custom css For Form Styling -->
	<link rel="stylesheet" type="text/css" href="<?php echo admin_index; ?>dist/css/style.css" />
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo admin_index; ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo admin_index; ?>plugins/select2/select2.min.css">
	
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
							<div class="input-group input-group-sm col-md-5" style="float:right;margin-top:-2%;">
              					<input type="text" name="view_stu_search" class="form-control" placeholder="Search..." autocomplete="off">
              					<span class="input-group-btn">
               						<button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat view_search_btn">Search</button>
             					</span>
            				</div><!-- ./input-group -->
						</form><!-- ./form-->
					</div><!-- ./box-heading -->
					<div class="box-body">
					
						<table id="example" class="table table-bordered table-striped display" style="font-size:12px;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th></th>
									<th>Staff-ID</th>
									<th>Staff-Name</th>
									<th>Staff-Type No</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Function</th>
									<?php
										$name = "BALAKUMAR";
										$rollno = 201308002;
										$complex = array('more', 'complex', 'object', array('foo', 'bar'));
									?>
								</tr>
							</thead>
							<tbody class="table_body_data">
								<?php
									$non_teaching = array();
									echo $query = "SELECT s.staff_id, s.staff_name, snt.department, snt.designation, acc.access_permission, acc.module, acc.dept_permission FROM staff_details s, access_permission acc, staff_non_teaching snt, login_info l WHERE s.staff_id = snt.staff_id AND snt.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username";
									$run_query = mysqli_query($con, $query);
									while($row = mysqli_fetch_array($run_query)){
										$non_teaching[] = $row;
									}
									echo $query1 = "SELECT DISTINCT s.staff_id, s.staff_name, snt.department, snt.designation FROM staff_details s, access_permission acc, staff_non_teaching snt, login_info l WHERE s.staff_id = snt.staff_id AND snt.staff_id = l.staff_id AND l.staff_id = s.staff_id AND l.username = acc.username";
									$run_query1 = mysqli_query($con, $query1);
									while($result = mysqli_fetch_array($run_query1)){
										echo "
										<tr>
											<td></td>
											<td>".$result['staff_id']."</td>
											<td>".$result['staff_name']."</td>
											<td>Non-Teaching</td>
											<td>".$result['department']."</td>
											<td>".$result['designation']."</td>
											<td align='center'><a href='edit.php?rollno=".$result['staff_id']."' class='btn btn-info btn-sm btn-flat'><i class='fa fa-edit'></i> Edit</a><button type='button' class='btn btn-danger btn-sm btn-flat' name='remove_levels' data-toggle='modal' data-target='.bs-example-modal-sm' href=''><i class='fa fa-close'></i> Delete</button></td>
										</tr>
									";
									}
								?>
								
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>Staff-ID</th>
									<th>Staff-Name</th>
									<th>Staff-Type No</th>
									<th>Department</th>
									<th>Designation</th>
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
									<button type="button" class="btn btn-primary">Yes</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
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
    <script src="<?php echo admin_index; ?>plugins/select2/select2.full.min.js"></script>

	<!-- DataTables -->
    <script src="<?php echo admin_index; ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo admin_index; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?php echo admin_index; ?>plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="<?php echo admin_index; ?>plugins/datatables/jquery.dataTables.columnFilter.js"></script>
	
    <!-- InputMask -->
    <script src="<?php echo admin_index; ?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo admin_index; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo admin_index; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- Currency format -->
	<script src="<?php echo admin_index; ?>plugins/currency_format/autoNumeric-min.js"></script>
	<!-- Form validation Plugin -->
	<script src="<?php echo admin_index; ?>plugins/formvalidation/jquery.validate.js"></script>
	<!-- Custom Script -->
	<script src="<?php echo admin_index; ?>Custom_script/custom_add.js"></script>
	
	<!-- Page script -->
	<script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		var name = '<?php echo $name; ?>';
		var complex = <?php echo json_encode($complex); ?>;
		var non_teaching = <?php echo json_encode($non_teaching); ?>;
		var module = new Array();
		var access_permission = new Array();
		var dept_permission = new Array();
		$.each(non_teaching, function(key, value){
				module.push(value.module);
				access_permission.push(value.access_permission);
				dept_permission.push(value.dept_permission);
				/*var table_data += "'<tr>'+
					'<td>'+value.module+'</td>'+
					'<td>'+value.access_permission+'</td>'+
					'<td>'+value.dept_permission+'</td>'+
				'</tr>'+";*/
		});
		//alert( $.toJSON(non_teaching));
		/* Formatting function for row details - modify as you need */
		function format ( d ) {
			//var table_data = "";
			// `d` is the original data object for the row
			/*return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
				'<tr>'+
					'<td>Full name:</td>'+
					'<td>'+name+'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>Extension number:</td>'+
					'<td>'+complex[0]+'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>Extra info:</td>'+
					'<td>And any further details here (images etc)...</td>'+
				'</tr>'+
			'</table>';*/
			return '<table id="example" class="table table-bordered table-striped display" style="font-size:12px;" cellspacing="0" width="100%">	'+
				'<thead>'+
				'<tr>'+
					'<th>Module</td>'+
					'<th>Access-permission</td>'+
					'<th>Dept-Permission</td>'+
				'</tr>'+
				'</thead>'+
					'<tr>'+
						'<td>'+module[0]+'</td>'+
						'<td>'+access_permission[0]+'</td>'+
						'<td>'+dept_permission[0]+'</td>'+
					'</tr>'+
					'<tr>'+
						'<td>'+module[1]+'</td>'+
						'<td>'+access_permission[1]+'</td>'+
						'<td>'+dept_permission[1]+'</td>'+
					'</tr>'+
			'</table>';
			
		}
 
		$(document).ready(function(){
				 var table = $('#example').DataTable( {
				//"ajax": "../ajax/data/objects.txt",
				"columns": [
					{
						"className":      'details-control',
						"orderable":      false,
						"data":           null,
						"defaultContent": ''
					},
					{ "data": "staff_id" },
					{ "data": "staff_name" },
					{ "data": "staff_type" },
					{ "data": "department" },
					{ "data": "designation" },
					{ "data": "" }
				],
				"order": [[1, 'asc']]
			} );
			// Add event listener for opening and closing details
			$('#example tbody').on('click', 'td.details-control', function () {
				var tr = $(this).closest('tr');
				var row = table.row(tr);
		 
				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				}
				else {
					// Open this row
					row.child(format(row.data())).show();
					tr.addClass('shown');
				}
			});
			$('#example tbody').on('click', 'tr', function () {
				//alert('hi');
				if ($(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
		}); // document close here
	</script>
	
</body>
</html>
