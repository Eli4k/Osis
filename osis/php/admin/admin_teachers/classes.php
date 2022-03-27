<?php
  require '../../../config.php';

  $class='<table class="table table-bordered dataTable">
            <thead>
              <tr><th colspan="2">Class</th></tr>
            </thead><tbody>';

  $query = $con->query("SELECT * FROM class");
  if($query){
    while($row = $query->fetch_assoc()){
      $c_id = $row["c_id"];
      $cname = $row["cname"];
      $class.='<tr><td width="2%"><input type="checkbox" value="'.$c_id.'"></td><td>'.$cname.'</td></tr>';
    }
  }else{
    $class.="Error".$con->error;
  }
$class.='</tbody></table>';
  $data = array("class" => $class);
  echo json_encode($data);

$con->close();
?>
