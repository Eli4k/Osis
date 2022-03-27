<?php include 'home_page/header.html';  ?>


    <!-- END nav -->


<!-- Homepage Contents-->
    <?php
      require 'php/admin/web/hr_fr/carousel.php';
      require 'php/admin/web/about/select.php';
      require 'php/admin/web/board/display_onhomepage.php';
      require 'php/admin/web/courses/courses_home.php';
      require 'php/admin/events/home_blog.php';
     ?>
<!-- End Homepage Contents -->
  <!-- End Carousel -->
    <?php include 'home_page/footer.html'; ?>
  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="home_page/js/jquery.min.js"></script>
  <script src="home_page/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="home_page/js/popper.min.js"></script>
  <script src="home_page/js/bootstrap.min.js"></script>
  <script src="home_Page/js/jquery.easing.1.3.js"></script>
  <script src="home_page/js/jquery.waypoints.min.js"></script>
  <script src="home_page/js/jquery.stellar.min.js"></script>
  <script src="home_page/js/owl.carousel.min.js"></script>
  <script src="home_page/js/jquery.magnific-popup.min.js"></script>
  <script src="home_page/js/aos.js"></script>
  <script src="home_page/js/jquery.animateNumber.min.js"></script>
  <script src="home_page/js/scrollax.min.js"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> -->
  <!-- <script src="home_page/js/google-map.js"></script> -->
  <script src="home_page/js/main.js"></script>
  <script src="plugins/myjs/hf_contact.js"></script>
  <script type="text/javascript">


  var sections  = document.querySelectorAll("section");


  // About
    $.ajax({
      url: "php/admin/web/about/select.php",
      type: "POST",
      dataType:"json",
      success: function(data){
        document.querySelector(".about_content").innerHTML = data.content;
        // $("#about_title").html(data.title);
      }
    });
  // End


  // Carousel
  $.ajax({
    url: "php/admin/web/hr_fr/carousel.php",
    type: "POST",
    dataType:"json",
    success: function(data){
      document.querySelector(".home-slider").innerHTML = data.output;
      // $("#about_title").html(data.title);
    }
  });
  // End

  // Board
  $.ajax({
    url: "php/admin/web/board/display_onhomepage.php",
    type: "POST",
    dataType:"json",
    success: function(data){
      sections[2].querySelectorAll(".row")[1].innerHTML = data.output;
    }
  });
  // End
  </script>
  </body>
</html>
