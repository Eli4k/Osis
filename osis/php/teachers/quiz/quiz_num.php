<?php

if(isset($_POST)){
  require_once '../../../config.php';
  $ex_num;

  $subject = $con->real_escape_string($_POST["subject"]);
  $term = $con->real_escape_string($_POST["term"]);
  $c_id = $con->real_escape_string($_POST["c_id"]);
  $yr_id = $con->real_escape_string($_POST["yr"]);
  $s_id = $con->real_escape_string($_POST["stream"]);
  $teacher = $con->real_escape_string($_POST["user"]);

  $query = $con->query("SELECT COUNT(DISTINCT(ex_id)) AS total FROM quiz WHERE sub_id = '$subject'
                          AND c_id = '$c_id' AND yr_id = '$yr_id' AND s_id = '$s_id' AND teacher_id = '$teacher' AND term_id = '$term'");
  if($query)
  {

    while($row = $query->fetch_assoc())
    {
      $total = $row["total"];
      $ex_num = (int)$total+1;
    }
  }
  $data = array("output" => $ex_num);
  echo json_encode($data);
}


?>
