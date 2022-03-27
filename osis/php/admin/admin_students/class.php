<?php

require '../../../config.php';

$class = '<option value="0">Choose Class</option>';

	$sql = $con->query("SELECT * FROM class");

	if ($sql->num_rows > 0 ) {
		$i = 1;

			while($row = $sql->fetch_assoc())
			{
				$class .= '
								<option value="'.$row["c_id"].'">'.$row["cname"].'</option>
							';
				$i++;
			}
	}

	$data = array('class' => $class);

	echo json_encode($data);

	$con->close();




?>
