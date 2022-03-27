<?php

$x = $_GET["x"];

$con = new mysqli("localhost","root","","schoolportal");

$output='';
$sql= "SELECT sid, student_id, first_name, last_name, password, cname, contact, admission_date, s_name, email, state
                  FROM class c INNER JOIN students s
                  ON s.c_id = c.c_id
                  JOIN stream st
                   ON s.s_id = st.s_id
                   WHERE
                    s.sid LIKE '%$x%' OR s.student_id LIKE '%$x%' OR s.first_name LIKE '%$x%'OR
                    s.last_name LIKE '%$x%' OR s.password LIKE '%$x%' OR  c.cname LIKE '%$x%' OR s.contact LIKE '%$x%' OR
                    s.admission_date LIKE '%$x%' OR st.s_name LIKE '%$x%' OR
                    s.email LIKE '%$x%' ORDER BY s.sid DESC";

 $result = $con->query($sql);

if (!empty($result)) {
	while($row = $result->fetch_assoc())
	{
		$output .='
                <tr class="gradeX">
                 			<td id='.$row["sid"].'><input type="checkbox" /></td>
                 			<td>'.$row["student_id"].'</td>
                 			<td>'.$row["password"].'</td>
                  		<td class="first_name" data-name="'.$row['sid'].'">'.$row["first_name"]." ".$row["last_name"].'</td>
                  		<td class="stream" data-str="'.$row['sid'].'">'.$row["s_name"].'</td>
                 			<td class="admission_date" data-adm="'.$row['sid'].'">'.$row["admission_date"].'</td>
                  		<td class="email" data-email="'.$row['sid'].'">'.$row["email"].'</td>
                  		<td class="contact" data-contact="'.$row['sid'].'">'.$row["contact"].'</td>
                      <td class="state" data-state="'.$row['sid'].'">'.$row["state"].'</td>
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
	   }
}else{
	$output .='

					<tr class="gradeX">
						<td colspan="10">Data Not Found</span></td>
				  </tr>
				';
}

		$data = array('filter' => $output);
		echo json_encode($data);

		$con->close();

 ?>
