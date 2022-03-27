<?php

	include '../../../config.php';

	if(isset($_POST["exam_id"])){
		$exam_id = $_POST["exam_id"];
		$sql = "DELETE FROM exam WHERE exam_id = '$exam_id'";

		if($con->query($sql)){
			$result = "Data Successfully Deleted";
		}else{
			$result = "Unable to delete Record: ".$con->error;
		}
	}else{
		$result = "Error: ".$con->error;
	}



	$data = array('result' => $result);

	echo json_encode($data);

$con->close();

?>
