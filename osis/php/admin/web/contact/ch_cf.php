<?php
  include '../../../../config.php';

  $select = $con->query("SELECT * FROM contact");

  if($select)
  {
    while($row = $select->fetch_assoc())
    {
      $location = $row["location"];
      $web = $row["website"];
      $email = $row["email"];
      $phone = $row["phone"];

      $data = array("location" => $location,
                   "web" => $web,
                   "email" => $email,
                   "phone" => $phone
                 );
        echo json_encode($data);
    }
  }

$con->close();

?>
