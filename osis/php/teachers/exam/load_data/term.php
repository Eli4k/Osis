<?php
include '../../../../config.php';

	$output = '<option selected="selected" disabled="disabled">Select Academic Term</option>';

	$sql = $con->query("SELECT * FROM term");

	if ($sql->num_rows > 0) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '<option value ="'.$row["term_id"].'">'.$row["term_name"].'</option>';
	 	}
	 }else{
	 	$output .='<option selected="selected" disabled="disabled">No Data to show</option>';
	 }

	 $data = array("term"=> $output);
	 echo json_encode($data);

	 $con->close();
?>