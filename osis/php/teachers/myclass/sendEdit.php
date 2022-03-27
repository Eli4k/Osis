<?php 

$con = new mysqli("localhost", "root","","schoolportal");

$sql = $con->query("SELECT gradeId, r.student_id, t_name, term_name, st.s_name,sub_name, cname, score, ac_yr,ovscr, pmark,
				  		   r.term_id, r.test_id, r.sub_id, r.c_id, r.yr_id, st.s_id FROM results r
		             JOIN students s ON r.student_id = s.student_id
		             JOIN test tt ON r.test_id = tt.test_id
		             JOIN class c ON r.c_id = c.c_id
		             JOIN subjects sub ON r.sub_id = sub.sub_id
		             JOIN academic_year ac ON r.yr_id = ac.yr_id
		             JOIN term t ON r.term_id = t.term_id
		             JOIN stream st ON r.s_id = st.s_id
             		 WHERE gradeId = '".$_POST['gid']."'");
	

	while($row = $sql->fetch_assoc())
	{
		$grade = $row["gradeId"];
		$student = $row["student_id"];
		$test = $row["t_name"];
		$subject = $row["sub_name"];
		$_class = $row["cname"];
		$score = $row["score"];
		$term = $row["term_name"];
		$ac_yr = $row["ac_yr"];
		$s_name = $row["s_name"];

		// Id Datas
		$test_id = $row["test_id"];
		$term_id = $row["term_id"];
		$c_id = $row["c_id"];
		$sub_id = $row["sub_id"];
		$yr_id = $row["yr_id"];
		$ovscr = $row["ovscr"];
		$pmark = $row["pmark"];
		$str_id = $row["s_id"];



	}

	$data = array(
		"grade_id" => $grade,
		"student" => $student,
		"test" => $test,
		"sub" => $subject,
		"_level" => $_class,
		"score" => $score,
		"term" => $term,
		"yr" => $ac_yr,
		"pmark"=>$pmark,
		"ov" => $ovscr,
		"s_name" => $s_name,


		// Data Id

		'ts_id' => $test_id,
		'tr_id' => $term_id,
		'c_id' => $c_id,
		'sub_id' => $sub_id,
		'yr_id' => $yr_id,
		"str_id" => $str_id
	);

	echo json_encode($data);

$con->close();

?>