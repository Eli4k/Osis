<?php

	require_once '../../../config.php';
	$verified = "";
	$output = '';
  $classes = $_POST["classes"];
	$query = "SELECT DISTINCT  e.yr_id, ac_yr, term_name, e.term_id FROM exam e
			  		JOIN academic_year a ON e.yr_id = a.yr_id
			  		JOIN term t ON e.term_id = t.term_id WHERE e.c_id = '$classes'
						AND verified = 1 AND t_sub = 1 AND admin_pub = 0";

	$result = $con->query($query);
	if (!empty($result)) {
			while($record = $result->fetch_assoc())
				{
					$yr_id = $record["yr_id"];
					$output.='<div class="row-fluid">';
					$output .='<div class="widget-box"><div class="widget-title">';
					$output .='<h5>'.$_POST["cname"].'  '.$record["term_name"].' '.$record["ac_yr"].'</h5></div>';
					$output .='<div class="widget-content nopadding span6">
								<table class="table table-bordered">
								<tr><th>Id</th><th>Name</th><th>Results Available</th><th>Action</th></tr>';

					$select_student = "SELECT DISTINCT first_name, middle_name, last_name, s.student_id"

					$sql = "SELECT COUNT(sub_id) FROM exam  WHERE c_id='".$_POST["classes"]."'
					 				AND yr_id ='$yr_id' AND verified = 1 AND student_id ='".$record["student_id"]."'
									AND admin_pub = 0";
						$exec = $con->query($sql);
						$num = $exec->num_rows;

						foreach($exec as $student_info){
							if ($num > 0) {
								$output .='<tr><td>'.$record["student_id"].'</td><td>'.$record["last_name"]." ".
													$record["middle_name"]." ".$record["first_name"].'</td><td>'.$num.'/9</td><td>
													<button class="btn btn-success btn-mini" id="'.$record["student_id"].'">View Results</button></td></tr>';
							}else{
								$output .='<tr><td colspan="3">Sorry! Results for '.$yr_id.' are currently not available</td></tr>';
							}
	      				}
	      		$output .= '</table></div></div></div>';
			}
	      }	else{
	      		$output .= "Nothing is available: ".$con->error;
	      	}

	$data = array('output' => $output);
	echo json_encode($data);


	$con->close();

?>
