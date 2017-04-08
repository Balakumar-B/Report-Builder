<?php
include('../../db_con.php');
if(isset($_SESSION['user_id'])){
if(isset($_POST['key'])){
	$access_permission_manage_student = "";
	$access_permission_reports = "";
	$dept_permission = "";
	$dept_permission_manage_student="";
	$dept_permission_reports="";
	$staff_id = filter_var($_POST['username'], FILTER_SANITIZE_NUMBER_INT);
	$query = "SELECT staff_name, staff_gender, staff_email FROM staff_details WHERE staff_id = ".$staff_id."";
	$run_query = mysqli_query($con, $query);
	$row = mysqli_fetch_array($run_query);
	$name = $row['staff_name'];
	$send_to = $row['staff_email'];
	if($row['staff_gender'] == 'Male'){
		$prefix = 'Mr.';
	}
	else if($row['staff_gender'] == 'Female'){
		$prefix = 'Ms.';
	}
	if($_POST['staff_type']=="Teaching"){
		foreach($_POST['manage_student'] as $key=>$value){
			$access_permission_manage_student .= $value.",";
		}
		$access_permission_manage_student = rtrim($access_permission_manage_student, ',');
		foreach($_POST['manage_student_dept_perm'] as $key=>$value){
		if($value == 'own'){
			$query1 = "SELECT branch FROM `staff_teaching` WHERE staff_id = ".$staff_id."";
			$run_query1 = mysqli_query($con, $query1);
			$row1 = mysqli_fetch_array($run_query1);
			$value = $row1['branch'];
		}
			$dept_permission_manage_student .= $value.",";
		}
		$dept_permission_manage_student = rtrim($dept_permission_manage_student, ',');
		if($dept_permission_manage_student != 'all'){
			$query2 = "select branch_name from branch where branch_id IN(".$dept_permission_manage_student.")";
			$run_query2 = mysqli_query($con, $query2);
			$dept_permission_manage_student = "";
			while($row2 = mysqli_fetch_array($run_query2)){
				$dept_permission_manage_student .= $row2['branch_name'].",";
			}
			$dept_permission_manage_student = rtrim($dept_permission_manage_student, ',');
		}
		else{
			//echo "inside else managestudent accesss permissions";
			$dept_permission_manage_student = "all departments";
		}
		foreach($_POST['reports'] as $key=>$value){
			if($value == 'show_with_cus'){
				$access_permission_reports = "You can access Report with Customization option";
			}
			else if($value = 'show_without_cus'){
				$access_permission_reports = "You can access Report without Customization option";
			}
			else if($value = 'hide'){
				$access_permission_reports = "You can't access Report option";
			}
		}
		//$access_permission_reports = rtrim($access_permission_reports, ',');
		foreach($_POST['reports_dept_perm'] as $key=>$value){
			if($value == 'own'){
			$query1 = "SELECT branch FROM `staff_teaching` WHERE staff_id = ".$staff_id."";
			$run_query1 = mysqli_query($con, $query1);
			$row1 = mysqli_fetch_array($run_query1);
			$value = $row1['branch'];
			}
			$dept_permission_reports .= $value.",";
		}
		$dept_permission_reports = rtrim($dept_permission_reports, ',');
		if($dept_permission_reports != 'all'){
			$query3 = "select branch_name from branch where branch_id IN(".$dept_permission_reports.")";
			$run_query3 = mysqli_query($con, $query3);
			$dept_permission_reports = "";
			while($row3 = mysqli_fetch_array($run_query3)){
				$dept_permission_reports .= $row3['branch_name'].",";
			}
			$dept_permission_reports = rtrim($dept_permission_reports, ',');
		}
		else{
			$dept_permission_reports = "all departments";
		}
		
	} // if(teaching)
	else if($_POST['staff_type']== "Non-Teaching"){
		foreach($_POST['manage_student'] as $key=>$value){
			$access_permission_manage_student .= $value.",";
		}
		$access_permission_manage_student = rtrim($access_permission_manage_student, ',');
		foreach($_POST['manage_student_dept_perm'] as $key=>$value){
		if($value == 'own'){
			$value = $_POST['departments'];
		}
			$dept_permission_manage_student .= $value.",";
		}
		$dept_permission_manage_student = rtrim($dept_permission_manage_student, ',');
		if($dept_permission_manage_student != 'all'){
			$query2 = "select branch_name from branch where branch_id IN(".$dept_permission_manage_student.")";
			$run_query2 = mysqli_query($con, $query2);
			$dept_permission_manage_student = "";
			while($row2 = mysqli_fetch_array($run_query2)){
				$dept_permission_manage_student .= $row2['branch_name'].",";
			}
			$dept_permission_manage_student = rtrim($dept_permission_manage_student, ',');
		}
		else{
			//echo "inside else managestudent accesss permissions";
			$dept_permission_manage_student = "all departments";
		}
		foreach($_POST['reports'] as $key=>$value){
			if($value == 'show_with_cus'){
				$access_permission_reports = "You can access Report with Customization option";
			}
			else if($value = 'show_without_cus'){
				$access_permission_reports = "You can access Report without Customization option";
			}
			else if($value = 'hide'){
				$access_permission_reports = "You can't access Report option";
			}
		}
		//$access_permission_reports = rtrim($access_permission_reports, ',');
		foreach($_POST['reports_dept_perm'] as $key=>$value){
			if($value == 'own'){
				$value = $_POST['departments'];
			}
			$dept_permission_reports .= $value.",";
		}
		$dept_permission_reports = rtrim($dept_permission_reports, ',');
		if($dept_permission_reports != 'all'){
			$query3 = "select branch_name from branch where branch_id IN(".$dept_permission_reports.")";
			$run_query3 = mysqli_query($con, $query3);
			$dept_permission_reports = "";
			while($row3 = mysqli_fetch_array($run_query3)){
				$dept_permission_reports .= $row3['branch_name'].",";
			}
			$dept_permission_reports = rtrim($dept_permission_reports, ',');
		}
		else{
			$dept_permission_reports = "all departments";
		}
	}
	
	$subject = "";
	$body = "Dear ".$prefix." ".$name." <br /> Your login username and password created successfully<br />Username: <b><i>".$_POST['username']."</i></b><br />Password: <b><i>".$_POST['password']."</i></b><br />Description about Your access permissions: <br /> You can access Manage student Module with <b>".$access_permission_manage_student."</b> Acceess Rights with their <b>".$dept_permission_manage_student."</b> and Report_module with <b>".$access_permission_reports."</b> and their <b>".$dept_permission_reports." </b>";
		
		require ("../../mail/PHPMailerAutoload.php");
		require ("../../mail/class.PHPMailer.php");
		require ("../../mail/class.smtp.php");
		$mail = new PHPMailer;
		$mail-> isSMTP();
		$mail-> Host = 'smtp.gmail.com';
		$mail-> SMTPAuth = true;
		$mail-> Username = 'stsbsathish@gmail.com';
		$mail-> Password = 'raja.mani';
		$mail-> SMTPSecure = 'tls';
		$mail-> Port = 587;
		$mail-> setFrom('stsbsathish@gmail.com', '');
		$mail-> addAddress($send_to,'');
		$mail-> addReplyTo('gmgbala143@gmail.com', 'Bala');
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(!$mail->send())
		{
			echo "Mailer Error: ".$mail->ErrorInfo;
			exit;
		}
		else
		{
			echo "sent";
		}
}
else{
}
}
/*function send_mail()
{
		require ("/report_builder/mail/PHPMailerAutoload.php");
		require ("/report_builder/mail/class.PHPMailer.php");
		require ("/report_builder/mail/class.smtp.php");
		$mail = new PHPMailer;
		$mail-> isSMTP();
		$mail-> Host = 'smtp.gmail.com';
		$mail-> SMTPAuth = true;
		$mail-> Username = 'stsbsathish@gmail.com';
		$mail-> Password = 'raja.mani';
		$mail-> SMTPSecure = 'tls';
		$mail-> Port = 587;
		$mail-> setFrom('stsbsathish@gmail.com', '');
		$mail-> addAddress($send_to,'');
		$mail-> addReplyTo('gmgbala143@gmail.com', 'Bala');
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $body;
		if(!$mail->send())
		{
			echo "Mailer Error: ".$mail->ErrorInfo;
			exit;
		}
		else
		{
			echo "sent";
		}
}
/*function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}

$string = 'hello! too long here too long here too heeeeeeeeeeeeeereisaverylongword but these words are shorterrrrrrrrrrrrrrrrrrrr';
echo smart_wordwrap($string, 11) . "\n";*/
?>