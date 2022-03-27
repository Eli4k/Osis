<?php
require_once '../../../config.php';

$output=$error="";

if(isset($_POST)){
  $student_id = $con->real_escape_string($_POST["user"]);
  $query = $con->query("SELECT CONCAT(first_name,' ',middle_name,' ',last_name) AS fullname, entry_class, s_name, cname, date_of_birth, admission_date, email, contact FROM students  s
                        JOIN stream st ON s.s_id = st.s_id
                        JOIN class c ON s.c_id = c.c_id
                        WHERE student_id = '$student_id'");
  $output.='<table class="styled_table">';
  if(!$query){
    $error.='<div class="alert alert-error"><p>Mysql Error: '.$con->error.'</p></div>';
  }
  else if(empty($query)){
    $error.='<div class="alert alert-error"><p>Server Response: No results found</p></div>';
  }else{
    while($row = $query->fetch_assoc()){
      $name = $row["fullname"];
      $entry_level = $row["entry_class"];
      $dob = $row["date_of_birth"];
      $admission = $row["admission_date"];
      $email = $row["email"];
      $contact = $row["contact"];
      $stream = $row ["s_name"];
      $level = $row["cname"];

      if($contact == ""){
        $contact = "Not Available";
      }

      if($email == ""){
          $email = "Not Available";
        }


      $output.='<thead>
                    <tr><th colspan="2" align="center"style="font-size: 30px; background-color: #efefef; color: #D5D8DC; font-family: Raleway;">PROFILE </th></tr>
                    <tr><th colspan="2" align="center"style="font-size: 20px;">'.$name.'</th></tr>
                </thead>
                <tbody>
                  <tr><td>ID</td><td>'.$student_id.'</td></tr>
                  <tr><td>Entry Class</td><td>'.$entry_level.'</td></tr>
                  <tr><td>Current Class</td><td>'.$level.'</td></tr>
                  <tr><td>Stream</td><td>'.$stream.'</td></tr>
                  <tr><td>Date of Admission</td><td>'.$admission.'</td></tr>
                  <tr><td>Email</td><td>'.$email.'</td></tr>
                  <tr><td>Contact</td><td>'.$contact.'</td></tr>
                </tbody>';

    }
    $output.='</table>';
  }
}
$data = array("output" => $output,
              "error" => $error);
echo json_encode($data);

$con->close();
?>
