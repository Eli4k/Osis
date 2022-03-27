<?php
require '../../../../config.php';

if(isset($_POST["records"])){

  $records = json_decode($_POST["records"], true);
  $message = array();

$i = 0;
  foreach($records as $record){
    $student_id = $record["student_id"];
    $score = $record["score"];
    $scaled_score = $record["scale_percentage"];
    $total_score = $record["total_score"];
    $scalar = $record["scalar"];
    $tid = $record["teacher"];
    $term = $record["term"];
    $yr = $record["ac_year"];
    $stream = $record["stream"];
    $level = $record["level"];
    $ex = $record["ex_id"];
    $subject = $record["subject"];
    $test = $record["test"];


      $query = $con->query("INSERT INTO class_score (tid, sid, ex_id, sub_id,  s_id, c_id, test_id, term_id, yr_id, score, scaled_score, percent_score, overall, used)
                    VALUES('$tid', '$student_id', '$ex', '$subject', '$stream', '$level', '$test', '$term', '$yr','$score', '$scaled_score', '$scalar', '$total_score', 0)");

      if($query){
        $i++;
      }else{
          $message["error"] = "Error: ".$con->error;
      }
    }

  $message["error"] = "<br>".$i." Record(s) Entered";

  $data = array("message" => $message);
  echo json_encode($data);


}

$con->close();




?>
