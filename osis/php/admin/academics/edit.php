<?php 

	$con = new mysqli("localhost","root","","schoolportal");

	$gradeId = $con->real_escape_string($_POST["grade"]);
	$std_id = $con->real_escape_string($_POST["std_id"]);
	$test = $con->real_escape_string($_POST["test"]);
	$class = $con->real_escape_string($_POST["level"]);
	$subject = $con->real_escape_string($_POST["subject"]);
	$term = $con->real_escape_string($_POST["term"]);
	$score = $con->real_escape_string($_POST["score"]);
	$user_id = $con->real_escape_string($_POST["user_id"]);

	$sql = "UPDATE results SET student_id = '$std_id', teacher_id = '$user_id', test = '$test', subject = '$subject', class ='$class', score = '$score', term = '$term' WHERE gradeId = '$gradeId'";

	if($con->query($sql))
		{
			$output = 'Changes saved successfully';
		}else{
			$output = 'Something Went wrong Unable to save changes';
		}

	$data = array('feedback' => $output);

	echo json_encode($data);

	$con->close();
?>