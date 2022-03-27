<?php

	include '../../../config.php';

$result='';
	if(isset($_POST)){
		$user_id = $con->real_escape_string($_POST["user_id"]);
		$id = $con->real_escape_string($_POST["gradeId"]);
		$sql = "DELETE FROM results WHERE gradeId = '$id' AND teacher_id = '$user_id'";

		if($con->query($sql)){
			$result.= "Data Successfully Deleted";
		}else{
			$result.= "Unable to delete Record: ".$con->error;
		}
	}

	$data = array('result' => $result);
	echo json_encode($data);

$con->close();

?>
