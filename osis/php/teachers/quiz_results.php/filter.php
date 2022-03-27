<?php
  require '../../../config.php';
  $output="";
  if(isset($_POST)){

      $user = $_POST["user"];
      $sub = $_POST["sub"];
      $yr = $_POST["yr"];
      $c_id = $_POST["c_id"];
      $term = $_POST["term"];

    $output.='<table class="styled-table" style="width:100px;">';

      $query = $con->query("SELECT DISTINCT s.sub_name FROM quiz q JOIN subjects s ON q.sub_id = s.sub_id WHERE teacher_id = '$user' AND q.sub_id = '$sub' ");

      if($query){
        foreach($query as $data){
            $subject = $data["sub_name"];
          $output.='<thead><tr><th colspan="2">'.$subject.'</th></tr>
                      <tr><th>Quizz No</th><th>Action</th></tr>
                  </thead>';
        }
      }else{$output.='Error: '.$con->error;}

    $output.='<tbody>';
      $ex = $con->query("SELECT DISTINCT ex_id FROM quiz WHERE yr_id = '$yr' AND c_id = '$c_id' AND term_id = '$term' AND teacher_id = '$user' AND sub_id = '$sub'");
          if($ex){
            if(!empty($ex)){
              foreach($ex as $data){
                  $ex_no = $data["ex_id"];
                  $output.='<tr><td>'.$ex_no.'</td><td><a target="_blank" href="quiz_result.php?class='.$c_id.'&&sub='.$sub.'&&'.$yr.'&&ex='.$ex_no.'">View</a></td></tr>';
              }
            }else{$output.='<tr><td>No data available</td></tr>';}
          }else{$output.='Error: '.$con->error;}
      $output.='</tbody></table>';
  }

$data = array("output" => $output);
echo json_encode($data);


$con->close();
?>
