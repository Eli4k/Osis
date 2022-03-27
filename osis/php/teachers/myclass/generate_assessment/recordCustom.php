<?php
require '../../../../config.php';

if(isset($_POST)){

  $sub = $con->real_escape_string($_POST["sub"]);
  $yr = $con->real_escape_string($_POST["yr"]);
  $term = $con->real_escape_string($_POST["term"]);
  $c_id = $con->real_escape_string($_POST["c_id"]);
  $stream = $con->real_escape_string($_POST["stream"]);
  $tid = $con->real_escape_string($_POST["tid"]);
  $teacher_id = $con->real_escape_string($_POST["user_id"]);

  $final_data = array();
  $sample_array = array();
  $error = array();


  // Check for existing data in assessment field and class_score fields
  $check = $con->query("SELECT * FROM assessment WHERE teacher_id = '$teacher_id' AND s_id = '$stream' AND term_id = '$term' AND yr_id= '$yr' AND sub_id = '$sub' AND c_id = '$c_id'");
  if($check){
    $check_counter = $check->num_rows;
    if($check_counter > 0){
        $con->query("DELETE FROM assessment WHERE teacher_id = '$teacher_id' AND s_id = '$stream' AND term_id = '$term' AND yr_id= '$yr' AND sub_id = '$sub' AND c_id = '$c_id'");
    }
  }else{$error["error"] = "Check existing error: ".$con->error;}


  $update = $con->query("UPDATE class_score SET used = 1 WHERE term_id = '$term' AND sub_id = '$sub' AND c_id = '$c_id' AND s_id = '$stream' AND tid = '$tid' AND yr_id = '$yr'");
  if($update){
    $error["error"] = "Success: New Assessment Recorded";

    // Generate Denominator from all percent_scores using scaled scores from test
    $cs_query = $con->query("SELECT distinct ex_id, test_id, percent_score FROM class_score WHERE term_id = '$term' AND sub_id = '$sub' AND c_id = '$c_id' AND s_id = '$stream' AND tid = '$tid' AND test_id != '5' AND yr_id = '$yr'");
      $total = 0;
    if($cs_query){
      foreach($cs_query as $query){
        $ex = $query["ex_id"];
        $test_id = $query["test_id"];
        $total += $query["percent_score"];

        // Get total class_score
          $error["total"] = "Class Total: ".$total;
      }

        // Get class_score && student_id

          $curr_score_query = $con->query("SELECT sid, sum(scaled_score) as class_50 FROM class_score WHERE  term_id = '$term' AND sub_id = '$sub' AND c_id = '$c_id' AND s_id = '$stream' AND  tid = '$tid' AND test_id != '5' AND yr_id = '$yr'
                  GROUP BY sid");

           if($curr_score_query){$counter = 0;
                foreach($curr_score_query as $new_class_score){
                  $sid = $new_class_score["sid"];
                  $new_score = $new_class_score["class_50"];
                  $class_50  = ($new_score/$total) * 50;

                  // Get Exam Score
                  $get_exam = $con->query("SELECT DISTINCT score ,scaled_score FROM class_score WHERE term_id = '$term' AND sub_id = '$sub' AND c_id = '$c_id' AND s_id = '$stream' AND  tid = '$tid' AND test_id = '5' AND yr_id = '$yr' AND sid='$sid'");

                  if($get_exam){
                      foreach($get_exam as $exam)
                        $exam_score = $exam["score"];
                        $ex_50 = $exam["scaled_score"];


                      array_push($final_data,
                        array("sid" => $sid,  "new_cs" => $class_50, "exam_score" => $exam_score, "ex_50" => $ex_50,
                          "total" => $class_50+$ex_50)
                      );
                  }else{$error["error"] = "Exam Data Error: ".$con->close();}
                  // End
              $counter++;}
          }else{ $error["error"] = "Class Score Error: ".$con->close();} //End
      }


      // Record new assessments
      foreach($final_data as $new_data){
        $new_id = $new_data["sid"];
        $new_cs = $new_data["new_cs"];
        $new_ex_score = $new_data["exam_score"];
        $new_ex_50 = $new_data["ex_50"];
        $new_total = $new_data["total"];

        $get_full_id = $con->query("SELECT DISTINCT s.student_id, t.teacher_id FROM class_score cs
          JOIN teachers t ON t.tid = cs.tid
          JOIN students s ON s.sid = cs.sid
          WHERE cs.sid = '$new_id' AND cs.tid = '$tid'");

        if($get_full_id){
          foreach($get_full_id as $row){
            $student_id = $row["student_id"];
            $teacher_id = $row["teacher_id"];

            $insert = $con->query("INSERT INTO assessment(student_id, teacher_id, yr_id, term_id, c_id, s_id, sub_id, class_score,ex_100,ex_50, ovscr, published)
              VALUES ('$student_id', '$teacher_id', '$yr', '$term', '$c_id', '$stream', '$sub', '$new_cs', '$new_ex_score', '$new_ex_50', '$new_total', '0')");
            $insert_counter = 0;
            if($insert){
              $error["insert_success"] = $insert_counter++." entries recorded successfully";
            }else{
              $error["error"] = "Record Error: ".$con->error;
            }
          }
        }else{
          $error["error"] = "Error: ".$con->error;
        }
      }

  } else{$error["error"] = "Update Class Score Error: ".$con->error;}

$data = array("error" => $error,
              "final" => $final_data
             );

  echo json_encode($data);


  $con->close();
}

?>
