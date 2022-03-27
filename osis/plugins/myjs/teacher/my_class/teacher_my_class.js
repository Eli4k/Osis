var response_div = document.querySelector("#request_response");
var data_loader = document.querySelectorAll("input[name=setup]");
var tab1 = document.querySelector("div > #tab1");
var tab2 = document.querySelector("div > #tab2");
var span10 = document.querySelectorAll('.span10');
var exam_half, class_scr=0;
var data_id = [];
var navtabs = document.querySelectorAll(".nav-tabs li");


load_general_assessment();

// edit
function edit(event){
	var element = event.target;
	var attr = event.target.dataset.edit;
	var tr = element.parentElement.parentElement
	var cs_tag = tr.querySelector(".class_score");
	var ex_tag = tr.querySelector(".exam_score");
	ex_tag.removeAttribute("disabled");
	cs_tag.removeAttribute("disabled");

	tr.querySelector(".save_btn").style.display="inline";
	tr.querySelector(".cancel_btn").style.display="inline";
	element.style.display="none";
}
// Cancel

// Delete
function  cancel(event){
	var element = event.target;
	var id = event.target.dataset.cancel;
	var tr = event.target.parentElement.parentElement;
	var cs_tag = tr.querySelector(".class_score");
	var ex_tag = tr.querySelector(".exam_score");
	console.log(id);
	$.ajax({
		url: '../../php/teachers/myclass/empty_table/undo.php',
		type: 'POST',
		dataType: 'json',
		data: {id: id},
		success: function(data){
			tr.querySelector(".class_score").value = data.class_score;
			tr.querySelector(".exam_score").value = data.ex_100;
			tr.querySelector(".exam_score_50").value = data.ex_50;
			tr.querySelector(".overall").value = data.ovscr;

			ex_tag.setAttribute("disabled" , "true");
			cs_tag.setAttribute("disabled", "true");

			tr.querySelector(".edit_btn").style.display="inline";
			tr.querySelector(".save_btn").style.display="none";
			element.style.display="none";
		}
	})
	}
// End

// Save changes
function save(event){
	var element = event.target;
	var id = event.target.dataset.save;
	var tr = event.target.parentElement.parentElement;
	var cs_tag = tr.querySelector(".class_score");
	var ex_tag = tr.querySelector(".exam_score");
	var ex_50  = tr.querySelector(".exam_score_50");
	var overall = tr.querySelector(".overall");

	$.ajax({
		url: '../../php/teachers/myclass/edit.php',
		type: 'POST',
		dataType: 'json',
		data: {id: id, class_score:cs_tag.value, exam_score: ex_tag.value, ex_50:ex_50.value, overall:overall.value},
		success: function(data){
			tr.querySelector(".class_score").value = data.class_score;
			tr.querySelector(".exam_score").value = data.ex_100;
			tr.querySelector(".exam_score_50").value = data.ex_50;
			tr.querySelector(".overall").value = data.ovscr;

			ex_tag.setAttribute("disabled" , "true");
			cs_tag.setAttribute("disabled", "true");

			element.style.display="none";
			tr.querySelector(".cancel_btn").style.display="none";
			tr.querySelector(".edit_btn").style.display="inline";
		}
	})
}

// Select All
function select_all(event){
	var check_box = event.target;
	var table = check_box.parentElement.parentElement.parentElement.parentElement;
	var this_box = table.querySelectorAll(".inc_thisBox");
	if(check_box.checked){
		for(var i=0; i<this_box.length; i++){
			this_box[i].checked = true;
		}
	}else{
		for(var i=0; i<this_box.length; i++){
			this_box[i].checked = false;
		}
	}
}
// End

// All Publish
function publish_all(event){
	var element = event.target;
	var table = element.parentElement.parentElement.parentElement.parentElement;
	var all_check_box = table.querySelectorAll(".inc_thisBox");
	for(var i=0; i<all_check_box.length; i++){
		if(all_check_box[i].checked = true){
			tr = all_check_box[i].parentElement.parentElement;
			data_id[i]={
					id: all_check_box[i].id,
					class_score: tr.querySelector(".class_score").value,
					ex_score:  tr.querySelector(".exam_score").value,
					ex_50: tr.querySelector(".exam_score_50").value,
					ovscr: tr.querySelector(".overall").value,
					teacher:user_id,
					term:tab1.querySelector(".term").value,
					subject:tab1.querySelector(".subject").value,
					ac_year:tab1.querySelector(".ac_year").value,
					stream:tab1.querySelector(".stream").value,
					level:tab1.querySelector(".level").value
			}
		}
	}

	console.log(data_id);
	$.ajax({
		url:'../../php/teachers/myclass/publish.php',
		dataType:'JSON',
		data:{data:JSON.stringify(data_id)},
		cache: false,
		type:'POST',
		success: function(data){
			response_div.innerHTML = data.output;
		}
	})
}
// End

