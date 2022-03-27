<?php

require '../../../config.php';

$div = array();
// $output='';
// $cid;
$level = $con->query("SELECT * FROM class");

if($level){
  foreach($level as $class_info){
    $c_id = $class_info["c_id"];
    $cname = $class_info["cname"];
    $output='<div class="span5">
              <div class="widget-box">
                  <div class="widget-title">
                  <h5>'.$cname.'</h5>
                  <button class="publish_all btn btn-min btn-info" style="float:right; margin: 4px" onclick="publish_all(event);">Publish All</button>
                  <select onchange="view_per_stream(event);" class="streams" id="'.$c_id.'" style="float:right; margin: 4px"></select>
              </div>
              <div class="widget-content nopadding">
                <table class="table dataTables table-bordered">
                  <thead>
                    <tr><th width="5%"><input type="checkbox" class="select_all" onclick="select_all(event);"></th><th width="70%">Full Name</th><th width="25%">Action</th></tr>
                  </thead>';
    $student = $con->query("SELECT * FROM students WHERE c_id = '$c_id' ORDER by last_name");
    if($student){
    $output.= "<tbody>";
      foreach($student as $student_info){
        $fullname = $student_info["last_name"].' '.$student_info["middle_name"].' '.$student_info["first_name"];
        $sid = $student_info["sid"];
        $student_id = $student_info["student_id"];
        $email = $student_info["email"];
        $output.='<tr><td><input type="checkbox" value="'.$student_id.'" class="child_checkbox" id="'.$email.'"></td><td>'.$fullname.'</td><td><button onclick="viewSlip(event);" class="btn btn-info btn-mini" data-id='.$student_id.'>View Slip</button><button data-publish='.$student_id.' data-email='.$email.' class="btn btn-warning btn-mini" onclick="indiPublish(event);">Publish</button></td></tr>';
      }
      $output.='</tbody>';
      $output.='<tfoot><tr><td colspan="3">End</td></tr></tfoot>
                </table>
              </div>
           </div>
          </div>';
       $output.='<div class="span7"></div>';
      $div[]=$output;
    }
  }
}

$data = array("div" => $div);
echo json_encode($data);

$con->close();  


?>
