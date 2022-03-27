<?php 
	$con = new mysqli("localhost","root","","schoolportal");

	// Insert Record
	if (isset($_POST["sub_data"])) {
			$sub = $con->real_escape_string($_POST["sub"]);

			$sql = "INSERT INTO subjects (sub_name) VALUES('$sub')";
			 $con->query($sql);
		}

	// fetch Edit Record
		if (isset($_GET["sub_id"])) {
			$sub_id =  $con->real_escape_string($_GET["sub_id"]);
			$sql = "SELECT * FROM subjects WHERE sub_id = '$sub_id'";
			$query=$con->query($sql);

				while($row = $query->fetch_assoc())
				{
					$sub_id = $row["sub_id"];
					$sub_name = $row["sub_name"];
				}

			$data = array("sub_name" => $sub_name,
						  "sub_id" => $sub_id
						 );

			echo json_encode($data);
			
		}
	
	// Edit Record
	if (isset($_POST['edit_btn'])) {

			$sub_id = $_POST['sub_id'];
			$sub_name = $con->real_escape_string($_POST["sub_name"]);
			$sql = "UPDATE subjects SET sub_name = '$sub_name' WHERE sub_id = '$sub_id'";
			 $con->query($sql);
			 if ($sql) {
			 		$output = "Record Updated";
				}else{
					$output = $con->error;
				}
			$data = array('result' => $output);
			echo json_encode($data);
		}

	// Delete Record
	if (isset($_GET['sub_col_data'])) {
			$sub_del_id= $con->real_escape_string($_GET["sub_del_id"]);
			$sql = "DELETE FROM subjects WHERE sub_id = '$sub_del_id'";
			  if ($con->query($sql)) {
			 		$output = "Data Deleted Successfully";
				}else{
					$output = $con->error;
				}
			$data = array('delete' => $output);
			echo json_encode($data);
		}

	$con->close();

?>