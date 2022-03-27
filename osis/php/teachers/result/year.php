<?php

	require_once '../../../config.php';

	$output = '';

	if(isset($_POST["user"])){

		$user = $con->real_escape_string($_POST["user"]);

		$query = $con->query("SELECT DISTINCT q.yr_id, y.ac_yr FROM quiz q
													JOIN academic_year y ON y.yr_id = q.yr_id
													WHERE teacher_id = '$user' ORDER BY q.yr_id DESC");

			if($query){
					if(!empty($query)){
						while($row = $query->fetch_assoc()){
							$id = $row["yr_id"];
							$name = $row["ac_yr"];
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
