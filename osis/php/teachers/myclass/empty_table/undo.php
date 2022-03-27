<?php

if(isset($_POST)){
    require_once '../../../../config.php';

    $id = $con->real_escape_string($_POST["id"]);

    $class_score=$ex_100=$ex_50=$ovscr="";

    $select = $con->query("SELECT class_score, ex_100, ex_50, ovscr FROM assessment WHERE assessment_id = '$id'");

    if($select){
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