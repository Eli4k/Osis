<?php 
	
	$con = new mysqli("localhost","root","","schoolportal");

	$output = '<option value="0">Choose Academic Year</option>';

	$sql = $con->query("SELECT * FROM academic_year ORDER BY yr_id DESC ");

	if ($sql->num_rows > 0) {
		$i = 1;
			while($row = $sql->fetch_assoc())
			{
				$output .= ' <option value="'.$row["yr_id"].'">'.$row["ac_yr"].'</option>';
                     $i++;
			}
	}else{
		$output .= '<option disabled="disable" selected="selected">Choose Academic Year</option>';
	}

	$data = array('result' => $output);

	echo json_encode($data);

	$con->close();


?>