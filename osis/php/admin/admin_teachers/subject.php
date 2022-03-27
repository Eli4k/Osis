<?php
  require '../../../config.php';

  $sub='<table class="table table-bordered dataTable">
              <thead>
                <tr><th colspan="2">Subject</th></tr>
              </thead>
          <tbody>';

  $query = $con->query("SELECT * FROM subjects");
  if($query){
    while($row = $query->fetch_assoc()){
      $sub_id = $row["sub_id"];
      $sub_name = $row["sub_name"];
      $sub.='<tr><td width="2%"><input type="checkbox" value="'.$sub_id.'"></td><td>'.$sub_name.'</td></tr>';
    }
  }else{
    $sub.="Error".$con->error;
  }
$sub.='</tbody></table>';
  $data = array("sub" => $sub);
  echo json_encode($data);

$con->close();
?>
