<?php
   include 'config.php';

if(isset($_POST))
{
  $output='<section class="ftco-section bg-light">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-8 text-center heading-section ftco-animate">
          <h2 class="mb-4"><span>Recent</span> Blog</h2>
          <p>Separated they live in. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country</p>
        </div>
      </div>
      <div class="row">';

  $fetch_id = $con->query("SELECT blog_id FROM blog ORDER BY blog_date DESC LIMIT 3");

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
                $content = substr($blogs["blog_message"], 0, 180)."....";
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
                $output.= '<div class="blg-msg">'.$content.'</div>';
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
  $output.='</div></div>
</section>';

  echo $output;
  $con->close();
}




?>
