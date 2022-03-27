var editor_tab = document.querySelector("#assessment_editor");
var records = [];
var search_btn = document.querySelector("#go");
var options = [];
var class_total = 0;

function edit_assessment(event){
  navtabs[1].classList.remove("active");
  navtabs[0].classList.add("active");
  tab2.classList.remove("active");
  tab1.classList.add("active");
   var btn = event.target;
   let sub_id = btn.dataset.sub;
   let yr_id = btn.dataset.yr;
   let c_id = btn.dataset.level;
   let test_id = btn.dataset.test;
   let s_id = btn.dataset.stream
   let ex = btn.dataset.ex;
   let term_id = btn.dataset.term;
  $.ajax({
    url:'../../php/teachers/myclass/generate_assessment/load_assessment_test.php',
    dataType:'JSON',
    data:{sub_id: sub_id, yr_id: yr_id, c_id:c_id, test_id: test_id, tid: tid, ex:ex, s_id:s_id, term_id: term_id, user_id: user_id},
    type: 'POST',
    success: function(data){
      document.querySelector(".unpublished").style.display="none";
      editor_tab.querySelector(".assmt_editor_content").innerHTML = data.output;
    }

  })
}
function update_class_score(event){
  var btn = event.target;
  let sub_id = btn.dataset.sub;
  let yr_id = btn.dataset.yr;
  let c_id = btn.dataset.level;
  let test_id = btn.dataset.test;
  let s_id = btn.dataset.stream
  let ex = btn.dataset.ex;
  let term_id = btn.dataset.term;
  let widget_box = btn.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
  let tbody = btn.parentElement.parentElement.parentElement.parentElement.querySelectorAll("tbody tr");
  let total = widget_box.querySelector("#score");
  let scalar = widget_box.querySelector("#scaler");

  if(total.value ==="0" || total.value ===""){
    alert("Select a value for total score");
    return false;
  }
  else if (scalar.value === "0") {
    alert("Select a scale number");
    return false;
  }else{
    tbody.forEach(function(tr){
      records.push({
        tid: tid,
        score_id: tr.querySelectorAll("td")[0].dataset.class_score,
        sid: tr.querySelectorAll("td")[2].querySelector("input").dataset.sid,
        score: tr.querySelectorAll("td")[2].querySelector("input").value,
        scaled_score: tr.querySelectorAll("td")[3].querySelector("input").value,
        scalar: scalar.value,
        total: total.value,
        ex: ex
      })
    });

    $.ajax({
      url: '../../php/teachers/myclass/generate_assessment/update.php',
      data: {records: JSON.stringify(records)},
      dataType: 'JSON',
      type: 'POST',
      success: function(data){
          alert(data.output.success);
          console.log(data.output.error);
          records.length = 0;
          editor_tab.style.display = "none";
          document.querySelector(".unpublished").style.display="inline";
      }
    });
  }
}


function remove_assessment(event){
  let btn = event.target;
  let sub_id = btn.dataset.sub;
  let yr_id = btn.dataset.yr;
  let c_id = btn.dataset.level;
  let test_id = btn.dataset.test;
  let s_id = btn.dataset.stream
  let ex = btn.dataset.ex;
  let term_id = btn.dataset.term;
  $.ajax({
    url:'../../php/teachers/myclass/generate_assessment/remove.php',
    dataType: 'JSON',
    type: 'POST',
    data: {sub_id: sub_id, yr_id:yr_id, c_id:c_id, test:test_id, s_id:s_id, ex:ex, term:term_id, tid:tid},
    success: function(data){
      alert(data.output.error);
      load_general_assessment();
    }
  });
}

// Filter search criteria
search_btn.addEventListener("click", function(){
const quick_actions = document.querySelector(".quick-actions_homepage");
    const c_id = quick_actions.querySelector(".level").value;
    const sub = quick_actions.querySelector(".subject").value;
    const term = quick_actions.querySelector(".term").value;
    const stream = quick_actions.querySelector(".stream").value;
    const yr_id = quick_actions.querySelector(".ac_year").value;


  $.ajax({
    url: '../../php/teachers/myclass/generate_assessment/assessment_filter.php',
    type: 'POST',
    data: {c_id: c_id, tid: tid, sub: sub, term: term, stream: stream, yr: yr_id},
    dataType: 'JSON',
    success: function(data){
      	document.querySelector(".assessment_generator").innerHTML = data.output;
        console.log(data.err);
    }
  })

});
// End

// Record Class Score //
function generateCustom(event){
  let btn = event.target;
  let sub = btn.dataset.sub;
  let yr = btn.dataset.yr;
  let c_id = btn.dataset.c_id;
  let stream = btn.dataset.stream
  let term = btn.dataset.term;

  $.ajax({
    url: '../../php/teachers/myclass/generate_assessment/recordCustom.php',
    type: 'POST',
    data: {c_id: c_id, tid: tid, sub: sub, term: term, stream: stream, yr: yr, user_id: user_id},
    dataType: 'JSON',
    success: function(data){
        load_general_assessment();
        alert(data.error.error);
        // btn.value = data.error.total;
        console.log(data.final.length);
        console.log(data.final);
        console.log(data.error.insert_success);

    }
  })

}
