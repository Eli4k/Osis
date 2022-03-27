<?php
    include 'config.php';

$section = "";

  if (isset($_GET["content"])) {

    $id = $_GET["content"];

    $query = $con->query("SELECT * FROM blog WHERE blog_id = $id");

    if($query && !empty($query))
    {
      if($row = $query->fetch_assoc())
      {
        $section.='<section class="hero-wrap hero-wrap-2" style="background-image: url(php/admin/events/'.$row["title_media"].');">
                    <div class="overlay"></div>
                        <div class="container">
                            <div class="row no-gutters slider-text align-items-center justify-content-center">
                              <div class="col-md-9 ftco-animate text-center">
                                <h1 class="mb-2 bread">'.$row["blog_title"].'</h1>
                                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home <i class="ion-ios-arrow-forward"></i></a></span>
                                 <span class="mr-2"><a href="blog.php">Blog <i class="ion-ios-arrow-forward"></i></a></span>
                                  <span>Blog Single <i class="ion-ios-arrow-forward"></i></span></p>
                              </div>
                            </div>
                        </div>
                  </section>';

      $section.='<section class="ftco-section">
    			<div class="container">
    				<div class="row">
              <div class="col-lg-8 ftco-animate">
                <h2 class="mb-3">'.$row["blog_title"].'</h2>';
      $section.=$row["blog_message"];
      $section.='</div>';

      }
    }

    echo $section;
  }




$con->close();
?>
