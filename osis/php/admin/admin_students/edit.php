<?php

require '../../../config.php';

$output="";

if(isset($_POST)){
 	$sid = $con->real_escape_string($_POST["sid"]);
 	$fname = $con->real_escape_string($_POST["fname"]);
 	$lname = $con->real_escape_string($_POST["lname"]);
  $other = $con->real_escape_string($_POST["other"]);
 	$dob = $con->real_escape_string($_POST["dob"]);
 	$adm = $con->real_escape_string($_POST["adm"]);
 	$contact = $con->real_escape_string($_POST["contact"]);
 	$stream = $con->real_escape_string($_POST["stream"]);
 	$level = $con->real_escape_string($_POST["level"]);
 	$email = $con->real_escape_string($_POST['email']);
	$entry = $con->real_escape_string($_POST['entry']);
	$gender = $con->real_escape_string($_POST["gender"]);
  $student_id = $con->real_escape_string($_POST["student_id"]);
  $entry = $con->real_escape_string($_POST["entry"]);


 	$sql = $con->query("UPDATE students SET  student_id= '$student_id', password= CONCAT('$student_id', '@gbs'),
                      entry_class = '$entry', middle_name = '$other', first_name = '$fname', last_name = '$lname',
                      date_of_birth = '$dob', admission_date = '$adm', s_id = '$stream', c_id = '$level', email = '$email',
                      contact = '$contact' WHERE sid = '$sid'");

		 if($sql){$output.="Changes successfully made.";}else{$output.="Error: ".$con->error;}
   }else{$output.="Error: ".$con->error;}

   $data = array("output" => $output);
   echo json_encode($data);

 	$con->close();
 ?>
