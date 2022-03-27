<?php
	$con = new mysqli("localhost", "root", "", "schoolportal");

	$sql = "SELECT * FROM academic_year ORDER BY yr_id DESC";
	$output ='';
	$result = $con->query($sql);

	$total = $result->num_rows;

	if ($total > 0) {
		$i = 1;
		while($row = $result->fetch_assoc()){
			$output .= '
						<tr>
                 			<td id='.$row["yr_id"].'><input type="checkbox" /></td>
                 			<td>'.$row["ac_yr"].'</td>
                  			<td>
												<button title="Set as current Academic Year" id="yr_activate" class="btn btn-success btn-mini yr_act" data-yr="'.$row['yr_id'].'">
													<i class="icon-ok"></i></span></button>
                        	   	<button title="Edit" id="yr_edit" class="btn btn-secondary btn-mini" data-yr="'.$row['yr_id'].'">
                        	   		<i class="icon-edit"></i></span></button>
                        		<button title="Delete" id="yr_delete" class="btn btn-secondary btn-mini" data-yr2="'.$row['yr_id'].'">
                        			<i class="icon-trash"></i></span></button>
                        	</td>
                		</tr>
             		';
			}
	}else{
		$output .= '<td><td colspan="5">No Data Available</span></td></td>';
	}

	$data = array('year' => $output);
	echo json_encode($data);
?>
