<?php
			require_once '../../../config.php';
			$heading = $questions = $timer="";


			$query = "
		  SELECT DISTINCT q.sub_id, ex_id, q.c_id, q.yr_id, q.term_id, ac_yr, cname, term_name, duration, q.s_id
		  FROM quiz q  JOIN class  c  ON  q.c_id = c.c_id
		  						 JOIN academic_year a ON q.yr_id = a.yr_id
		  					 	 JOIN stream s  ON q.s_id = s.s_id
		  					 	 JOIN term tr  ON	q.term_id = tr.term_id
		  					 WHERE q.c_id = '".$_POST["class_id"]."'
								  AND q.s_id='".$_POST["stream"]."'
									AND q.yr_id = '".$_POST["yr"]."'
									AND ex_id = '".$_POST["ex"]."'
									AND q.term_id = '".$_POST["term"]."'
									AND q.sub_id = '".$_POST["sub"]."'ORDER BY ex_id, c_id, yr_id, term_id DESC";

			$result = $con->query($query);
			if (!empty($result)) {
				$i=1;
					while($record = $result->fetch_assoc()){
							$heading.='<h5>'.$record["ac_yr"].'</h5>
				             		 <h5>'.$record["cname"].'</h5>
				             		 <h5>'.$record["term_name"].'</h5>
												 <h5>'.$record["ex_id"].'</h5>';


			              			$yr = $record["yr_id"];
			              			$term = $record["term_id"];
			              			$c_id = $record["c_id"];
			              			$ex_id = $record["ex_id"];
													$sub = $_POST["sub"];

			              			// Fetch Records
			              				$column = $con->query("SELECT quiz_id, question, opt_a, opt_b, opt_c, opt_d, answer  FROM quiz q
					  									 JOIN class c ON q.c_id = c.c_id
					  									 JOIN academic_year a ON q.yr_id = a.yr_id
		                           JOIN term tr ON q.term_id = tr.term_id
		                           JOIN stream s ON q.s_id = s.s_id
					  									 WHERE q.yr_id = '$yr' AND q.term_id = '$term'
					  									 AND q.c_id = '$c_id' AND q.ex_id = '$ex_id' AND q.sub_id = '$sub' ORDER BY RAND()");

			     foreach($column as $col)
					  					{
												$quiz_id = $col["quiz_id"];
												$option_a = $col["opt_a"];
												$option_b = $col["opt_b"];
												$option_c = $col["opt_c"];
												$option_d = $col["opt_d"];
												$question = $col["question"];
												$correct_ans = $col["answer"];

					  						$questions.=  '
											<div class="control-group">
													<div class="controls question" id="'.$quiz_id.'"><h4>'.$question.'</h4></div>
											</div>
											<div class="control-group">
												<div class="controls options">
														<label>
															<div class="radio">
																<span>
															<input  id="'.$quiz_id.'" type="radio" name="'.$quiz_id.'" value="'.$option_a.'">
															</span>'.$option_a.'</div>
														</label>
														<label>
															<div class="radio">
																<span>
																	<input  id="'.$quiz_id.'" type="radio" name="'.$quiz_id.'" value="'.$option_b.'">
																</span>'.$option_b.'</div>
														</label>
														<label>
															<div class="radio">
																<span>
															<input  id="'.$quiz_id.'" type="radio" name="'.$quiz_id.'" value="'.$option_c.'">
															</span>'.$option_c.'</div>
														</label>
														<label>
																<div class="radio">
																<span>
																	<input  id="'.$quiz_id.'" type="radio" name="'.$quiz_id.'" value="'.$option_d.'">
															</span>'.$option_d.'</div>
														</label>
														 <input type="hidden" value="'.$correct_ans.'">
												 </div>
											</div>';
					  					}
		$questions.='<div class="form-actions">
								<input type="submit" id="quiz" class="btn btn-primary btn" value="FINISH" data-sub = '.$_POST["sub"].'>
							</div>';
									$timer.='<h1 id="time" data-time='.$record["duration"].'>'.$record["duration"].'</h1>';
			      				}
			      			}



			$data = array('questions' => $questions,
										'timer' => $timer,
										'heading' => $heading);
			echo json_encode($data);

			$con->close();
?>
