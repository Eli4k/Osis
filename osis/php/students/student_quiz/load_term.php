<?php
	include '../../../config.php';

$term="";
	$sql = $con->query("SELECT  DISTINCT q.term_id, t.term_name, qa.sid FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
											JOIN term t ON t.term_id = q.term_id WHERE qa.sid = ".$_POST["sid"]."
						ORDER BY q.term_id DESC");

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


?>
