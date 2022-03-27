<?php
$years = "";
$levels = "";
$error=array();

  require_once '../../config.php';

if(isset($_POST["id"])){
  $id = $con->real_escape_string($_POST["id"]);

  $class_query = $con->query("SELECT DISTINCT asm.c_id, c.cname FROM assessment asm JOIN class c ON c.c_id = asm.c_id WHERE asm.student_id = '$id' ORDER BY c.c_id DESC");
  if($class_query){
    foreach($class_query as $curr_class){
      $class_id = $curr_class["c_id"];
      $cname = $curr_class["cname"];

      $levels.='<option value="'.$class_id.'">'.$cname.'</option>';
    }
  }else{$error["error"] = "Class data Error: ".$con->error;}

  $yr_query = $con->query("SELECT DISTINCT asm.yr_id, y.ac_yr FROM assessment asm JOIN academic_year y ON y.yr_id = asm.yr_id WHERE asm.student_id = '$id' ORDER BY y.yr_id DESC");
  if($yr_query){
    foreach($yr_query as $yr_data){
      $yr_id = $yr_data["yr_id"];
      $yr = $yr_data["ac_yr"];

      $years.='<option value="'.$yr_id.'">'.$yr.'</option>';
    }
  }else{$error["error"] = "Year data Error: ".$con->error;}


  $data = array("classes" => $levels,
                "years" => $years,
                "error" => $error);

  echo json_encode($data);
}



$con->close();

?>
