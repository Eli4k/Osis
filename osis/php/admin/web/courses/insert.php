<?php

include '../../../../config.php';
$output="";
$uploaddir = "courses_img/";
if (isset($_POST["submit"])){
$courseName = $con->real_escape_string($_POST["courseName"]);
$desc = $con->real_escape_string($_POST["desc"]);
$file = $_FILES["courseImg"];
  if(!empty($file) || !empty($desc) || $courseName)
  {
        $fileName = $_FILES['courseImg']['name'];
        $tmpName = $_FILES['courseImg']['tmp_name'];
        $file_path = $uploaddir.$fileName;
        if(move_uploaded_file($tmpName,$file_path))
        {
          $query = "INSERT INTO courses(name, thumbnail, description) VALUES('$courseName','$file_path', '$desc')";
          if($con->query($query))
          { $output.="File uploaded successfully";
          }else{$output.="Error: ".$con->error;}
        }else{
          $output.="Error: File selected was unable to upload: ".$con->error;
        }
 }else{
   $output.="Error: No file was selected";
 }
}else{$output.="No data to submit";}

$data = array("output" => $output);
 echo json_encode($data);
  $con->close();

?>
