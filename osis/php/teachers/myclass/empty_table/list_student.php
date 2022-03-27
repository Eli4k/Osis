<?php

  if(isset($_POST)){
    require_once '../../../../config.php';

    $output ='<div class="widget-box">
                <div class="widget-title">';
    $level = $con->real_escape_string($_POST["level"]);
    $stream = $con->real_escape_string($_POST["stream"]);
    $test = $con->real_escape_string($_POST["test"]);

    $query = $con->query("SELECT DISTINCT s.s_id, s.c_id, st.s_name, c.cname FROM students s
                          JOIN stream st ON st.s_id = s.s_id
                          JOIN class  c  ON c.c_id = s.c_id
                        WHERE c.c_id = '$level' AND s.s_id='$stream'");


    if($query){
        if(!empty($query)){

          while($row = $query->fetch_assoc()){
            $output.='<h5>'.$row["cname"].'</h5>
                      <h5>'.$row["s_name"].'</h5>
                    </div>';

            $output.='<div class="widget-content nopadding">
                  <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                            <th width="2%"><input type="checkbox" onclick="select_all(event);">All</th>
                            <th width="4%">No</th>
                            <th width="54%">FULL NAME</th>
                            <th width="10%">CLASS SCORE [50%]</th>
                            <th width="10%">EXAM SCORE[100%]</th>
                            <th width="10%">EXAM SCORE[50%]</th>
                            <th width="10%">OVERALL [A+B]</th>
                      </tr></thead><tbody>';

              $second_query = $con->query("SELECT * FROM students WHERE c_id = '$level' AND s_id = '$stream' ORDER BY last_name ASC");
              if($second_query){
                $i=1;
                foreach($second_query as $students){
                  $output.=
                  '<tr>
                       <td><input type="checkbox" class="inc_thisBox" id="'.$students["student_id"].'"></td>
                       <td>'.$i.'</td>
                       <td>'.strtoupper($students["last_name"].' '.$students["middle_name"].' '.$students["first_name"]).'</td>
                       <td><input type="number"  class="class_score span11" style="width:100px" onkeyup="getClassScore(event);"></td>
                       <td><input type="number"  class="exam_score span11" style="width:100px" onkeyup="getExam50(event);"></td>
                       <td><input type="number"  class="exam_score_50 span11" style="width:100px" disabled></td>
                       <td><input type="number"  class="overall span11" style="width:100px" disabled></td>
                  </tr>';
                        $i++;
                }
              }
              $output.='</tbody>
              <tfoot><tr><td  colspan="8"><button class="btn btn-info btn" onclick="publish_all(event);">Add</button>
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
