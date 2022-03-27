<?php

	require_once '../../../config.php';

	$output = '';
if(isset($_POST["uname"])){
	$username = $_POST["uname"];

	$query = "
			   SELECT DISTINCT r.yr_id, r.c_id, r.term_id,
			   				    ac_yr, cname, term_name
			   FROM results r
			   JOIN academic_year a ON r.yr_id = a.yr_id
			   JOIN class  c  ON  r.c_id = c.c_id
			   JOIN term tr  ON	  r.term_id = tr.term_id
			   WHERE student_id = '$username' AND a.yr_id = 1 AND tr.status = 1 AND r.published = 1 ";

	$result = $con->query($query);
	if (!empty($result)) {

			while($record = $result->fetch_assoc()){
					$output .='

								<div class="span6">
        						<div class="widget-box">
		            			<div class="widget-title">
		            				<h5>'.$record["ac_yr"].'</h5>
		             			 	<h5>'.$record["cname"].'</h5>
		             			 	<h5>'.$record["term_name"].'</h5>
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

	              			$yr = $record["yr_id"];
	              			$term = $record["term_id"];
	              			$c_id = $record["c_id"];
	              			// $test = $record["test_id"];


	              			// Fetch Records
	              				$column = $con->query("SELECT sub_name, score, r.test_id, ts.t_name, ovscr, pmark FROM results r
			  										JOIN subjects sub ON r.sub_id = sub.sub_id
			  										JOIN test ts ON r.test_id = ts.test_id
			  										WHERE student_id = '$username'
			  										AND yr_id = '$yr' AND r.term_id = '$term'
			  										AND r.c_id = '$c_id'ORDER BY r.test_id DESC");

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
    						</div>
		              			';
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
																			<th colspan="1">No data available:'.$con->error.'</th>
																		</tr>
																	</table>
																</div>
															<div>
														<div>';
								}



	$data = array('output' => $output);
	echo json_encode($data);
}

$con->close();
?>
