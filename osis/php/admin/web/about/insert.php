<?php
  include '../../../../config.php';
  $response = "";

  if(isset($_POST["user"]))
  {
    $content = $con->real_escape_string($_POST["delta"]);
    $user = $_POST["user"];

    $delete = $con->query("DELETE FROM about");

    if($delete){
      $query = "INSERT INTO about(content, ad_id) values( '$content', '$user')";
      if($con->query($query))
      {
        $response.= '<div class="alert alert-success">
                      <button class="close" data-dismiss="alert">x</button>
                        <strong>Success!</strong>
                            Content successfully updated
                     </div>';

      }else {
        $response.='<div class="alert alert-error">
                      <button class="close" data-dismiss="alert">x</button>
                          <strong>Error!</strong>
                           Something went wrong'.$con->error.'
                </div>';
      }
    }else {
      $response.='<div class="alert alert-error">
                    <button class="close" data-dismiss="alert">x</button>
                      <strong>Error!</strong> '.$con->error.'</div>';
          }
  }else{
    $response.='<div class="alert alert-error">
                  <button class="close" data-dismiss="alert">x</button>
                    <strong>Error!</strong> '.$con->error.'</div>';
  }
    $data = array("response" => $response);
    echo json_encode($data);
?>
