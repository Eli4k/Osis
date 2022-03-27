<?php
	include '../../../config.php';

$cl="";
	$sql = $con->query("SELECT  DISTINCT q.c_id, c.cname, qa.sid FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
											JOIN class c ON q.c_id = c.c_id WHERE qa.sid = ".$_POST["sid"]."
						ORDER BY c_id");

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


?>
