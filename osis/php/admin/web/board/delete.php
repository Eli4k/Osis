<?php
	require_once '../../../../config.php';

	$output = array();

	if(isset($_POST)){
		$id = $con->real_escape_string($_POST["id"]);

		$query = $con->query("DELETE FROM board WHERE board_id = '$id'");

		if($query){
			$output["success"] = "Record deleted successfully";
		}else{
			$output["error"] = "Error: ".$con->error;
		}

	}

	$data = array("output" => $output);

	echo json_encode($data);

	$con->close();


?>