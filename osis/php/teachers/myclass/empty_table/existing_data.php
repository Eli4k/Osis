<?php

  if(isset($_POST)){
    require_once '../../../../config.php';

    $output ='<div class="widget-box">
                <div class="widget-title">';
    $level = $con->real_escape_string($_POST["level"]);
    $stream = $con->real_escape_string($_POST["stream"]);
    $teacher = $con->real_escape_string($_POST["teacher"]);
    $term = $con->real_escape_string($_POST["term"]);
    $yr = $con->real_escape_string($_POST["yr"]);
    $stream = $con->real_escape_string($_POST["stream"]);
    $subject =  $con->real_escape_string($_POST["subject"]);


    $query = $con->query("SELECT DISTINCT  st.s_name, c.cname, sub.sub_name, y.ac_yr, t.term_name  FROM assessment a
                          JOIN stream st ON st.s_id = a.s_id
                          JOIN class  c  ON c.c_id = a.c_id
                          JOIN subjects sub ON sub.sub_id = a.sub_id
                          JOIN academic_year y ON y.yr_id = a.yr_id
                          JOin term t ON t.term_id = a.term_id
                        WHERE c.c_id = '$level' AND st.s_id='$stream' AND teacher_id = '$teacher' AND y.yr_id = '$yr'
                        AND  sub.sub_id = '$subject' AND t.term_id = '$term'");


    if($query){
        if(!empty($query)){

          while($row = $query->fetch_assoc()){
            $output.='<h5>'.$row["cname"].'</h5>
                      <h5>'.$row["s_name"].'</h5>
                      <h5>'.$row["sub_name"].'</h5>
                      <h5>'.$row["term_name"].'</h5>
                      <h5>'.$row["ac_yr"].'</h5>
                    </div>';

            $output.='<div class="widget-content nopadding">
                  <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                            <th width="2%"><input type="checkbox" onclick="select_all(event);"><h5>ALL</h5></th>
                            <th width="4%"><h5>No</h5></th>
                            <th width="30%"><h5>FULL NAME</h5></th>
                            <th width="10%"><h5>CLASS SCORE [50%]</h5></th>
                            <th width="10%"><h5>EXAM SCORE[100%]</h5></th>
                            <th width="10%"><h5>EXAM SCORE[50%]</h5></th>
                            <th width="10%"><h5>OVERALL [A+B]</h5></th>
                            <th width="20%"><h5>ACTION</h5></th>
                          </tr>
                        </thead><tbody>';

              $second_query = $con->query("SELECT a.student_id, s.last_name, s.middle_name, s.first_name, assessment_id, class_score, ex_100, ex_50, ovscr FROM assessment a
                  JOIN students s ON s.student_id = a.student_id
                WHERE a.c_id = '$level' AND a.s_id = '$stream' AND a.term_id = '$term' AND a.s_id = '$stream' AND a.yr_id = '$yr'
                AND a.sub_id = '$subject' AND teacher_id = '$teacher' ORDER BY last_name ASC");
              if($second_query){
                $i=1;
                foreach($second_query as $students){
                  $output.=
                  '<tr>
                       <td><input type="checkbox" class="inc_thisBox" id="'.$students["student_id"].'" data-assessment = "'.$students["assessment_id"].'""></td>
                       <td>'.$i.'</td>
                       <td>'.strtoupper($students["last_name"].' '.$students["middle_name"].' '.$students["first_name"]).'</td>
                       <td><input type="number" value="'.$students["class_score"].'" class="class_score span11" style="width:100px" onkeyup="getClassScore(event);" onChange="getClassScore(event);" disabled></td>
                       <td><input type="number" value="'.$students["ex_100"].'"class="exam_score span11" style="width:100px" onkeyup="getExam50(event);" onChange="getExam50(event);" disabled></td>
                       <td><input type="number" value="'.$students["ex_50"].'" class="exam_score_50 span11" style="width:100px" disabled></td>
                       <td><input type="number" value="'.$students["ovscr"].'" class="overall span11" style="width:100px" disabled></td>
            <td>
                <button class="edit_btn btn btn-secondary btn span11" onclick="edit(event);" data-edit="'.$students["assessment_id"].'">Edit</button>
                <button class="save_btn btn btn-success btn span5" onclick="save(event);" data-save="'.$students["assessment_id"].'">Save</button>
                <button class="cancel_btn btn-danger btn span5" onclick="cancel(event);" data-cancel="'.$students["assessment_id"].'">Cancel</button>
             </td>
          </tr>';
                        $i++;
                }
              }else{
                $output.='<tr><td colspan="6">Error: '.$con->error.'</td></tr>';
              }
              $output.='</tbody>
              <tfoot><tr><td  colspan="8"><button class="btn btn-info btn" onclick="save_all(event);">Save</button>
                             </tr></tfoot>
              </table>';
          }
        }else{
          $output.="Something went wrong: ".$con->error;
        }
    }else{
      $output.="Something went wrong: ".$con->error;
    }
    $output.='</div></div>';
  }
  $data = array('output' => $output);
    echo json_encode($data);

    $con->close();

?>
