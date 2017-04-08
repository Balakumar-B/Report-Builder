<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - Managestudents</title>
	<!-- Custom css For Form Styling -->
	<link rel="stylesheet" type="text/css" href="../../dist/css/style.css" />
	 <!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css" />
	<!-- Font Awesome -->
	<link rel="stylesheet" type="text/css" href="../../dist/css/font-awesome.css" />
	<!-- Ionicons -->
	<link rel="stylesheet" type="text/css" href="../../bootstrap/css/ionicons.min.css" />
	<!-- Theme style -->
	<link rel="stylesheet" type="text/css" href="../../dist/css/AdminLTE.min.css" />
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<!-- daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../plugins/iCheck/all.css">
	<!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../plugins/select2/select2.min.css">
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
	</style>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="wrapper">
		<?php
			include("../../header.php");
			include("../../sidebar.php");
		?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Manage Students
					<small>View Student Record</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"></a>Home</li>
					<li><a href="#">Manage Students</a></li>
					<li>View Student Record</li>
				</ol>	
			</section><!-- ./section content-header -->
			<section class="content">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">View Student</h3>
						<form action="" role="" method="" id="">
							<div class="input-group input-group-sm col-md-5" style="float:right;margin-top:-2%;">
              					<input type="text" name="view_stu_search" class="form-control" placeholder="Search..." autocomplete="off">
              					<span class="input-group-btn">
               						<button type="submit" name="search" id="search-btn" class="btn btn-info btn-flat">Search</button>
             					</span>
            				</div><!-- ./input-group -->
						</form><!-- ./form-->
					</div><!-- ./box-heading -->
					<div class="box-body">
					
						<table id="example" class="table table-bordered table-striped display" style="font-size:12px;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Salary</th>
									<th>Action</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Name</th>
									<th>Position</th>
									<th>Office</th>
									<th>Salary</th>
									<th>Action</th>
								</tr>
							</tfoot>
						</table>
					
					</div><!-- ./box-body -->
				</div><!-- ./box -->
			</section>
		</div><!-- ./content-wrapper -->
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	<!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="../../plugins/datatables/jquery.dataTables.columnFilter.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
	<!-- toTop Smooth scrolling -->
	<script src="../../plugins/totop/jquery.totop.js"></script>
	<!-- Form validation Plugin -->
	<script src="../../plugins/formvalidation/jquery.validate.js"></script>
	<script>
		/* Formatting function for row details - modify as you need */
		function format ( d ) {
			// `d` is the original data object for the row
			/*return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
				'<tr>'+
					'<td>Full name:</td>'+
					'<td>'+d.name+'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>Extension number:</td>'+
					'<td>'+d.extn+'</td>'+
				'</tr>'+
				'<tr>'+
					'<td>Extra info:</td>'+
					'<td>And any further details here (images etc)...</td>'+
				'</tr>'+
			'</table>';*/
			return '<fieldset class="scheduler-border">'+ 
						'<legend class="scheduler-border text-info">Personal Details</legend>'+
						'<form action="" method="" role="" name="" id="">'+
							'<div class="from-group" style="margin-top:1%;">'+
								'<label class="col-sm-1 control-label" for="rollno">Rollno <span class="text-danger">*</span></label>'+
								'<div class="col-sm-6">'+
									'<input type="text" name="rollno" class="form-control input-xm" id="rollno" value="'+d.name+'" autocomplete="off" style="width:80%;" />'+
								'</div><!-- ./lg6-->'+
							'</div><!-- ./form group for rollno-->'+
						 '</form>'+
					 '</fieldset>';				
		}
		$(document).ready(function() {
   				 //$('#example').DataTable();
				  var table = $('#example').DataTable({
					"ajax": "objects.txt",
					"columns": [
						{ "data": "name" },
						{ "data": "position" },
						{ "data": "office" },
						{ "data": "salary" },
						{
							"className":      'details-control',
							"orderable":      false,
							"data":           null,
							"defaultContent": '<button type="button" class="btn btn-block	 btn-success btn-xs">Edit/Delete</button>'
						}
					],
					"order": [[1, 'asc']]
		});
		
		// Add event listener for opening and closing details
			$('#example tbody').on('click', 'td.details-control', function(){
				var tr = $(this).closest('tr');
				var row = table.row(tr);
		 
				if (row.child.isShown()) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
				}
				else {
					// Open this row
					row.child( format(row.data())).show();
					tr.addClass('shown');
				}
			});
		});
	</script>
</body>
</html>
