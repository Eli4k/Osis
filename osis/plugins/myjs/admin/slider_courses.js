var response_div = document.querySelector("#req_response");
var sliders_form = document.querySelector("#sliders_form");
var courses_form = document.querySelector("#courses_form");
var courseInputTags = courses_form.querySelectorAll("input");
toggleBtnDisp();


load_sliders();
load_courses();
// Carousel Begin

//Submit Carousel
sliders_form.onsubmit = function(e){
   e.preventDefault();

  var slider_img = sliders_form.querySelector('input[name=sliderImg]').files[0];
  var caption = sliders_form.querySelector("input[name=caption]").value;
  var submit =  sliders_form.querySelector("input[type=submit]").value;


  if(!slider_img){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' No File is Selected'+
                 '</div>';

    return false;
  }else if(caption == ""){
    response_div.innerHTML = '<div class="alert alert-error">'+
                  '<button class="close" data-dismiss="alert">x</button>'+
                    '<strong>Error!</strong>'+
                        ' Biography cannot be left empty'+
                 '</div>';
    return false;
  }else{
  var formData = new FormData();
  formData.append("slider_img", slider_img);
  formData.append("caption", caption);
  formData.append("submit", submit);
   $.ajax({
       url: "../../php/admin/web/home_sliders/carousel_insert.php",
       type: "POST",
       dataType: "json",
       contentType: false,
       processData: false,
       data: formData,
       success: function(data){
        alert(data.output);
        load_sliders();
       }
     });
   }
}
// End carousel

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

// Load Sliders
function load_sliders(){
  $.ajax({
    url: "../../php/admin/web/home_sliders/select.php",
    type:"POST",
    dataType:"JSON",
    success: function(data){document.querySelector("#sliders_list tbody").innerHTML = data.output;}
  })
}
// End

function deleteSlider(e){
  let btn = e.target.dataset.id;
  $.ajax({
    url: "../../php/admin/web/home_sliders/delete.php",
    type:"POST",
    data:{id: btn},
    dataType:"JSON",
    success: function(data){
      response_div.innerHTML = data.output;
      load_sliders();
      }
  })
}
// End

// Carousel End


// Courses Start
courses_form.onsubmit= function(e){
  e.preventDefault();

 let course_img = courses_form.querySelector('input[type=file]').files[0];
 let course_name =courses_form.querySelector("input[name=lesson]").value;
 let desc = courses_form.querySelector("textarea").value;
 let submit = courses_form.querySelector("input[type=submit]").value;


 if(!course_img){
   response_div.innerHTML = '<div class="alert alert-error">'+
                 '<button class="close" data-dismiss="alert">x</button>'+
                   '<strong>Error!</strong>'+
                       ' No File is Selected'+
                '</div>';

   return false;
 }else if(course_name == ""){
   response_div.innerHTML = '<div class="alert alert-error">'+
                 '<button class="close" data-dismiss="alert">x</button>'+
                   '<strong>Error!</strong>'+
                       'Course name cannot be left empty'+
                '</div>';
   return false;
 }else if(desc == ""){
   response_div.innerHTML = '<div class="alert alert-error">'+
                 '<button class="close" data-dismiss="alert">x</button>'+
                   '<strong>Error!</strong>'+
                       ' Description cannot be left empty'+
                '</div>';
   return false;
 }else{
 var formData = new FormData();
 formData.append("courseImg", course_img);
 formData.append("desc", desc);
 formData.append("courseName", course_name);
 formData.append("submit", submit);
  $.ajax({
      url: "../../php/admin/web/courses/insert.php",
      type: "POST",
      dataType: "json",
      contentType: false,
      processData: false,
      data: formData,
      success: function(data){
       alert(data.output);
       load_courses();
      }
    });
  }
}

// load course
function load_courses(){
  // let btn = e.target.dataset.id;
  $.ajax({
    url: "../../php/admin/web/courses/load.php",
    type:"POST",
    dataType:"JSON",
    success: function(data){
      document.querySelector("#course_list tbody").innerHTML = data.output;
      }
  })
}
// End load_courses


// Load Course Data on Edit
function editCourse(e){
  let textArea = courses_form.querySelector("textarea");
  let btn = e.target.dataset.id;
  $.ajax({
    url: "../../php/admin/web/courses/edit.php",
    type:"POST",
    data:{id: btn},
    dataType:"JSON",
    success: function(data){
        courseInputTags[0].value = data.courseName;
        textArea.value = data.desc;
        courseInputTags[3].value = data.id;
        inverseBtnDisp();
      }
  })
}
// End

// Delete Courses
function deleteCourse(e){
  let btn = e.target.dataset.id;
  $.ajax({
    url: "../../php/admin/web/courses/delete.php",
    type:"POST",
    data:{id: btn},
    dataType:"JSON",
    success: function(data){
      response_div.innerHTML = data.output;
      load_courses();
      }
  })
}
// End

function toggleBtnDisp(){
  courseInputTags[2].style.display="inline";
  courses_form.querySelectorAll("button")[0].style.display = "none";
  courses_form.querySelectorAll("button")[1].style.display = "none";
}

function inverseBtnDisp(){
  courseInputTags[2].style.display="none";
  courses_form.querySelectorAll("button")[0].style.display = "inline";
  courses_form.querySelectorAll("button")[1].style.display = "inline";

// Cancel
  courses_form.querySelectorAll("button")[1].onclick = function(){
    toggleBtnDisp();
    courses_form.reset();
  }
// End

// Update Course Data
  courses_form.querySelectorAll("button")[0].onclick = function(e){
    e.preventDefault();

    var formData = new FormData();
    if(!courseInputTags[1].files[0]){
    }else{
      formData.append("courseImg", courseInputTags[1].files[0]);
    }
    formData.append("desc", courses_form.querySelector("textarea").value);
    formData.append("id", courseInputTags[3].value);
    formData.append("courseName", courseInputTags[0].value);
     $.ajax({
         url: "../../php/admin/web/courses/update.php",
         type: "POST",
         dataType: "json",
         contentType: false,
         processData: false,
         data: formData,
         success: function(data){
          alert(data.output);
          load_courses();
         }
       });

  }
// End
}
// End
