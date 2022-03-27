<?php
include '../../../config.php';

$output = "";
$count = 0;
$array = json_decode($_POST["set"], true);





foreach($array as  $json)
{
  $question = $con->real_escape_string($json["question"]);
  $opt_a = $con->real_escape_string($json["option_a"]);
  $opt_b = $con->real_escape_string($json["option_b"]);
  $opt_c = $con->real_escape_string($json["option_c"]);
  $opt_d = $con->real_escape_string($json["option_d"]);
  $answer = $con->real_escape_string($json["answer"]);
  $teacher_id = $con->real_escape_string($json["teacher_id"]);
  $term_id = $con->real_escape_string($json["term_id"]);
  $c_id = $con->real_escape_string($json["c_id"]);
  $yr_id = $con->real_escape_string($json["yr_id"]);
  $s_id = $con->real_escape_string($json["s_id"]);
  $sub_id = $con->real_escape_string($json["sub_id"]);
  $duration = $con->real_escape_string($json["duration"]);
  $ex_id = $con->real_escape_string($json["ex_id"]);
  $query = "INSERT INTO quiz(question,sub_id, ex_id, opt_a, opt_b, opt_c, opt_d, answer, c_id, yr_id, term_id, teacher_id, s_id, duration)
          VALUES('$question', '$sub_id', '$ex_id', '$opt_a', '$opt_b', '$opt_c', '$opt_d', '$answer', '$c_id', '$yr_id', '$term_id', '$teacher_id', '$s_id', '$duration')";

  if($con->query($query))
  {
    $output= '<div class="alert alert-success">
                <strong>Success!</strong>
                '.$count.' questions uploaded
                <button class="close" data-dismiss="alert">x</button>';
  }else{
    $output.= '<div class="alert alert-error">
            <button class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong>
                '.$con->error.' '.$count.' question(s) unable to upload
              </div>';
          }
$count++;
}
  $data = array("output" => $output);
  echo json_encode($data);


  $con->close();
?>
