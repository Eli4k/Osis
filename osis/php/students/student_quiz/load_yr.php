<?php
	include '../../../config.php';

$yr="";
	$sql = $con->query("SELECT  DISTINCT q.yr_id, y.ac_yr, qa.sid FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
											JOIN academic_year y ON q.yr_id = y.yr_id WHERE qa.sid = ".$_POST["sid"]."
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


?>
