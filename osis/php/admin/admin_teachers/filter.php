<?php

require '../../../config.php';

$x = $con->real_escape_string($_GET["x"]);

$output='';
$sql= $con->query("SELECT * FROM teachers WHERE tid LIKE '%$x%' OR first_name LIKE '%$x%' OR middle_name LIKE '%$x%' OR last_name LIKE '%$x%'OR teacher_id LIKE'%$x%' OR date_of_birth  LIKE '%$x%'
                    OR class_assigned LIKE '%$x%' OR sub_assigned LIKE '%$x%' OR gender LIKE '%$x%'  OR email LIKE '%$x%'");


 if ($sql->num_rows > 0){
 	while($row = $sql->fetch_assoc())
 	{
 		$array_sub = explode(",", $row["sub_assigned"]);
 		$array_class = explode(",", $row["class_assigned"]);
 			$new_sub=array();
 		for($i=0; $i<count($array_sub); $i++){
 		 $sub = $array_sub[$i];
 		 $query = $con->query("SELECT sub_name FROM subjects WHERE sub_id ='$sub'");
 		 if($query){while($data=$query->fetch_assoc()){array_push($new_sub, substr($data["sub_name"],0,3));}}
 	 }
 	 $new_class=array();
 	 for($i=0; $i<count($array_class); $i++){
 		 $class = $array_class[$i];
 		 $query = $con->query("SELECT cname FROM class WHERE c_id ='$class'");
 		 if($query){while($data=$query->fetch_assoc()){array_push($new_class, $data["cname"]);}}
 	 }


 		$output .='<tr>
                  <td><input type="checkbox" class="this_teacher_select" data-t_id='.$row["tid"].'></td>
                  <td class="first_name" data-fullname="'.$row['tid'].'">'.$row["last_name"]." ".$row["middle_name"]." ".$row["first_name"].'</td>
 								 <td>'.$row["teacher_id"].'</td>
   						 	<td>'.implode(",",$new_sub).'</td>
 								<td>'.implode(",",$new_class).'</td>
 				         <td class="emp_date" data-emp="'.$row['tid'].'">'.$row["emp_date"].'</td>
             		 <td class="email" data-email="'.$row['tid'].'">'.$row["email"].'</td>
             		 <td class="contact" data-contact="'.$row['tid'].'">'.$row["contact"].'</td>
                   			<td>
                             <button title="Profile" id="btn_view" class="btn btn-info btn-mini" data-prof="'.$row['tid'].'">
               								View
                     				</button>
 														<button title="Edit" id="btn_edit" onclick="edit_data(event);" class="btn btn-warning btn-mini"data-edit="'.$row['tid'].'">
 														Edit
                           	</button>
                           	<button onclick="delete_data(event);" title="Delete" class="btn btn-danger btn-mini" data-del="'.$row['tid'].'">Delete</span></button>';
           $output.=   '</td>
                 		</tr>
              	';
 	     }
     }else{
           $output .= '
                     <tr>
                       <td colspan="5">No Data Available</td>
                     </tr>
                   ';
           }

$data = array("filter" => $output);
echo json_encode($data);
