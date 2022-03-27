<?php 

	require_once '../../../config.php';
	$output = "";

	if($_POST["c_id"]){
	$query = "SELECT DISTINCT a.yr_id, ac_yr, t.term_id, term_name, cname, c.c_id, st.s_id, s_name FROM exam e
			  JOIN academic_year a ON e.yr_id = a.yr_id
			  JOIN stream st  ON e.s_id = st.s_id
			  JOIN term t ON e.term_id = t.term_id
			  JOIN class c ON e.c_id = c.c_id
			WHERE t_sub = 1 AND verified =1 AND admin_pub = 1";

	$result = $con->query($query);

			if (!empty($result)) {

					while($record = $result->fetch_assoc())
						{
							$output.='<div class="widget-box">
									  <div class="widget-title" data-yr="'.$record["yr_id"].'" data-yr_txt="'.$record["ac_yr"].'"><h5>ACADEMIC YEAR: '.$record["ac_yr"].'</h5></div>
									  <div class="widget-title" data-class="'.$record["c_id"].'" data-term="'.$record["term_id"].'">
									  	<h5>'.$record["cname"].' - '.strtoupper($record["s_name"]).'</h5><h5>'.strtoupper($record["term_name"]).'</h5></div> ';	
									  	$s_id = $record["s_id"];
									  	$yr_id = $record["yr_id"];
									  	$c_id = $record["c_id"];
									  	$term_id = $record["term_id"];
								
									
										$student = $con->query("SELECT DISTINCT s.student_id, email, first_name, last_name, middle_name, st.s_id, s_name FROM exam e
													JOIN students s ON e.student_id = s.student_id
													JOIN stream st ON e.s_id = st.s_id
													WHERE e.yr_id ='$yr_id'
													AND   e.term_id = '$term_id' 
													AND   e.c_id   = '$c_id'
													AND   e.s_id = '$s_id'
													AND verified = 1
													AND t_sub = 1 AND
													admin_pub = 1 GROUP BY s.student_id, st.s_id HAVING COUNT(e.sub_id) > 0 ORDER BY last_name");

										$output.='<div class="widget-content nopadding">
														<table class="table table-bordered">
														<tbody>
														<tr><td><input type="checkbox" class="select_all" title="Select All"</td><th>ID</th><th>Fullname</th><th>View Result</th></tr>
														';

									if (!empty($student)) {
									
												foreach($student as $student_data)
												{
													$output.='<tr>
															<td><input type="checkbox" value="'.$student_data["email"].'" data-check_id = "'.$student_data["student_id"].'" class="thisBox"></td>
															<td>'.$student_data["student_id"].'</td>
															<td>'.$student_data["last_name"].' '.strtoupper(substr($student_data["middle_name"],1,1)).' '.$student_data["first_name"].'</td>
															<td><button class="btn btn-success btn-mini myres" data-std_id="'.$student_data["student_id"].'">View Result</button></td>
															
													 </tr>
													';
												}
										
											}else{
												$output.='<tr><td colspan="4">No data available</td></tr>';
											}

										$output.='</tbody>
														<tfoot>
															<tr><td colspan="4"><button class="btn btn-success btn-mini publish" disabled></button></td></tr>
														</tfoot>
												</table>
											</div>
											</div>';
									
								}

							
			}else{
				$output."Something went wrong: ".$con->error;
			}

}


	$data= array('output' => $output);
	echo json_encode($data);

	$con->close();

?>