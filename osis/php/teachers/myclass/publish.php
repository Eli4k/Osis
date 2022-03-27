<?php
require_once('../../../config.php');

$output="";

if(isset($_POST)){

    $data = json_decode($_POST["data"], true);

    foreach($data as $value){
      $student = $value["id"];
      $class_score = $value["class_score"];
      $ex_score = $value["ex_score"];
      $ex_50 = $value["ex_50"];
      $overall = $value["ovscr"];
      $teacher = $value["teacher"];
      $term = $value["term"];
      $subject = $value["subject"];
      $yr = $value["ac_year"];
      $stream = $value["stream"];
      $class = $value["level"];

      $insert = $con->query(
        "INSERT INTO assessment (student_id, teacher_id, yr_id, term_id, c_id, s_id, sub_id, class_score, ex_100, ex_50, ovscr) 
        VALUES('$student', '$teacher', '$yr', '$term', '$class', '$stream', '$subject', '$class_score', '$ex_score', '$ex_50', '$overall')");

      if($insert){
        $output = '<div class="alert alert-success"><strong>Success!</strong> Records entered successfully</div>';
      }else{
         $output .= '<div class="alert alert-error"><strong>Error!</strong> '.$con->error.'</div>';
      }
    }
  }else{
    $output .= '<div class="alert alert-error"><strong>Error!</strong> '.$con->error.'</div>';
  }

   $data = array("output" => $output);
    echo json_encode($data);

  $con->close();
?>
