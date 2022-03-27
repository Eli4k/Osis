var contact_form = document.querySelector("#contact-form");
var about = document.querySelector("#about-form");
var board_form = document.querySelector("#board_form");
var response_div = document.querySelector("#req_response");

// load_contact();

// Contact form onsubmit
contact_form.onsubmit = function(e){
  var formData = new FormData();
  e.preventDefault();
  formData.append('address', document.querySelector("input[name=address]").value);
  formData.append('email', document.querySelector("input[name = email]").value);
  formData.append('phone', document.querySelector("input[name = phone]").value);
  formData.append('web', document.querySelector("input[name=web]").value);

  $.ajax({
    url: "../../php/admin/web/contact/contact.php",
    type:"POST",
    processData: false,
    contentType: false,
    dataType:"json",
    data: formData,
    success: function(data){
      response_div.style.display = "block";
      response_div.innerHTML = data.response;
      setTimeout(function(){
      response_div.style.display = "none";
      }, 3000);
      load_contact();
    }
  });
}
//End contact onsubmit


// function load_contact(){
//
//     $.ajax({
//       url: "web/contact.php",
//       type:"post",
//       dataType:"json",
//       success: function(data){
//         document.querySelector("#contact > div") = data.output;
//       }
//     });
// }
