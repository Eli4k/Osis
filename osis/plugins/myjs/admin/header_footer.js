var sliders = document.querySelectorAll(".home-slider .owl-carousel");

// Carousel
  $.ajax({
    url: "php/admin/web/hr_fr/carousel.php",
    type: "POST",
    dataType:"JSON",
    success: function(data){
      sliders.forEach(function(slider){

        if(data.output === ""){
          slider.innerHTML = "Nothing to show";
        }else{
            slider.innerHTML = data.output;
        }
      })
    }
  });
// End
