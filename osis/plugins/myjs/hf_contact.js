  $.ajax({
    url: "php/admin/web/hr_fr/data.php",
    type: "POST",
    dataType: 'json',
    success: function(data){
      var location = document.querySelectorAll(".location");
      location.forEach(locationIterate);
      function locationIterate(item, index){
        item.innerHTML = data.location;
      }

      var phone = document.querySelectorAll(".phone");
      phone.forEach(phoneIterate);

      function phoneIterate(item, index){
        item.innerHTML = data.phone;
      }

      var email = document.querySelectorAll(".email");
      email.forEach(emailIterate);

      function emailIterate(item, index){
        item.innerHTML = data.email;
      }

      document.querySelector(".web").innerHTML = data.web;


    }
  });
