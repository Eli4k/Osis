<?php
	include '../../../config.php';

$term="";

if(isset($_POST['sid'])){

	$student_id = $_POST['sid'];


	$sql = $con->query("SELECT  DISTINCT r.term_id, t.term_name, r.student_id FROM results r
											JOIN students s ON r.student_id = s.student_id
											JOIN term t ON r.term_id = t.term_id WHERE r.student_id = '$student_id'
						ORDER BY t.term_id DESC");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$term .= '<option value="'.$row["term_id"].'">'.$row["term_name"].'</option>';
		}
	}else{
		$term.='<option select="selected">None available</option>'.$con->error;;
	}
	$data = array('result_term'=>$term);
	echo json_encode($data);
}

$con->close();

?>
