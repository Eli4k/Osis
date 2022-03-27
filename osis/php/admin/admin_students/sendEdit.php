<?php

require '../../../config.php';


$id=$fname=$lname=$dob=$s_id=$c_id=$level=$stream=$adm=$email=$contact=$entry=$student_id="";

if($_GET["id"]){
  $id = $con->real_escape_string($_GET["id"]);

  $sql = $con->query("SELECT sid, student_id, first_name, middle_name, last_name, gender, entry_class, date_of_birth, c.c_id, st.s_id, s_name, cname, contact, admission_date, s_name, email
                    FROM class c INNER JOIN students s
                    ON s.c_id = c.c_id
                    JOIN stream st
                     ON s.s_id = st.s_id WHERE sid = '$id'");


  	while($row = $sql->fetch_assoc())
  	{
      $student_id = $row["student_id"];
  		$id = $row["sid"];
  		$fname = $row["first_name"];
  		$lname = $row["last_name"];
      $other_name = $row["middle_name"];
  		$dob = $dob = date("Y-m-d", strtotime($row["date_of_birth"]));
  		$s_id = $row["s_id"];
  		$c_id = $row["c_id"];
  		$level = $row["cname"];
  		$stream = $row["s_name"];
   		$adm = date("Y-m-d", strtotime($row["admission_date"]));
  		$email = $row["email"];
  		$contact = $row["contact"];
      $gender = $row["gender"];
      $entry = $row["entry_class"];

  	}
}



	$data = array(
		"id" => $id,
		"fname" => $fname,
		"lname" => $lname,
    "student_id" => $student_id,
    "other" => $other_name,
		"dob" => $dob,
		"c_id" => $c_id,
		"s_id" => $s_id,
		"stream" => $stream,
		"level" => $level,
		"adm" => $adm,
		"email" => $email,
		"contact" => $contact,
    "gender" => $gender,
    "entry" =>$entry
	);

	echo json_encode($data);

$con->close();

?>
