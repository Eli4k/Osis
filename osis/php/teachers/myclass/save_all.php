<?php
require_once('../../../config.php');

$output="";

if(isset($_POST)){

    $data = json_decode($_POST["data_info"], true);

    foreach($data as $value){
      $assessment_id = $value["assessment_id"];
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

      $update = $con->query("UPDATE assessment SET yr_id = '$yr', term_id = '$term',c_id = '$class', s_id = '$stream', sub_id = '$subject', class_score = '$class_score',
                            ex_100 = '$ex_score', ex_50 = '$ex_50', ovscr = '$overall' WHERE assessment_id = '$assessment_id'");


      if($update){
        $output.= 'Records changed successfully';
      }else{
         $output.= 'Error: '.$con->error;
      }
    }
  }else{
    $output.= 'Error: '.$con->error;
  }

   $data = array("output" => $output);
    echo json_encode($data);

  $con->close();
?>
