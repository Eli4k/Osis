<?php 
	$con = new mysqli("localhost", "root", "", "schoolportal");

	$sql = "SELECT * FROM stream ORDER BY s_id ASC";
	$output ='';
	$result = $con->query($sql);

	$total = $result->num_rows;

	if ($total > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()){
			$output .= '
						<tr>
                 			<td id='.$row["s_id"].'><input type="checkbox" /></td>
                 			<td>'.$row["s_name"].'</td>
                  			<td>
                        	   	<button title="Edit" id="btn_edit" class="btn btn-secondary btn-mini" data-sid="'.$row['s_id'].'">
                        	   		<i class="icon-edit"></i></span></button>
                        		<button title="Delete" id="btn_delete" class="btn btn-secondary btn-mini" data-s_id="'.$row['s_id'].'">
                        			<i class="icon-trash"></i></span></button>
                        	</td>
                		</tr>
             		';						
			}
	}else{
		$output .= '<td><td colspan="5">No Data Available</span></td></td>';
	}	

	$data = array('streams' => $output);
	echo json_encode($data);
?>