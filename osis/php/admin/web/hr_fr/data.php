<?php
include '../../../../config.php';
$output = "";

$query = "SELECT * FROM contact";

$query_exec = $con->query($query);

if($query_exec)
{
  while($row = $query_exec->fetch_assoc())
  {
    $data = array( "location" => $row["location"],
                   "phone" => $row["phone"],
                   "web" => $row["website"],
                   "email" => $row["email"]);
    echo json_encode($data);

  }
}

$con->close();



?>
