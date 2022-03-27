<?php

require_once '../../../../config.php';
$output="";
if(isset($_POST)){
  $id = $_POST["id"];

  $select_file = $con->query("SELECT thumbnail FROM courses WHERE course_id = '$id'");
  if($select_file){
    foreach($select_file as $data){
      $new_file = $data["thumbnail"];
      if(unlink($new_file)){
        $delete_data = $con->query("DELETE FROM courses WHERE course_id= '$id'");

        if($delete_data){
          $output.='<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">x</button>
                          <strong>Success!</strong>
                              Deleted Successfully
                       </div>';
        }else{
          $output.= '<div class="alert alert-error">
                        <button class="close" data-dismiss="alert">x</button>
                          <strong>Error!</strong>
                            Error:'.$con->error.'
                    </div>';
        }
      }
    }
  }else{$output.= '<div class="alert alert-error">
                  <button class="close" data-dismiss="alert">x</button>
                    <strong>Error!</strong>
                      Error: No data has been set
                  </div>';}
}

$data = array("output" => $output);

echo json_encode($data);
$con->close();

?>
