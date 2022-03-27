<?php
include '../../../../config.php';

	$output = '<option value="0">Select the Test Type</option>';

	$sql = $con->query("SELECT * FROM test");

	if ($sql->num_rows > 0) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '<option value ="'.$row["test_id"].'">'.$row["t_name"].'</option>';
	 	}
	 }else{
	 	$output .='<option selected="selected" disabled="disabled">No Data to show</option>';
	 }

	 $data = array("test"=> $output);
	 echo json_encode($data);

	 $con->close();
?>