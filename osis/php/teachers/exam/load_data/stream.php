<?php
include '../../../../config.php';

	$output = '<option selected="selected" disabled="disabled">Select Stream</option>';

	$sql = $con->query("SELECT * FROM stream");

	if ($sql->num_rows > 0) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '<option value ="'.$row["s_id"].'">'.$row["s_name"].'</option>';
	 	}
	 }else{
	 	$output .='<option selected="selected" disabled="disabled">No Data to show</option>';
	 }

	 $data = array("s_name"=> $output);
	 echo json_encode($data);

	 $con->close();
?>