<?php 
	
	$con = new mysqli("localhost","root","","schoolportal");

	$output = '';

	$tid = $_GET['user_id'];
	$x = strtoupper($_GET['x']);

	$sql = 	"SELECT gradeId, student_id,test, subject, class, score, term
			FROM results
			WHERE gradeId LIKE '$x' OR student_id LIKE '%$x%' OR test LIKE '%$x%' OR class LIKE '%$x%' OR score LIKE '%$x%' OR term LIKE '%$x%' OR subject LIKE '%$x%' OR ac_yr LIKE '%$x%' AND teacher_id = '$tid' ORDER BY score DESC";

	$result = $con->query($sql);

	if (!empty($result)) {
		while($row = $result->fetch_assoc()){
			$output .= '<tr class="gradeX">
                  <td>'.$row["student_id"].'</td>
                  <td>'.$row["test"].'</td>
                  <td>'.$row["subject"].'</td>
                  <td>'.$row["class"].'</td>
                  <td>'.$row["score"].'</td>
                  <td>
                  		<button title="edit" class="btn btn-info btn-mini" id="btn_edit" data-gid1="'.$row['gradeId'].'"><span class="icon-edit"></span></button>
                  </td>
                </tr>';
			} 	
	}else{
		$output .=  '<tr class="gradeX">
                  <td colspan = "5">No Results Found</td>
                </tr>';
	}

	$search = array('result' => $output);

	echo json_encode($search);

	$con->close();

?>