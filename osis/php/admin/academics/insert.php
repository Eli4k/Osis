<?php
	
	$con = new mysqli("localhost","root","","schoolportal");

	$std_id = $con->real_escape_string($_POST["std_id"]);
	$test = $con->real_escape_string($_POST["test"]);
	$score = $con->real_escape_string($_POST["score"]);
	$level = $con->real_escape_string($_POST["level"]);
	$teacher_id = $con->real_escape_string($_POST["user_id"]);
	$subject = $con->real_escape_string($_POST["subject"]);
	$term = $con->real_escape_string($_POST["term"]);
	$ac_year = $con->real_escape_string($_POST["ac_year"]);

	$sql = "INSERT INTO results(student_id, teacher_id, test, subject, class, score, term, ac_yr) VALUES('$std_id', '$teacher_id', '$test', '$subject', '$level', '$score', '$term', '$ac_year')";

	($con->query($sql))?"Data Inserted Successfully":"Something went wrong";

	
	$con->close();
?>