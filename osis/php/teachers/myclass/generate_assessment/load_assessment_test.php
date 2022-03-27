<?php

  if(isset($_POST)){
    require_once '../../../../config.php';

    $output ='<div class="widget-box">
                <div class="widget-title">';
    $c_id = $con->real_escape_string($_POST["c_id"]);
    $s_id = $con->real_escape_string($_POST["s_id"]);
    $test_id = $con->real_escape_string($_POST["test_id"]);
    $tid = $con->real_escape_string($_POST["tid"]);
    $yr_id = $con->real_escape_string($_POST["yr_id"]);
    $term_id = $con->real_escape_string($_POST["term_id"]);
    $ex = $con->real_escape_string($_POST["ex"]);



    $query_test = $con->query("SELECT DISTINCT  test.t_name, cs.overall, cs.percent_score FROM class_score cs
          JOIN test test ON test.test_id = cs.test_id
          WHERE cs.test_id = '$test_id'  AND c_id = '$c_id'  AND yr_id='$yr_id' AND ex_id = '$ex' AND s_id = '$s_id' AND tid = '$tid' AND term_id = '$term_id'");
    if($query_test){
      if(!empty($query_test)){
        foreach($query_test as $ex_data){
          $overall = $ex_data["overall"];
          $scaled = $ex_data["percent_score"];
          $t_name= $ex_data["t_name"];

          $query = $con->query("SELECT DISTINCT s.s_id, s.c_id, st.s_name, c.cname FROM students s
                                JOIN stream st ON st.s_id = s.s_id
                                JOIN class  c  ON c.c_id = s.c_id
                              WHERE c.c_id = '$c_id' AND s.s_id='$s_id'");


          if($query){
              if(!empty($query)){
                while($row = $query->fetch_assoc()){
                  $output.='<h5>'.$row["cname"].'</h5>
                            <h5>'.$row["s_name"].'</h5>
                            <h5 data-ex_num="'.$ex.'">'.$t_name.' - '.$ex.'<span></h5>
                            <input type="number"  id="score" value="'.$overall.'" style="margin: 4px; float:right; width: 100px" placeholder="Total Score">
                            <select id="scaler"   style="margin: 4px; float: right; width:100px">';
                            $output.='<option value="0">Scale to</option>';
                            for($x = 1; $x<=20; $x++)
                                        {
                                                      	$result = $x*5;
                                                        $output.="<option value='$result'";
                                                        if($result == $scaled){
                                                          $output.="selected = selected";
                                                        }
                                                        $output.='>'.$result.'%</option>';
                                        }
                            $output.='</select>';

                          $output.='</div>';

                  $output.='<div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                  <th width="2%">No</th>
                                  <th width="78%">FULL NAME</th>
                                  <th width="10%">Score</th>
                                  <th width="10%">Scale[%]</th>
                            </tr></thead><tbody>';

                    $second_query = $con->query("SELECT DISTINCT class_score_id, cs.sid, s.student_id, s.first_name, s.last_name, s.middle_name, score, scaled_score, overall, percent_score  FROM class_score cs
                                  JOIN students s ON s.sid = cs.sid
                                  WHERE cs.c_id = '$c_id' AND cs.s_id = '$s_id' AND tid ='$tid' AND cs.yr_id = '$yr_id' AND cs.term_id = '$term_id' AND ex_id = '$ex' AND cs.test_id  = '$test_id' ORDER BY last_name ASC");
                    if($second_query){
                      $i=1;
                      foreach($second_query as $students){
                        $cs_id = $students["class_score_id"];
                        $sid = $students["sid"];
                        $student_id = $students["student_id"];
                        $name = $students["last_name"].' '.$students["middle_name"].' '.$students["first_name"];
                        $score = $students["score"];
                        $scaled_score = $students["scaled_score"];
                        $output.=
                        '<tr>
                             <td data-class_score="'.$cs_id.'">'.$i.'</td>
                             <td>'.strtoupper($name).'</td>
                             <td><input type="number"  class="score span11" onkeyup="calculate_scalar_mark(event);" data-sid="'.$sid.'" value="'.$score.'"></td>
                             <td><input type="number"  class="score_scale span11" value="'.$scaled_score.'" disabled=disabled"></td>
                        </tr>';
                              $i++;
                      }
                    }
                    $output.='</tbody>
                    <tfoot><tr><td  colspan="4"><button class="btn btn-success btn" onclick="update_class_score(event);" data-term="'.$term_id.'" data-yr="'.$yr_id.'" data-c_id="'.$c_id.'" data-ex="'.$ex.'" data-stream="'.$s_id.'" data-test_id="'.$test_id.'">Update</button></td>
                                   </tr></tfoot>
                    </table>';
                }
              }else{
                $output.="Something went wrong: ".$con->error;
              }
          }else{
            $output.="Something went wrong: ".$con->error;
          }
        }
      }

    }else{
      $output.='Error: '.$con->error;
    }


    $output.='</div></div>';
  }
  $data = array('output' => $output);
    echo json_encode($data);

    $con->close();

?>
