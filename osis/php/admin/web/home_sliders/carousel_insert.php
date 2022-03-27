<?php

include '../../../../config.php';
$output="";
$uploaddir = "sliders/";
if (isset($_POST["submit"])){
$thumbnail = $con->real_escape_string($_POST["slider_img"]);
$caption = $con->real_escape_string($_POST["caption"]);
$file = $_FILES["slider_img"];
  if(!empty($file) || !empty($caption))
  {
        $fileName = $_FILES['slider_img']['name'];
        $tmpName = $_FILES['slider_img']['tmp_name'];
        $file_path = $uploaddir.$fileName;
        if(move_uploaded_file($tmpName,$file_path))
        {
          $query = "INSERT INTO carousel(image, caption) VALUES('$file_path', '$caption')";
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
