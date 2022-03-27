<?php

  if(isset($_POST)){
    require_once '../../../../config.php';

    $output ='<div class="widget-box">
                <div class="widget-title">';
    $level = $con->real_escape_string($_POST["level"]);
    $stream = $con->real_escape_string($_POST["stream"]);
    $test = $con->real_escape_string($_POST["test"]);
    $teacher_id = $con->real_escape_string($_POST["teacher"]);
    $yr = $con->real_escape_string($_POST["yr"]);
    $term = $con->real_escape_string($_POST["term"]);
    $ex_num = 0;



    $query_test = $con->query("SELECT count(DISTINCT ex_id) as ex_id, test.t_name FROM class_score cs
          JOIN test test ON test.test_id = cs.test_id
          WHERE test.test_id = '$test' AND c_id = '$level' AND s_id = '$stream' AND yr_id='$yr' AND term_id = '$term'");
    if($query_test){
      if(!empty($query_test)){
        foreach($query_test as $ex){
          $ex_id = intval($ex["ex_id"]);
          $t_name= $ex["t_name"];
          $ex_num = $ex_id+1;

          $query = $con->query("SELECT DISTINCT s.s_id, s.c_id, st.s_name, c.cname FROM students s
                                JOIN stream st ON st.s_id = s.s_id
                                JOIN class  c  ON c.c_id = s.c_id
                              WHERE c.c_id = '$level' AND s.s_id='$stream'");

          if($query){

              if(!empty($query)){

                while($row = $query->fetch_assoc()){
                  $output.='<h5>'.$row["cname"].'</h5>
                            <h5>'.$row["s_name"].'</h5>
                            <h5 data-ex_num="'.$ex_num.'">'.$t_name.':'.$ex_num.'<span></h5>
                            <input type="number" id="score" style="margin: 4px; float:right; width: 100px" placeholder="Total Score">
                            <select id="scaler" style="margin: 4px; float: right; width:100px">
                            $output.="<option value="0">Scale to</option>';
                            for($x = 1; $x<=20; $x++)
                                        {
                                                      	$result = $x*5;
                                                        $output.="<option value='$result'>$result%</option>";
                                        }
                            $output.='</select>';

                          $output.='</div>';

                  $output.='<div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                  <th width="2%">No</th>
                                  <th width="68%">FULL NAME</th>
                                  <th width="10%">Score</th>
                                  <th width="10%">Scale[%]</th>
                            </tr></thead><tbody>';

                    $second_query = $con->query("SELECT * FROM students WHERE c_id = '$level' AND s_id = '$stream' ORDER BY last_name ASC");
                    if($second_query){
                      $i=1;
                      foreach($second_query as $students){
                        $sid = $students["sid"];
                        $student_id = $students["student_id"];
                        $name = $students["last_name"].' '.$students["middle_name"].' '.$students["first_name"];
                        $output.=
                        '<tr>
                             <td id="'.$sid.'">'.$i.'</td>
                             <td>'.strtoupper($name).'</td>
                             <td><input type="number"  class="score span11" onkeyup="calculate_scalar_mark(event);" data-id="'.$sid.'"></td>
                             <td><input type="number"  class="score_scale span11" disabled=disabled"></td>
                        </tr>';
                              $i++;
                      }
                    }
                    $output.='</tbody>
                    <tfoot><tr><td  colspan="8"><button class="btn btn-info btn" onclick="record_class_score(event);">Record Class Score</button>
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
