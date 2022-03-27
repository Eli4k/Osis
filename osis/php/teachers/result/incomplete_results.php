<?php

	require_once '../../../config.php';

	$output = '<div class="widget-box">
            <div class="widget-title">
               <span class="icon"><i class="icon-th"></i></span>
              <h5>Test Result</h5>
           </div>
        </div>';

	$teacher_id = $_POST["user_id"];

	$query = "
			  SELECT DISTINCT r.test_id, r.sub_id, r.yr_id, r.c_id, r.term_id, r.s_id, ovscr, pmark,
			   				   s_name, t_name, sub_name, ac_yr, cname, term_name
			   FROM results r
			   JOIN test t ON r.test_id = t.test_id
			   JOIN subjects sub ON r.sub_id = sub.sub_id
			   JOIN academic_year a ON r.yr_id = a.yr_id
			   JOIN stream str ON r.s_id = str.s_id
			   JOIN class  c  ON  r.c_id = c.c_id
			   JOIN term tr  ON	  r.term_id = tr.term_id
			   WHERE teacher_id = '$teacher_id' AND published = 0 ORDER BY yr_id, test_id DESC
			";

	$result = $con->query($query);
	if (!empty($result)) {


			while($record = $result->fetch_assoc()){
					$output .='<div class="row-fluid">
								<div class="span12">
        						<div class="widget-box">
        						<div class="widget-title"><h5>UNPUBLISHED RESULTS</h5></div>
		            			<div class="widget-title">
		             			 	<h5>'.strtoupper($record['sub_name']).'</h5>
		             			 	<h5>'.strtoupper($record['cname']." - ".$record['s_name']).'</h5>
		             			 	<h5>'.strtoupper($record['ac_yr']).'</h5>
		             			 	<h5>'.strtoupper($record['t_name']).'</h5>
		             			 	<h5>'.strtoupper($record['term_name']).'</h5><br>
		           				</div>
		           				<div class="widget-title">
		             			 	<h5>OVERALL SCORE: '.$record['ovscr'].'</h5>
		             			 	<h5>PASS MARK: '.$record['pmark'].'</h5>
		           				</div>

          			<div class="widget-content nopadding">
            			<table class="table table-bordered data-table">
              			<thead>
		                	<tr>
		                		  <th width="1%"><input type="checkbox" class="select_all" onclick="select_all(event);" title="SELECT ALL" value="All"></th>
													<th width="3%">RANK</th>
				                  <th width="15%">STUDENT INFO</th>
				                  <th width="4%">SCORE</th>
				                  <th width="3%">ACTION</th>
		                	</tr>
              			</thead>

	              			<tbody id="tableBody">';

	              			$yr = $record["yr_id"];
	              			$term = $record["term_id"];
	              			$sub = $record["sub_id"];
	              			$c_id = $record["c_id"];
	              			$test = $record["test_id"];
	              			$ov = $record["ovscr"];
	              			$sid = $record["s_id"];
											$pmark = $record["pmark"];


	              			// Fetch Records and Rank
	              				$column = $con->query("SELECT  gradeId, email, s.student_id, first_name, middle_name, last_name, score FROM results r
			  					JOIN students s ON r.student_id = s.student_id
			  					WHERE teacher_id = '$teacher_id' AND test_id = '$test'
			  					AND yr_id = '$yr' AND term_id = '$term' AND sub_id= '$sub'
			  					AND r.c_id = '$c_id' AND r.s_id = '$sid' AND ovscr = '$ov'
									AND pmark='$pmark' AND published = 0 ORDER BY score DESC");
								$i = 1;
	              				foreach($column as $col)
			  					{

			  							$output.= '<tr><td><input type="checkbox" value="'.$col['gradeId'].'" data-email="'.$col['email'].'" data-student="'.$col['student_id'].'" class="inc_thisBox"></td>';
											$output.='<td>'.$i.'</td>';
			  							$output.= '<td>'.$col["first_name"]." ".$col["last_name"].'</td>';
		              					$output.= '<td>'.$col["score"].'</td>';
		              					$output.= '<td>
		 											<button class="btn btn-secondary btn-mini" data-edit="'.$col["gradeId"].'" onclick="edit(event);" title="Edit">Edit</button>
													<button class="btn btn-secondary btn-mini save" data-save="'.$col["gradeId"].'" onclick="save(event);" style="display:none" title="Save">Save</button>
		 											<button class="btn btn-secondary btn-mini" data-delete="'.$col["gradeId"].'" onclick="remove(event);" title="Delete">Delete</button>
		 											</td>
		              							</tr>';
											$i++;
			  					}
			  					$output .='<tr><td colspan="5"><button class="btn btn-success inc_pub" title="Check Results as verified and publish to Parents" onclick="publish_all(event);">Publish Results</button></td></tr>
			  								</tbody>
			  							 </table>
		              					</div>
    								</div>
    							</div>
    						</div>';
	      					}
	      				}



	$data = array('output' => $output);
	echo json_encode($data);
	$con->close();

?>
