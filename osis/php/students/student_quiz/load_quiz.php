<?php
	require_once '../../../config.php';
$output = '<ul class="quick-actions">';

$sid = $con->real_escape_string($_POST["sid"]);
$class = $con->real_escape_string($_POST["student_class"]);
$stream = $con->real_escape_string($_POST["stream"]);
$query =  $con->query("SELECT DISTINCT q.sub_id, s.sub_name, ex_id, q.term_id, q.yr_id, q.c_id, t.status, a.status, q.s_id, c.cname FROM quiz q
LEFT JOIN quiz_ans qa on q.quiz_id = qa.quiz_id
LEFT JOIN term t ON t.term_id = q.term_id
LEFT JOIN academic_year a ON a.yr_id = q.yr_id
LEFT JOIN class c ON c.c_id = q.c_id
LEFT JOIN subjects s ON s.sub_id = q.sub_id
WHERE q.c_id = '$class' AND q.s_id = '$stream' AND t.status = 1 AND a.status =1 AND q.quiz_id NOT IN(SELECT qa.quiz_id FROM quiz_ans qa WHERE qa.sid = '$sid')");


		if($query){
       if (!empty($query)) {
          $i=1;
           while($record = $query->fetch_assoc()){
             $c_id = $record["c_id"];
             $yr_id = $record["yr_id"];
             $ex_id = $record["ex_id"];
						 $term = $record["term_id"];
						 $stream = $record["s_id"];
						 $subject = $record["sub_id"];
               $output.='
               <li>
								 	<a href="active_quiz.php?class='.$c_id.'&&yr='.$yr_id.'&&ex='.$ex_id.'&&stream='.$stream.'&&term='.$term.'&&sub='.$subject.'">
	                   <img src="../../img/cw.png" style="width:90px;">
	                    <p>'.$record["sub_name"].'</p>
	                    <button class="btn btn-success btn" id="quiz-start">Start</button>
								  </a>
               </li>';
               $i++;
             }
        }else{
          $output.='<li>No new Quizzes available: '.$con->error.'</li>';
        }
		}else{
			$output.='<li>Something went wrong: '.$con->error.'</li>';
		}
  $output.='</ul>';



       $data = array('output' => $output);
       echo json_encode($data);

$con->close();

?>
