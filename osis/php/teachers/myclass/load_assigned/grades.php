<?php
include '../../../../config.php';

	$output = '';

	$sql = $con->query("SELECT
								gradeId, first_name, last_name, ovscr, pmark,
							     r.student_id, sub_name, cname,
								 score, t_name, ac_yr, term_name 
						FROM
								results r LEFT JOIN students s ON r.student_id = s.student_id
				  INNER JOIN 
				  				test tt ON r.test_id = tt.test_id
				  		JOIN
				  				subjects sub ON r.sub_id = sub.sub_id
				   		JOIN  
				   				class c ON r.c_id = c.c_id
				   		JOIN      	
				   				term t ON r.term_id = t.term_id
				   		JOIN	
				   				academic_year ac ON r.yr_id = ac.yr_id
				   		WHERE 
				   				teacher_id = '".$_POST["user_id"]."' AND published = 0 ORDER BY score DESC");

	$output.='
			 <div class="widget-title">
				<div class="widget-content nopadding">
					<table class="table table-bordered data-table">
						<tr>
							<th><input type="checkbox" class="inc_selectAll"></th>
							<th>STUDENT ID</th>
							<th>STUDENT INFO</th>
							<th>TEST</th>
							<th>SUBJECT</th>
							<th>CLASS</th>
							<th>OVERALL SCORE</th>
							<th>PASS MARK</th>
							<th>SCORE</th>
						</tr>';

	if (!empty($sql)) {
	 	while($row = $sql->fetch_assoc()){
	 		$output .= '
	 					<tr>
	 						<td><input type="checkbox" class="inc_thisBox" value="'.$row["student_id"].'"></td>	
		 					<td>'.$row["student_id"].'</td>
		 					<td>'.$row["first_name"]." ".$row["last_name"].'</td>
		 					<td>'.$row["t_name"].'</td>
		 					<td>'.$row["sub_name"].'</td>
		 					<td>'.$row["cname"].'</td>
		 					<td>'.$row["ovscr"].'</td>
		 					<td>'.$row["pmark"].'</td>
		 					<td>'.$row["score"].'</td>
		 					<td>
		 						<button class="btn btn-secondary btn-mini" id="edit_btn" data-edit="'.$row["gradeId"].'"><span class="icon-edit"></span></button>
		 						<button class="btn btn-secondary btn-mini" id="btn_delete" data-delete="'.$row["gradeId"].'"><span class="icon-trash"></span></button>
		 					</td>
		 				</tr>		
	 				   ';
	 	}

	 
	 }else{
	 	$output .='<td colspan="9"> No Data Entered Today </td>';
	 }

	 	$output.='</table></div></div>';

	 $data = array('grades'=> $output);
	 echo json_encode($data);

	 $con->close();
?>