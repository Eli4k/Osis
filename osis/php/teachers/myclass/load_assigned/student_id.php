<?php 
	require_once '../../../../config.php';

	$output = ''; 

	$x = $_GET['x'];

	$query = "SELECT student_id, first_name, last_name FROM students WHERE student_id LIKE '%$x%'";

	$result = $con->query($query);


	$output .='<ul class="list-new" style="list-style:none; cursor:pointer" class="span10">';
 	if (!empty($result)) {
		while($row = $result->fetch_assoc()){
		$output .= '<li class="res_list" data-id="'.$row["student_id"].'">'.$row["student_id"].'- '.$row["first_name"].' '.$row["last_name"].'</li>';
		}
	}else{
		$output .= '<li>Student Not Found</li>';
	}

	$output .='</ul>';
	

	echo json_encode($output);

?>