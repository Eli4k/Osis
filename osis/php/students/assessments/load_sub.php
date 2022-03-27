<?php
	include '../../../config.php';

$sub="";

if(isset($_POST['sid'])){
	$student_id = $_POST['sid'];

	$sql = $con->query("SELECT  DISTINCT r.sub_id, s.sub_name, r.student_id FROM results r
											JOIN students st ON r.student_id = st.student_id
											JOIN subjects s ON r.sub_id = s.sub_id WHERE r.student_id = '$student_id'
						ORDER BY s.sub_id ");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$sub .= '<option value="'.$row["sub_id"].'">'.strtoupper($row["sub_name"]).'</option>';
		}
	}else{
		$sub.='<option selected>No Subjects Available</option>';
	}
	$data = array('result_sub'=>$sub);
	echo json_encode($data);
}
$con->close();

?>
