<?php

require '../../../../config.php';

$message = array();

if(isset($_POST)){
  $records = json_decode($_POST["records"], true);

$i=0;
  foreach($records as $record){
    $sid = $record["sid"];
    $tid = $record["tid"];
    $score = $record["score"];
    $scaled = intval($record["scaled_score"]);
    $score_id = $record["score_id"];
    $total = $record["total"];
    $scalar = $record["scalar"];
    $ex = $record["ex"];
    $query = $con->query("UPDATE class_score SET score='$score', scaled_score='$scaled', overall='$total', percent_score='$scalar' WHERE sid = '$sid' AND class_score_id = '$score_id' AND tid='$tid'");

    if($query){
      $i++;
      $message["success"] = $i." Records changed successfully";
    }else{
      $message["error"] = "Error updating ".$sid."'s record. Please check entry ".$con->error;
    }
  }
}

$data = array("output" => $message);
echo json_encode($data);


$con->close();


?>
