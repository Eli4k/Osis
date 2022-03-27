

var subjects = document.querySelectorAll(".subject");
var terms = document.querySelectorAll(".term");
var ac_years = document.querySelectorAll(".ac_year");
var levels = document.querySelectorAll(".level");
var streams = document.querySelectorAll(".stream");
var tests = document.querySelectorAll(".test");

load_term();
// load_class();
// load_subject();
load_stream();
ac_year();
load_presets();




// Subject
// function load_subject(){
//   $.ajax({
//     url: "../../php/teachers/myclass/load_assigned/subject.php",
//     type: "POST",
//     dataType: "json",
//     success: function(data){
//          subjects.forEach(function(subject){
//            subject.innerHTML = data.subject;
//          });
//     }
//   });
// }
// End

// Term
function load_term(){
  $.ajax({
    url: "../../php/teachers/myclass/load_data/term.php",
    type: "POST",
    dataType: "json",
    success: function(data){
      terms.forEach(function(term){
          term.innerHTML = data.term;
         });
    }
  });
}
// End

// Test
// function load_test(){
//   $.ajax({
//     url: "../../php/teachers/myclass/load_data/test.php",
//     type: "POST",
//     dataType: "json",
//     success: function(data){
//       tests.forEach(function(test){
//            test.innerHTML = data.test;
//          });
//     }
//   });
// }
// End

// Stream
function load_stream(){
  $.ajax({
    url:"../../php/teachers/myclass/load_data/stream.php",
    type:"POST",
    dataType:"json",
    success: function(data){
     streams.forEach(function(stream){
           stream.innerHTML = data.s_name;
         });
    }
  })
}
// End


// Academic Year
function ac_year(){
  $.ajax({
    url:"../../php/admin/academics/ac_year.php",
    type:"POST",
    dataType:"json",
    success: function(data)
      {
       ac_years.forEach(function(ac_year){
           ac_year.innerHTML = data.result;
         });
      }
  });
}
// End

function load_presets(){
  $.ajax({
    url:"../../php/teachers/myclass/load_assigned/teacher_presets.php",
    data: {user_id : user_id},
    type:"POST",
    dataType:"json",
    success: function(data){
      levels.forEach(function(level){
         level.innerHTML = data.class_assigned;
       });

       tests.forEach(function(test){
          test.innerHTML = data.test_type;
      });

      subjects.forEach(function(subject){
               subject.innerHTML = data.subject_assigned;
             });
    }
  })
}
