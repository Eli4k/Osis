<?php

	require_once '../../../config.php';

	$output = '';
if(isset($_POST["student_id"])){
	$username = $_POST["student_id"];
  $year = $con->real_escape_string($_POST["year"]);
  $class = $con->real_escape_string($_POST["class"]);
  $term = $con->real_escape_string($_POST["term"]);
  $sub = $con->real_escape_string($_POST["subject"]);

	$query = "
			   SELECT DISTINCT r.yr_id, r.c_id, r.term_id, r.sub_id, a.ac_yr, c.cname, tr.term_name, s.sub_name
			   FROM results r
			   JOIN academic_year a ON r.yr_id = a.yr_id
         JOIN subjects s ON s.sub_id = r.sub_id
			   JOIN class  c  ON  r.c_id = c.c_id
			   JOIN term tr  ON	  r.term_id = tr.term_id
			   WHERE student_id = '$username' AND r.yr_id = '$year' AND r.term_id = '$term' AND  r.sub_id = '$sub' AND r.c_id = '$class'";

	$result = $con->query($query);
	if(!empty($result)) {
			while($record = $result->fetch_assoc()){

					$output .='<div class="span6">
        								<div class="widget-box">
				            			<div class="widget-title">
				            				<h5>'.$record["ac_yr"].'</h5>
				             			 	<h5>'.$record["cname"].'</h5>
				             			 	<h5>'.$record["term_name"].'</h5>
		                        <h5>'.$record["sub_name"].'</h5>
				           				</div>
          			<div class="widget-content nopadding">
            			<table class="table table-bordered data-table">
              			<thead>
			                	<tr>
					                  <th width="15%">SUBJECT</th>
					                  <th width="10%">TEST</th>
					                  <th width="4%">OV/SCORE</th>
					                  <th width="2%">PASS MARK</th>
					                  <th width="2%">SCORE</th>
			                	</tr>
              			</thead>

	              			<tbody id="tableBody">';

	              			// $yr = $record["yr_id"];
	              			// $term = $record["term_id"];
	              			// $c_id = $record["c_id"];
	              			// $test = $record["test_id"];


	              			// Fetch Records
	              				$column = $con->query("SELECT sub.sub_name, r.score, ts.t_name, r.ovscr, r.pmark FROM results r
			  										JOIN subjects sub ON r.sub_id = sub.sub_id
			  										JOIN test ts ON r.test_id = ts.test_id
			  										WHERE student_id = '$username'
			  										AND r.yr_id = '$year' AND r.term_id = '$term'
			  										AND r.c_id = '$class' AND r.sub_id = '$sub' AND r.published = '1' ORDER BY r.test_id DESC");

	              				foreach($column as $col){
			  							$output.= '<tr><td>'.$col["sub_name"].'</td>';
		              					$output.= '<td>'.$col["t_name"].'</td>';
		              					$output.= '<td>'.$col["ovscr"].'</td>';
		              					$output.= '<td>'.$col["pmark"].'</td>';
		              					$output.= '<td>'.$col["score"].'</td></tr>';
			  					}
			  					$output .='</tbody>
			  							 </table>
    								</div>
    							</div>
    						</div>';
	      					}
	      				}else{
									$output.='<div class="span6">
															<div class="widget-box">
																<div class="widget-title">
																	<h5>Your Assessments</h5>
																</div>
																<div class="widget-content nopadding">
																	<table class="table table-bordered data-table">
																		<tr>
																			<th colspan="1">No data available</th>
																		</tr>
																	</table>
																</div>
															</div>
														</div>';
													}
					}else{
							$output.='Error: '.$con->error;
				}
$data = array('output' => $output);
echo json_encode($data);

$con->close();
?>
