<?php
include '../../../config.php';

$output="<tr>";


if (isset($_POST["user"])){
  $user_id = $con->real_escape_string($_POST["user"]);

  // Class
  $output.='<th><select>';
      $quiz_class = $con->query("SELECT DISTINCT q.c_id, c.cname FROM quiz q
                            JOIN class c ON c.c_id = q.c_id
                            WHERE teacher_id = '$user_id'");
      if($quiz_class){
        foreach($quiz_class as $level){$c_id = $level["c_id"]; $cname=$level["cname"]; $output.='<option value="'.$c_id.'">'.$cname.'</option>';}
      }
  $output.='</select></th>';
  // End


  $output.='<th><select>';
  // End

  // Subjects
  $quiz_sub = $con->query("SELECT DISTINCT q.sub_id, s.sub_name FROM quiz q
                          JOIN subjects s ON s.sub_id = q.sub_id
                          WHERE teacher_id = '$user_id'");
   if($quiz_sub){
     foreach($quiz_sub as $sub){$sub_id = $sub["sub_id"]; $sub_name = $sub["sub_name"]; $output.='<option value="'.$sub_id.'">'.$sub_name.'</option>';}
    }
    $output.='</select></th><th><select>';
  // End

  // Term
  $quiz_term = $con->query("SELECT DISTINCT q.term_id, t.term_name FROM quiz q
                        JOIN term t ON t.term_id = q.term_id
                        WHERE teacher_id = '$user_id'");
  if($quiz_term){
    foreach($quiz_term as $term){$term_id = $term["term_id"]; $term_name = $term["term_name"]; $output.='<option value="'.$term_id.'">'.$term_name.'</option>';}
  }
  $output.='</select></th><th><select>';
  //End

  // Year
  $quiz_yr = $con->query("SELECT DISTINCT q.yr_id, y.ac_yr FROM quiz q
                        JOIN academic_year y ON y.yr_id = q.yr_id
                        WHERE teacher_id = '$user_id'");
  if($quiz_yr){
    foreach($quiz_yr as $yr){$yr_id = $yr["yr_id"]; $year = $yr["ac_yr"]; $output.='<option value="'.$yr_id.'">'.$year.'</option>';}
  }
  $output.='</select></th>';
}
  $output.='<th><button class="btn btn-info btn" id="search_btn" onclick="search_quiz(event);">Search</button></th></tr>';
  //End



  $data = array("output" => $output);
  echo json_encode($data);
  $con->close();
?>
