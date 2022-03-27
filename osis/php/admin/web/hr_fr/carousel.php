<?php
  require 'config.php';

$select = $con->query("SELECT * FROM carousel");
$output = '<section class="home-slider owl-carousel">';
if($select){
  foreach($select as $data){
    $image = "php/admin/web/home_sliders/".$data["image"];
    $caption = $data["caption"];
    $slider_id = $data["slider_id"];


    $output.='<div class="slider-item" style="background-image:url('.$image.');">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-8 text-center ftco-animate">
          <h1 class="mb-4"><span>'.$caption.'</span></h1>
        </div>
      </div>
      </div>
    </div>';

  }
}else{
  $output.="Error: ".$con->error;
}
$output.='</section>';

// $data = array("output" => $output);
// echo json_encode($data);
echo $output;

$con->close();
 ?>
