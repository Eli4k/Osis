<?php 
	$con = new mysqli("localhost", "root", "", "schoolportal");

	$sql = "SELECT * FROM subjects ORDER BY sub_id DESC";
	$output ='';
	$result = $con->query($sql);

	$total = $result->num_rows;

	if ($total > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()){
			$output .= '
						<tr>
                 			<td id='.$row["sub_id"].'><input type="checkbox" /></td>
                 			<td>'.$row["sub_name"].'</td>
                  			<td>
                        	   	<button title="Edit" id="sub_edit" class="btn btn-secondary btn-mini" data-sub_id="'.$row['sub_id'].'">
                        	   		<i class="icon-edit"></i></span></button>
                        		<button title="Delete" id="sub_delete" class="btn btn-secondary btn-mini" data-sub_id2="'.$row['sub_id'].'">
                        			<i class="icon-trash"></i></span></button>
                        	</td>
                		</tr>
             		';						
			}
	}else{
		$output .= '<td><td colspan="5">No Data Available</span></td></td>';
	}	

	$data = array('subject' => $output);
	echo json_encode($data);
?>