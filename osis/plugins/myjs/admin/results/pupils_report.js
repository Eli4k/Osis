var tab_pane = [];
tabs();
var slip_div = null	;
var students = emails =[];


// Load tabs
function tabs(){
	$.ajax({
		url: '../../php/admin/terminal_reports/tabs.php',
		dataType:'JSON',
		type: 'POST',
		// async: false,
		success: function(data){
		document.querySelector(".widget-box").innerHTML = data.output;
		var tabs = document.querySelectorAll(".nav-tabs li");
		var pane = document.querySelectorAll(".tab-pane");
		tabs[0].classList.add("active");
		pane[0].classList.add("active");
		for(i=0; i<pane.length; i++){tab_pane[i] = pane[i].innerHTML;}
		// tab_pane;
		slips(pane);
		}
	});
}
// End

// Get Class Slips
function slips(elements){
	$.ajax({
		url: '../../php/admin/terminal_reports/result_test.php',
		dataType: 'JSON',
		type: 'POST',
		//async: false,
		success: function(data){
		for(i=0; i<elements.length; i++){elements[i].querySelector(".span12").innerHTML = data.div[i];}
		load_stream();
		}

	});
}
// End

// View Result per student
function viewSlip(event){
		var element = event.target;
		slip_div = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.nextElementSibling;
		var student_id = element.dataset.id;
		$.ajax({
			url:'../../php/admin/terminal_reports/view_results.php',
			type: 'POST',
			data: {id: student_id},
			dataType: 'JSON',
			success: function(data){
				slip_div.innerHTML = data.output;
			}
		})
	}
// End

// Publish Indi
function indiPublish(event){
	var student_id = event.target.dataset.publish;
	var email = event.target.dataset.email;
	students.push(student_id);
	emails.push(email);
	$.ajax({
		url:'../../php/admin/terminal_reports/admin_publish.php',
		type: 'POST',
		dataType: 'JSON',
		data: {id: students, email: emails},
		success: function(data){
			alert(data.msg);
		}
	});
}
// End

// Select All
function select_all(event){
	var element = event.target;
	var table = element.parentElement.parentElement.parentElement.parentElement;
	var checkboxes = table.querySelectorAll(".child_checkbox");
	if(element.checked == true){
		for(i=0; i<checkboxes.length; i++){
			checkboxes[i].checked = true;
			students[i] = checkboxes[i].value;
		}
	}else{for(i=0; i<checkboxes.length; i++){
		checkboxes[i].checked = false;
		students.pop();
	}}
}
// End

// Publish All
function publish_all(event){
	var element = event.target.parentElement.parentElement;
	var checkbox_child = element.querySelectorAll(".child_checkbox");
	var emails = [];
	checkbox_child.forEach(function(checkbox){
		if(checkbox.checked){
			students.push(checkbox.value);
			emails.push(checkbox.id);
		}
	});
	if(students.length < 1){
		alert("Oops select a student to continue");
		return false;
	}else{
		$.ajax({
			url: '../../php/admin/terminal_reports/admin_publish.php',
			type: 'POST',
			dataType: 'JSON',
			data: {id: students, email: emails},
			success: function(data){
				alert(data.msg);
			}
		})
	}
}
// End

// Stream
function load_stream(){
 let streams = document.querySelectorAll(".streams");
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

function view_per_stream(event){
	let select = event.target;
	let stream = select.options[select.selectedIndex].value;
	let c_id = event.target.id;
	let tbody = event.target.parentElement.parentElement.querySelector("tbody");
	$.ajax({
		url: '../../php/admin/terminal_reports/result_by_stream.php',
		type: 'POST',
		dataType: 'JSON',
		data: {stream: stream, c_id: c_id},
		success: function(data){
			tbody.innerHTML = data.output;
		}
	})
}
