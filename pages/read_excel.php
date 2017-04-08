<?php 
require_once 'PHPExcel/IOFactory.php';
// echo getcwd() . "\n"; //get current working directory
//$excelFile = "Sample.xlsx";
 //echo is_readable($excelFile);
 
 //$pathInfo = pathinfo($excelFile);
 //echo $_FILES["inputficons1"]["tmp_name"];
$inputFileName = 'Sample.csv';

/**  Identify the type of $inputFileName  **/
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
/**  Load $inputFileName to a PHPExcel Object  **/
$objPHPExcel = $objReader->load($inputFileName);

/*$type = PHPExcel_IOFactory::identify($excelFile);
$objReader = PHPExcel_IOFactory::createReader($type);
$objPHPExcel = $objReader->load($excelFile);*/
 
//Itrating through all the sheets in the excel workbook and storing the array data
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $arrayData[$worksheet->getTitle()] = $worksheet->toArray();
}

var_dump($arrayData);

?>
