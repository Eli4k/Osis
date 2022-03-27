<?php 
	$con = new mysqli("localhost","root","","schoolportal");

	// Insert Record
	if (isset($_POST["yr_btn"])) {
			$ac_yr = $con->real_escape_string($_POST["ac_yr"]);

			$sql = "INSERT INTO academic_year (ac_yr) VALUES('$ac_yr')";
			if($con->query($sql)){
				$insert = "Data inserted Successfully";
			}
			else{
				$insert = "Unable to insert record :".$con->error;
			}

			$data = array("insert_yr" => $insert);
			echo json_encode($data);
		}

	// fetch Edit Record
		if (isset($_GET["yr_id"])) {
			$yr_id =  $con->real_escape_string($_GET["yr_id"]);
			$sql = "SELECT * FROM academic_year WHERE yr_id = '$yr_id'";
			$query=$con->query($sql);

				while($row = $query->fetch_assoc())
				{
					$yr_id = $row["yr_id"];
					$yr_name = $row["ac_yr"];
				}

			$data = array("yr_name" => $yr_name,
						  "yr_id" => $yr_id
						 );

			echo json_encode($data);
			
		}
	
	// Edit Record
	if (isset($_POST['y_btn'])) {

			$y_id = $_POST['y_id'];
			$yr_name = $con->real_escape_string($_POST["yr_name"]);
			$sql = "UPDATE academic_year SET ac_yr = '$yr_name' WHERE yr_id = '$y_id'";
			 if ($con->query($sql)) {
			 		$output = "Record Updated";
				}else{
					$output = "Unable to update: ".$con->error;
				}
				
			$data = array("yr_result" => $output);
			echo json_encode($data);
		}

	// Delete Record
	if (isset($_GET['yr_col_data'])) {
			$yr_del_id= $con->real_escape_string($_GET["yr_del_id"]);
			$sql = "DELETE FROM academic_year WHERE yr_id = '$yr_del_id'";
			  if ($con->query($sql)) {
			 		$output = "Data Deleted Successfully";
				}else{
					$output = "Record could not be deleted because it has been used other academic fields: ".$con->error;
				}
			$data = array('yr_delete' => $output);
			echo json_encode($data);
		}

	$con->close();

?>