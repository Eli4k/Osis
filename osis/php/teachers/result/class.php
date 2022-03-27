<?php

	require_once '../../../config.php';

	$output="";

	if(isset($_POST["user"])){

		$user = $con->real_escape_string($_POST["user"]);

		$query = $con->query("SELECT DISTINCT q.c_id, c.cname FROM quiz q
													JOIN class c ON c.c_id = q.c_id
													WHERE teacher_id = '$user' ORDER BY q.c_id DESC");

		if($query){
				if(!empty($query)){
					while($row = $query->fetch_assoc()){
						$id = $row["c_id"];
						$name = $row["cname"];
						$output.='<option value="'.$id.'">'.$name.'</option>';
					}
				}else{
					$output.='<option>No quiz is available</option>';
				}
		}else{
				$output.='<option>Error: '.$con->error.'</option>';
			}
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();
?>