// List students
data_loader[0].onclick = function(){
	var test = tab1.querySelector(".test").value;
	var level = tab1.querySelector(".level").value;
	var stream = tab1.querySelector(".stream").value;
	var ac_year = tab1.querySelector(".ac_year").value;
	var term = tab1.querySelector(".term").value;
	var subject = tab1.querySelector(".subject").value;
		if(test.value == 0){
			alert("Please Select a test type");
			return false;
		}
		if(level.value==0){
			alert("Please Select a Class");
			return false;
		}
		if(stream.value==0){
			alert("Please Select a Stream");
			return false;
		}
		if(term.value==0){
			alert("Please Select Academic Term");
			return false;
		}
		if(ac_year.value==0){
			alert("Please Select an Academic Year");
			return false;
		}
		else{
			if(test !== "6"){
				$.ajax({
					url:'../../php/teachers/myclass/empty_table/students_test.php',
					type:'POST',
					dataType:'JSON',
					data: {level: level, stream:stream, test:test, teacher: curr_id, yr: ac_year, term: term},
					success: function(data){
							span10[0].innerHTML = data.output;
					}
				});

			}else{
				$.ajax({
					url:'../../php/teachers/myclass/empty_table/list_student.php',
					type:'POST',
					dataType:'JSON',
					data: {level: level, stream:stream, test:test},
					success: function(data){
							span10[0].innerHTML = data.output;
					}
				});
			}
		}

}
// End

// List students
data_loader[1].onclick = function(){
	// var test = tab2.querySelector("#test").value;
	var level = tab2.querySelector(".level").value;
	var stream = tab2.querySelector(".stream").value;
	var ac_year = tab2.querySelector(".ac_year").value;
	var term = tab2.querySelector(".term").value;
	var subject = tab2.querySelector(".subject").value;
		// if(test.value == 0){
		// 	alert("Please Select a test type");
		// 	return false;
		// }
		if(level.value==0){
			alert("Please Select a Class");
			return false;
		}
		if(stream.value==0){
			alert("Please Select a Stream");
			return false;
		}
		if(term.value==0){
			alert("Please Select Academic term");
			return false;
		}
		if(ac_year.value==0){
			alert("Please Select an Academic Year");
			return false;
		}
		else{
			// console.log(level);
			$.ajax({
				url:'../../php/teachers/myclass/empty_table/existing_data.php',
				type:'POST',
				dataType:'JSON',
				data: {level:level, stream:stream, term:term, yr:ac_year, subject:subject, teacher:user_id},
				success: function(data){
						span10[1].innerHTML = data.output;
						cancel_btns = tab2.querySelectorAll(".cancel_btn");
						save_btns = tab2.querySelectorAll(".save_btn");

						cancel_btns.forEach(function(btn){
							btn.style.display="none";
						});

						save_btns.forEach(function(btn){
							btn.style.display="none";
						});
				}
			})
		}

}
// End


// Exam 50 percent
function getExam50(event){
	var element = event.target;
	var tr = element.parentElement.parentElement;
	var exam = tr.querySelector(".exam_score_50");
	exam.value = element.value/2;
	exam_half = exam.value;

	if(exam.value > 100){
		alert("Sorry exam score cannot be more than 100%");
		return false;
	}else{
	var overall = tr.querySelector(".overall");
	overall.value = +exam_half + +class_scr;
	}

}
// End

// Class Score
function getClassScore(event){
	var element = event.target;
	var tr = element.parentElement.parentElement;
	var class_score = tr.querySelector(".class_score");
	class_score.value = element.value;
	class_scr =  class_score.value;

	var new_ex = tr.querySelector(".exam_score_50").value;

	if(class_score.value > 50){
		alert("Sorry Class score cannot be more than 50%");
		return false;
	}else{
		var overall = tr.querySelector(".overall");
	overall.value = +new_ex + +class_scr;
	}


}
// End


