<?php

	$output=$remarks=$grade='';

	$class_length = array();

	if (isset($_POST["id"])) {
		$user = $_POST["id"];
    $yr_id= $_POST["yr_id"];
    $c_id = $_POST["c_id"];

	 	require_once "../../../config.php";

	 		$sql = "SELECT DISTINCT c.cname, a.ac_yr,t.term_name,c.c_id, a.yr_id,t.term_id,s.s_name, s.s_id FROM assessment asmt
	 				JOIN class c ON asmt.c_id = c.c_id
	 				JOIN academic_year a  ON asmt.yr_id = a.yr_id
	 				JOIN term t ON asmt.term_id = t.term_id
					JOIN stream s ON asmt.s_id = s.s_id
	 				WHERE asmt.student_id = '$user' AND a.yr_id = '$yr_id' AND c.c_id = '$c_id'
	 				AND published = 0 ORDER BY t.term_id desc";

	 		$result = $con->query($sql);

	 		if($result == true){
	 			while($row = $result->fetch_assoc())
	 			{
					$rawscore = 0;
					$raw_total = array();
	 				$term_name = $row["term_name"];
	 				$class_name = $row["cname"];
	 				$yr_name = $row["ac_yr"];
	 				$term_id = $row["term_id"];
					$stream = $row["s_name"];
	 				$output.='
					<div class="row-fluid">
						<table class="reportslip-table">
							<thead class="slip_heads">
							<tr>
								<th colspan="6">GAEC '.$stream.' BASIC SCHOOL</th>
							</tr>
							<tr >
								<th colspan="3" align="left">Name: '.$name.'</th>
								<th colspan="3" align="right">Class/Form:  '.$class_name.'</th>
							</tr>
							<tr style="border-bottom: 3px solid #0f0f0f;">
								<th colspan="3" align="left">Term: '.$term_name.'</th>
								<th colspan="3" align="right">Year: '.$yr_name.'</th>
							</tr>
							</thead>
							<thead>
								<tr>
									<th width="17%" align="center">SUBJECT</th>
									<th width="16%" align="center">CLASS SCORE</th>
									<th width="16%" align="center">EXAM SCORE</th>
									<th width="16%" align="center">TOTAL</th>
									<th width="16%" align="center">GRADE</th>
									<th width="16%" align="center">REMARKS</th>
								</tr>
							</thead><tbody>';

	 								$record = $con->query("SELECT sub_name, asmt.sub_id, class_score, ex_100, ex_50, ovscr FROM assessment asmt
	 											JOIN subjects sub ON asmt.sub_id = sub.sub_id
	 											WHERE term_id = '$term_id'
	 											AND c_id = '$c_id' AND  yr_id = '$yr_id' AND student_id = '$user' AND published = 0");

	 								foreach($record AS $score){
	 										$subject = $score["sub_name"];
											$class_score = $score["class_score"];
											$ex_100 = $score["ex_100"];
											$ex_50 = $score["ex_50"];
											$ovscr = $score["ovscr"];
											$rawscore += $ovscr;
											array_push($raw_total, $subject);

				 					if($ovscr > 79 ){$remarks = "Excellent";$grade = "1";	}
				 					if($ovscr > 74 && $ovscr <= 79){$remarks = "Very Good";$grade = "2";}
				 					if($ovscr > 69 && $ovscr <= 74){$remarks = "Good";$grade = "3";}
				 					if($ovscr > 64 && $ovscr <= 69 ){$remarks = "Credit";$grade = "4";}
				 					if($ovscr > 59 && $ovscr <= 64){$remarks = "Credit"; $grade = "5";}
				 					if($ovscr > 54 && $ovscr <= 59){$remarks = "Credit"; $grade = "6";}
				 					if($ovscr > 49 && $ovscr <= 54){$remarks = "Pass"; $grade = "7";}
				 					if($ovscr > 39 && $ovscr <= 49){$remarks = "Weak Pass"; $grade = "8";}
				 					if($ovscr <= 39){$remarks ="Fail"; $grade = "9";}
									$output.='<tr><td>'.$subject.'</td><td>'.$class_score.'</td><td >'.$ex_50.'</td><td>'.$ovscr.'</td><td>'.$grade.'</td><td>'.$remarks.'</td></tr>';
								}
								$output.='</tbody><tfoot><tr><td colspan="2">Raw Score:</td><td colspan="2"><b>'.$rawscore.'/'.count($raw_total)*100 .'</b></td><td><button onclick="print_document(event);" class="span12 btn-info btn">Print</button></td></tr></tfoot></table></div>';
							}
	 			}else{
	 			$output.='Something went wrong'.$con->error;
	 		}
	 	$data = array('output'=> $output);

	 	echo json_encode($data);

	}else{
		echo "No data available";
	}
?>
