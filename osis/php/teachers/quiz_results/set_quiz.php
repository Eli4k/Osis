<?php
include '../../../config.php';

$output = "";

$array = json_decode($_POST["set"], true);

foreach($array as  $json)
{
  $question = $json["question"];
  $opt_a = $json["option_a"];
  $opt_b = $json["option_b"];
  $opt_c = $json["option_c"];
  $opt_d = $json["option_d"];
  $answer = $json["answer"];
  $teacher_id = $json["teacher_id"];
  $term_id = $json["term_id"];
  $c_id = $json["c_id"];
  $yr_id = $json["yr_id"];
  $s_id = $json["s_id"];
  $sub_id = $json["sub_id"];
  $duration = $json["duration"];
  $ex_id = $json["ex_id"];
  $query = "INSERT INTO quiz(question,sub_id, ex_id, opt_a, opt_b, opt_c, opt_d, answer, c_id, yr_id, term_id, teacher_id, s_id, duration)
          VALUES('$question', '$sub_id', '$ex_id', '$opt_a', '$opt_b', '$opt_c', '$opt_d', '$answer', '$c_id', '$yr_id', '$term_id', '$teacher_id', '$s_id', '$duration')";

  if($con->query($query))
  {
    $output.= '<div class="alert alert-success">
                <strong>Success!</strong>
                <button class="close" data-dismiss="alert">x</button>
                  Questions uploaded Successfully.
              </div>';
  }else{
    $output.= '<div class="alert alert-error">
            <button class="close" data-dismiss="alert">x</button>
                <strong>Error!</strong>
                '.$con->error.'
              </div>';
          }

}
  $data = array("output" => $output);
  echo json_encode($data);


  $con->close();
?>
