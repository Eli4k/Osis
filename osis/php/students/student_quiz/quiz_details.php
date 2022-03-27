<?php
	include '../../../config.php';

$output="";

if(isset($_POST)){

$student_id = $_POST["sid"];
$term_id = $_POST["term"];
$class_id = $_POST["class_id"];
$ex = $_POST["ex"];
$yr = $_POST["yr"];
$sub = $_POST["sub"];

  $sql = $con->query("SELECT DISTINCT q.ex_id, t.term_name, c.cname, y.ac_yr, qa.sid, s.sub_name, UPPER(CONCAT(st.first_name,' ',st.last_name)) as fullname
                      FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
                      JOIN term t ON q.term_id = t.term_id
                      JOIN class c ON q.c_id = c.c_id
                      JOIN subjects s ON q.sub_id = s.sub_id
											JOIN students st ON st.sid = qa.sid
											JOIN academic_year y ON q.yr_id = y.yr_id
											WHERE qa.sid = '$student_id'
                      AND q.yr_id = '$yr' AND q.c_id = '$class_id' AND q.ex_id = '$ex'
                      AND q.term_id = '$term_id' AND q.sub_id = '$sub'");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$yr_name = $row["ac_yr"];
			$cname = $row["cname"];
			$term_name = $row["term_name"];
			$sub_name = $row["sub_name"];
			$fullname = $row["fullname"];
			$ex_id = $row["ex_id"];

      $output.='
      <div class="span9">
        <div class="widget-box">
          <div class="widget-title">
						<h5>'.$fullname.'</h5>
          </div>
					<div class="widget-title">
            <h5>'.$yr_name.'</h5>
            <h5>'.$cname.'</h5>
            <h5>'.$term_name.'</h5>
            <h5>'.$sub_name.'</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form horizontal">';

      $index_data = $con->query("SELECT qa.quiz_id, qa.quiz_ans_id, q.question, qa.chosen_ans, q.opt_a, q.opt_b, q.opt_c, q.opt_d, q.answer FROM quiz_ans qa
                                JOIN quiz q ON q.quiz_id = qa.quiz_id
                                JOIN subjects s ON q.sub_id = s.sub_id
                                WHERE qa.sid = '$student_id' AND q.term_id = '$term_id' AND q.ex_id = '$ex' AND q.c_id = '$class_id' AND q.yr_id= '$yr' AND q.sub_id = '$sub'");


              if($index_data && !empty($index_data)){
										$i=1;
                  foreach($index_data as $new_row){
										$chosen = $new_row["chosen_ans"];
										$answer = $new_row["answer"];
										$id = $new_row["quiz_id"];
										$question = $new_row["question"];

										$array_options = array($new_row["opt_a"], $new_row["opt_b"],
																					 $new_row["opt_c"], $new_row["opt_d"]);
                    $output.='<div class="control-group">
                                <div class="controls question" id="'.$id.'"><h4> '.$question.'</h4></div>
															</div>
                              <div class="control-group">
															<div class="controls options">';
						for($i=0; $i<count($array_options); $i++){
							$output.='<label>
													<div class="radio">
														<span>
															<input type="radio" disabled ';

											$output.='value="'.$array_options[$i].'" name="'.$id.'">'.$array_options[$i];

											if($array_options[$i] == $chosen && $chosen == $answer){
												$output.=' <span><i class="icons icon-ok"></i> <i style="color:green;">Chosen answer</i></span>';
												}
										 elseif($array_options[$i] == $chosen && $chosen != $answer){
													$output.=' <span><i class="icons icon-remove"></i> <i style="color:red;">Chosen answer</i></span>';
												}
										elseif($array_options[$i] != $chosen && $array_options[$i] == $answer)
											{
												$output.=' <span><i class="icons icon-ok"></i> <i style="color:green;">Correct answer</i></span>';
											}

							$output.='</span>
											</div>
										</label>';
								}

							$output.='</div></div>';
							$i++;
                  }
            }else{
                $output.='<div class="control-group">
													<div class="controls"> Error: '.$con->error.'</div></div>';
              }
							$output.='</form>
		            </div>
		          </div>
		        </div>';
					}
	}else{
		$output.='<p>No data regarding this text exists. The data might have been uploaded via a DOCUMENT!!</p>';
	}
}

	$data = array('output'=>$output);
	echo json_encode($data);
$con->close();

?>
