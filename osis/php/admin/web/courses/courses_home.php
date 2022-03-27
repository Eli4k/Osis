<?php
  require 'config.php';
  $select = $con->query("SELECT * FROM courses");

  $output='<section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <h2 class="mb-4"><span>Our</span> Courses</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row">';

if($select){
    foreach($select as $data){
      $thumbnail = $data["thumbnail"];
      $courseName = $data["name"];
      $description = $data["description"];
      $output.='<div class="col-md-6 course d-lg-flex ftco-animate">
        <div class="img" style="background-image: url(php/admin/web/courses/'.$thumbnail.');"></div>
        <div class="text bg-light p-4">
          <h3><a href="#">'.$courseName.'</a></h3>
          <p>'.$description.'</p>
        </div>
      </div>';
    }
}else{$output.= "Error: ".$con->error;}

$output.='</div>
</div>
</section>';

// $data = array("output" => $output);
// echo json_encode($data);

echo $output;

 $con->close();

?>
