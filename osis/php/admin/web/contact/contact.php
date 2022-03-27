<?php

$response = "";
if(isset($_POST))
{
  include '../../../../config.php';

  $address = $con->real_escape_string($_POST["address"]);
  $phone = $con->real_escape_string($_POST["phone"]);
  $email = $con->real_escape_string($_POST["email"]);
  $web = $con->real_escape_string($_POST["web"]);

  $query = "UPDATE contact SET location = '$address', email='$email', phone='$phone', website='$web' WHERE id = 1";

  if($con->query($query))
  {
    $response.='<div class="alert alert-success">
                  <button class="close" data-dismiss="alert">x</button>
                  <strong>Success</strong> changes Made successfully
                </div>';
  }else{
    $response.='<div class="alert alert-error">
                  <button class="close" data-dismiss="alert">x</button>
                  <strong>Error!</strong>
                      Something went wrong: '.$con->error.'<div>';
  }

  $data = array("response" => $response);
  echo json_encode($data);
  // echo $response;
  $con->close();
}


?>
