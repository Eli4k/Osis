<?php

	require_once '../../../config.php';

	$output = '';

	if(isset($_POST["user"])){

		$user = $con->real_escape_string($_POST["user"]);

		$query = $con->query("SELECT DISTINCT q.term_id, t.term_name FROM quiz q
													JOIN term t ON t.term_id = q.term_id
													WHERE teacher_id = '$user' ORDER BY q.term_id DESC");

		if($query){
				if(!empty($query)){
					while($row = $query->fetch_assoc()){
						$id = $row["term_id"];
						$name = $row["term_name"];
						$output.='<option value="'.$id.'">'.$name.'</option>';
					}
				}else{
					$output.='<option>No quiz is available</option>';
				}
		}else{$output.='<option>Error: '.$con->error.'</option>';}
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();
?>
