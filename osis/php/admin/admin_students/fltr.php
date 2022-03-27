<?php

require '../../../config.php';

if(isset($_GET)){
  $level = $con->real_escape_string($_GET["level"]);
  $stream = $con->real_escape_string($_GET["stream"]);
  $total = 0;

  $sql = "";

  if($level > 0 && $stream < 1){
    $sql = $con->query("SELECT sid, student_id, c.c_id, st.s_id, first_name, last_name, password, cname, contact, admission_date, s_name, email, state
                    FROM class c INNER JOIN students s
                    ON s.c_id = c.c_id
                    JOIN stream st
                     ON s.s_id = st.s_id
                    WHERE s.c_id = '$level' AND s.state = 'continuing' ORDER BY s.c_id");
  }
  elseif($level < 1 && $stream > 0){
    $sql = $con->query("SELECT sid, student_id, c.c_id, first_name, last_name, password, cname, contact, admission_date, s_name, email, state
                    FROM class c INNER JOIN students s
                    ON s.c_id = c.c_id
                    JOIN stream st
                     ON s.s_id = st.s_id
                    WHERE st.s_id = '$stream' AND s.state = 'continuing' ORDER BY s.c_id");
  }
  else{
    $sql = $con->query("SELECT sid, student_id, c.c_id, first_name, last_name, password, cname, contact, admission_date, s_name, email, state
                  FROM class c INNER JOIN students s
                  ON s.c_id = c.c_id
                  JOIN stream st
                   ON s.s_id = st.s_id
                  WHERE st.s_id = '$stream' AND s.state = 'continuing' AND s.c_id = '$level' ORDER BY last_name");
            }

$output="";

if($sql){
  $total = $sql->num_rows;
  if($total > 0){
    while($row = $sql->fetch_assoc())
    {
        $output.= ' <tr class="gradeX">
                       <td><input type="checkbox" class="this_student" data-st_id="'.$row["sid"].'" /></td>
                       <td>'.$row["student_id"].'</td>
                       <td class="first_name" data-name="'.$row['sid'].'">'.$row["first_name"]." ".$row["last_name"].'</td>
                       <td class="stream" data-str="'.$row['sid'].'">'.$row["s_name"].'</td>
                       <td data-cls="'.$row["c_id"].'">'.$row["cname"].'</td>
                       <td class="admission_date" data-adm="'.$row['sid'].'">'.$row["admission_date"].'</td>
                       <td class="email" data-email="'.$row['sid'].'">'.$row["email"].'</td>
                       <td class="contact" data-contact="'.$row['sid'].'">'.$row["contact"].'</td>
                       <td class="state" data-state="'.$row['sid'].'">'.$row["state"].'</td>
                       <td>
                               <button title="Edit" onclick="edit_data(event);"class="btn btn-secondary btn-mini" data-edit="'.$row['sid'].'">Edit</button>
                             <button title="Delete" onclick="delete_data(event);" class="btn btn-secondary btn-mini" data-del="'.$row['sid'].'">Delete</button>
                         </td>
                 </tr>
                 ';
    }
  }else{$output.="<tr><td colspan=9>No results found</td></tr>";}
  }

}else{
  $output.="Error: ".$con->error;
}

    $data = array("fltr" => $output,
                  "total" => $total);

   echo json_encode($data);

?>
