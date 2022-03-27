<?php 

include '../../../config.php';
	
$student_id = "";
$message="";

if(isset($_POST["csv"])){

	$csv = json_decode($_POST["csv"], true);

	// var_dump($csv);

	$i = 0;
	foreach($csv as $row){
		if(empty($row)){ continue;}else{
			$fname = $con->real_escape_string($row["fname"]);
			$oname = $con->real_escape_string($row["other"]);
			$lname = $con->real_escape_string($row["lname"]);
			$dob = $con->real_escape_string(strtr($row["dob"],'/','-'));
			$regDate = $con->real_escape_string(strtr($row["dreg"],'/','-'));
			$gender = $con->real_escape_string($row["gender"]);
			$level = $con->real_escape_string($row["clsId"]);
			$stream = $con->real_escape_string($row["strId"]);
			$stream_txt = $con->real_escape_string($row["strName"]);
			$lvlTxt = $con->real_escape_string($row["clsName"]);
			$email = $con->real_escape_string($row["email"]);
			$contact = $con->real_escape_string($row["contact"]);
			$newDob = date("Y-m-d", strtotime($dob));
			$year = date("Y", strtotime($regDate));

			$select_count = $con->query("SELECT count(sid) as total FROM students WHERE s_id = '$stream' AND YEAR(admission_date) ='$year'");


	if($select_count){

	
		while($row = $select_count->fetch_assoc()){
			$total = intval($row["total"]);
			$new_total = $total+1;
			
			// Create Student_id
			$student_id = substr($stream_txt,0,1).$year.str_pad($new_total,3,0,STR_PAD_LEFT);

			$sql = $con->query("INSERT INTO students(first_name, middle_name, last_name, student_id, password, date_of_birth, s_id, entry_class, c_id, gender,  admission_date, email, contact)
				VALUES('$fname', '$oname', '$lname', '$student_id', '$student_id', '$newDob', '$stream','$lvlTxt', '$level', '$gender', '$regDate', '$email', '$contact')");
							if($sql){$message = $i.' user(s) registered successfully';}
							else{$message.=$i.' Error(s): '.$con->error;}
		
		 
		}
	}else{
		$message = 'Error: '.$con->error;
	}

		}
		$i++;
	}
}else{
	$message = 'Error: '.$con->error;
}

$data = array("output" => $message);
echo json_encode($data);


$con->close();

?>