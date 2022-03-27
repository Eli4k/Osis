<?php

	require_once '../../../config.php';

	$output = '';

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
			   WHERE teacher_id = '".$_POST["uname"]."' AND r.sub_id = '".$_POST["sub"]."' AND r.c_id ='".$_POST["cl"]."' AND
			    r.yr_id='".$_POST['yr']."' AND r.s_id ORDER BY yr_id, test_id DESC";

	$result = $con->query($query);
	if (!empty($result)) {
			while($record = $result->fetch_assoc()){
					$output .='
								<div class="span8">
        						<div class="widget-box">
		            			<div class="widget-title">
		             			 	<h5>'.strtoupper($record['sub_name']).'</h5>
		             			 	<h5>'.strtoupper($record['cname']." - ".$record['s_name']).'</h5>
		             			 	<h5>'.$record['ac_yr'].'</h5>
		             			 	<h5>'.strtoupper($record['t_name']).'</h5><br>
		           				</div>
		           				<div class="widget-title">
		             			 	<h5>OVERALL: '.$record['ovscr'].'</h5>
		             			 	<h5>PASS MARK: '.$record['pmark'].'</h5>
		           				</div>

          			<div class="widget-content nopadding">
            			<table class="table table-bordered data-table">
              			<thead>
                	<tr>
		                  <th width="30%">STUDENT</th>
		                  <th width="4%">SCORE</th>
		                  <th width="2%">RANK</th>
                	</tr>
              			</thead>

	              			<tbody id="tableBody">';

	              			$yr = $record["yr_id"];
	              			$term = $record["term_id"];
	              			 // $sub = $record["sub_id"];
	              			$c_id = $record["c_id"];
	              			$test = $record["test_id"];
	              			$ov = $record["ovscr"];
	              			$sid = $record["s_id"];


	              			// Fetch Records and Rank
	              				$column = $con->query(" SELECT  s.student_id, first_name, last_name, score,FIND_IN_SET( score, (
												SELECT GROUP_CONCAT( score
												ORDER BY score DESC )
												FROM results WHERE teacher_id = '".$_POST["uname"]."'
												 AND test_id = '$test' AND yr_id = '$yr'
												 AND term_id = '$term' AND sub_id ='".$_POST["sub"]."'
												 AND s_id = '$sid'
												 AND r.c_id = '$c_id'
												 )
											) AS rank FROM results r
			  					JOIN students s ON r.student_id = s.student_id
			  					WHERE teacher_id = '".$_POST["uname"]."' AND test_id ='$test'
			  					AND yr_id = '$yr' AND term_id = '$term' AND sub_id = '".$_POST["sub"]."'
			  					AND r.c_id = '$c_id' AND r.s_id = '$sid' ORDER BY score DESC"
			  				);
	              				foreach($column as $col)
			  					{
			  							$output.= '<tr><td>'.$col["student_id"]." - ".$col["first_name"]." ".$col["last_name"].'</td>';
		              					$output.= '<td>'.$col["score"].'</td>';
		              					$output.= '<td>'.$col["rank"].'</td></tr>';
			  					}
			  					$output .='</tbody>
			  							 </table>
		              					</div>
    								</div>
    							</div>

		              			';
	      					}
	      				}else{
	      					$output.='<div class="apan12">
	      							 <div class="alert alert-error alert-block">
	      								<a class="close" href="#">x</a>
	      								<h4 class="alert-heading">Sorry!</h4>
	      								The class you selected has no results to show. Please choose another class to check.
	      							 </div></div>'
	      							 ;
	      				}



	$data = array('filter_result' => $output);
	echo json_encode($data);

?>
