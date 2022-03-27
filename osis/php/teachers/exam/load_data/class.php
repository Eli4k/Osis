<?php
include '../../../../config.php';

	$output = '<option selected="selected" disabled="disabled">Select Class</option>';

	$sql = $con->query("SELECT * FROM class");

	if ($sql->num_rows > 0) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '<option value ="'.$row["c_id"].'">'.$row["cname"].'</option>';
	 	}
	 }else{
	 	$output .='<option selected="selected" disabled="disabled">No Data to show</option>';
	 }

	 $data = array("_class"=> $output);
	 echo json_encode($data);

	 $con->close();
?>