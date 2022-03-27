<?php
	require_once '../../../config.php';

	$output = '';

	if(isset($_POST["user"])){
		$user = $con->real_escape_string($_POST["user"]);

		$query = $con->query("SELECT DISTINCT q.sub_id, sub.sub_name FROM quiz q
													JOIN subjects sub ON sub.sub_id = q.sub_id
													WHERE teacher_id = '$user' ORDER BY q.sub_id DESC");

if($query){
	if(!empty($query)){
		while($row = $query->fetch_assoc()){
			$id = $row["sub_id"];
			$name = $row["sub_name"];
			$output.='<option value="'.$id.'">'.$name.'</option>';
		}
	 }else{
				$output.='<option>No quiz is available</option>';
			}
		}else{
				$output.='<option>Error: '.$con->error.'</option>';
			}
}else{
		$output.='<option>'.$con->error.'</option>';
	}

$data = array("output" => $output);
echo json_encode($data);

$con->close();
?>
