<?php 

	$con = new mysqli("localhost","root","","schoolportal");

	// Insert Record
	if (isset($_POST["class_button"])) {
			$cname = $con->real_escape_string($_POST["class_name"]);

			$sql = "INSERT INTO class (cname) VALUES('$cname')";
			 if($con->query($sql))
			 {
			 	$insert = "Data inserted successfully"; 
			 }
			 else
			 {
			 	$insert = "Unable to insert record: ".$con->error;
			 }
			 $data = array("insert" => $insert);
			 echo json_encode($data);
		}

	// fetch Class Record
		if (isset($_GET["c_id"])) {
			$c_id =  $con->real_escape_string($_GET["c_id"]);
			$sql = "SELECT * FROM class WHERE c_id = '$c_id'";
			$query=$con->query($sql);

				while($row = $query->fetch_assoc())
				{
					$class_id = $row["c_id"];
					$c_name = $row["cname"];
				}

			$data = array("c_name" => $c_name,
						  "c_id" => $c_id
						 );

			echo json_encode($data);
			
		}
	
	// Edit Record
	if (isset($_POST['edit_btn'])) {

			$c_id = $_POST['class_id'];
			$c_name = $con->real_escape_string($_POST["class_name"]);
			$sql = "UPDATE class SET cname = '$c_name' WHERE c_id = '$c_id'";
			 $con->query($sql);
			 if ($sql) {
			 		$output = "Record Updated";
				}else{
					$output = $con->error;
				}
			$data = array('class_result' => $output);
			echo json_encode($data);
		}

	// Delete Record
	if (isset($_GET['class_col_data'])) {
			$class_del_id= $con->real_escape_string($_GET["class_del_id"]);
			$sql = "DELETE FROM class WHERE c_id = '$class_del_id'";
			  if ($con->query($sql)) {
			 		$c_result = "Data Deleted Successfully";
				}else{
					$c_result = $con->error;
				}
			$data = array('class_delete' => $c_result);
			echo json_encode($data);
		}

	$con->close();

?>