var quiz_form = document.querySelector('.row');

load_answers();


function load_answers(){
  $.ajax({
    url: "../../php/students/student_quiz/quiz_details.php",
    data: {class_id: class_id, sid: sid, ex: ex, term:term, yr:yr, sub: sub},
    dataType:'JSON',
    type: 'POST',
    success: function(data)
    {
      quiz_form.innerHTML = data.output;
      check_selected(".radio span > span i");
    }
  });
}


// Check options selected by Student
function check_selected(radio_tag){
  var radio= document.querySelectorAll(radio_tag);
  var selected;

  for(var i=0; i < radio.length; i++)
  {
    if(radio[i].textContent == "Chosen answer"){
      selected = radio[i];
      selected.parentElement.previousElementSibling.checked = true;
    }
  }
}
// End
