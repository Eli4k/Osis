<?php

include '../../../../config.php';
$output="";
$uploaddir = "board_img/";
if (isset($_POST["submit"])){
$username = $con->real_escape_string($_POST["name"]);
$bio = $con->real_escape_string($_POST["bio"]);
$desig = $con->real_escape_string($_POST["position"]);
$file = $_FILES["board_img"];
  if(!empty($username) || !empty($bio) || !empty($file))
  {
        $fileName = $_FILES['board_img']['name'];
        $tmpName = $_FILES['board_img']['tmp_name'];
        $file_path = $uploaddir.$fileName;
        if(move_uploaded_file($tmpName,$file_path))
        {
          $query = "INSERT INTO board(name, position, image, bio) VALUES('$username', '$desig', '$file_path', '$bio')";
          if($con->query($query))
          {
            $output.='<div class="alert alert-success">
                          <button class="close" data-dismiss="alert">x</button>
                            <strong>Success!</strong>
                                File uploaded successfully
                         </div>';
              }
          }else{
            $output.="Failed to upload Image";
          }
      }
}else{
  $output.= '<div class="alert alert-error">
                <button class="close" data-dismiss="alert">x</button>
                  <strong>Error!</strong>
                    No File available for upload.
               </div>';
}

$data = array("response" => $output);
 echo json_encode($data);
  $con->close();

?>
