<?php

	include '../../../../config.php';

	if (isset($_POST)) {
		$message = "";
		$user_id = $_POST['uname'];
		$exam_id = $_POST['exam_id'];


							if(updateResults($con, $exam_id,'exam') != true)
							{
								$message .= "Unable to update query ".$con->error;
							}else{
								$message .= "Results successfully Published to admin";
						}



			$data = array('msg' => $message);
			echo json_encode($data);
	}

		function updateResults($connect, $table_id, $tablename)
			{
				$connection = $connect;
				$exam_id = $table_id;
				$tbl= $tablename;

				foreach($exam_id as $results_id)
				{
					$update = $connection->query("UPDATE $tbl SET t_sub =  1, verified = 1 WHERE exam_id = '$results_id'");
				}
				return $update;
			}


		$con->close();


?>
