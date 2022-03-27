<?php
  require '../../../../config.php';


$output= '<div class="widget-box">';

  if(isset($_POST)){
    $term = $con->real_escape_string($_POST["term"]);
    $level = $con->real_escape_string($_POST["level"]);
    $stream = $con->real_escape_string($_POST["stream"]);
    $yr = $con->real_escape_string($_POST["yr"]);
    $sub = $con->real_escape_string($_POST["sub"]);
    $tid = $con->real_escape_string($_POST["tid"]);
    $ex = $con->real_escape_string($_POST["ex"]);
    $test = $con->real_escape_string($_POST["test"]);


    $test_header = $con->query("SELECT DISTINCT t.term_name, c.cname, sub.sub_name, tt.t_name, yr.ac_yr FROM class_score cs
                      JOIN term t ON t.term_id = cs.term_id
                      JOIN class c ON c.c_id = cs.c_id
                      JOIN subjects sub ON sub.sub_id = cs.sub_id
                      JOIN test tt ON tt.test_id = cs.test_id
                      JOIN academic_year yr ON yr.yr_id = cs.yr_id
                        WHERE tid='$tid' AND t.term_id = '$term' AND sub.sub_id = '$sub' AND cs.test_id = '$test' AND ex_id = '$ex' AND cs.c_id = '$level' AND cs.yr_id='$yr'");

          if($test_header){
          while($row = $test_header->fetch_assoc()){
            $term_name = $row["term_name"];
            $cname = $row["cname"];
            $subject = $row["sub_name"];
            $t_name = $row["t_name"];
            $ac_yr = $row["ac_yr"];

            $output.='<div class="widget-title">
                        <h5>'.$cname.'</h5><h5>'.$subject.'</h5><h5>'.$t_name.': '.$ex.'</h5><h5>'.$term_name.'</h5><h5>'.$ac_yr.'</h5>
                        <button class="btn btn-danger btn"style="float: right; margin:4px" onclick="print(event);"><i class="icon icon-print"></i>Print</button></div>';

            $output.='<table class="table dataTables table-bordered widget-content nopadding">
                        <thead>
                          <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Actual Score</th>
                            <th>Percentage</th>
                            <th>Score Info</th>
                          </tr>
                        </thead>
                        <tbody>';


            $students = $con->query("SELECT s.sid, CONCAT(s.last_name,' ', s.middle_name,' ', s.first_name) AS full_name, score, scaled_score FROM class_score cs
                JOIN students s ON s.sid = cs.sid
                WHERE tid = '$tid' AND cs.term_id = '$term' AND cs.c_id = '$level' AND cs.yr_id = '$yr' AND cs.s_id = '$stream' AND ex_id = '$ex' AND cs.sub_id = '$sub' AND cs.test_id = '$test'
                ORDER BY score DESC");

                if($students){
                  $i=1;
                  foreach($students as $students_data){
                    $name  = $students_data["full_name"];
                    $score = $students_data["score"];
                    $scaled_score = $students_data["scaled_score"];
                    $sid  = $students_data["sid"];

                    $output.='<tr><td>'.$i.'</td><td>'.$name.'</td><td>'.$score.'</td><td>'.$scaled_score.'</td><td><a href="quiz_info.php?sid='.$sid.'&&term='.$term.'&&level='.$level.'&&stream='.$stream.'&&yr='.$yr.'&&sub='.$sub.'&&ex='.$ex.'&&test='.$test.'">View</a></td></tr>';

                    $i++;
                  }
                }else{
                  $output.="Error: ".$con->error;
                }

            $output.="</tbody></table>";
          }

      }else{$output.="Error: ".$con->error;}


  }else{
    $output.="No data has been sent";
  }
  $output.="</div>";

  $data = array("output" => $output);
  echo json_encode($data);

  $con->close();
?>
