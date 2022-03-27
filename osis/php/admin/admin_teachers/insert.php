<?php
	include '../../../config.php';
	//
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
				$user_count="";
				$pwd="";

				$check_user = $con->query("SELECT * FROM teachers WHERE first_name = '$fname' AND last_name = '$lname'");
				if($check_user){
					$count = $check_user->num_rows;
					if($count > 0){
						$user_count = $count;
						$username.= $user_count;
						$pwd= $username.'@gbs';
					}else{
						$pwd=$username.'@gbs';
					}
				}else{$response.="Error ".$con->error;}

	$sql = "INSERT INTO teachers (first_name, middle_name, last_name, teacher_id, password,  date_of_birth,class_assigned, sub_assigned, gender,m_status, contact, email, emp_date)
										VALUES ('$fname', '$other_name', '$lname', '$username', '$pwd', '$dob', '$level','$subject', '$gender', 	'$m_stat', '$contact', '$email', '$e_date')";

		  if ($con->query($sql)) {
		  	$response.= "User successfully registered";
		  }else{
		  	$response.="Unable to add record: ".$con->error;
		  	exit();
		  }
		}

		$data = array("insert_response" => $response);
	echo json_encode($data);

	$con->close();
?>
