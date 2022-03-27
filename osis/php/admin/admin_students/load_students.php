<?php

require '../../../config.php';


	$sql = "SELECT sid, student_id, c.c_id, first_name, last_name, password, cname, contact, admission_date, s_name, email, state
                  FROM class c INNER JOIN students s
                  ON s.c_id = c.c_id
                  JOIN stream st
                   ON s.s_id = st.s_id WHERE state = 'continuing' ORDER BY s.sid";

	$output="";

if($query = $con->query($sql)){
	while($row = $query->fetch_assoc())
	{
			$output.= ' <tr class="gradeX">
										 <td><input type="checkbox" class="this_student" value="'.$row["sid"].'" /></td>
										 <td>'.$row["student_id"].'</td>
										 <td class="first_name" data-name="'.$row['sid'].'">'.$row["first_name"]." ".$row["last_name"].'</td>
										 <td class="stream" data-str="'.$row['sid'].'">'.$row["s_name"].'</td>
										 <td data-cls="'.$row["c_id"].'">'.$row["cname"].'</td>
										 <td class="admission_date" data-adm="'.$row['sid'].'">'.$row["admission_date"].'</td>
										 <td class="email" data-email="'.$row['sid'].'">'.$row["email"].'</td>
										 <td class="contact" data-contact="'.$row['sid'].'">'.$row["contact"].'</td>
										 <td class="contact" data-state="'.$row['sid'].'">'.$row["state"].'</td>
										 <td>
														 <button title="Edit" onclick="edit_data(event);"class="btn btn-secondary btn-mini" data-edit="'.$row['sid'].'">
														Edit</button>
													 <button title="Delete" onclick="delete_data(event);" class="btn btn-secondary btn-mini" data-del="'.$row['sid'].'">
														 Delete</button>
											 </td>
							 </tr>
							 ';
	}
}else{
	$output.="Error: ".$con->error;
}

    $data = array(
    			 "students" => $output
				 );

   echo json_encode($data);

?>
