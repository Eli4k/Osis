<?php
  require '../../../../config.php';

if(isset($_POST)){
$id = $con->real_escape_string($_POST["id"]);

$select = $con->query("SELECT * FROM courses WHERE course_id ='$id'");
if($select){
  foreach($select as $data){
    $courseName = $data["name"];
    $thumbnail = $data["thumbnail"];
    $desc = $data["description"];
    $data = array("id" => $id, "courseName" => $courseName,"thumbnail" => $thumbnail,"desc" => $desc);
    echo json_encode($data);
    exit();
    }
  }
}

$con->close();

?>
