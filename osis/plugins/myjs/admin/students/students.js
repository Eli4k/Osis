var form = document.querySelector(".form-horizontal");
var student_id = document.querySelector("input[name=student_id]");
var fname = document.querySelector("input[name=first]");
var other = document.querySelector("input[name=other]");
var lname = document.querySelector("input[name=last]");
var dob = document.querySelector("input[name=dob]");
var adm = document.querySelector("input[name=adm]");
var gender = document.querySelector("#gender");
var contact = document.querySelector("input[name = contact]");
var email = document.querySelector("input[name = email]");
var adm = document.querySelector("input[name=adm]");
var nav_link = document.querySelectorAll(".nav-tabs li");
var tab_pane = document.querySelectorAll(".tab-content > div");
var add_buttons = document.querySelectorAll("#add  button");
var hidden_tag = document.querySelector("input[type=hidden]");
var printBtn = document.querySelector("#print");
var data_id = [];
var add_select = document.querySelectorAll("#add select");
var view_select = document.querySelectorAll("#view select");
var file_div = document.querySelector("#multi_add");
var upload_btn = file_div.querySelector("button");



load_students_info();
load_class();
load_streams();


add_buttons.forEach(function(button){button.style.display = "none";});


//Add Students Info
	form.onsubmit = function(event){
		event.preventDefault();

			$.ajax({
				url: "../../php/admin/admin_students/insert.php",
				type: "POST",
				data: {fname:fname.value, other:other.value, adm:adm.value,
							 lname:lname.value, dob:dob.value, contact:contact.value,
							 entry: add_select[2].options[add_select[2].selectedIndex].text,
							 level: add_select[3].options[add_select[3].selectedIndex].value,
							 stream: add_select[1].options[add_select[1].selectedIndex].value,
							 stream_txt: add_select[1].options[add_select[1].selectedIndex].text,
							 gender: select[3].options[select[3].selectedIndex].text,
							 email:email.value},
				dataType:"json",
				success:function(data){
					form.reset();
					alert(data.msg);
					load_students_info();
				}
			});
	};
// End

// All checkbox
var select_all = document.getElementById("all_students");
var all = document.getElementsByClassName("this_student");
select_all.onclick= function(){
		if(select_all.checked == true){
				for(var i=0; i<all.length; i++){
						all[i].checked = true;
						if(all[i].checked){data_id.push(all[i].value);}
				}
				console.log(data_id);
		}else{
			for(var i=0; i<all.length; i++){
				all[i].checked = false;
			}
			data_id.length = 0;
			console.log(data_id.length);
		}

}
// Checkbox End

// Update content
add_buttons[0].onclick = function(event){
		event.preventDefault();
		if(add_select[1].options[add_select[1].selectedIndex].text == "Choose Stream"){	alert("Please assign a stream");return false;}
		else if(add_select[2].options[add_select[2].selectedIndex].text == "Choose Class"){alert("Please assign an Entry Class"); return false;}
		else if(add_select[3].options[add_select[3].selectedIndex].text == "Choose Class"){alert("Please assign a Current Class"); return false;}
		else{

			$.ajax({
				url: "../../php/admin/admin_students/edit.php",
				type: "POST",
				data: {
					   sid:hidden_tag.value, fname:fname.value,
					   other:other.value, lname:lname.value,
					   dob:dob.value,  adm:adm.value, gender: add_select[0].options[add_select[0].selectedIndex].value,
					   stream: add_select[1].options[add_select[1].selectedIndex].value,
					   entry: add_select[2].options[add_select[2].selectedIndex].text,
					   level: add_select[3].options[add_select[3].selectedIndex].value,
					   contact:contact.value,
					   student_id: student_id.value,
					   email:email.value
					},
				dataType:"json",
				success:function(data){
					// form.reset();
					alert(data.output);
					add_buttons.forEach(function(button){button.style.display = "none";});
					document.querySelector("input[type=submit]").style.display="inline";
					load_students_info();
				}
			});
			}
		}
// End

// Cancel Edit
add_buttons[1].onclick = function(event){
	event.preventDefault();
	form.reset();
	adm.value="";
	load_class();
	load_streams();
	add_buttons.forEach(function(button){button.style.display="none";});
	form.querySelector("input[type=submit]").style.display = "block";
}
// End

