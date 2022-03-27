<?php

require_once '../../../../config.php';

$select = $con->query("SELECT * FROM carousel");
$output = "";
$i = 1;
if($select){
  foreach($select as $data){
    $image = '../../php/admin/web/home_sliders/'.$data["image"];
    $caption = $data["caption"];
    $slider_id = $data["slider_id"];

    $output.='<tr><td>'.$i.'</td><td><img src="'.$image.'" style="border-radius:20%; width:80px; height:50px;"/></td><td>'.$caption.'</td><td><button data-id='.$slider_id.' onclick="deleteSlider(event);">Delete</button></td></tr>';

    $i++;
  }
}else{
  $output.="Error: ".$con->error;
}

$data = array("output" => $output);
echo json_encode($data);

$con->close();

 ?>
