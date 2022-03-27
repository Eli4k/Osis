<?php  
	require '../../../config.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$message = "";

	if (isset($_POST["add"])) {
		
		$std_id = $con->real_escape_string($_POST["std_id"]);
		$test = $con->real_escape_string($_POST["test"]);
		$score = $con->real_escape_string($_POST["score"]);
		$_class = $con->real_escape_string($_POST["level"]);
		$user_id = $con->real_escape_string($_POST["user_id"]);
		$subject = $con->real_escape_string($_POST["subject"]);
		$term = $con->real_escape_string($_POST["term"]);
		$ac = $con->real_escape_string($_POST["ac_year"]);
		$pmark = $con->real_escape_string($_POST["pmark"]);
		$ovscr = $con->real_escape_string($_POST["ovscr"]);
		$s_id = $con->real_escape_string($_POST["s_id"]);

		$check = $con->query("SELECT first_name, last_name, middle_name, s.student_id FROM results r
								JOIN students s ON r.student_id = s.student_id
								WHERE r.student_id = '$std_id' AND r.teacher_id='$user_id' AND r.sub_id ='$subject' AND r.c_id = '$_class' AND r.term_id = '$term' AND r.yr_id = '$ac'");

		


		if($check->num_rows > 0){

			while($row = $check->fetch_assoc()){
					$message .= 'A record for '.$row["first_name"].' '.$row["middle_name"].' '.$row["last_name"].': '.$std_id.' on this test already exists';
			}

		
		}else{
			$sql = $con->query("INSERT INTO results (student_id, teacher_id, test_id, sub_id, c_id, s_id, ovscr, pmark, score, term_id, yr_id) 
								VALUES ('$std_id', '$user_id', '$test', '$subject', '$_class', $s_id, '$ovscr', '$pmark', '$score', '$term', '$ac')");
			if ($sql) {
				$message .= "Record successfully entered";
			}else{
				$message .= "Something went wrong. Please check your connection.".$con->error;
			}
		}
		$data = array('message' => $message);

		echo json_encode($data);

		
	}


?>