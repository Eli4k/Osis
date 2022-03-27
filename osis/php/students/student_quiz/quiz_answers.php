<?php

$output = $response="";
$correct_ans = array();
  if(isset($_POST))
  {
    require '../../../config.php';

    $array = json_decode($_POST["result"], true);
    $yr = $con->real_escape_string($_POST["yr"]);
    $c_id = $con->real_escape_string($_POST["class_id"]);
    $s_id = $con->real_escape_string($_POST["stream"]);
    $term = $con->real_escape_string($_POST["term"]);
    $sid = $con->real_escape_string($_POST["sid"]);
    $ex = $con->real_escape_string($_POST["ex_id"]);
    $total = $con->real_escape_string($_POST["total"]);
    $sub = $con->real_escape_string($_POST["sub"]);
    $tid = "";
    $teacher_id = "";


    // Insert iterate answers
    foreach($array as $data)
    {
      $chosen_ans = $con->real_escape_string($data["chosen_ans"]);
      $quiz_id = $data["q_id"];
      // $sid = $data["sid"];

      $query = "INSERT INTO quiz_ans(quiz_id, sid, chosen_ans) VALUES('$quiz_id', '$sid', '$chosen_ans')";
      if($con->query($query)){
        $output = "Success";
      }else{
        $output = "Error: ".$con->error;
      }
    }
    // End

    if($output == "Success"){
        $getTeacherId = $con->query("SELECT DISTINCT t.tid, t.teacher_id FROM quiz q  JOIN teachers t  ON t.teacher_id  = q.teacher_id WHERE q.term_id = '$term' AND q.yr_id = '$yr' AND q.ex_id = '$ex' AND q.c_id = '$c_id' AND q.sub_id = '$sub'");

      if($getTeacherId){
        while($row = $getTeacherId->fetch_assoc()){
          $tid = $row["tid"];
          $teacher_id = $row["teacher_id"];
        }
      }else{$response.='Error: '.$con->error;}
    }else{$response.='Error: '.$con->error;}

    // Count correct Answers
      foreach($array as $data){
        $chosen_ans = $con->real_escape_string($data["chosen_ans"]);
        $quiz_id = $data["q_id"];
        $select = $con->query("SELECT qa.chosen_ans FROM quiz_ans qa
                  JOIN quiz q ON qa.quiz_id = q.quiz_id
                  WHERE q.teacher_id = '$teacher_id' AND q.term_id = '$term' AND q.yr_id = '$yr' AND q.c_id = '$c_id' AND qa.sid = '$sid' AND q.s_id = '$s_id'
                  AND q.ex_id = '$ex'  AND q.answer = '$chosen_ans' AND qa.quiz_id = '$quiz_id' AND q.sub_id= '$sub'");
          if($select){
            while($row=$select->fetch_assoc()){
              array_push($correct_ans, $row["chosen_ans"]);
            }
          }else{$response.='Error: '.$con->error;}
      }

    $mark = round((count($correct_ans)/$total) * 100);
    $score = count($correct_ans);

    // Record Class Score
    $record = $con->query("INSERT INTO class_score(tid, sid, ex_id, sub_id, s_id, c_id, test_id, term_id, yr_id, score, scaled_score, percent_score, overall)
                                            VALUES('$tid', '$sid', '$ex', '$sub','$s_id', '$c_id', '7', '$term', '$yr', $score, '$mark', '100', '$total')");

$response.='<div class="span6">
  <div class="widget-box">
  <div class="widget-title">
    <h5>QUIZ RESULT</h5>
    </div>
    <div class="widget-content nopadding">';

      $response.='<h1>Your Score: '.$mark.' out of 100</h1>';
    if($mark > 80){$response.='<h3>Remarks: Excellent Performance</h3>';}
    elseif ($mark >74 && $mark<80) {$response.='<h3>Remarks: Very Good </h3>';}
    elseif ($mark >69 && $mark<75) {$response.='<h3>Remarks: Good</h3>';}
    elseif ($mark >64 && $mark<70) {$response.='<h3>Remarks: Okay</h3>';}
    elseif ($mark >59 && $mark<65) {$response.='<h3>Remarks: Almost there</h3>';}
    elseif ($mark >49 && $mark<59) {$response.='<h3>Remarks: Average</h3>';}
    elseif ($mark < 49) {$response.='<h3>Remarks: Fail</h3>';}

    if($record){
      $response.='<h4>Class Score recorded</h4>';
    }else{$response.='<h4>Error: '.$con->error.'</h4>';}

}else{$response.="No data has been set";}

$response.='</div></div></div>';

$data = array("response" => $response,
              "output" => $output);

echo json_encode($data);

$con->close();
?>
