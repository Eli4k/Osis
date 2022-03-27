<?php
  include '../../../config.php';

  $output="";

  $select = "SELECT * FROM contact";

  if($data = $con->query($select))
  {
    while($row = $data->fetch_assoc())
    {
      $output.= '<div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Contact-info</h5>
          </div>
          <div class="widget-content nopadding">
            <form  method="POST" class="form-horizontal" id="contact-form">
              <div class="control-group">
                <label class="control-label">Location:</label>
                <div class="controls">
                  <input type="text" class="span11" name="address" placeholder="'.$row["location"].'"/>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Email:</label>
                <div class="controls">
                  <input type="text" class="span11"  name="email" placeholder="'.$row["email"].'"/>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Phone</label>
                <div class="controls">
                  <input type="text"  class="span11"  name="phone" placeholder="'.$row["phone"].'"/>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Website</label>
                <div class="controls">
                  <input type="text"  class="span11" name="web" placeholder="'.$row["website"].'"/>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>';
    }
  }
  $data = array("output" => $output);
  echo json_encode($data);


  $con->close();
 ?>
