<?php

$output = "";
  if(isset($_POST))
  {
    require '../../../config.php';
      $yr = $_POST["yr"];
      $c_id = $_POST["class_id"];
      $s_id = $_POST["stream"];
      $term = $_POST["term"];
      $sid = $_POST["sid"];
      $ex = $_POST["ex_id"];
      $sub = $_POST["sub"];

      $quiz_result = "SELECT DISTINCT q.yr_id, q.term_id, q.c_id, q.s_id, qa.sid, q.ex_id FROM quiz_ans qa
      JOIN quiz q ON q.quiz_id = qa.quiz_id
      JOIN students s ON s.sid = qa.sid
      WHERE q.yr_id = '$yr' AND q.c_id = '$c_id'  AND q.sub_id = '$sub' AND q.s_id = '$s_id' AND q.term_id = '$term' AND qa.sid = '$sid' AND q.ex_id = '$ex'";

      $result_executed = $con->query($quiz_result);
       if($result_executed){
        if(!empty($result_executed->fetch_assoc())){
          $output = 1;
        }else{
          $output = 0;
        }
       }else{
         $output.= "Something went wrong ".$con->error;
       }

  }else{
    $output="No data has been sent";
  }
  $data = array('output' => $output);
  echo json_encode($data);

$con->close();

?>
