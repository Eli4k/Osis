<?php

require '../../../config.php';

$output="";

if(isset($_POST)){
	$yr = $con->real_escape_string($_POST["yr"]);
	$level = $con->real_escape_string($_POST["level"]);
	$term = $con->real_escape_string($_POST["term"]);
	$sub = $con->real_escape_string($_POST["sub"]);
	$teacher = $con->real_escape_string($_POST["user"]);

	$students = $con->query("SELECT DISTINCT y.ac_yr,c.cname, t.term_name, sub.sub_name, ex_id FROM quiz q
													 JOIN academic_year y ON y.yr_id = q.yr_id
													 JOIN class c ON c.c_id = q.c_id
													 JOIN term t ON t.term_id = q.term_id
													 JOIN subjects sub ON sub.sub_id = q.sub_id
													WHERE teacher_id = '$teacher' AND q.yr_id = '$yr' AND q.c_id = '$level'
													AND q.sub_id='$sub' AND q.term_id = '$term'
													ORDER BY q.ex_id DESC");
	if($students){
		while($row = $students->fetch_assoc()){
			$year = $row["ac_yr"];
			$cname = $row["cname"];
			$term_name = $row["term_name"];
			$subject = $row["sub_name"];
			$ex = $row["ex_id"];
			$output.='<div class="row span5">
									<div class="widget-box">
												<div class="widget-title">
														<h5>'.$year.'</h5>
														<h5>'.$term_name.'</h5>
														<h5>'.$cname.'</h5>
														<h5>'.$subject.'</h5>
														<h5> Quizz No: '.$ex.'</h5>';

													$total_query = $con->query("SELECT count(quiz_id) AS total FROM quiz WHERE ex_id = '$ex' AND term_id = '$term' AND sub_id = '$sub' AND yr_id = '$yr' AND c_id = '$level' AND teacher_id = '$teacher'");

													if($total_query){

														foreach($total_query as $score){
																$total_score = $score["total"];
																$output.='<h5>TOTAL: '.$total_score.'</h5>';
														}

													}else{
														$output.= '<h5>Error: '.$con->error.'</h5>';
													}

						$output.='</div>
									<div class="widget-content nopadding">
										<table class="table table-bordered data-table dataTable">
											<thead>
												<tr>
													<th width="3%">ID</th>
													<th width="94%">STUDENT</th>
													<th width="3%">SCORE</th>
												</tr>
											</thead>
											<tbody>';

		$student_data = $con->query("SELECT DISTINCT s.student_id, s.first_name, s.middle_name, s.last_name, qa.sid From quiz_ans qa
																JOIN quiz q ON q.quiz_id = qa.quiz_id
																JOIN students s ON s.sid = qa.sid
    													  WHERE q.term_id = '$term'
																AND q.ex_id = '$ex' AND q.yr_id = '$yr' AND q.sub_id = '$sub'
																AND q.teacher_id = '$teacher'");

			if($student_data){
				foreach($student_data as $student){
					$name = strtoupper($student["last_name"].' '.$student["middle_name"].' '.$student["first_name"]);
					$id = $student["student_id"];
					$sid = $student["sid"];
					$output.='<tr><td>'.$id.'</td><td>'.$name.'</td>';


						$score_query = $con->query("SELECT count(chosen_ans) AS score FROM quiz_ans qa
																	JOIN quiz q ON q.quiz_id = qa.quiz_id WHERE qa.sid ='$sid' AND q.yr_id = '$yr' AND q.ex_id = '$ex' AND q.answer = qa.chosen_ans
																	AND q.term_id = '$term' AND q.c_id = '$level' AND q.ex_id = '$ex' AND q.teacher_id = '$teacher' AND q.sub_id = '$sub'");

												if($score_query){
													foreach($score_query as $score){
														$mark = $score["score"];
															$output.='<td>'.$mark.'</td></tr>';
													}
												}else{
													$output.="Error: ".$con->error;
												}
									}
								}else{
									$output.='<tr>
															<td colspan="3">'.$con->error.'</td>
														</tr>';
								}
					$output.='		</tbody>
												<tfoot><tr><td colspan="3"><button class="btn btn-info btn"id="print_btn">Print</button></td></tr></tfoot>
									</table>
							</div>
					</div>
					</div>';
											;
		}
	}else{
		$output.="Error: ".$con->error;
	}
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();
?>
