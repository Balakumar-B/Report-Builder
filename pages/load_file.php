<?php
	include("../db_con.php");
	//error_reporting(0);
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Repory-Builder | Load Excel</title>
	<link rel="stylesheet" type="text/css" href="<?php echo path ?>plugins/file_input_plugin/fileinput.min.css"  />
	
	<!-- DataTables -->
    <link rel="stylesheet" href="<?php echo path ?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?php echo path ?>plugins/datatables/editor.dataTables.min.css">
	
	<!-- File Export Buttons Style sheet -->
	<link rel="stylesheet" href="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.dataTables.min.css">
	<style>
		.dataTables_wrapper {
	   		overflow: auto;
		}
		.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('../dist/img/ajax-loader_trans.gif') 50% 50% no-repeat rgba(249, 249, 249, 0.76);
	}
	</style>
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
	<div class="loader"></div>  <!--div from loader  -->
	<div class="wrapper">
		<?php
			//Include the header.php
			include("../header.php");
			//Include the sidebar.php
			include("../sidebar.php");
		?>
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
				<section class="content-header">
					  <h1>
					   Report
						<small>Load Excel Book</small>
					  </h1>
					  <ol class="breadcrumb">
						<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Report</a></li>
						<li class="active">Community wise</li>
					  </ol>
				</section><!--./content-header -->
			<!-- Main Content -->
				<section class="content">
					<div class="row">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Load Excel/Csv File</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- ./box-tool -->
							</div><!-- ./box-header -->
							
							<div class="box-body">
								<!--<div class="form-group">
									<input id="input-ficons-1" name="inputficons1[]" multiple type="file" class="file-loading" data-allowed-file-extensions='["csv", "xls","xlsx"]'>
								</div>
								<div class="form-group">-->
								 <!--<div class="fileupload fileupload-new" data-provides="fileupload">
									<span class="btn btn-primary btn-file" style="width: 20%;"><span class="fileupload-new">Select file</span>
									<span class="fileupload-exists">Change</span>         <input type="file" /></span>
									<span class="fileupload-preview"></span>
									<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-close" style="font-size: 12px;"></i></a>
								 </div>-->
								 <form action="" method="post" enctype="multipart/form-data" >
									<div class="col-md-6">
										<input type="file" name="excel_file" class="filestyle" data-size="sm">
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control input-sm" name="worksheet" placeholder = "Enter worksheet no..(Ex: 0 or 1 or 2)" />
										<span class="text-danger" id="worksheet_error" style="font-size:11px;"></span>
									</div>
									<button type="submit" class="btn btn-primary btn-flat" name="load_file"><i class="fa fa-upload"></i> Upload</button>
								 </form>
							</div><!-- ./box-body-->
							
							<div class="box-footer">
							
							</div><!-- ./box-footer -->
						</div><!-- ./box -->
					</div><!--./row -->
					
			<?php 
					if(isset($_POST['load_file'])){
						$target_dir = "";
						$target_file = $target_dir . basename($_FILES["excel_file"]["name"]);
						$uploadOk = 1;
						$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
						$selector = "";
						// Check if file already exists
						if (file_exists($target_file)) {
							echo "<div class='bg bg-danger text-warning' style='padding:5px;'>Sorry, file already exists.</div>";
							$uploadOk = 0;
						}
						// Check file size
						if ($_FILES["excel_file"]["size"] > 500000) {
							echo "<div class='bg bg-danger text-warning' style='padding:5px;'>Sorry, your file is too large.</div>";
							$uploadOk = 0;
						}
						// Allow certain file formats
						if($FileType != "csv" && $FileType != "xlsx" && $FileType != "xls") {
							echo "<div class='bg bg-danger text-warning' style='padding:5px;'>Sorry, only xlsx, xls & CSV files are allowed.</div>";
							$uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
							echo "<div class='bg bg-danger text-warning' style='padding:5px;'>Sorry, your file was not uploaded.</div>";
						// if everything is ok, try to upload file
						} else {
							if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $target_file)) {
								echo "<center><div class='bg bg-success text-success' style='padding:5px;'>The file <b><i>". basename( $_FILES["excel_file"]["name"]). "</i></b> has been uploaded.!</div></center>";
							} else {
								echo "<div class='bg bg-danger text-warning' style='padding:5px;'>Sorry, there was an error uploading your file.</div>";
							}
						}
						require_once 'PHPExcel/IOFactory.php';
						$inputFileName = basename($_FILES["excel_file"]["name"]);
						//$_SESSION['inputFileName'] = realpath($inputFileName);
						/**  Identify the type of $inputFileName  **/
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						/**  Create a new Reader of the type that has been identified  **/
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						/**  Advise the Reader of which WorkSheets we want to load  **/ 
						$objReader->setLoadSheetsOnly(true); 
						/**  Load $inputFileName to a PHPExcel Object  **/
						$objPHPExcel = $objReader->load($inputFileName);
				
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
								$arrayData[] = $worksheet->toArray();
								//$arrayData[$worksheet->getTitle()] = $worksheet->toArray();
						}
					
				?>
					<div class="row">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Load Excel/Csv File</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- ./box-tool -->
							</div><!-- ./box-header -->
							<div class="box-body">
								<table id="example" class="table table-bordered table-striped compact" style="font-size: 12px;width:100%;">
									<thead>
										<tr>
										<?php
											$worksheet = $_POST['worksheet'];
											$remove[] = "'";
											$remove[] = '"';
											$remove[] = '?';
											$remove[] = ' ';
											$remove[] = '(';
											$remove[] = ')';
											$remove[] = "."; // just as another example
											for($i=0; $i < count($arrayData[$worksheet][$i]); $i++)
											{ 
												//str_replace("'", "", $arrayData[$worksheet][0][$i])
												echo "<th id='".stripslashes(str_replace($remove, "", $arrayData[$worksheet][0][$i]))."".$i."'></th>";
											} 
										?>
										</tr>
										<tr>
										<?php 
											
											for($i=0; $i < count($arrayData[$worksheet][$i]); $i++)
											{ 
												echo "<th>".$arrayData[$worksheet][0][$i]."</th>";
												//echo $arrayData['Worksheet'][0][$i]."<br />";
											} 
										?>
										</tr>
									</thead>
									<tbody>
									<?php
										for($i=1; $i < count($arrayData[$worksheet]); $i++)
										{ 
											echo "<tr>";
											for($j=0; $j<count($arrayData[$worksheet][$i]); $j++){
												echo "<td>".$arrayData[$worksheet][$i][$j]."</td>";
												//echo $arrayData['Worksheet'][$i][$j]."<br />";
											}
											echo "</tr>";
										} 
									?>
									</tbody>
									<tfoot>
										<tr>
										<?php 
											for($i=0; $i < count($arrayData[$worksheet][$i]); $i++)
											{ 
												echo "<th>".$arrayData[$worksheet][0][$i]."</th>";
											} 
											for($i=0; $i < count($arrayData[$worksheet][$i]); $i++)
											{ 
												if(is_numeric($arrayData[$worksheet][1][$i]) || is_float($arrayData[$worksheet][1][$i])){
													 $type = 'number-range';
												}
												else if(is_string($arrayData[$worksheet][1][$i])){
													//echo $arrayData[$worksheet][1][$i]."<br/>";
													$formats = array("d.m.Y", "d/m/Y", "d-m-Y", "d.m.Y", "Y/m/d", "Y-m-d", "Y.m.d", "Ymd", "YY MM DD", "YY/MM/DD", "yy-MM-DD", "M-DD-y", "y-M-DD"); // and so on.....
													$input = $arrayData[$worksheet][1][$i];
													foreach ($formats as $format)
													{
													  //echo "Applying format $format on date $input...<br>";

													  $date = DateTime::createFromFormat($format, $input);
													  if ($date == false) {
														  //echo "failed";
														  $type = "select";
													  }
													  else{
														  //echo "Success";
														  $type = "number-range";
														  break;
													  } 
													}
												}
												else{}
													$selector .= '{sSelector:"#'.stripslashes(str_replace($remove, "", $arrayData[$worksheet][0][$i])).''.$i.'",type:"'.$type.'"},';
											} 
											//echo $selector;
										?>
										</tr>
									</tfoot>
								</table><!-- ./table -->
							</div><!-- ./box-body -->
							<div class="box-footer">
								<?php 
									
									//print_r($arrayData['Worksheet'][0]);
									//print_r($arrayData['Worksheet'][1]);
									//echo count($arrayData[$worksheet][0]);
									/*echo count($arrayData[1][0]);
									$worksheet = 0;
									for($i=0; $i < count($arrayData[$worksheet][$i]); $i++)
									{ 
										echo $arrayData[$worksheet][0][$i]."<br />";
									} 
									
									for($i=1; $i < count($arrayData[$worksheet]); $i++)
									{ 
										for($j=0; $j<count($arrayData[$worksheet][$i]); $j++){
											echo $arrayData[$worksheet][$i][$j]."<br />";
										}
									} */
									/*if (count($arrayData) == count($arrayData, COUNT_RECURSIVE)) 
									{
									  echo 'array is not multidimensional';
									}
									else
									{
									  echo 'array is multidimensional';
									}*/
									//var_dump($arrayData);
								?>
							</div><!-- ./box-footer -->
						</div><!-- ./box box-primary -->
					</div><!-- ./row -->
				<?php
							unlink($inputFileName);
						}	// isset() close here
						else{
							
						}
					?>		
				</section><!-- ./section-content -->
		</div><!-- ./content-wrapper -->
		<div id="totopscroller"></div>
		<?php
			//Include the footer page
			include("../footer.php");
			//Include the sidepane page
			include("../sidepane.php");
		?>
	</div><!-- ./wrapper -->	
	
	<!-- File-Input Plugin -->
	<script src="<?php echo path ?>bootstrap/js/bootstrap-filestyle.min.js"></script>
	<script src="<?php echo path ?>plugins/datatables/dataTables.select.min.js"></script>
	
	<!-- Cloumn Visibility Button -->
	<script src="<?php echo path ?>plugins/exportpdfcsvxsl_plugins/buttons.colVis.min.js"></script>	
	
	<!-- PAGE Script -->
	
	<script>
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
		$(document).ready(function(){
			$(":file").filestyle();
			$('button[name=load_file]').prop('disabled', true);
			var table = $('#example').dataTable({
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
								orientation: 'portrait',
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
								extend: 'copyHtml5',
								exportOptions: {columns: ':visible'},
								text:      '<i class="fa fa-clipboard"></i>',
                				titleAttr: 'Copy'
							},
							{
								extend: 'print',
								exportOptions: {columns: ':visible'},
								pageSize: 'LEGAL'
							},
							{
								text: 'Customize Column',
                				extend: 'colvis',
                				postfixButtons: [ 'colvisRestore' ],
								collectionLayout: 'fixed three-column'
							},
							/*{
								text: 'Remove row',
                				action: function ( e, dt, node, config ) {
									alert("yes");
									  table.rows( $(this).parents('tr')).remove().draw();
									//table.row('.selected').remove().draw( false );
								}
							},*/
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
					 			<?php echo $selector ?>
					 ]
				});
				$('#example tbody').on( 'click', 'tr', function () {
					//alert("select");
					  table.rows($(this).parents('tr')).remove().draw();
					$(this).toggleClass('selected');
				} );
		});	 // document close here
		$('input[name=worksheet]').keyup(function(){
			if($('input[name=excel_file]').val() == ''){
				$('#worksheet_error').text('First Choose Excel file!');
				$('button[name=load_file]').prop('disabled', true);
			}
			else if($(this).val() == '' || $(this).val() == ' '){
				$('#worksheet_error').text('does not empty pls specify worksheet');
				$('button[name=load_file]').prop('disabled', true);
			}
			else{
				$('#worksheet_error').text('');
				$('button[name=load_file]').prop('disabled', false);
			}
		}); 
	</script>
</body>
</html>
<?php
	/*function date_check($input){
		$formats = array("d.m.Y", "d/m/Y", "d-m-Y", "d.m.Y", "Y/m/d", "Y-m-d", "Y.m.d", "Ymd", "YY MM DD", "YY/MM/DD", "yy-MM-DD", "M-DD-y", "y-M-DD"); // and so on.....
		//$input = "1993/02/23";
		foreach ($formats as $format)
		{
		  echo "Applying format $format on date $input...<br>";

		  $date = DateTime::createFromFormat($format, $input);
		  if ($date == false) 
		   return "Failed";
		  else
		   return "Success";
		}
	}*/

?>