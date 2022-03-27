<?php

$message = "";
include '../../../config.php';
$temp_name = $_FILES['thumbnail']['tmp_name'];
$file_size = $_FILES['thumbnail']['size'];
$uploaddir = 'header_files/';
$file_path="";
$title = $con->real_escape_string($_POST['title']);
$delta = $con->real_escape_string($_POST['delta']);
$user = $con->real_escape_string($_POST['user']);


   if (isset($_POST["submit"]))
   {
     $file_path .= $uploaddir.basename($_FILES['thumbnail']['name']);
        if(move_uploaded_file($temp_name, $file_path)){
          $query = "INSERT INTO blog (blog_title, title_media, blog_message, ad_id) values('$title','$file_path','$delta', '$user')";
          if($con->query($query)){
            $message.='<div class="alert alert-success">
                          <button class="close" data-dismiss="alert">x</button>
                          <strong>Success!</strong>
                            Post successfully published
                    </div>';
          }else{
            $message.='<div class="alert alert-error">
                          <button class="close" data-dismiss="alert">x</button>
                          <strong>Error!</strong>
                        Insert Query Error: '.$con->error.'
                      </div>';
          }
        }else{
        $message.='<div class="alert alert-error">
                      <button class="close" data-dismiss="alert">x</button>
                      <strong>Error!</strong>
                  File Upload Error: '.$con->error.'
                  </div>';
        }

   }else{
      $file_path.= 'header_files/nomedia.png';
      $query = "INSERT INTO blog(blog_title, title_media, blog_message, ad_id) values('$title','$file_path','$delta', '$user')";
      if($con->query($query)){
        $message.='<div class="alert alert-success">
                      <button class="close" data-dismiss="alert">x</button>
                        <strong>Success!</strong>
                          Post successfully inserted with default header Image
                </div>';
      }else{
        $message.='<div class="alert alert-error">
                    <button class="close" data-dismiss="alert">x</button>
                        <strong>Error!</strong> Something went wrong: '.$con->error.'
                  </div>';
      }

   }

   $data = array("response" => $message);
   echo json_encode($data);
   $con->close();
  ?>
