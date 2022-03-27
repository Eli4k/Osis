<?php 
	
	require_once '../../../../config.php';

	$output = '<div class="widget-box">
            <div class="widget-title">
               <span class="icon"><i class="icon-th"></i></span> 
              <h5>EXAM RESULTS</h5>
           </div>
        </div>';

	$teacher_id = $_POST["user_id"];

	$query = "
			  SELECT  DISTINCT e.sub_id, e.yr_id, e.c_id, e.term_id, e.s_id,
			   			s_name, sub_name, ac_yr, cname, term_name
			   FROM exam e
			   JOIN subjects sub ON e.sub_id = sub.sub_id
			   JOIN academic_year a ON e.yr_id = a.yr_id
			   JOIN stream str ON  e.s_id = str.s_id
			   JOIN class 	c  ON  e.c_id = c.c_id
			   JOIN term   tr  ON e.term_id = tr.term_id
			   WHERE teacher_id = '$teacher_id' AND t_sub = 0  AND admin_pub = 0";

	$result = $con->query($query);
	if (!empty($result)) {


			while($record = $result->fetch_assoc()){
					$output .='<div class="row-fluid">
								<div class="span12">
        						<div class="widget-box">
        						<div class="widget-title"><h5>END OF TERM EXAMINATION</h5></div> 
		            			<div class="widget-title"> 
		             			 	<h5>SUBJECT: '.strtoupper($record['sub_name']).'</h5>
		             			 	<h5>CLASS: '.strtoupper($record['cname']." - ".$record['s_name']).'</h5> 
		             			 	<h5>YEAR: '.$record['ac_yr'].'</h5>
		           				</div>
		           				<div class="widget-title">
		           					<h5>TERM: '.strtoupper($record['term_name']).'</h5>
		           				</div>

          			<div class="widget-content nopadding">
            			<table class="table table-bordered data-table">
              			<thead>
		                	<tr>	
		                		  <th width="1%"><input type="checkbox" class="inc_selectAll" title="SELECT ALL"></th>
		                		  <th width="2%">#</th>
				                  <th width="15%">STUDENT NAME</th>
				                  <th width="4%">CLASS SCORE(50%)</th>
				                  <th width="4%">EXAM SCORE (50%)</th>
				                  <th width="4%">TOTAL SCORE(100%)</th>
				                  <th width="4%">ACTION</th>
		                	</tr>
              			</thead>
	              			
	              			<tbody id="tableBody">';

	              			$yr = $record["yr_id"];
	              			$term = $record["term_id"];
	              			$sub = $record["sub_id"];
	              			$c_id = $record["c_id"];
	              			$sid = $record["s_id"];

	              			
	              			// Fetch Records and Rank
	              				$column = $con->query("SELECT exam_id, email, s.student_id, first_name, middle_name, last_name, class_score, ex_score,
	              					FIND_IN_SET( exam_id, (    
												SELECT GROUP_CONCAT(exam_id
												ORDER BY exam_id DESC)
												FROM exam e JOIN students s ON e.student_id = s.student_id
												WHERE e.teacher_id = '$teacher_id' 
												 AND e.yr_id = '$yr' 	AND e.term_id = '$term' 
												 AND e.sub_id= '$sub'	AND e.s_id = '$sid'												 
												 AND e.c_id = '$c_id'
												)
											)AS listing FROM exam e
			  									JOIN students s ON e.student_id = s.student_id	 
			  									WHERE e.teacher_id = '$teacher_id' 
			  									AND e.yr_id = '$yr'  AND e.term_id = '$term'
			  									AND e.sub_id= '$sub' AND e.c_id = '$c_id'
			  									AND e.s_id = '$sid'  AND verified = 0
			  									AND t_sub = 0 ORDER BY exam_id DESC");
	              				foreach($column as $col)
			  					{	
			  					$output.='<tr>';
			  						$total = $con->query("SELECT SUM(class_score + ex_score) AS total_score FROM exam 
			  												WHERE teacher_id = '$teacher_id' AND student_id = '".$col["student_id"]."'
			  												      AND  s_id = '$sid' AND  c_id = '$c_id' AND yr_id = '$yr'
			  												      AND  sub_id = '$sub'  
			  													 ");

			  								foreach($total as $total_score)
			  								{
			  								$output.='<td><input type="checkbox" value="'.$col['exam_id'].'" data-email="'.$col['email'].'" class="inc_thisBox"></td>';
			  									$output.= '<td>'.$col["listing"].'</td>';
			  								$output.= '<td>'.$col["first_name"]." ".$col["middle_name"]." ".$col["last_name"].'</td>';
			  								$output.= '<td>'.$col["class_score"].'</td>';
			  								$output.= '<td>'.$col["ex_score"].'</td>';
			  								$output.= '<td>'.$total_score["total_score"].'</td>';
		              						$output.= '<td>
		 												<button class="btn btn-secondary btn-mini" id="edit_btn" data-edit="'.$col["exam_id"].'" title="Edit"><span class="icon-edit"></span></button>
		 												<button class="btn btn-secondary btn-mini" id="btn_delete" data-delete="'.$col["exam_id"].'" title="Delete"><span class="icon-trash"></span></button>
		 												</td>';	
			  								}
			  							$output.=' </tr>';
			  					}
			  					$output .='<tr><td colspan="7"><button class="btn btn-success inc_pub" title="Check Results as verified and publish to Parents">Publish Results</button></td></tr>
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