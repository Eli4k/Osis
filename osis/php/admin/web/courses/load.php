<?php

require_once '../../../../config.php';

$select = $con->query("SELECT * FROM courses");
$output = "";
$i = 1;
if($select){
  foreach($select as $data){
    $image = '../../php/admin/web/courses/'.$data["thumbnail"];
    $courseName = $data["name"];
    $description = $data["description"];
    $course_id = $data["course_id"];

    $output.='<tr><td>'.$i.'</td><td><img src="'.$image.'" style="border-radius:20%; width:80px; height:50px;"/></td><td>'.$courseName.'</td><td><button data-id='.$course_id.' onclick="editCourse(event);">Change</button><button data-id='.$course_id.' onclick="deleteCourse(event);">Delete</button></td></tr>';

    $i++;
  }
}else{
  $output.="Error: ".$con->error;
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();

 ?>
