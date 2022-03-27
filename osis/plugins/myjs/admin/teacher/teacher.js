var form = document.querySelector(".form-horizontal");
var fname = document.querySelector("input[name=first]");
var other_name = document.querySelector("input[name=other]");
var lname = document.querySelector("input[name=last]");
var dob = document.querySelector("input[name=dob]");
var gender = document.querySelector("#gender");
var m_stat = document.querySelector("#m_stat");
var e_date = document.querySelector("input[name=e_date]");
var contact = document.querySelector("input[name = contact]");
var email = document.querySelector("input[name = email]");
var ass_class = document.querySelector('.ass_class');
var nav_link = document.querySelectorAll(".nav-tabs li");
var tab_pane = document.querySelectorAll(".tab-content > div");
var buttons = document.querySelectorAll("#add  button");
var select = document.querySelectorAll("#view  select");

var ass_sub = document.querySelector('.ass_sub');
var sub_array=[];
var class_array =[];

load_teacher_info();
load_class_assignment();
load_sub_assignment();
load_stream();
load_class();

buttons.forEach(function(button){button.style.display = "none";});


// Add Teacher Info
	form.onsubmit = function(event){
		event.preventDefault();

		var classes = ass_class.querySelectorAll("input:checked");
		classes.forEach(function(level){
			class_array.push(level.value);
		});

		// Eliminate class duplicates
		var class_duplicates = Array.from(new Set(class_array));
		alert(class_duplicates.toString());
		// End


		var subs = ass_sub.querySelectorAll("input:checked");
		subs.forEach(function(sub){
			sub_array.push(sub.value);
		});

		// Eleminate subject duplicates
		var sub_duplicates = Array.from(new Set(sub_array));
		alert(sub_duplicates.toString());
		// End

		if(sub_duplicates.length < 1 || class_duplicates.length < 1){
			alert("Please assign a class or a subject for the teacher");
			return false;}
		else{
			$.ajax({
				url: "../../php/admin/admin_teachers/insert.php",
				type: "POST",
				data: {fname:fname.value, other_name:other_name.value, lname:lname.value, dob:dob.value,
					 			gender:gender.value, m_stat:m_stat.value, e_date:e_date.value, contact:contact.value,
								email:email.value, subs: sub_duplicates.toString(), level: class_duplicates.toString()},
				dataType:"json",
				success:function(data){
					alert(data.insert_response);
					sub_duplicates.length = 0;
					class_duplicates.length = 0;
					ass_sub.length = 0;
					ass_class.length = 0;
					form.reset();
					load_teacher_info();
				}
			});

		}
	};
// End

// All checkbox
var super_checkbox = document.getElementById("super_checkbox");
var all = document.getElementsByClassName("this_teacher_select");
super_checkbox.onclick= function(){
		if(super_checkbox.checked == true){
				for(var i=0; i<all.length; i++){
					all[i].checked = true;
				}
		}else{
			for(var i=0; i<all.length; i++){
				all[i].checked = false;
			}
		}

}
// End


// Update content
	buttons[0].onclick = function(event){
		event.preventDefault();

		var classes = ass_class.querySelectorAll("input:checked");
		classes.forEach(function(level){
			class_array.push(level.value);
		});

		// Eleminate duplicates
		var class_duplicates = Array.from(new Set(class_array));
		// End

		var subs = ass_sub.querySelectorAll("input:checked");
		subs.forEach(function(sub){
			sub_array.push(sub.value);
		});

		// Eleminate duplicates
		var sub_duplicates = Array.from(new Set(sub_array));
		// End

		if(class_array.length < 1 || sub_array.length < 1){
			alert("Please assign a class or a subject for the teacher");
			return false;}
		else{
			$.ajax({
				url: "../../php/admin/admin_teachers/edit.php",
				type: "POST",
				data: {fname:fname.value, other_name:other_name.value, lname:lname.value, dob:dob.value,
					 			gender:gender.value, m_stat:m_stat.value, e_date:e_date.value, contact:contact.value,
								email:email.value, subs: sub_duplicates.toString(), level: class_duplicates.toString()
							},
				dataType:"json",
				success:function(data){
					form.reset();
					alert(data.response);
					buttons.forEach(function(button){button.style.display = "none";});
					document.querySelector("input[type=submit]").style.display="inline";
					load_teacher_info();
				}
			});

		}
	};
// End

// Cancel Edit
buttons[1].onclick = function(event){
	event.preventDefault();
	form.reset();
	var classes = ass_class.querySelectorAll("input:checked");
	classes.forEach(function(level){
		level.checked = false;
	});
	var subs = ass_sub.querySelectorAll("input:checked");
	subs.forEach(function(sub){
	sub.checked = false;
	});

	buttons.forEach(function(button){
		button.style.display = "none";
	});

	form.querySelector("input[type=submit]").style.display = "block";
}
// End








