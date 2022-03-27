<?php

	require '../../../config.php';

	$message = "";

	if(isset($_POST["add"])){

		$std_id = $con->real_escape_string($_POST["std_id"]);
		$_class = $con->real_escape_string($_POST["level"]);
		$user_id = $con->real_escape_string($_POST["user_id"]);
		$sub_id = $con->real_escape_string($_POST["subject"]);
		$term = $con->real_escape_string($_POST["term"]);
		$yr_id = $con->real_escape_string($_POST["ac_year"]);
		$s_id = $con->real_escape_string($_POST["s_id"]);
		$class_score = $con->real_escape_string($_POST["class_score"]);
		$ex_score = $con->real_escape_string($_POST["ex_score"]);

		$check = $con->query("SELECT first_name, last_name, middle_name, s.student_id FROM exam e
								JOIN students s ON e.student_id = s.student_id
								WHERE e.student_id = '$std_id' AND e.teacher_id='$user_id' AND e.sub_id ='$sub_id' AND e.c_id = '$_class' AND e.term_id = '$term' AND e.yr_id = '$yr_id' AND e.s_id = '$s_id'"
							);

		if(!empty($check)){
			while($row = $check->fetch_assoc()){
					$message.= "A record for ".$row["first_name"]." ".$row["middle_name"]." ".$row["last_name"]." of student id: ".$std_id." concerning this term's exam already exists.";
			}
		}else{
			$sql = $con->query("INSERT INTO exam(teacher_id, student_id, c_id, s_id, term_id, sub_id, yr_id, class_score, ex_score)
								VALUES('$user_id', '$std_id', '$_class', '$s_id','$term', '$sub_id', '$yr_id', '$class_score', '$ex_score')");
			if($sql){
				$message.='Record successfully entered';
			}else{
				$message.='Something went wrong. Please check your connection.'.$con->error;
			}
		}
	}else{
		$message.='Error: '.$con->error;
	}

	$data = array('message' => $message);
	echo json_encode($data);

	$con->close();


?>
