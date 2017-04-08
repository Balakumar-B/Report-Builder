<?php
	include('../../db_con.php');
	$mba = 70;
	$me = 37;
	$mtech = 55;
	$mca = 90;
	$be = 103;
	$btech = 14;
	$sc = "[$mba,$me,$mtech,$mca,$be,$btech]";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Advanced form elements</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/datatables/dataTables.bootstrap.css">
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
				<h1>Report
					<small>Branch Wise</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
					<li><a href="3">Report</a></li>
					<li>Branch wise</li>
				</ol>
			</section><!-- ./content-header -->
		</div><!-- ./content wrapper -->
		<?php
			include("../../footer.php");
			include("../../sidepane.php");
		?>
	</div><!-- ./wrapper -->
	
	 /* J Q U E R Y   P L U G I N S   I N C L U D E D   H E R E  */
	
	<!-- Select2 -->
    <script src="<?php echo path ?>plugins/select2/select2.full.min.js"></script>

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
	
    <!-- date-range-picker -->
    <script src="<?php echo path ?>bootstrap/js/moment.min.js"></script>
    <script src="<?php echo path ?>plugins/daterangepicker/daterangepicker.js"></script>
    
	<!-- high charts Script -->
	<script src="<?php echo path ?>plugins/highcharts/highcharts.js"></script>
	<!--<script src="../../plugins/highcharts/exporting.js"></script>-->
	
	<!-- Cloumn Visibility Button -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.colVis.min.js"></script>
	
	<!-- My custom script -->
	<script src="<?php echo path ?>Custom_script/reports.js"></script>
	
    <!-- Page script -->
	<script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		$(document).ready(function(){
			// Smooth Scrolling to top
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
			$('#example1').dataTable({
						"sDom": 'Bfrtip',
						//stateSave: true,
						lengthMenu: [
            				[ 10, 25, 50,100, -1 ],
            				[ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
        				],
						/*"buttons": [
							{
								extend: 'collection',
								text: 'Export',
								buttons: [
									'copy',
									'excel',
									'csv',
									'pdf',
									'print'
								]
							}
						],*/
						buttons: [
							'pageLength',
							{
								extend: 'pdf',
								exportOptions: {columns: ':visible'},
								filename: 'Data export',
								text:      '<i class="fa fa-file-pdf-o" style="color:red;"></i>',
								titleAttr: 'PDF',
								orientation: 'landscape',
               					pageSize: 'LEGAL',
								header: false
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
							},
							{
                				extend: 'colvis',
                				postfixButtons: [ 'colvisRestore' ],
								collectionLayout: 'fixed three-column'
							},
					],
					columnDefs: [
            			//{
							 { targets: [0, 1], visible: true},
        					 { targets: '_all', visible: true }
                			//targets: [3,4,5,7,8,9,10,11,12,14,15,16,17,18,19],
                			//visible: true,
            			//}
        			]
					
				}).columnFilter({
				//"sPlaceHolder" : "head:before",
				 aoColumns:[
							{sSelector:"#rollno",type:"text"},
							{sSelector:"#name",type:"text"},
							{sSelector:"#gender",type:"select"},
							{sSelector:"#course",type:"select"},
							{sSelector:"#branch",type:"select"},
							{sSelector:"#section",type:"select"},
							{sSelector:"#year",type:"number-range"},
							{sSelector:"#nationality",type:"select"}
				 ]
			}); // colum filter close here
		}); // document close here
		<!-- C H A R T    S C R I P T    S T A R T   H E R E -->
				
		<!-- L I N E    C H A R T -->
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
					categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
				series: [{
					name: 'SC',
					data: <?php echo $sc; ?>,
				}, {
					name: 'ST',
					data: [4, 19, 55, 22, 11, 97]
				}, {
					name: 'BC',
					data: [12, 20, 96, 54, 18, 32]
				}, {
					name: 'MBC',
					data: [120, 160, 45, 76, 67, 89]
				},
				{
					name: 'Denotified Community',
					data: [3, 2, 0, 0, 1, 0]
				},
				{
					name: 'Converted Christian from SC',
					data: [3, 8, 5, 2, 0, 1]
				}]
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
					//text: 'Source: <a href="http://thebulletin.metapress.com/content/c4120650912x74k7/fulltext.pdf">' +
						//'thebulletin.metapress.com</a>'
				},
				xAxis: {
					categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
				series: [{
					name: 'SC',
					data: <?php echo $sc; ?>,
				}, {
					name: 'ST',
					data: [4, 19, 55, 22, 11, 97]
				}, {
					name: 'BC',
					data: [12, 20, 96, 54, 18, 32]
				}, {
					name: 'MBC',
					data: [120, 160, 45, 76, 67, 89]
				},
				{
					name: 'Denotified Community',
					data: [3, 2, 0, 0, 1, 0]
				},
				{
					name: 'Converted Christian from SC',
					data: [3, 8, 5, 2, 0, 1]
				}]
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
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
					series: [{
						name: 'SC',
						data: <?php echo $sc; ?>,
					}, {
						name: 'ST',
						data: [4, 19, 55, 22, 11, 97]
					}, {
						name: 'BC',
						data: [12, 20, 96, 54, 18, 32]
					}, {
						name: 'MBC',
						data: [120, 160, 45, 76, 67, 89]
					},
					{
						name: 'Denotified Community',
						data: [3, 2, 0, 0, 1, 0]
					},
					{
						name: 'Converted Christian from SC',
						data: [3, 8, 5, 2, 0, 1]
					}]
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
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
						data: [{
							name: 'SC',
							y: 56
							
						}, {
							name: 'ST',
							y: 24,
							//sliced: true,
							//selected: true
						}, {
							name: 'BC',
							y: 10
						}, {
							name: 'MBC',
							y: 4
						}, {
							name: 'Denotified Community',
							y: 4
						}, {
							name: 'Converted Christian from SC',
							y: 8
						}]
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
						categories: ['Master of Business Administration(M.B.A)', 'Master of Engineering(M.E)', 'Master of Technology(M.Tech)', 'Master of Computer Applications(M.C.A)', 'Bachelor of Engineering(B.E)', 'Bachelors of Technology(B.Tech)']
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
					series: [{
						type: 'column',
						name: 'SC',
						data: <?php echo $sc; ?>,
					}, {
						type: 'column',
						name: 'ST',
						data: [4, 19, 55, 22, 11, 97]
					}, {
						type: 'column',
						name: 'BC',
						data: [12, 20, 96, 54, 18, 32]
					},
					{
						type: 'column',
						name: 'MBC',
						data: [120, 160, 45, 76, 67, 89]
					},
					{
						type: 'column',
						name: 'Denotified Community',
						data: [3, 2, 0, 0, 1, 0]
					},
					 {
						type: 'spline',
						name: 'Converted Christian from SC',
						data: [3, 8, 5, 2, 0, 1],
						marker: {
							lineWidth: 2,
							lineColor: Highcharts.getOptions().colors[3],
							fillColor: 'white'
						}
					}, {
						type: 'pie',
						name: 'Total consumption',
						data: [{
							name: 'SC',
							y: 13,
							//color: Highcharts.getOptions().colors[0] // Jane's color
						}, {
							name: 'ST',
							y: 23,
							//color: Highcharts.getOptions().colors[1] // John's color
						}, {
							name: 'BC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'MBC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'Denotified Community',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						},
						{
							name: 'Converted Christian from SC',
							y: 19,
							//color: Highcharts.getOptions().colors[2] // Joe's color
						}],
						
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
			
	<!-- C H A R T    S C R I P T    E N D   H E R E -->
	</script>
</body>
</html>
