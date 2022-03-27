<?php
   include 'config.php';

if(isset($_POST))
{
  $output='<div class="row">';

  $fetch_id = $con->query("SELECT blog_id FROM blog");

  while($row = $fetch_id->fetch_assoc())
  {
    $id = $row["blog_id"];

    $output.='<div class="col-md-6 col-lg-4 ftco-animate">';
    $output.='<div class="blog-entry">';

          $data = $con->query("SELECT * FROM blog WHERE blog_id = $id");

          if(!empty($data)){
              foreach($data as $blogs)
              {
                $new_id = $blogs['blog_id'];
                $header_file = 'php/admin/events/'.$blogs["title_media"];
                $heading = $blogs["blog_title"];
                $content = $blogs["blog_message"];
                $month = date("F", strtotime($blogs["blog_date"]));
                $day = date("d", strtotime($blogs["blog_date"]));
                $year = date("Y", strtotime($blogs["blog_date"]));

                $output.='<a href="blog-single.php?content='.$new_id.'"
                              class="block-20 d-flex align-items-end" style="background-image:url('.$header_file.');">';
                $output.='<div class="meta-date text-center p-2">
                            <span class="day">'.$day.'</span>
                              <span class="mos">'.$month.'</span>
                            <span class="yr">'.$year.'</span>
                         </div></a>';
                $output.='<div class="text bg-white p-4">';
                $output.='<h3 class="heading"><a href="blog-single.php?content='.$new_id.'">'.$heading.'</a></h3>';
                $output.= '<div class="blg-msg">'.substr($content, 0, 120).'.....</div>';
                $output.='<div class="d-flex align-items-center mt-4">
  	                     <p class="mb-0"><a href="blog-single.php?content='.$new_id.'" class="btn btn-secondary">Read More <span class="ion-ios-arrow-round-forward">
                            </span></a></p>
        	                <p class="ml-auto mb-0">
        	                	<a href="blog-single.php?content='.$new_id.'" class="mr-2" data-id="'.$new_id.'">Admin</a>
        	                </p>
                            </div>
                        </div>';
              }
          };

    $output.='</div>
              </div>';

  }
  $output.='</div>';

  echo $output;
  $con->close();
}




?>
