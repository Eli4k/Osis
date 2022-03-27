<?php

require '../../../config.php';

$streams = '<option value="0">Choose Stream</option>';

	$sql = $con->query("SELECT * FROM stream");

	if ($sql->num_rows > 0 ) {
		$i = 1;

			while($row = $sql->fetch_assoc())
			{
				$streams .= '
								<option value="'.$row["s_id"].'">'.$row["s_name"].'</option>
							';
				$i++;
			}
	}

	$data = array('streams' => $streams);

	echo json_encode($data);




?>
