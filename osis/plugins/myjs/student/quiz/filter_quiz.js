  var subject_value,level_value,term_value,yr_value;

   new_quizzes();
   load_sub();
   load_class();
   load_yr();
   load_term();
   load_all();

   subject= document.querySelector(".subject");
   level= document.querySelector(".level");
   term= document.querySelector(".term");
   yr= document.querySelector(".year");

// Load new Quiz
  function new_quizzes(){
  $.ajax({
    url: "../../php/students/student_quiz/load_quiz.php",
    type:"POST",
    data: {student_class:class_id, stream:stream, sid:sid},
    dataType: "json",
    success: function(data){
    document.querySelector(".quick-actions_homepage").innerHTML = data.output;
    }
  });
  }
// End

// Load Subjects
  function load_sub(){
    $.ajax({
      url: "../../php/students/student_quiz/load_sub.php",
      type:"POST",
      data: {sid:sid},
      dataType: "json",
      success: function(data){
      document.querySelector(".filter_menu .subject").innerHTML = data.result_sub;
    }
  })
  }
// End

// Load classes
  function load_class(){
    $.ajax({
      url: "../../php/students/student_quiz/load_class.php",
      type:"POST",
      data: {sid:sid},
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
        url: "../../php/students/student_quiz/load_yr.php",
        type:"POST",
        data: {sid:sid},
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
          url: "../../php/students/student_quiz/load_term.php",
          type:"POST",
          data: {sid:sid},
          dataType: "json",
          success: function(data){
          document.querySelector(".filter_menu .term").innerHTML = data.result_term;
          }
        });
        }
// end

// Load all
  function load_all(){
    $.ajax({
      url: "../../php/students/student_quiz/load_all.php",
      type:"POST",
      data: {sid:sid},
      dataType: "json",
      success: function(data){
      document.querySelector(".quiz_result").innerHTML = data.output;
      }
    });
  }
// End

var search_btn = document.querySelector("#search_quiz");

  search_btn.onclick = function(){
    $.ajax({
      url: "../../php/students/student_quiz/filter_quiz.php",
      data:{subject:subject.value, class:level.value, term:term.value, year:yr.value, student_id: sid},
      dataType:'JSON',
      type: 'POST',
      success: function(data){
        document.querySelector(".quiz_result").innerHTML = data.output;
      }

    });
  }
