<?php
require_once "../../../config.php";
$output="";
	if (isset($_POST)){

		$student_id= $_POST["id"];

		$sql = $con->query("SELECT DISTINCT asmt.yr_id, asmt.s_id, asmt.c_id, asmt.term_id, y.ac_yr, t.term_name, c.cname, st.s_name FROM assessment asmt
												JOIN academic_year y ON asmt.yr_id = y.yr_id
												JOIN class c ON asmt.c_id = c.c_id
												JOIN term t ON asmt.term_id = t.term_id
                        JOIN stream st ON asmt.s_id = st.s_id
												 WHERE student_id = '$student_id' AND published = 0");
		if($sql){
			if(!empty($sql)){
				foreach($sql as $exam_data){
					$yr_id = $exam_data["yr_id"];
					$c_id = $exam_data["c_id"];
					$term_id = $exam_data["term_id"];
					$stream_id = $exam_data["s_id"];
					$term_name = $exam_data["term_name"];
					$yr = $exam_data["ac_yr"];
					$cname = $exam_data["cname"];
					$sname = $exam_data["s_name"];

					$output.='<div class="widget-box">
										 	<div class="widget-title"><h5>'.$yr.'</h5><h5>'.$term_name.'</h5><h5>'.$cname.'</h5><h5>'.$sname.'</h5></div>
											<input type="hidden" value="'.$c_id.':'.$term_id.':'.$yr_id.':'.$stream_id.'">
											<div class="widget-content nopadding">
												<table class="table dataTables table-bordered">
														<thead>
																<tr>
																	<th>Subject</th>
																	<th>Class Score</th>
																	<th>Exam Score</th>
																	<th>Total</th>
																</tr>
														</thead>
														<tbody>';


							$slip = $con->query("SELECT s.sub_name, class_score, ex_50, ovscr FROM assessment asmt
											JOIN subjects s ON s.sub_id = asmt.sub_id
											WHERE student_id = '$student_id' AND yr_id = '$yr_id'
								 		 AND published = 0 AND term_id = '$term_id' AND c_id = '$c_id'");
							// Get SplMinHeap
							if($slip){
								if(!empty($slip)){
									foreach($slip as $data){
										$subject = $data["sub_name"];
										$exam_score = $data["ex_50"];
										$class_score = $data["class_score"];
										$total = $data["ovscr"];
										$output.='<tr><td>'.$subject.'</td><td>'.$class_score.'</td><td>'.$exam_score.'</td><td>'.$total.'</td></tr>';
									}
								}else{
									$output.='<tr colspan="4"><td>No results available for this student</td></tr>';
								}
							}else{$output.='<tr colspan="4"></td>Error: '.$con->error.' </td></tr>';}
							// End

					$output.='</tbody><tfoot><tr><td colspan="4">GAEC</td></tr></tfoot></table>
											</div>
										</div>';
				}
			}else{
				$output.= "All results for this students have been published";
			}
		}else{
			$output.='Error: '.$con->error;
		}
}else{
	$output.='Error: '.$con->error;
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();
?>