// Check and fetch studen_id
// select[3].onchange = function(event){
// 	if(adm.value === ""){
// 		alert("Please enter an admission date");
// 		return false;
// 	}else{
// 		$.ajax({
// 			url:'../../php/admin/admin_students/create_id.php',
// 			data: {stream:select[3].value, adm:adm.value, char: select[3].options[select[3].selectedIndex].innerHTML},
// 			dataType: 'JSON',
// 			type:'GET',
// 			success: function(data){
// 				document.querySelector("input[name=student_id]").value = data.id;
// 				console.log(data.msg);
// 			}
// 		})
//
// 	}
// }
// End



// Delete teacher Info
function delete_data(event){
	let id = event.target.dataset.del;
	let element = event.target;
	let td,fullname;

	td = element.parentElement.parentElement.querySelectorAll("td");
	fullname = td[2].innerHTML;

		if (confirm("Are you sure you want to delete records of "+fullname+"?")) {
			$.ajax({
				url: "../../php/admin/admin_students/delete.php",
				type: "POST",
				data:{sid:id},
				dataType:"json",
				success: function(data){
					alert(data.del);
					load_students_info();
				}
			})
		}
	}
//  End.

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
		url: '../../php/admin/admin_students/sendEdit.php',
		type:'GET',
		dataType: 'JSON',
		data: {id: id},
		success: function(data){
			document.querySelector("input[type=submit]").style.display="none";
		add_buttons.forEach(function(button){button.style.display = "inline";});
			hidden_tag.value = data.id;
			fname.value = data.fname;
			lname.value = data.lname;
			other.value = data.other;
			dob.value = data.dob;
			student_id.value = data.student_id;
			contact.value = data.contact;
			email.value = data.email;
			adm.value = data.adm;

			var str = add_select[1].options;
			for(var opt, i=0; opt = str[i]; i++){
				if(opt.value == data.s_id){str.selectedIndex = i;}
			}

			var classes = add_select[3].options;
			for(var lvl, i=0; lvl = classes[i]; i++){
				if(lvl.value == data.c_id){classes.selectedIndex = i;}
			}

			var entry_class = add_select[2].options;
			for(var lvl, i=0; lvl = classes[i]; i++){
				if(lvl.text == data.entry.toUpperCase()){entry_class.selectedIndex = i;}
			}

			var gender_arr = view_select[0].options;
			for(var opt, i=0; genderIndex = gender_arr[i]; i++){
				if(genderIndex.value == data.gender){gender_arr.selectedIndex = i;}
			}
		 }


	});
}


function load_class(){
	$.ajax({
		url: "../../php/admin/admin_students/class.php",
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			view_select[1].innerHTML = data.class;
			add_select[2].innerHTML = data.class;
			add_select[3].innerHTML = data.class;
			file_div.querySelectorAll("select")[0].innerHTML = data.class;
			// document.querySelectorAll("select")[2].innerHTML = data.class;
		}
	})
}

function load_streams(){
	$.ajax({
		url: "../../php/admin/admin_students/streams.php",
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			add_select[1].innerHTML = data.streams;
			view_select[0].innerHTML = data.streams;
			file_div.querySelectorAll("select")[1].innerHTML = data.streams;
		}
	})
}



// Function to load teacher info
	function load_students_info(){
		$.ajax({
			url:"../../php/admin/admin_students/load_students.php",
			type:"POST",
			dataType: "JSON",
			success: function(data){
				document.querySelector(".tbody").innerHTML=data.students;
				}
			});
	}
// End


// Type Filter
document.querySelector('input[name="search"]').onkeyup = function(event){
	var x = event.target.value;
	if (x !== ''){
			$.ajax({
			url:"../../php/admin/admin_students/typo_fltr.php",
			data:{x:x},
			dataType:"json",
			type:"POST",
			success: function(data){
			document.querySelector("tbody").innerHTML = data.fltr;
			document.querySelector("#total").innerHTML = data.total+" result[s]";
			}
		});
	}	else
		{
			load_students_info();
		}

}
// End

// Filter on go button
document.querySelector("#go").onclick = function(event){
	event.preventDefault();

	if(view_select[0].value < 1 && view_select[0].value < 1){
		alert("Select a Class or a Stream to begin search");
		return false;
	}else{
		$.ajax({
			url: '../../php/admin/admin_students/fltr.php',
				data: {stream:view_select[0].value, level:view_select[1].value},
			type: 'GET',
			dataType: 'JSON',
			success: function(data){
				document.querySelector("tbody").innerHTML = data.fltr;
				document.querySelector("#total").innerHTML = data.total+" result[s]";
			}
		})
	}


};// End




