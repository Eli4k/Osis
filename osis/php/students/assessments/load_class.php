<?php
	include '../../../config.php';

$cl="";

if(isset($_POST['sid'])){
	$student_id = $_POST['sid'];
	$sql = $con->query("SELECT  DISTINCT r.c_id, c.cname, r.student_id FROM results r
											JOIN students s ON r.student_id = s.student_id
											JOIN class c ON r.c_id = c.c_id WHERE s.student_id = '$student_id'
						ORDER BY r.c_id DESC");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$cl .= '<option value="'.$row["c_id"].'">'.$row["cname"].'</option>';
		}
	}else{
		$cl ='<option select="selected">No classes available</option>';
	}
	$data = array('result_class'=>$cl);
	echo json_encode($data);
}
$con->close();

?>
