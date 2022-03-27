var hrs,mins,sec,fixed_time,time_tag,new_time;
// getActiveQuiz();

check_existing_quiz();


// Submit Answers
var form = document.querySelector("#quiz_form");
form.onsubmit = submit_form;
function submit_form(){
    var question_count = form.querySelectorAll(".question");
    var result = [];
    var options = form.querySelectorAll(".options");
    for(var i=0; i<options.length; i++){
        result[i]={
        q_id: options[i].querySelector("input[type=radio]:checked").id,
        chosen_ans: options[i].querySelector("input[type=radio]:checked").value,
        correct_ans: options[i].querySelector("input[type=hidden]").value,
        // sid: sid
      }
    }
    $.ajax({
      url: '../../php/students/student_quiz/quiz_answers.php',
      type:"POST",
      data: {result: JSON.stringify(result), sub:form.querySelector("input[type = submit]").dataset.sub, term: term, yr:yr, class_id:class_id, sid:sid, stream:stream, ex_id:ex, total: question_count.length},
      dataType: "JSON",
      beforeSend: function(){
        alert(`Please Wait. Submitting Answers.  Total: ${question_count.length}`);
      },
      success: function(data){
        $('.row').html(data.response);
        result.length = 0;
      },
      error: function(){
        alert("Error: ");
        result.length = 0;
      }

    });
    return false;
  }


// Convert milliseconds to Standard Time
function convertTime(number){
   sec=Math.floor((number % (1000 * 60)) / 1000);
   mins=Math.floor((number % (1000 * 60 * 60)) / (1000 * 60));
   hrs=Math.floor((number % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   new_time = fixed_time-=1000;
   time_tag.dataset.time =  new_time;
   time_tag.innerHTML = hrs+" : "+mins+" : "+sec;
   if(time_tag.dataset.time < 0){
     clearInterval(myCounter);
      submit_form();
   }

 }

 function stopTimer(){
   clearInterval(myCounter);
 }

 var myCounter = setInterval(function(){
 convertTime(fixed_time);
 },1000);

 // Load Active Quiz
 function getActiveQuiz(){
   $.ajax({
     url: "../../php/students/student_quiz/questions.php",
     type: "POST",
     data: {class_id:class_id, ex:ex, stream:stream, term:term, yr:yr, sub:sub, sid:sid},
     dataType: "JSON",
     success: function(data){
       $("#quiz_form").html(data.questions);
       $("#countdown").html(data.timer);
       $("#heading").html(data.heading);

       time_tag = document.querySelector("#time");
       fixed_time = time_tag.dataset.time;
       convertTime(fixed_time);

     }
   });
 }
 // End

// Check if quiz on this User Exist
function check_existing_quiz(){
  $.ajax({
    url: '../../php/students/student_quiz/check_quiz.php',
    data: {class_id:class_id, stream:stream, yr:yr, sid:sid, term:term, ex_id:ex, sub:sub},
    dataType: 'JSON',
    type: "POST",
    success: function(data){
        switch(data.output)
        {
          case 0:
          getActiveQuiz();
          break;

          default:
          window.location.assign('quiz.php');
          break;
        }
      }
    });
  }
