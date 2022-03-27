<?php 
	$con = new mysqli("localhost","root","","schoolportal");

	// Insert Record
	if (isset($_POST["stval"])) {
			$stream = $con->real_escape_string($_POST["stream"]);

			$sql = "INSERT INTO stream (s_name) VALUES('$stream')";
			 $con->query($sql);
		}

	// fetch Edit Record
		if (isset($_GET["s_id"])) {
			$s_id =  $con->real_escape_string($_GET["s_id"]);
			$sql = "SELECT * FROM stream WHERE s_id = '$s_id'";
			$query=$con->query($sql);

				while($row = $query->fetch_assoc())
				{
					$s_id = $row["s_id"];
					$s_name = $row["s_name"];
				}

			$data = array("stream_name" => $s_name,
						  "stream_id" => $s_id
						 );
			echo json_encode($data);
			
		}
	
	// Edit Record
	if (isset($_POST['sid'])) {
			$sid = $_POST['sid'];
			$s_name = $con->real_escape_string($_POST["s_name"]);
			$sql = "UPDATE stream SET s_name = '$s_name' WHERE s_id = '$sid'";
			 $con->query($sql);


		}

	// Delete Record
	if (isset($_GET['col_data'])) {
			$s_message = '';
			$s_id= $con->real_escape_string($_GET["del_id"]);
			$sql = "DELETE FROM  stream WHERE s_id = '$s_id'";
			 $con->query($sql);
			 $s_message = 'Stream Successfully Deleted';

			$data = array('s_msg' => $s_message);

			echo json_encode($data);
		}

	$con->close();

?>