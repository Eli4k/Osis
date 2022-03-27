<?php 


$con = new mysqli("localhost","root","","schoolportal");

$output = '';

$user_id = $_POST['user_id'];


$sql = $con->query("SELECT * FROM results WHERE teacher_id = '$user_id' ORDER BY gradeId DESC LIMIT 30 ");


if ($sql->num_rows > 0) {
	$i = 1;
	while($row = $sql->fetch_assoc()){
		
		$output .= ' <tr class="gradeX">
                  <td>'.$row["student_id"].'</td>
                  <td>'.$row["test"].'</td>
                  <td>'.$row["subject"].'</td>
                  <td>'.$row["class"].'</td>
                  <td>'.$row["score"].'</td>
                  <td>
                  		<button title="edit" class="btn btn-info btn-mini" id="btn_edit" data-gid1="'.$row['gradeId'].'"><span class="icon-edit"></span></button>
                  		<button title="delete" class="btn btn-danger btn-mini" id="btn_delete" data-gid2='.$row["gradeId"].'><span class="icon-trash"></span></button>
                  </td>
                </tr>';
               $i++; 
	}
}else{
	 $output .= '<tr class="gradeX">
                  <td colspan = "5">Nothing Posted Today</td>
                </tr>';
}

$data = array(
	'result' => $output	
	);

echo json_encode($data);

?>