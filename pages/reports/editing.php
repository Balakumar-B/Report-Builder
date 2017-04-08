<?php
	include("../../db_con.php");
	//define("path","http://localhost/report_builder/");
	//session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Advanced form elements</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
   <link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/examples/resources/syntax/shCore.css">
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>Editor-PHP-1.5.6/examples/resources/demo.css">
	<style type="text/css" class="init">
	
	</style>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/js/dataTables.editor.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/examples/resources/syntax/shCore.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/examples/resources/demo.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo path ?>Editor-PHP-1.5.6/examples/resources/editor-demo.js">
	</script>
	
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
			//Left side column. contains the logo and sidebar 
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
				<div class="box box-primary collapsed-box" style="margin-bottom:1%;">
					<div class="box-header with-border">
						<h3 class="box-title">Student Community Report</h3>
						<div class="box-tools pull-right">
               				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div><!-- ./box-tool -->	
					</div><!-- ./box-header --->
					<!-- form start -->
					<form role="form" action="" method="post" id = "comu_form">
						<div class="box-body">
							<!-- Course list box-->
							<div class="form-group col-md-10">
								<label>Select a Course</label>
								<select class="form-control select2" id="com_wise_course" name="com_wise_course[]" multiple="multiple" data-placeholder="Select a course" style="width: 100%;">
			
									<?php
										$query = "SELECT course_id, degree_id, course_name FROM courses;";
										$run_query = mysqli_query($con, $query);
										while($row = mysqli_fetch_array($run_query))
										{ 
											?>
											<option value=<?php echo $row["course_id"] ?> <?php if(!in_array($row['course_id'], $course) && !in_array('all', $dept_permission_reports)){echo "disabled";} ?>><?php echo $row["course_name"]; ?></option>
										<?php	
										}
									?>
								</select>
								<?php
								if(in_array('all', $dept_permission_reports)){
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all Courses</div>';
								}
								else{
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all your access rights Courses</div>';
								}
							?>
							</div>
							<!-- Branch List -->
							<div class="form-group col-md-10">
								<label>Select a Branch</label>
								<select class="form-control select2" id="com_wise_branch" multiple="multiple" name="com_wise_branch[]" data-placeholder="Select a Brach" style="width: 100%;">
									
								</select>
								<?php
								if(in_array('all', $dept_permission_reports)){
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all branches</div>';
								}
								else{
									echo '<div class="text-info" style="font-size:11px;">Leave blank to be display all your access rights branches</div>';
								}
							?>
							</div>
							<!-- Community List -->
							<div class="form-group col-md-10">
								<label>Select a Community</label>
								<select class="form-control select2" name="com_wise_community" data-placeholder="Select a Brach" style="width: 100%;">
									<option selected="selected">--Select--</option>
									<option>SC</option>
									<option>BC</option>
									<option>MBC</option>
									<option>ST</option>
									<option>Denotified Community</option>
									<option>Converted Christian from SC</option>
								</select>
								<div class="text-info" style="font-size:11px;">Leave Blank to be display all Community</div>
							</div>	
						</div><!-- ./box-body -->
						<div class="box-footer">
							<center><button type="submit" name="cummunity_wise_button" id="cummunity_wise_button" class="btn btn-primary">Submit</button></center>			
						</div>
					</form><!-- ./form -->
				</div><!-- ./box-primary -->
			<!--</div><!-- ./col-md-11 -->
		   </div><!-- ./row -->
		   <?php 
				if(isset($_POST['cummunity_wise_button'])){
				
				?>
			   <div class="row">
					<div class="box box-primary" id="community_generated_report">
						<div class="box-header with-border">
							<h3 class="box-title">Generated Report</h3>
							<!--<h4>Show Result for</h4>-->
							<p></p>
						</div>
						<div class="box-body">
							<table id="example" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<th>First name</th>
										<th>Last name</th>
										<th>Position</th>
										<th>Office</th>
										<th width="18%">Start date</th>
										<th>Salary</th>
									</tr>
								</thead>
							</table>
							<!--<div class="col-md-12" id="chart_options">
								<label class="col-md-2" style="padding-top:1%;">Select a Chart type</label>
								<div class="form-group" style="padding-top:1%;">
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="line_chart" />
										<span class="Form-label-text">Line Chart <i class="fa fa-line-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="area_chart" />
										<span class="Form-label-text">Area Chart <i class="fa  fa-area-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="bar_chart" />
										<span class="Form-label-text">Bar Chart <i class="fa fa-bar-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="pie_chart" />
										<span class="Form-label-text">Pie Chart <i class="fa fa-pie-chart"></i></span>
									</label>
									<label class="Form-label--tick">
										<input type="radio" name="charts_options" class="Form-label-radio" value="combination_chart" />
										<span class="Form-label-text">Combination</span>
									</label>
								</div><!-- ./form-group -->
							<!--</div><!-- ./chart_options -->
							
						<!-- Chart Will be Displying Here -->	
						<!--<div class="col-md-12" id="charts"></div> -->		
						
						</div><!-- box-body -->
						
					</div><!-- ./box-primary -->
		   		</div>
				<?php
					}	// isset() close here
					else{
						
					}
					?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <div id="totopscroller"></div>
	  <?php
		include("../../footer.php");
		include("../../sidepane.php");
	  ?>
		
    </div><!-- ./wrapper -->

	<!--J Q U E R Y   P L U G  I N S   I N C L U  D E D   B E L O W -->

	<!-- high charts Script -->
	<script src="<?php echo path ?>plugins/highcharts/highcharts.js"></script>
	<script src="<?php echo path ?>plugins/highcharts/exporting.js"></script>
	<script src="<?php echo path ?>/plugins/highcharts/export-csv.js"></script>
	
	<!-- Cloumn Visibility Button -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.colVis.min.js"></script>
	<!-- My custom script -->
	<script src="<?php echo path ?>Custom_script/reports.js"></script>
	
    <!-- Page script -->
		<script type="text/javascript" language="javascript" class="init">
			$(window).load(function() {
				$(".loader").fadeOut("slow");
			});
			var editor; // use a global for the submit and return data rendering in the examples

				$(document).ready(function() {
					editor = new $.fn.dataTable.Editor({
						ajax: "../php/staff.php",
						table: "#example",
						fields: [ {
								label: "First name:",
								name: "first_name"
							}, {
								label: "Last name:",
								name: "last_name"
							}, {
								label: "Position:",
								name: "position"
							}, {
								label: "Office:",
								name: "office"
							}, {
								label: "Extension:",
								name: "extn"
							}, {
								label: "Start date:",
								name: "start_date",
								type: "datetime"
							}, {
								label: "Salary:",
								name: "salary"
							}
						]
					});

					// Activate an inline edit on click of a table cell
					$('#example').on( 'click', 'tbody td:not(:first-child)', function (e) {
						editor.inline(this);
					});

					$('#example').DataTable({
						dom: "Bfrtip",
						ajax: "../php/staff.php",
						columns: [
							{
								data: null,
								defaultContent: '',
								className: 'select-checkbox',
								orderable: false
							},
							{ data: "first_name" },
							{ data: "last_name" },
							{ data: "position" },
							{ data: "office" },
							{ data: "start_date" },
							{ data: "salary", render: $.fn.dataTable.render.number( ',', '.', 0, '$' ) }
						],
						select: {
							style:    'os',
							selector: 'td:first-child'
						},
						buttons: [
							{ extend: "create", editor: editor },
							{ extend: "edit",   editor: editor },
							{ extend: "remove", editor: editor }
						]
					});
				});
					<!-- C H A R T    S C R I P T    S T A R T   H E R E -->
				
				<!-- L I N E    C H A R T -->
			<?php if(isset($_POST['cummunity_wise_button'])){
				
			?>	
        		$('input:radio').click(function(){
					//alert($(this).val());
					if($(this).val() == 'line_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						
						$('#charts').highcharts({
						chart: {
            				type: 'line'
        				},
						title: {
							text: 'Community Report chart',
							x: -20 //center
						},
						subtitle: {
							//text: 'Source: WorldClimate.com',
							x: -20
						},
						xAxis: {
							categories: [<?php echo $catagories; ?>]
						},
						yAxis: {
							title: {
								text: 'No.of Students'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						plotOptions: {
            				series: {
              				  allowPointSelect: true,
							  cursor: 'pointer'
          					  }
        				},
						tooltip: {
							valueSuffix: ' students'
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [<?php echo $series ?>]
					});
					}<!-- ./if -->
					
					<!-- A R E A   |  C H A R T -->
					
					else if($(this).val() == 'area_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						
						$('#charts').highcharts({
						chart: {
							  type: 'area'
						  },
						title: {
							text: 'Community Report Area Chart'
						},
						subtitle: {
							//text: ''
						},
						xAxis: {
							categories: [<?php echo $catagories; ?>]
						},
							/*allowDecimals: false,
							labels: {
								formatter: function () {
									return this.value; // clean, unformatted number for year
								}
							}
						},*/
						yAxis: {
							title: {
								text: 'No.of students'
							},
							
						},
						tooltip: {
							pointFormat: '{series.name} Students <b>{point.y:,.0f}</b><br/>'
						},
						plotOptions: {
							area: {
								//pointStart: 'SC',
								cursor: 'pointer',
								stacking: 'normal'
								/*marker: {
									enabled: false,
									symbol: 'circle',
									radius: 2,
									states: {
										hover: {
											enabled: true
										}
									}
								}*/
							}
						},
						series: [<?php echo $series ?>]
					});
					}<!-- ./else if for area chart-->
					
					<!-- B A R    |   C H A R T -->
					
					else if($(this).val() == 'bar_chart')
					{
						$('body,html').animate({ scrollTop: $('body').height() }, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							chart: {
								type: 'column'
							},
							title: {
								text: 'Community Report Stacked column chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							yAxis: {
								//min: 0,
								title: {
									text: 'Total students'
								},
								stackLabels: {
									enabled: true,
									style: {
										fontWeight: 'bold',
										color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
									}
								}
							},
							legend: {
								align: 'right',
								x: -30,
								verticalAlign: 'top',
								y: 25,
								floating: true,
								backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
								borderColor: '#CCC',
								borderWidth: 1,
								shadow: false
							},
							tooltip: {
								headerFormat: '<b>{point.x}</b><br/>',
								pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
							},
							plotOptions: {
								column: {
									cursor: 'pointer',
									stacking: 'normal',
									dataLabels: {
										enabled: true,
										color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
										style: {
											textShadow: '0 0 3px black'
										}
									}
								}
							},
							series: [<?php echo $series ?>]
						});
					}<!-- ./else if for bar chart(bar with stacked) -->
					
					<!-- P I E   C H A R T -->
					
					else if($(this).val() == 'pie_chart')
					{
						$('body,html').animate({scrollTop: $('body').height()}, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							chart: {
								plotBackgroundColor: null,
								plotBorderWidth: null,
								plotShadow: false,
								type: 'pie'
							},
							title: {
								text: 'Community wise Student Report chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							tooltip: {
								//pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
							},
							plotOptions: {
								pie: {
									allowPointSelect: true,
									cursor: 'pointer',
									dataLabels: {
										enabled: true,
										format: '<b>{point.name}</b>: {point.y} ',
										style: {
											color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
										}
									},
									showInLegend: true
								}
							},
							series: [{
								name: 'Students',
								colorByPoint: true,
								data: [<?php echo $pie_chart?>]
							}]
						});
					}<!-- ./else if for pie chart -->
					else if($(this).val() == 'combination_chart')
					{	
						$('body,html').animate({scrollTop: $('body').height()}, 1000); <!-- syntax (selector).animate({styles},speed,easing,callback) -->
						$('#charts').highcharts({
							title: {
								text: 'Combination chart'
							},
							xAxis: {
								categories: [<?php echo $catagories ?>]
							},
							labels: {
								items: [{
									html: '',
									style: {
										left: '50px',
										top: '18px',
										color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
									}
								}]
							},
							series: [<?php echo $combination ?>
							 , {
								type: 'pie',
								name: 'Total consumption',
								data: [<?php echo $pie_chart ?>],
								
								center: [150, 10],
								size: 100,
								showInLegend: false,
								dataLabels: {
									enabled: false
								}
							}]
						});
					}<!-- else if close for combination chart -->
				});	// ./rdion button click event close
			<?php } ?>
				<!-- C H A R T    S C R I P T    E N D   H E R E -->
		</script>
  </body>
</html>
<?php
	
?>
