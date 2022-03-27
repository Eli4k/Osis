<?php

	$output=$remarks=$grade='';

	$class_length = array();

	if (isset($_GET["user_id"])) {
		$user = $_GET["user_id"];

	 	require_once "../../../config.php";

	 		$sql = "SELECT DISTINCT cname, ac_yr,term_name,c.c_id, a.yr_id,t.term_id,s_name, s.s_id FROM assessment asmt
	 				JOIN class c ON asmt.c_id = c.c_id
	 				JOIN academic_year a  ON asmt.yr_id = a.yr_id
	 				JOIN term t ON asmt.term_id = t.term_id
					JOIN stream s ON asmt.s_id = s.s_id
	 				WHERE asmt.student_id = '$user'
	 				AND published = 1 ORDER BY a.yr_id desc, c.c_id desc, t.term_id desc";

	 		$result = $con->query($sql);

	 		if($result == true){
	 			while($row = $result->fetch_assoc())
	 			{
					$rawscore = 0;
	 				$term_name = $row["term_name"];
	 				$class_name = $row["cname"];
	 				$yr_name = $row["ac_yr"];
	 				$term_id = $row["term_id"];
	 				$c_id = $row["c_id"];
	 				$yr_id = $row["yr_id"];
					$stream = $row["s_name"];
	 				$output.='
						<div>
	 							<table class="styled-table ">
	 								<thead>
									<tr>
										<th colspan="6" align="center" style="font-size: 20px">GAEC '.$stream.' BASIC SCHOOL</th>
									</tr>
									<tr>
										<th  colspan="2" align="center" style="font-size:16px">'.$class_name.'</th>
										<th colspan="2" align="center" style="font-size:18px">'.$term_name.'</th>
										<th colspan="2" align="center" style="font-size:18px">'.$yr_name.'</th>
									</tr>
	 									<tr>
	 										<th width="17%" align="center">SUBJECT</th>
	 										<th width="16%" align="center">CLASS SCORE</th>
	 										<th width="16%" align="center">EXAM SCORE </th>
	 										<th width="16%" align="center">TOTAL</th>
	 										<th width="16%" align="center">GRADE</th>
	 										<th width="16%" align="center">REMARKS</th>
	 									</tr>
	 								</thead><tbody>';

	 								$record = $con->query("SELECT sub_name, asmt.sub_id, class_score, ex_100, ex_50, ovscr FROM assessment asmt
	 											JOIN subjects sub ON asmt.sub_id = sub.sub_id
	 											WHERE term_id = '$term_id'
	 											AND c_id = '$c_id' AND  yr_id = '$yr_id' AND student_id = '$user' AND published = 1");

	 								foreach($record AS $score){
	 										$subject = $score["sub_name"];
											$class_score = $score["class_score"];
											$ex_100 = $score["ex_100"];
											$ex_50 = $score["ex_50"];
											$ovscr = $score["ovscr"];
											$rawscore += $ovscr;

				 					if($ovscr > 79 ){$remarks = "Excellent";$grade = "1";	}
				 					if($ovscr > 74 && $ovscr <= 79){$remarks = "Very Good";$grade = "2";}
				 					if($ovscr > 69 && $ovscr <= 74){$remarks = "Good";$grade = "3";}
				 					if($ovscr > 64 && $ovscr <= 69 ){$remarks = "Credit";$grade = "4";}
				 					if($ovscr > 59 && $ovscr <= 64){$remarks = "Credit"; $grade = "5";}
				 					if($ovscr > 54 && $ovscr <= 59){$remarks = "Pass"; $grade = "6";}
				 					if($ovscr > 49 && $ovscr <= 54){$remarks = "Average"; $grade = "7";}
				 					if($ovscr > 39 && $ovscr <= 49){$remarks = "Below Average"; $grade = "8";}
				 					if($ovscr <= 39){$remarks ="Fail"; $grade = "9";}
				 				$output.='<tr><td align="center">'.$subject.'</td><td align="center">'.$class_score.'</td><td align="center">'.$ex_50.'</td><td align="center">'.$ovscr.'</td><td align="center">'.$grade.'</td><td align="center">'.$remarks.'</td></tr>';
				 			}
							$output.='</tbody><tfoot><td colspan="2" align="center" style="background-color:#6c3f5e; color:#ffffff; font-size:18px;">Raw Score:</td><td colspan="2" align="center" style="font-size: 16px;">'.$rawscore.'</td><td><button onclick="print_document(event);" class="span12 btn-info btn" style="padding:0; margin:0;">Print</button></td></tfoot></table></div>';
				 		}
	 			}else{
	 			$output.='Something went wrong'.$con->error;
	 		}
	 	$data = array('output'=> $output);

	 	echo json_encode($data);

	 }
?>
