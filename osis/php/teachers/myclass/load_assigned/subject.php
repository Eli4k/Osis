<?php
include '../../../../config.php';

	$output = '<option value="0">Choose a Subject</option>';

	$sql = $con->query("SELECT * FROM subjects");

	if ($sql->num_rows > 0) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '<option value ="'.$row["sub_id"].'">'.$row["sub_name"].'</option>';
	 	}
	 }else{
	 	$output .='<option selected="selected" disabled="disabled">No Data to show</option>';
	 }

	 $data = array("subject"=> $output);
	 echo json_encode($data);

	 $con->close();
?>