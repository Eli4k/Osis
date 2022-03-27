<?php 

$con = new mysqli("localhost", "root","","schoolportal");

$sql = $con->query("SELECT exam_id, s.student_id, term_name, s_name, sub_name, cname, ex_score, ac_yr, class_score,
				  		   e.term_id, e.sub_id, e.c_id, e.yr_id, st.s_id FROM exam e
		             JOIN students s ON e.student_id = s.student_id
		             JOIN class c ON e.c_id = c.c_id
		             JOIN subjects sub ON e.sub_id = sub.sub_id
		             JOIN academic_year ac ON e.yr_id = ac.yr_id
		             JOIN term t ON e.term_id = t.term_id
		             JOIN stream st ON e.s_id = st.s_id
             		 WHERE exam_id = '".$_POST['exam_id']."'");
	

	while($row = $sql->fetch_assoc())
	{
		$exam_id = $row["exam_id"];
		$student = $row["student_id"];
		$subject = $row["sub_name"];
		$ex_score = $row["ex_score"];
		$_class = $row["cname"];
		$class_score = $row["class_score"];
		$term = $row["term_name"];
		$ac_yr = $row["ac_yr"];
		$s_name = $row["s_name"];

		// Id Datas
		$term_id = $row["term_id"];
		$c_id = $row["c_id"];
		$sub_id = $row["sub_id"];
		$yr_id = $row["yr_id"];
		$str_id = $row["s_id"];



	}

	$data = array(
		"exam_id" => $exam_id,
		"student" => $student,
		"sub" => $subject,
		"_level" => $_class,
		"ex_score" => $ex_score,
		"term" => $term,
		"yr" => $ac_yr,
		"class_score"=>$class_score,
		"s_name" => $s_name,


		// Data Id
		'tr_id' => $term_id,
		'c_id' => $c_id,
		'sub_id' => $sub_id,
		'yr_id' => $yr_id,
		"str_id" => $str_id
	);

	echo json_encode($data);

$con->close();

?>