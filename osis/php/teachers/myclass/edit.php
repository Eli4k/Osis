<?php

if(isset($_POST)){
    require_once '../../../config.php';

    $id = $con->real_escape_string($_POST["id"]);
    $class_score=$con->real_escape_string($_POST["class_score"]);
    $ex_100=$con->real_escape_string($_POST["exam_score"]);
    $ex_50=$con->real_escape_string($_POST["ex_50"]);
    $ovscr=$con->real_escape_string($_POST["overall"]);

    $update = $con->query("UPDATE assessment SET class_score = '$class_score', ex_100 = '$ex_100',
    											 ex_50 = '$ex_50', ovscr = '$ovscr' WHERE assessment_id = '$id'");

    if($update){

    	$select = $con->query("SELECT class_score, ex_100, ex_50, ovscr FROM assessment WHERE assessment_id = '$id'");
    	while($row = $select->fetch_assoc()){
    		$class_score = $row["class_score"];
    		$ex_100 = $row["ex_100"];
    		$ex_50 = $row["ex_50"];
    		$ovscr = $row["ovscr"];
    	}
    }else{
    	echo $con->error;
    }
  }

  $data = array("class_score" => $class_score,
  				"ex_100" => $ex_100,
  				"ex_50" => $ex_50,
  				"ovscr" => $ovscr
  			);

  echo json_encode($data); 
 ?>