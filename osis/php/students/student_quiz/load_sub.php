<?php
	include '../../../config.php';

$sub="";
	$sql = $con->query("SELECT  DISTINCT q.sub_id, s.sub_name, qa.sid FROM quiz q
											JOIN quiz_ans qa ON q.quiz_id = qa.quiz_id
											JOIN subjects s ON q.sub_id = s.sub_id WHERE qa.sid = ".$_POST["sid"]."
						ORDER BY q.sub_id");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
			$sub .= '<option value="'.$row["sub_id"].'">'.strtoupper($row["sub_name"]).'</option>';
		}
	}else{
		$sub.='<option>No Subjects Available</option>';
	}
	$data = array('result_sub'=>$sub);
	echo json_encode($data);


?>
