var sub = document.querySelector(".quick-actions_homepage > #sub");
var level = document.querySelector(".quick-actions_homepage > #level");
var yr = document.querySelector(".quick-actions_homepage > #yr");
var term = document.querySelector(".quick-actions_homepage > #term");
var go_btn = document.querySelector(".quick-actions_homepage > #search_btn");

load_class();
subject();
year();
term_id();

function subject(){
  $.ajax({
    url: "../../php/teachers/result/subject.php",
    dataType: 'JSON',
    type: 'POST',
    data: {user: user_id},
    success: function(data){
      sub.innerHTML = data.output;
    }
  });
}

function load_class(){
  $.ajax({
    url: "../../php/teachers/result/class.php",
    dataType: 'JSON',
    type: 'POST',
    data: {user: user_id},
    success: function(data){
      level.innerHTML = data.output;
    }
  });
}

function year(){
  $.ajax({
    url: "../../php/teachers/result/year.php",
    dataType: 'JSON',
    type: 'POST',
    data: {user: user_id},
    success: function(data){
      yr.innerHTML = data.output;
    }
  });
}

function term_id(){
  $.ajax({
    url: "../../php/teachers/result/term.php",
    dataType: 'JSON',
    type: 'POST',
    data: {user: user_id},
    success: function(data){
      term.innerHTML = data.output;
    }
  });
}

go_btn.onclick = function(e){
  $.ajax({
    url: '../../php/teachers/result/load_results.php',
    type: 'POST',
    dataType: 'JSON',
    data: {sub: sub.value, level:level.value, term:term.value, yr:yr.value, user: user_id},
    success: function(data){
      document.querySelector(".result").innerHTML = data.output;
    }
  })
}
