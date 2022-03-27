<?php
require '../../../config.php';

if(isset($_POST)){
  $teacher_id = $con->real_escape_string($_POST["tid"]);
  $err_msg = array();
  $output = "";

  // Check for data on specification
  $check = $con->query("SELECT DISTINCT s.sub_name, asmt.sub_id, y.ac_yr, asmt.yr_id, c.cname, asmt.c_id, st.s_name,  asmt.s_id, tt.term_name, asmt.term_id FROM assessment asmt
          JOIN subjects s ON s.sub_id = asmt.sub_id
          JOIN academic_year y ON y.yr_id = asmt.yr_id
          JOIN class c ON c.c_id = asmt.c_id
          JOIN term tt ON tt.term_id = asmt.term_id
          JOIN stream st ON st.s_id = asmt.s_id
          WHERE teacher_id = '$teacher_id' ORDER BY asmt.sub_id, asmt.c_id, asmt.term_id, asmt.yr_id, asmt.s_id DESC");
  // End

  if($check){
    $num_found = $check->num_rows;
    if($num_found > 0){
      $err_msg["error"] = $num_found." result(s) found";

      while($row = $check->fetch_assoc()){
        $sub = $row["sub_id"];
        $yr_id = $row["yr_id"];
        $c_id = $row["c_id"];
        $s_id = $row["s_id"];
        $term_id = $row["term_id"];
        $subject = $row["sub_name"];
        $year = $row["ac_yr"];
        $cname = $row["cname"];
        $stream = $row["s_name"];
        $term_name = $row["term_name"];

        $output.='
              <div class="row-fluid">
                <div class="span7">
                  <div class="widget-box">
                    <div class="widget-title">
                      <h5>'.$subject.'</h5>
                      <h5>'.$term_name.'</h5>
                      <h5>'.$cname.'-'.$stream.'</h5>
                      <h5>'.$year.'</h5>
                    </div>
                    <table class="table dataTables table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>CS[50%]</th>
                          <th>EX[100%]</th>
                          <th>ES[50%]</th>
                          <th>Total</th>
                          <th>Grade</th>
                          <th>Rank</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>
                      <tbody>';
                      // Student id

            $query = $con->query("SELECT CONCAT(s.last_name, ' ', s.middle_name, ' ', s.first_name) as fullname, class_score,ex_100,ex_50,ovscr, DENSE_RANK() OVER(PARTITION BY sub_id ORDER BY ovscr DESC) Rank
              FROM assessment a
              JOIN students s ON s.student_id = a.student_id
              WHERE term_id = '$term_id' AND yr_id = '$yr_id' AND sub_id = '$sub' AND a.s_id = '$s_id' AND  a.c_id = '$c_id' ORDER BY a.student_id, Rank");
            $i=1;
            if($query){
              foreach($query as $row){
                $fullname = $row["fullname"];
                $class_score = $row["class_score"];
                $ex_100 = $row["ex_100"];
                $ex_50 = $row["ex_50"];
                $overall = $row["ovscr"];
                $rank = $row["Rank"];
                $grade = "";
                $remarks = "";

                if($overall >=95){$remarks.= "Distinction";$grade.="A+";}
                elseif($overall >=90 && $overall<=94){$remarks.="Excellent"; $grade.="A";}
                elseif($overall >=85 && $overall<=89){$remarks.="Excellent"; $grade.="B+";}
                elseif($overall >=80 && $overall<=84){$remarks.="Very Good"; $grade.="B-";}
                elseif($overall >=75 && $overall<=79){$remarks.="Very Good"; $grade.="B";}
                elseif($overall >=70 && $overall<=74){$remarks.="Good"; $grade.="C+";}
                elseif($overall >=65 && $overall<=69){$remarks.="Credit"; $grade.="C-";}
                elseif($overall >=60 && $overall<=64){$remarks.="Credit"; $grade.="C";}
                elseif($overall >=55 && $overall<=59){$remarks.="Credit"; $grade.="D-";}
                elseif($overall >=50 && $overall<=54){$remarks.="Credit"; $grade.="D";}
                elseif($overall <=49){$remarks.="Fail"; $grade.="F";}

                $output.='<tr><td>'.$i++.'</td><td>'.$fullname.'</td><td>'.$class_score.'</td><td>'.$ex_100.'</td><td>'.$ex_50.'</td><td>'.$overall.'</td><td>'.$grade.'</td><td>'.$rank.'</td><td>'.$remarks.'</td><tr>';
              }
            }else{$err_msg["error"] = "Student Data Error: ".$con->error;}
            $output.='</tbody>
                    </table>
                  </div>
                </div>
              </div>';

          }


      }
    }else{$err_msg["error"] = "Error: ".$con->error;}
}else{$err_msg["error"] = "Error: ".$con->error;}



$data = array("output" => $output,
              "error"  => $err_msg);

echo json_encode($data);


$con->close();
?>
