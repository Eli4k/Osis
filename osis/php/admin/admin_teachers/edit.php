<?php
	include '../../../config.php';

	// use PHPMailer\PHPMailer\PHPMailer;
	// use PHPMailer\PHPMailer\Exception;

	$response = "";


	if (isset($_POST)){
		  	$fname = $con->real_escape_string($_POST["fname"]);
		  	$other_name = $con->real_escape_string($_POST["other_name"]);
		  	$lname = $con->real_escape_string($_POST["lname"]);
		  	$dob = $con->real_escape_string($_POST["dob"]);
		  	$gender = $con->real_escape_string($_POST["gender"]);
		  	$m_stat = $con->real_escape_string($_POST["m_stat"]);
		  	$e_date = $con->real_escape_string($_POST["e_date"]);
		  	$contact = $con->real_escape_string($_POST["contact"]);
		  	$email = $con->real_escape_string($_POST["email"]);
				$level = $con->real_escape_string($_POST["level"]);
				$subject = $con->real_escape_string($_POST["subs"]);
				$username = strtolower(substr($fname, 0,1).'.'.$lname);
				$user_count=0;
				$pwd="";

				$check_user = $con->query("SELECT * FROM teachers WHERE first_name = '$fname' AND last_name = '$lname'");
				if($check_user){
					$count = $check_user->num_rows;
					if($count > 0){
						$user_count = $count;
						$username = $username.$user_count;
						$pwd= $username.'@gbs';
					}else{
						$pwd=$username.'@gbs';
					}
				}else{$response.="Error ".$con->error;}

		  $sql = ("UPDATE teachers SET first_name='$fname', middle_name = '$other_name', last_name='$lname', teacher_id = '$username',
              password='$pwd', date_of_birth = '$dob', class_assigned = '$level', sub_assigned = '$subject', gender = '$gender', m_status = '$m_stat',
              contact = '$contact', email = '$email', emp_date = '$e_date'");

		  if ($con->query($sql)) {
		  	$response.= "User info successfully changed";
		  }else{
		  	$response.="Error: ".$con->error;
		  }
		}

		$data = array("response" => $response);
	echo json_encode($data);

	$con->close();
?>
