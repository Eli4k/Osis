<?php
 $output = '
 <div class="span12">
 <div class="widget-box">
  <div class="widget-title"><span class="icon"><i class="icon-align-justify"></i></span>
    <h5>About Us</h5>
  </div>
  <div class="widget-content nopadding">
    <form id="about_form" class="form-horizontal">
          <div id="about_tools"></div>
          <div id="about_editor"></div>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Save</button>
          </div>
      </form>
    </div>
    </div>
  </div>';

$data = array("output"=>$output);
echo json_encode($data);




?>
