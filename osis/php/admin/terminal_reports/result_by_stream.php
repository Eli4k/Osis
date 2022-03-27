<?php
 require_once '../../../config.php';
	$output = "";

	if($_POST){
		$c_id = $_POST["c_id"];
		$s_id = $_POST["stream"];

		$query = $con->query("SELECT * FROM students WHERE s_id = '$s_id' AND c_id = '$c_id' ORDER by last_name");

		if($query){
			if (!empty($query)) {
				foreach($query as $data){
					$student_id = $data["student_id"];
					$fullname = $data["last_name"].' '.$data["middle_name"].' '.$data["first_name"];
					$email = $data["email"];
					$output.='<tr><td><input type="checkbox" class="child_checkbox" id="'.$email.'" value="'.$student_id.'"</td><td>'.$fullname.'</td><td><button onclick="viewSlip(event);" class="btn btn-info btn-mini" data-id='.$student_id.'>View Slip</button><button data-publish='.$student_id.' data-email='.$email.' class="btn btn-warning btn-mini" onclick="indiPublish(event);">Publish</button></td></td></tr>';
				}
			}else{
				$output.='<tr><td>No students available for this stream</td></tr>';
			}
		}else{
			$output.='Error: '.$con->error;
		}
}else{
	$output.='Error: '.$con->error;
}

	$data= array('output' => $output);
	echo json_encode($data);

	$con->close();

?>
