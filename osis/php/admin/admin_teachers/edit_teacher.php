<?php
require '../../../config.php';

$data = array();

$new_sub=$new_class="";

if($_POST["id"]){
  $id = $_POST["id"];

  $query=$con->query("SELECT * FROM teachers WHERE tid='$id'");

  if($query){
    while($row = $query->fetch_assoc()){
      $fname = $row["first_name"];
      $mid_name = $row["middle_name"];
      $lname = $row["last_name"];
      $username = $row["teacher_id"];
      $dob = date("Y-m-d", strtotime($row["date_of_birth"]));
      $assigned_class= $row["class_assigned"];
      $assigned_sub= $row["sub_assigned"];
      $gender = $row["gender"];
      $m_stat = $row["m_status"];
      $contact = $row["contact"];
      $email = $row["email"];
      $emp_date = date("Y-m-d", strtotime($row["emp_date"]));


      $data = ['fname' => $fname,
               'lname' => $lname,
               'mid_name' => $mid_name,
               'username' => $username,
               'dob' => $dob,
               'array_class' => $assigned_class,
               'array_sub' =>$assigned_sub,
               'gender' => $gender,
               'm_stat' => $m_stat,
               'contact' => $contact,
               'email' => $email,
               'emp_date' => $emp_date
             ];
    }
  }
}

echo json_encode($data);

$con->close();
?>
