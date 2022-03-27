<?php

include 'config.php';

$output = '<section class="ftco-section ftco-no-pb">
  <div class="container">
    <div class="row justify-content-center mb-5 pb-2">
      <div class="col-md-8 text-center heading-section ftco-animate">
        <h2 class="mb-4"><span>Certified</span> Teachers</h2>
        <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
      </div>
    </div>
    <div class="row">';
if(isset($_POST)){
  $query="SELECT * FROM board";
  $query_exec = $con->query($query);
  $i = 0;
  if($query_exec){
    while($row = $query_exec->fetch_assoc())
    {
        $board_id = $row["board_id"];
        $name = $row["name"];
        $position = $row["position"];
        $profile = $row["image"];

      $output.='<div class="col-md-6 col-lg-3 ftco-animate">
      <a href="board_id.php?id='.$board_id.'">
        <div class="staff">
          <div class="img-wrap d-flex align-items-stretch">
            <div class="img align-self-stretch" style="background-image: url(php/admin/web/board/'.$profile.'); max-width:100%; height:auto;"></div>
          </div>
          <div class="text pt-3 text-center">
            <h3>'.$name.'</h3>
            <span class="position mb-2">'.$position.'</span>
          </div>
        </div></a>
      </div>';
    }

  }else{
    $output.="<p> Something went wrong:" .$con->error."<p>";
  }

}else{
  $output.="<p>Error: ".$con->error."</p>";
}

$output.='  </div>
</div>
</section>';

  // $data = array("output" => $output);
  //
  // echo json_encode($data);
echo $output;
$con->close();

?>
