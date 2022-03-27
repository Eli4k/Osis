<?php
	include '../../../config.php';
	if (isset($_POST)) {
    $status = $_POST["data"];
    $array = json_decode($_POST["sid"], true);
    $query;
    $report = "";
    $studentCount=0;

    switch ($status) {
      case "promote":
        foreach($array as $id){
          $query = $con->query("UPDATE students SET c_id = c_id+1 WHERE sid = '$id'");
          if($query){$studentCount++; $report="{$studentCount} students Promoted";}else{
            $report="Error: ".$con->error;
          }
        }
        break;

				case "revert":
	 			foreach($array as $id){
	 				$query = $con->query("UPDATE students SET c_id = c_id-1 WHERE sid = '$id'");
	 				if($query){$studentCount++; $report="{$studentCount} students class reverted";}else{
	 					$report="Error: ".$con->error;
	 				}
	 			}
	 			break;

        case "transfer":
          foreach($array as $id){
            $query = $con->query("UPDATE students SET state = '$status' WHERE sid = '$id'");
            if($query){$studentCount++; $report="{$studentCount} students transferred";}else{
              $report="Error: ".$con->error;
            }
          }
          break;

				case "alumni":
						foreach($array as $id){
							$query = $con->query("UPDATE students SET state = '$status' WHERE sid = '$id'");
							if($query){$studentCount++; $report="{$studentCount} students turned Alumi";}else{
								$report="Error: ".$con->error;
							}
						}
						break;
    }

	}
	$data = array("output"=>$report);
	echo json_encode($data);
	$con->close();
 ?>
