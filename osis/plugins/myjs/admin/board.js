var contact_form = document.querySelector("#contact-form");
var about = document.querySelector("#about-form");
var board_form = document.querySelector("#board_form");
var response_div = document.querySelector("#req_response");

board_data();

//Submit Board content
board_form.onsubmit = function(e){
   e.preventDefault();

  var fileToUpload = board_form.querySelector("input[name=board_img]").files[0];
  var bio = board_form.querySelector("#bio").value;
  var name = board_form.querySelector("input[name=username]").value;
  var desig = board_form.querySelector("input[name=position]").value;
  var submit =  board_form.querySelector("input[type=submit]").value;

  if(!fileToUpload){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' No File is Selected'+
                 '</div>';
                 alert("error");
    return false;
  }else if(bio == "" ){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' Biography cannot be left empty'+
                 '</div>';
    return false;
  }else if(name == ""){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' Name cannot be left empty'+
                 '</div>';
    return false;
  }else{
  var formData = new FormData();
  formData.append("board_img", fileToUpload);
  formData.append("bio", bio);
  formData.append("position", desig);
  formData.append("name",  name);
  formData.append("submit", submit);
   $.ajax({
       url: "../../php/admin/web/board/insert.php",
       type: "POST",
       dataType: "json",
       contentType: false,
       processData: false,
       data: formData,
       success: function(data){
         response_div.style.display = "block";
         response_div.innerHTML = data.response;
         setTimeout(function(){
         response_div.style.display = "none";
         }, 3000);

         board_data();
       }
     });
   }
}

// End Board

var setExt = ["jpg", "jpeg", "JPG", "JPEG"];

function checkExtension(source){
  var fileName = source.value;
  var extension = fileName.split('.').pop();
  if(!setExt.includes(extension)){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' File must be of Format JPG or JPEG'+
                 '</div>';
  }else{
    response_div.innerHTML =  '<div class="alert alert-success">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Accepted!</strong>'+
                        ' This file format is accepted'+
                 '</div>';
  }
}

// Load Board Info
function board_data(){
  $.ajax({
    url: "../../php/admin/web/board/select.php",
    type:"POST",
    dataType:"JSON",
    success: function(data){
      document.querySelector("#board_list").innerHTML = data.output;
    }
  });
}
// End

// Delete board_member
function delete_board(event){
  let button = event.target.dataset.id;
  $.ajax({
    url: '../../php/admin/web/board/delete.php',
    type:"POST",
    dataType: "JSON",
    data: {id: button},
    success: function(data){
      if(data.output.success == undefined){
        alert(data.output.error);
      }else{
        alert(data.output.success);
      }

      board_data();

    }
  })
}