// Delete teacher Info
function delete_data(event){
	let id = event.target.dataset.del;
	let element = event.target;
	let td,fullname;

	td = element.parentElement.parentElement.querySelectorAll("td");
	fullname = td[1].innerHTML;

		if (confirm("Are you sure you want to delete records of "+fullname+"?")) {
			$.ajax({
				url: "../../php/admin/admin_teachers/crudTeachers.php",
				type: "GET",
				data:{del_id:id},
				dataType:"json",
				success: function(data){
					alert(data.cmd_response);
					load_teacher_info();
				}
			})
		}
	}
//  End.

// Edit Teacher Info
function edit_data(event){
	let id = event.target.dataset.edit;
	let element = event.target;

	tab_pane.forEach(function(tab){
		if(tab.id == "add"){
			tab.classList.add("active");
			nav_link[1].classList.add("active");
		}else{
			tab.classList.remove("active");
			nav_link.forEach(function(nav){
				nav.classList.remove("active");
			})
		}
	});

	$.ajax({
		url: '../../php/admin/admin_teachers/edit_teacher.php',
		type:'POST',
		dataType: 'JSON',
		data: {id: id},
		success: function(data){
			document.querySelector("input[type=submit]").style.display="none";
		buttons.forEach(function(button){button.style.display = "inline";});
			fname.value = data.fname;
			lname.value = data.lname;
			other_name.value = data.mid_name;
			dob.value = data.dob;
			m_stat.options[m_stat.selectedIndex].text = data.m_stat;
			m_stat.options[m_stat.selectedIndex].value = data.m_stat;
			gender.options[gender.selectedIndex].text = data.gender;
			gender.options[gender.selectedIndex].value = data.gender;
			contact.value = data.contact;
			email.value = data.email;
			e_date.value = data.emp_date;
			var array_class = data.array_class.split(",");
			var array_sub = data.array_sub.split(",");

			var all = ass_class.querySelectorAll("input[type=checkbox]");
			array_class.forEach(function(curr_class){
				all.forEach(function(input){
					if(input.value == curr_class){input.checked = true;}
				})
			})

			var all_sub = ass_sub.querySelectorAll("input[type=checkbox]");
			array_sub.forEach(function(sub){
				all_sub.forEach(function(input){
					if(input.value == sub){input.checked = true;}
				})
			})
		}
	})
}
// End

// Load Class for assignment
function load_class_assignment(){
	$.ajax({
		url: "../../php/admin/admin_teachers/classes.php",
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			document.querySelector(".ass_class").innerHTML =  data.class;
		}
	})
}
// End

// Load Subject for assignment
function load_sub_assignment(){
	$.ajax({
		url: "../../php/admin/admin_teachers/subject.php",
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			document.querySelector(".ass_sub").innerHTML =  data.sub;
		}
	})
}
// End


// Function to load teacher info
	function load_teacher_info(){
		$.ajax({
			url:"../../php/admin/admin_teachers/load_teachers.php",
			type:"POST",
			dataType: "JSON",
			success: function(data){
				document.querySelector(".tbody").innerHTML=data.teacher_info;
				}
			});
	}
// End


// Type Filter
document.querySelector('input[name="search"]').onkeyup = function(event){
	var x = event.target.value;
	if (x !== ''){
			$.ajax({
			url:"../../php/admin/admin_teachers/filter.php",
			data:{x:x},
			dataType:"json",
			type:"GET",
			success: function(data){
			document.querySelector("tbody").innerHTML = data.filter;
			}
		});
	}	else
		{
			load_teacher_info();
		}

}
// End

// Filter on go button
document.querySelector("#go").onclick = function(event){
	event.preventDefault();

	if(select[0].value < 1 && select[1].value < 1){
		alert("Select a Class or a Subject to begin search");
		return false;
	}else{
		$.ajax({
			url: '../../php/admin/admin_teachers/fltr.php',
			data: {level: select[0].value, sub: select[1].value},
			type: 'GET',
			dataType: 'JSON',
			success: function(data){
				document.querySelector("tbody").innerHTML = data.fltr;
			}
		})
	}
};
// End

// Stream
function load_stream(){
  $.ajax({
    url:"../../php/teachers/myclass/load_data/stream.php",
    type:"POST",
    dataType:"json",
    success: function(data){
     select[1].innerHTML = data.s_name;
    }
  })
}
// End

// Stream
function load_class(){
  $.ajax({
    url:"../../php/teachers/myclass/load_data/class.php",
    type:"POST",
    dataType:"json",
    success: function(data){
     select[0].innerHTML = data._class;
    }
  })
}
// End
