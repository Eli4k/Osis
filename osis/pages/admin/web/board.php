<?php

$output='
  <div class="span6">
    <div class= "widget-box">
      <div class="widget-title">
        <span class="icon">
          <i class="icon-play"></i>
        </span>
          <h5>Change contents to be displayed under board.</h5>
        </div>
      <div class="widget-content nopadding">
        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="board_form">
        <div class="control-group">
          <div class="controls">
            <input type="text" name="username" class="span11" placeholder="Enter Name">
          </div>
       </div>
       <div class="control-group">
         <div class="controls">
           <input type="text" name="position" class="span11" placeholder="Position">
         </div>
      </div>
       <div class="control-group">
        <label class="control-label">Image</label>
         <div class="controls">
           <input type="file" name="board_img" onchange="checkExtension(this);">
         </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <textarea cols="100" rows="15" id="bio" class="span11" placeholder="Say something about this person"></textarea>
        </div>
      </div>

        <div class="form-actions">
            <input type="submit" class="btn btn-success" name="submit" value="Submit">
        </div>
  </form>
          </div>
      </div>

</div>
<div class="span6">
<div class="widget-box">
<div class="widget-title">
  <span class="icon">
  <i class="icon-list"></i>
  </span>
  <h5>Board Members</h5>
</div>
<div class="widget-content nopadding">
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">Profile</th>
                <th width="30%">Name</th>
                <th width="20%">Position</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody id="board_list">
        </tbody>
    </table>
    <div>
  </div>
  </div>
</div>';

$data = array("output" => $output);
echo json_encode($data);

 ?>