// Print Data
printBtn.onclick = function(){
	var tbl = document.querySelector("#student_table_data");
	var htmlToPrint = '' +
			 '<style type="text/css">'
			 +'table{font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;  width: 100%;}'+
			 'table th,td{' +
			 'border:1px solid #ddd;' +
			 'padding:8px;' +
			 '}' + 'table th{padding-top: 12px;padding-bottom: 12px;text-align: left;background-color: #04AA6D;color: white;}'+
			  'tr:nth-child(even){background-color: #f2f2f2;}'+
			 '</style>';
	newWin = window.open("");
	newWin.document.write("<style>td:nth-child(1){display:none;}td:nth-child(6){display:none;}td:nth-child(7){display:none;}td:nth-child(8){display:none;}td:nth-child(9){display:none;}</style>");
	newWin.document.write("<style>th:nth-child(1){display:none;}th:nth-child(6){display:none;}th:nth-child(7){display:none;}th:nth-child(8){display:none;}th:nth-child(9){display:none;}</style>");
	newWin.document.write(tbl.outerHTML+htmlToPrint);
	newWin.print();
	newWin.close();
}
// End


// Collect Checked CheckedBox
function collectDataId(){
	if(!select_all.checked){
		for(i=0; i<all.length; i++){
			if(all[i].checked == true){data_id.push(all[i].value)}
		}
		console.log(data_id);
	}
}
// End

function clickList(e){
	let action = e.target.dataset.action;
	collectDataId();

	if(data_id.length < 1){alert("Select at least one student"); return false;}else{
		if(confirm(e.target.innerText+": "+data_id.length+" students")){
			$.ajax({
				url: "../../php/admin/admin_students/change_stats.php",
				data: {data:action, sid:JSON.stringify(data_id)},
				type: "post",
				dataType: "json",
				success: function(data){
					alert(data.output);
					data_id.length = 0;
				}})
		}
	}
	}


// Upload csv File
function checkExt(event){
	let file = file_div.querySelector("[type=file]").files[0];
	let exe = file.name.split('.').pop();
	if(exe != "csv"){
		alert("File extension "+exe+" not supported. File must be of extension CSV");
		return false;
	}else{return true;}
}

file_div.querySelector('form').onsubmit = function(event){
	event.preventDefault();

	let file = file_div.querySelector("[type=file]").files[0];

	var formData = new FormData();
		formData.append('fileToUpload', file);

		$.ajax({
			url: "../../readCsvPhp/csv2.php",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			type:"POST",
			success: function(data){
				file_div.querySelector("table").innerHTML = data.tbl_arr;
			}


		
		})
}


upload_btn.onclick = () => {

	let classObj = {
		entry_class: file_div.querySelectorAll('select')[0].value,
		stream: file_div.querySelectorAll('select')[1].value,
		class_txt: file_div.querySelectorAll('select')[0].options[file_div.querySelectorAll('select')[0].selectedIndex].text,
		stream_txt: file_div.querySelectorAll('select')[1].options[file_div.querySelectorAll('select')[1].selectedIndex].text
	}


	if(classObj.stream < 1 || classObj.entry_class < 1){
		alert('One or All of the following is not selected Class && Stream');
		return false;
	}else{

	const studentTable = file_div.querySelector('table');
	const tBody = studentTable.querySelector('tbody');
	const trs = tBody.querySelectorAll('tr');


		var csvArr = [];
		var item = 0;
		trs.forEach(function(tr, index){
			if(index < 1){}
			else{
				csvArr[index-1] = {
					fname: tr.querySelectorAll('td')[0].querySelector('input').value,
					lname: tr.querySelectorAll('td')[1].querySelector('input').value,
					other: tr.querySelectorAll('td')[2].querySelector('input').value,
					dob: tr.querySelectorAll('td')[3].querySelector('input').value,
					dreg: tr.querySelectorAll('td')[4].querySelector('input').value,
					gender: tr.querySelectorAll('td')[5].querySelector('input').value,
					contact: tr.querySelectorAll('td')[6].querySelector('input').value,
					email: tr.querySelectorAll('td')[7].querySelector('input').value,
					clsId: classObj.entry_class,
					clsName: classObj.class_txt,
					strId:  classObj.stream,
					strName: classObj.stream_txt
				}
				
			}

		})

		csvArr.pop();
		$.ajax({
			url: '../../php/admin/admin_students/insertCsv.php',
			type: 'POST',
			dataType: 'json',
			data: {csv: JSON.stringify(csvArr)},
			success: function(data){	
				alert(data.output);
				csvArr.length = 0;
				studentTable.innerHTML = '';
				classObj.entry_class.selectedIndex = 0;
				classObj.stream.selectedIndex = 0;
			}
		})

		
	}

}




