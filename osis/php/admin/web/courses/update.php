<?php

include '../../../../config.php';
$output="";
$uploaddir = "courses_img/";
if (isset($_POST["id"])){
$id = $con->real_escape_string($_POST["id"]);
$courseName = $con->real_escape_string($_POST["courseName"]);
$desc = $con->real_escape_string($_POST["desc"]);
  // If image is uploaded
  if(isset($_FILES["courseImg"]))
  {
    // Delete previous Image
    $load_img = $con->query("SELECT thumbnail FROM courses WHERE course_id = '$id'");
    if($load_img){
      foreach($load_img as $img){
        if(unlink($img["thumbnail"])){
          $file = $_FILES['courseImg'];
          $fileName = $_FILES['courseImg']['name'];
          $tmpName = $_FILES['courseImg']['tmp_name'];
          $file_path = $uploaddir.$fileName;
          if(move_uploaded_file($tmpName,$file_path))
          {
            $query = "UPDATE courses SET name = '$courseName' , description = '$desc' , thumbnail = '$file_path' WHERE course_id = '$id'";
            if($con->query($query))
            { $output.="File and Changes made Successfully";
            }else{$output.="Error: ".$con->error;}
          }else{
            $output.="Error: File selected was unable to upload: ".$con->error;
          }
        }
      }
    }
  } //End
 else{
   // If no image is uploaded
   $query = "UPDATE courses SET name = '$courseName', description = '$desc' WHERE course_id = '$id'";
   if($con->query($query))
   { $output.="Changes made Successfully";
   }else{$output.="Error: ".$con->error;}
 }
}else{$output.="No data to submit";}

$data = array("output" => $output);
 echo json_encode($data);
  $con->close();

?>
