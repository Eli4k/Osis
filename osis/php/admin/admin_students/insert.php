<?php

	include '../../../config.php';

	// use PHPMailer\PHPMailer\PHPMailer;
	// use PHPMailer\PHPMailer\Exception;

	$message = "";

	$fname = $con->real_escape_string($_POST['fname']);
	$lname = $con->real_escape_string($_POST['lname']);
	$dob = $con->real_escape_string($_POST['dob']);
	$email = $con->real_escape_string($_POST['email']);
	$stream = $con->real_escape_string($_POST['stream']);
	$stream_txt = $con->real_escape_string($_POST['stream_txt']);
	$adm = $con->real_escape_string($_POST['adm']);
	$level = $con->real_escape_string($_POST['level']);
	$contact = $con->real_escape_string($_POST['contact']);
	$gender = $con->real_escape_string($_POST["gender"]);
	$other = $con->real_escape_string($_POST["other"]);
	$entry = $con->real_escape_string($_POST["entry"]);
	$student_id = "";
	$year = date("Y", strtotime($adm));





	$select_count = $con->query("SELECT count(sid) as total FROM students WHERE s_id = '$stream' AND YEAR(admission_date) ='$year'");
	if($select_count){
		while($row = $select_count->fetch_assoc()){
			$total = intval($row["total"]);
			$new_total = $total+1;
			// Create Student_id
			$student_id.= substr($stream_txt,0,1).$year.str_pad($new_total,3,0,STR_PAD_LEFT);

			$sql = $con->query("INSERT INTO students(first_name, middle_name, last_name, student_id, password, date_of_birth, s_id, entry_class, c_id, gender,  admission_date, email, contact)
					VALUES('$fname', '$other', '$lname', '$student_id', '$student_id', '$dob', '$stream','$entry', '$level', '$gender', '$adm', '$email', '$contact')");
							if($sql){
								$message.='User registration successful';}else{$message.='Error: '.$con->error;}
		}
	}

 		$data = array("msg"=>$message);
		echo json_encode($data);

		$con->close();
 ?>
