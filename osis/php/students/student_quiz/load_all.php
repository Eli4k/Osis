<?php
	include '../../../config.php';

$output="";
$sid = $_POST["sid"];
	$sql = $con->query("SELECT DISTINCT q.term_id, q.c_id, t.term_name, c.cname, q.yr_id, y.ac_yr, qa.sid
                                      FROM quiz_ans qa
											JOIN quiz q ON q.quiz_id = qa.quiz_id
                      JOIN term t ON q.term_id = t.term_id
                      JOIN class c ON q.c_id = c.c_id
											JOIN academic_year y ON q.yr_id = y.yr_id WHERE qa.sid = '$sid'	ORDER BY q.yr_id, q.term_id, q.c_id DESC");

	if (!empty($sql)) {
		while($row=$sql->fetch_assoc())
		{
		$yr_id = $row["yr_id"];
    $term_id = $row["term_id"];
    $class_id = $row["c_id"];
    // $sub_id = $row["sub_id"];
    $term = $row["term_name"];
    $class = $row["cname"];
    // $subject = $row["sub_name"];
    $year = $row["ac_yr"];

      $output.='
      <div class="span7">
        <div class="widget-box">
          <div class="widget-title">
            <h5>'.$year.'</h5>
            <h5>'.$class.'</h5>
            <h5>'.$term.'</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-tables">
                    <thead>
                      <th>SUBJECT</th>
                      <th>EXERCISE No</th>
                      <th>ACTION</th>
                    </thead>
                    <tbody>
      ';

      $index_data = $con->query("SELECT DISTINCT q.sub_id, s.sub_name, q.ex_id, q.c_id, q.yr_id FROM quiz_ans qa
                                JOIN quiz q ON q.quiz_id = qa.quiz_id
                                JOIN subjects s ON q.sub_id = s.sub_id
                                WHERE qa.sid = ".$_POST["sid"]." AND q.term_id = '$term_id' AND q.ex_id = q.ex_id AND q.c_id = '$class_id' AND q.yr_id= '$yr_id'");
              if($index_data && !empty($index_data)){
                  foreach($index_data as $new_row)
                  {
                    $output.='<tr>
                                <td>'.$new_row["sub_name"].'</td>
                                <td>'.$new_row["ex_id"].'</td>
                                <td><a href="quiz_details.php?class='.$class_id.'&&ex_id='.$new_row["ex_id"].'&&subject='.$new_row["sub_id"].'&&id='.$_POST["sid"].'&&yr='.$yr_id.'&&term='.$term_id.'">View</a></td>
															</tr>
                            ';
                  }
              }else{
                $output.='<td colspan=3>Error: '.$con->error.'</td>';
              }
          $output.='</tbody>
            </table>
          <div>
        </div>
      </div>';
		}
	}else{
		$output.='<p>Error: '.$con->error.'</p>';
	}
	$data = array('output'=>$output);
	echo json_encode($data);


?>