// Save All
function save_all(event){
	var element = event.target;
	var table = element.parentElement.parentElement.parentElement.parentElement;
	var all_check_box = table.querySelectorAll(".inc_thisBox");
	for(var i=0; i<all_check_box.length; i++){
			if(all_check_box[i].checked = true){
				tr = all_check_box[i].parentElement.parentElement;
				data_id[i]={
						id: all_check_box[i].id,
						assessment_id: all_check_box[i].dataset.assessment,
						class_score: tr.querySelector(".class_score").value,
						ex_score:  tr.querySelector(".exam_score").value,
						ex_50: tr.querySelector(".exam_score_50").value,
						ovscr: tr.querySelector(".overall").value,
						teacher:user_id,
						term:tab2.querySelector(".term").value,
						subject:tab2.querySelector(".subject").value,
						ac_year:tab2.querySelector(".ac_year").value,
						stream:tab2.querySelector(".stream").value,
						level:tab2.querySelector(".level").value
				}
			}

	}

	$.ajax({
		url:'../../php/teachers/myclass/save_all.php',
		dataType:'JSON',
		data:{data_info:JSON.stringify(data_id)},
		type:'POST',
		success: function(data){
			alert(data.output);
			var all_input =  table.querySelectorAll("input[type=number]");
			all_input.forEach(function(number_box){
				number_box.setAttribute("disabled", "true");
			});

			cancel_btns = tab2.querySelectorAll(".cancel_btn");
			save_btns = tab2.querySelectorAll(".save_btn");
			edit_btns = tab2.querySelectorAll(".edit_btn");

			cancel_btns.forEach(function(btn){
				btn.style.display="none";
			});

			save_btns.forEach(function(btn){
				btn.style.display="none";
			});

			edit_btns.forEach(function(btn){
				btn.style.display="inline";
			});
		}
	})
}
// End

// Scale down test scores
function calculate_scalar_mark(event){
	var element = event.target;
	var score = event.target.value;
	var widget_box = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
	var total_score = widget_box.querySelector("#score");
	var scalar_selector = widget_box.querySelector("#scaler");
	var scalar_input = element.parentElement.nextElementSibling.querySelector("input");

	if(total_score.value < 1){alert("Enter value for Total Score");}
	if(scalar_selector.value < 1){alert("Select scaling percentage");}

	scalar_input.value = (element.value/total_score.value)*scalar_selector.value;
}
// End

// Add to class_score
function record_class_score(event){
	let records = [];
	let record_btn = event.target;
	let table = record_btn.parentElement.parentElement.parentElement.parentElement;
	let widget_div = record_btn.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
	let rows= table.querySelectorAll("tbody tr");

	if(widget_div.querySelector("#score").value === ""){
		alert("Enter A value for total score");
		widget_div.querySelector("#score").focus();
		return false;
	}
	else if (widget_div.querySelector("#scaler").value === "0") {
		alert("Select a Scale Percentage");
		widget_div.querySelector("#scaler").focus();
		return false;
	}else{
		rows.forEach(function(row){
						records.push({
								student_id: row.querySelectorAll("td")[0].id,
								score: row.querySelector(".score").value,
								scale_percentage: row.querySelector(".score_scale").value,
								total_score: widget_div.querySelector("#score").value,
								scalar: widget_div.querySelector("#scaler").value,
								teacher:tid,
								test: tab1.querySelector(".test").value,
								term:tab1.querySelector(".term").value,
								subject:tab1.querySelector(".subject").value,
								ac_year:tab1.querySelector(".ac_year").value,
								stream:tab1.querySelector(".stream").value,
								level:tab1.querySelector(".level").value,
								ex_id: widget_div.querySelectorAll("h5")[2].dataset.ex_num
						});
					});

					$.ajax({
						url:'../../php/teachers/myclass/generate_assessment/insert.php',
						type: 'POST',
						dataType:'JSON',
						data: {records: JSON.stringify(records)},
						success: function(data){
							alert(data.message.error);
							load_general_assessment();
								rows.forEach(function(row){
								row.querySelector(".score").value = "";
								row.querySelector(".score_scale").value = "";
							})
						}
					});
	}




	 }
// End

// Load General Assessment
function load_general_assessment(){
	$.ajax({
		url: '../../php/teachers/myclass/generate_assessment/assessment_general.php',
		data: {tid: tid},
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			document.querySelector(".assessment_generator").innerHTML = data.output;
	}




		})
}
// End
