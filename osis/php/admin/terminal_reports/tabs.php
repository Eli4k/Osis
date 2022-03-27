<?php

require '../../../config.php';

$output = '<div class="widget-title">';

    $sql = $con->query("SELECT * FROM class");

    if($sql){
      if(!empty($sql)){
        $output.='<ul class="nav nav-tabs">';
        foreach($sql as $row){
          $class_id = $row["c_id"];
          $class_name = $row["cname"];
          $output.='<li><a href="#'.$class_id.'" data-toggle="tab">'.$class_name.'</a></li>';
        }

        $output.='</div><div class="widget-content tab-content">';
        foreach($sql as $data){
          $c_id = $data["c_id"];
          $output.='<div id="'.$c_id.'" class="tab-pane">
            <div class="row-fluid">
              <div class="span12"></div>
            </div>
          </div>';
        }
        $output.='</div>';
      }
    }else{$output.= $con->error;}

$data = array('output' => $output);
echo json_encode($data);

?>
