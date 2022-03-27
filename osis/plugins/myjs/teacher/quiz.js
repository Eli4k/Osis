var toolbarOptions = [
    [{ 'font': [] }],
    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'align': [] }],
    [{ 'header': [] }],
    ['bold', 'italic', 'underline', 'strike','link','image','video'],
    ['blockquote', 'code-block'],
    [{'list':'ordered'},{'list':'bullet'}],
    [{ 'direction': 'rtl' }]
  ];

  var options = {
    debug: 'info',
    modules: {
      toolbar:toolbarOptions
    },
    placeholder: 'Your question goes here....',
    theme: 'snow'
  };

  var setup_edit = document.querySelector("button[name=setup_edit]");
  var setup_save = document.querySelector("button[name=setup_save]");
  var submit = document.querySelector("input[name=submit]");
  var quiz_form = document.querySelector("#quiz-form");
  var response_div = document.querySelector(".req_response");
  var add_btn = document.querySelector("#add_qst");
  var editors = [];
  var hours = document.querySelector("input[name=hours]");
  var minutes = document.querySelector("input[name=minutes]");
  var saved;
  var c_id =  document.querySelector(".level");
  var term_id= document.querySelector(".term");
  var yr_id= document.querySelector(".ac_year");
  var s_id = document.querySelector(".stream");
  var subject = document.querySelector(".subject");
  var modal = document.querySelector("#myModal");
  var nodes = document.querySelector("#settings_form").getElementsByTagName('*');
  var ex_num = $("#quiz_num");

hours.onkeyup = function(){
  if(hours.value > hours.max)
  {
    hours.value = 00;
  }
}

minutes.onkeyup = function(){
  if(minutes.value > minutes.max)
  {
    minutes.value = 00;
  }
}
add_btn.onclick = additionalFields;

// Create Additional Fields
function additionalFields(){
  var control_group = document.createElement("div");
  control_group.className="control-group";
  var set = document.createElement("div");
  set.className="set";
  var toolbar = document.createElement("div");
  toolbar.id="toolbar";
  var new_editor = document.createElement("div");
  new_editor.id="editor";
  new_editor.className = "question";

  control_group.appendChild(set);
  set.appendChild(toolbar);
  set.appendChild(new_editor);

  for(var i=1; i<=4; i++){
    var input = document.createElement("input");
    var br= document.createElement("br");
    input.className ="options";
    input.type="text";
    input.placeholder = "Option "+i;
    input.name = "option"+i;
    set.appendChild(input);
    set.appendChild(br);
  }
  var answer = document.createElement("input");
  answer.className ="answer";
  answer.placeholder = "Enter your answer here";
  answer.name="answer";
  set.appendChild(answer);
  quiz_form.insertBefore(control_group, quiz_form.lastChild.previousSibling);

   editor  = new Quill(new_editor, options);

   editors.push(editor);

}
// console.log(quiz_form.lastChild.previousSibling);


// Disable settings
setup_save.onclick = function(){
  // Quiz Number
  $.ajax({
    url:"../../php/teachers/quiz/quiz_num.php",
    type:"POST",
    dataType: "JSON",
    data: {subject: subject.value, term: term_id.value,
            c_id:c_id.value, yr:yr_id.value, stream:s_id.value,
            user: curr_id },
    success: function(data){
    document.querySelector("#ex_num").innerHTML = data.output;
    ex_num.value = data.output;
    }

  });
  // End

  for(var i = 0; i < nodes.length; i++){
     nodes[i].disabled = true;
  }
  saved = true;
}
// End

// Enable Settings
setup_edit.onclick = function(){
  var nodes = document.querySelector("#settings_form").getElementsByTagName('*');
  for(var i = 0; i < nodes.length; i++){
     nodes[i].disabled = false;
  }
  saved = false;
}
// End


// Post questions to the database
quiz_form.onsubmit = function(e){
     e.preventDefault();


     if (isNaN(subject.value)) {
       alert("Select a Subject to proceed");
       return false;
   }

     if (isNaN(s_id.value)) {
       alert("Select the Stream in the Settings to proceed ");
       return false;
     }

     if (isNaN(yr_id.value)) {
       alert("Select the Academic year in your settings to proceed ");
       return false;
     }

     if (isNaN(c_id.value)) {
       alert("Select a Class in settings to proceed ");
       return false;
     }

     if(isNaN(term_id.value)){
       alert("Select an Academic Term in settings to proceed")
     }

     var hrsToSec = Math.floor(hours.value * 60 * 60);
     var minToSec = Math.floor(minutes.value * 60);
     var duration = 1000*(hrsToSec+minToSec);

    var question_set = quiz_form.querySelectorAll(".set");
    var set = new Array();
    if(question_set.length < 1)
    {
      alert("Sorry. There are no questions to submit. \n Click on Add A Question to add questions.");
      return false;
    }else{
      for(var i=0; i<question_set.length; i++){

        set[i]={
          question: editors[i].root.innerHTML,
          option_a: question_set[i].querySelectorAll(".options")[0].value,
          option_b: question_set[i].querySelectorAll(".options")[1].value,
          option_c: question_set[i].querySelectorAll(".options")[2].value,
          option_d: question_set[i].querySelectorAll(".options")[3].value,
          answer: question_set[i].querySelector(".answer").value,
          c_id: c_id.value,
          term_id: term_id.value,
          yr_id: yr_id.value,
          duration: duration,
          teacher_id: curr_id,
          sub_id: subject.value,
          s_id: s_id.value,
          ex_id: ex_num.value
          }
        }

        var formData = new FormData();
        formData.append("set", JSON.stringify(set));

        if (!saved){
          var setup_box = document.querySelector(".span4").querySelector(".widget-box");
          setup_box.focus();
          alert("Please save your Quiz settings");
            console.log("Saved is: "+saved);
            return false;
        }else{
          $.ajax({
            url: "../../php/teachers/quiz/set_quiz.php",
            type:"post",
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function(){
              response_div.innerHTML = '<div class="alert alert-info">'+
                        '<strong>Please Wait...</strong>'+
                        '<button class="close" data-dismiss="alert">x</button>'+
                        'Uploading Questions to database.'+
                        '</div>';
            },
            data: formData,
            success: function(data)
            {
              response_div.innerHTML = data.output;
              setTimeout(function(){
                response_div.style.display= "none";
              }, 5000);
            }
          });
        }

  }


}
// End
