<?php

$output = '<div class="span12">
      <div class="widget-box">
       <div class="widget-title">
         <span class="icon">
           <i class="icon-globe"></i>
         </span>
            <h5>Blog</h5>
       </div>
       <div class="widget-content nopadding">
           <form id="this_form" enctype="multipart/form-data">
               <input type="text" id="title" name="title" placeholder="Title Goes Here....">
               <input type="file" name="userfile" id="userfile">
               <div id="toolbars"></div>
               <div id="editors"></div>
               <input type="submit" class="btn btn-success" name="publish" value="Publish">
           </form>
       </div>
     </div>
   </div>';

$data = array("output" => $output);
   echo json_encode($data);

?>
