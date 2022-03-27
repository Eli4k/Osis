<?php

require_once '../../../../config.php';

$output = array();

if(isset($_POST)){
  $tid = $con->real_escape_string($_POST["tid"]);
  $s_id = $con->real_escape_string($_POST["s_id"]);
  $c_id = $con->real_escape_string($_POST["c_id"]);
  $yr = $con->real_escape_string($_POST["yr_id"]);
  $term = $con->real_escape_string($_POST["term"]);
  $test = $con->real_escape_string($_POST["test"]);
  $ex = $con->real_escape_string($_POST["ex"]);
  $sub_id = $con->real_escape_string($_POST["sub_id"]);


  $delete = $con->query("DELETE FROM class_score WHERE tid='$tid' AND s_id='$s_id' AND c_id='$c_id' AND yr_id='$yr' AND test_id='$test' AND ex_id='$ex' AND sub_id='$sub_id'");

  if($delete){
      $output["error"] = "All records have been deleted";
      }else{
      $output["error"] = "Error ".$con->error;
  }
}


$data = array("output" => $output);
echo json_encode($data);

$con->close();
 ?>
