<?php 

$con = new mysqli("localhost","root","","schoolportal");
$output='';
$sql=$con->query("SELECT sid, student_id, first_name, last_name, password, cname, contact, admission_date, s_name, email
                  FROM class c INNER JOIN students s
                  ON s.c_id = c.c_id 
                  JOIN stream st
                   ON s.s_id = st.s_id  ORDER BY s.sid DESC"
                );
     
if ($sql->num_rows > 0) {
	$i=1;
	while($row = $sql->fetch_assoc())
	{
		$output .='
                		<tr>
                 			<td><input type="checkbox" class="this_student" data-st_id='.$row["sid"].'"/></td>
                 			<td>'.$row["student_id"].'</td>
                 			<td>'.$row["password"].'</td>
                  			<td class="first_name" data-name="'.$row['sid'].'">'.$row["first_name"]." ".$row["last_name"].'</td>
                  			<td class="graduation_date" data-str="'.$row['sid'].'">'.$row["s_name"].'</td>
                 			<td class="admission_date" data-adm="'.$row['sid'].'">'.$row["admission_date"].'</td>
                  			<td class="graduation_date" data-grad="'.$row['sid'].'">'.$row["email"].'</td>
                  			<td class="graduation_date" data-grad="'.$row['sid'].'">'.$row["contact"].'</td>
                  			<td>
                  				<button id="btn_view" title="View Profile"  class="btn btn-secondary btn-mini" data-id1="'.$row['sid'].'">
                  					<i class="icon-user"></i></span></button> 
                        	   	<button title="Edit" id="btn_edit" class="btn btn-secondary btn-mini" data-id2="'.$row['sid'].'">
                        	   		<i class="icon-edit"></i></span></button>
                        		<button title="Delete" id="btn_delete" class="btn btn-secondary btn-mini" data-id3="'.$row['sid'].'">
                        			<i class="icon-trash"></i></span></button>
                        	</td>
                		</tr>
             		';
				  $i++;
		
	}
}else{
	$output .='
				
					<tr>
						<td colspan="10">Awaiting Inputs</span></td>
					</tr>
				';
}
	
		$data = array('result' => $output);	
		echo json_encode($data);
		
		$con->close();

 ?>