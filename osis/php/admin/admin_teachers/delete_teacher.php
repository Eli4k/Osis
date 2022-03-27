<?php
	$con = new mysqli("localhost","root","","schoolportal");

// Delete Record
	if (isset($_GET["del_id"])) {
		$del_id = $_GET["del_id"];
		$response = "";

		$sql = "DELETE FROM teachers WHERE tid = '$del_id'";

		if($con->query($sql)){
			$response .="Record successfully deleted";
		}else{
			$response .= "Unable to delete record: ".$con->error;
		}

		$data = array("cmd_response" => $response);
		echo json_encode($data);
	}

	// Multi DELETE
	if(!empty($_POST["multi_id"]))
	{
		foreach($_POST as $teacher_id){
			$sql = $con->query("DELETE FROM teachers WHERE tid in ($teacher_id)");
			if($sql){
				$reponse = "Records Successfully deleted";
			}else {
				$response = "Something Went Wrong ".$con->error;
			}
		}
		$data = array('cmd_response' => $response);
		echo json_encode($data);
	}






	$con->close();
?>
