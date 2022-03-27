<?php
require_once '../../../config.php';

$output='<div class="span7">
          <div class="widget-box">
            <div class="widget-title">';
if(isset($_POST))
{
  $student_id = $_POST["student_id"];
  $level = $_POST["class"];
  $term = $_POST["term"];
  $year = $_POST["year"];
  $subject = $_POST["subject"];

  $query = $con->query("SELECT DISTINCT q.term_id, q.c_id, t.term_name, c.cname, q.yr_id, y.ac_yr, qa.sid
                                      FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
                      JOIN term t ON q.term_id = t.term_id
                      JOIN class c ON q.c_id = c.c_id
											JOIN academic_year y ON q.yr_id = y.yr_id WHERE qa.sid = '$student_id'
                      AND q.c_id = '$level' AND q.yr_id = '$year' AND q.term_id = '$term'
                      AND q.sub_id = '$subject' ORDER BY q.sub_id DESC
                    ");

  if($query){
        if(!empty($query)){
          while($row=$query->fetch_assoc()){
            $output.='<h5>'.$row["ac_yr"].'</h5>
            <h5>'.$row["cname"].'</h5>
            <h5>'.$row["term_name"].'</h5>';
          $output.='</div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-tables">
              <thead>
                <tr>
                  <th>SUBJECT</th>
                  <th>EXERCISE No</th>
                  <th>ACTION</th>
                </tr>
              </thead>
                <tbody>';

            $sub_query = $con->query("SELECT DISTINCT q.term_id, q.c_id, t.term_name, s.sub_name, c.cname, q.yr_id, y.ac_yr, qa.sid, q.ex_id
                            FROM quiz_ans qa
          											JOIN quiz q ON q.quiz_id = qa.quiz_id
                                JOIN term t ON q.term_id = t.term_id
                                JOIN class c ON q.c_id = c.c_id
                                JOIN subjects s ON q.sub_id = s.sub_id
          											JOIN academic_year y ON q.yr_id = y.yr_id WHERE qa.sid = '$student_id'
                                AND q.c_id = '$level' AND q.yr_id = '$year' AND q.term_id = '$term'
                                AND q.sub_id = '$subject' AND q.ex_id = q.ex_id ORDER BY q.ex_id");

            foreach($sub_query as $index){
                  $output.='<tr>
                    <td>'.$index["sub_name"].'</td>
                    <td>'.$index["ex_id"].'</td>
                    <td><a href="quiz_details.php?class='.$level.'&&ex_id='.$index["ex_id"].'&&subject='.$subject.'&&id='.$student_id.'&&yr='.$year.'&&term='.$term.'">View</a></td></tr>';
                        }
                    '</tbody>
                  </table>  </div>';
                    }
                  }
              }
}
$output.='</div></div>';

$data = array('output' => $output);
 echo json_encode($data);

 $con->close();

?>
