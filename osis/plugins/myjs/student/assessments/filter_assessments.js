var subject,level,term,yr;

subject = document.querySelector(".subject");
level = document.querySelector(".level");
term = document.querySelector(".term");
yr = document.querySelector(".year");

load_sub();
load_class();
load_yr();
load_term();

// Load Subjects
function load_sub(){
 $.ajax({
   url: "../../php/students/assessments/load_sub.php",
   type:"POST",
   data: {sid:curr_id},
   dataType: "json",
   success: function(data){
   document.querySelector(".filter_menu .subject").innerHTML = data.result_sub;
      }
    });
  }
// End

// Load classes
function load_class(){
 $.ajax({
   url: "../../php/students/assessments/load_class.php",
   type:"POST",
   data: {sid:curr_id},
   dataType: "json",
   success: function(data){
   document.querySelector(".filter_menu .level").innerHTML = data.result_class;
    }
  });
 }
// End

// Load year
function load_yr(){
   $.ajax({
     url: "../../php/students/assessments/load_yr.php",
     type:"POST",
     data: {sid:curr_id},
     dataType: "json",
     success: function(data){
     document.querySelector(".filter_menu .year").innerHTML = data.result_yr;
     }
   });
   }
// End

// Load term
function load_term(){
     $.ajax({
       url: "../../php/students/assessments/load_term.php",
       type:"POST",
       data: {sid:curr_id},
       dataType: "json",
       success: function(data){
       document.querySelector(".filter_menu .term").innerHTML = data.result_term;
       }
     });
     }
// end

// Filter assessments
var search_btn = document.querySelector("#search_test");
  search_btn.onclick = function(e){
    e.preventDefault();
    $.ajax({
      url: "../../php/students/assessments/filter_assessments.php",
      data:{subject:subject.value, class:level.value, term:term.value, year:yr.value, student_id: curr_id},
      dataType:'JSON',
      type: 'POST',
      success: function(data){
        document.querySelectorAll(".row-fluid")[0].innerHTML = data.output;
      }
    });
  }
