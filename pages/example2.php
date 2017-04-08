
	<?php
	include 'reader.php';
    $excel = new Spreadsheet_Excel_Reader();
	?>
	Sheet 1:<br/><br/>
    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;width:100%;>
    <?php
    $excel->read('sample.xls');    
	$x=1;
    while($x<=$excel->sheets[0]['numRows']) {
      echo "\t<tr>\n";
      $y=1;
      while($y<=$excel->sheets[0]['numCols']) {
        $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
        echo "\t\t<td>$cell</td>\n";  
       $y++;
      }  
      echo "\t</tr>\n";
     $x++;
    }
    ?>    
    </table>
	Sheet 2:<br/><br/>
    <table id="example1" class="table table-bordered table-striped" style="font-size: 12px;width:100%;">
    <?php
    $excel->read('sample.xls');    
    $x=1;
    while($x<=$excel->sheets[1]['numRows']) {
      echo "\t<tr>\n";
      $y=1;
      while($y<=$excel->sheets[1]['numCols']) {
        $cell = isset($excel->sheets[1]['cells'][$x][$y]) ? $excel->sheets[1]['cells'][$x][$y] : '';
        echo "\t\t<td>$cell</td>\n";  
        $y++;
      }  
      echo "\t</tr>\n";
      $x++;
    }
    ?>    
    </table>
	