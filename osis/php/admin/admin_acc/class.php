<?php 
	$con = new mysqli("localhost", "root", "", "schoolportal");

	$sql = "SELECT * FROM class ORDER BY c_id DESC";
	$output ='';
	$result = $con->query($sql);

	$total = $result->num_rows;

	if ($total > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()){
			$output .= '
						<tr>
                 			<td id='.$row["c_id"].'><input type="checkbox" /></td>
                 			<td>'.$row["cname"].'</td>
                  			<td>
                        	   	<button title="Edit" id="class_edit" class="btn btn-secondary btn-mini" data-c_id="'.$row['c_id'].'">
                        	   		<i class="icon-edit"></i></span></button>
                        		<button title="Delete" id="class_delete" class="btn btn-secondary btn-mini" data-c_id2="'.$row['c_id'].'">
                        			<i class="icon-trash"></i></span></button>
                        	</td>
                		</tr>
             		';						
			}
	}else{
		$output .= '<td><td colspan="5">No Data Available</span></td></td>';
	}	

	$data = array('class' => $output);
	echo json_encode($data);
?>