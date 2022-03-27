<?php
	include '../../../config.php';

$yr="";

if(isset($_POST["sid"])){

	$student_id = $_POST['sid'];
	$sql = $con->query("SELECT  DISTINCT r.yr_id, y.ac_yr, r.student_id FROM results r
											JOIN students s ON s.student_id = r.student_id
											JOIN academic_year y ON y.yr_id = r.yr_id WHERE r.student_id = '$student_id'
						ORDER BY y.yr_id DESC");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$yr .= '<option value="'.$row["yr_id"].'">'.$row["ac_yr"].'</option>';
		}
	}else{
		$yr ='<option select="selected">No Academic_year Available</option>';
	}
	$data = array('result_yr'=>$yr);
	echo json_encode($data);
}

$con->close();


?>
