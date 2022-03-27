var all = document.querySelector(".all > div >  div > table > thead");

load_quiz();

function load_quiz(){
  $.ajax({
    url:"../../php/teachers/quiz/list_quiz.php",
    data: {user: curr_id},
    dataType: 'JSON',
    type: 'POST',
    success: function(data){
        all.querySelector("thead").innerHTML = data.output;
    }
  })
}

function search_quiz(event){
  var element = event.target;
  var c_id,yr,term,sub,table,selects;
  table = element.parentElement.parentElement.parentElement;
  selects = table.querySelectorAll("select");
  $.ajax({
    url:'../../php/teachers/quiz/filter.php',
    type:'POST',
    dataType: 'JSON',
    data: {c_id: selects[0].value, sub: selects[1].value, term: selects[2].value, yr: selects[3].value, user: curr_id},
    success: function(data){
        document.querySelector(".filter_result").innerHTML = data.output;
    }
  })

}
