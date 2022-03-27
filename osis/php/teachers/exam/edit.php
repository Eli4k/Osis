<?php 

	include '../../../config.php';

	$data='';
	$exam_id = $con->real_escape_string($_POST["exam_id"]);
	$std_id = $con->real_escape_string($_POST["std_id"]);
	$_class = $con->real_escape_string($_POST["level"]);
	$subject = $con->real_escape_string($_POST["subject"]);
	$term = $con->real_escape_string($_POST["term"]);
	$ex_score = $con->real_escape_string($_POST["ex_score"]);
	$yr = $con->real_escape_string($_POST["yr"]);
	$user_id = $con->real_escape_string($_POST["user_id"]);
	$class_score = $con->real_escape_string($_POST["class_score"]);
	$s_id = $con->real_escape_string($_POST["s_id"]);


	$sql = "UPDATE exam SET student_id = '$std_id', teacher_id = '$user_id', s_id = '$s_id', sub_id = '$subject', c_id ='$_class', class_score = '$class_score',
	  	ex_score= '$ex_score', term_id = '$term', yr_id = '$yr' WHERE exam_id = '$exam_id'";

	
		if($con->query($sql))
		{
			$output = 'Changes saved successfully';
		}else{
			$output = 'Something Went wrong Unable to save changes'.$con->error;
		}

		$data = array('feedback' => $output);

	

	echo json_encode($data);
	
	


	$con->close();
?>