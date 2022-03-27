$(document).ready(function() {
		hide_btn();
		ac_year();
		load_class();
		load_subject();
		load_term();
		fetch_all_grades();
		show_by_class();
		show_by_ac();
		// fetch_all_grades();
		load_stream();
		toggleSetup();
		setConditions();

		function fetch_all_grades(){
			$.ajax({
				url: "../../php/teachers/exam/exam_result/exam_result_inc.php",
				type:"POST",
				data: {user_id:user_id},
				dataType: "json",
				success: function(data){
					$(".incomplete").html(data.output);
				}
			});
		}

		$('#change_setup').hide();


		// Toggle setup div
		function toggleSetup(){
				$(document).on('click', '#test_setup',function(event){
				$(this).closest('.widget-box').hide('slow');
				$("#exam_setup").val("ok");
				$('#change_setup').show('slow');
			});

				$(document).on('click', '#change_setup',function(event){
					$(this).hide('slow');
					$("#exam_setup").val('');
					$('.main_setup').show('slow');
			});


				$(document).on('click', '#btn_edit',function(event){
					$('.main_setup').show('slow');
					$('#change_setup').hide('slow');
			});


		}
		// End of setup div




// Insert Records
	$("#myForm").submit(function(event){
		event.preventDefault();

		var add = $('#myForm input[type = submit]').val();
		var std_id = $('input[name="std_id"]').val();
		var score = $("#score").val();
		var	level = $("#level option:selected").val();
		var subject = $("#subject option:selected").val();
		var term = $("#term option:selected").val();
		var ac_year = $("#ac_year option:selected").val();
		var stream = $("#stream option:selected").val();
		var class_score = $("#class_score").val();


		if (std_id == "") {
			alert('Enter  student Id');
			document.getElementById("myForm").reset();
			$("#student").focus();
			return false;
		}


		if ($("#subject option:selected").prop('disabled')== true) {
			alert("Select a Subject in your test setup box");
			$('.main_setup').show('slow');
			$('#change_setup').hide('slow');
			$("#subject").focus();
			return false;
		}

		if ($("#stream option:selected").prop('disabled')== true) {
			alert("Select the Stream ");
			$('.main_setup').show('slow');
			$('#change_setup').hide('slow');
			$("#stream").focus();
			return false;
		}

		if ($("#ac_year option:selected").prop('disabled')== true) {
			alert("Select the Academic year in your test setup box ");
			$('.main_setup').show('slow');
			$('#change_setup').hide('slow');
			$("#ac_year").focus();
			return false;
		}


		if (score == "") {
			alert('Enter Test Score');
			$("#score").focus();
			return false;
		}

		if (class_score == ""){
			alert('Enter Class score');
			$("#class_score").focus();
			return false;
		}

		if (confirm("Are you sure you entered the correct info?") && $("#exam_setup").val() == "ok"){
				$.ajax({
				url: '../../php/teachers/exam/insert.php',
				type:'POST',
				dataType:'JSON',
				data: {add:add, std_id:std_id, ex_score:score, class_score:class_score,
					   s_id:stream, level:level, user_id: user_id, subject:subject,
					    term:term, ac_year:ac_year},
				success: function(data){
					// document.getElementById("myForm").reset();
					console.log(data.message);
					// fetch_all_grades();
				},
				error: function (jqXHR, exception) {
	        var msg = '';
	        if (jqXHR.status === 0) {
	            msg = 'Not connect.\n Verify Network.';
	        } else if (jqXHR.status == 404) {
	            msg = 'Requested page not found. [404]';
	        } else if (jqXHR.status == 500) {
	            msg = 'Internal Server Error [500].';
	        } else if (exception === 'parsererror') {
	            msg = 'Requested JSON parse failed.';
	        } else if (exception === 'timeout') {
	            msg = 'Time out error.';
	        } else if (exception === 'abort') {
	            msg = 'Ajax request aborted.';
	        }
				}
			});
		}else{
			return false;
		}
	});
// End of Insert


// Edit Functions

	$(document).on('click', '#edit_btn', function(){
		var exam_id= $(this).data("edit");

		$.ajax({
			url: "../../php/teachers/exam/sendEdit.php",
			type:'POST',
			data:{exam_id :exam_id},
			dataType:'text',
			success: function(data){
				$('input[name="std_id"]').val(data.student);
				$('#score').val(data.ex_score);
				$('#h_input').val(data.exam_id);
				$('#level option:selected').val(data.c_id);
				$('#term option:selected').val(data.tr_id);
				$('#ac_year option:selected').val(data.yr_id);
				$('#subject option:selected').val(data.sub_id);
				$('#stream option:selected').val(data.str_id);
				$('#class_score ').val(data.class_score);

				$('#level option:selected').html(data._level);
				$('#term option:selected').html(data.term);
				$('#ac_year option:selected').html(data.yr);
				$('#subject option:selected').html(data.sub);
				$('#stream option:selected').html(data.s_name);

				$('.main_setup').show('slow');
				$('#change_setup').hide('slow');
				rev_hide_btn();
			}

		});

	});
// End of Sending Edit Data function

	// Database On Update
	$('#edit').click(function(){
		if($("#exam_setup").val()!=="ok"){
			alert("Click the SET button after setting your exam conditions in the setup box");
			return false;
		}else{
		var exam_id = $("#h_input").val();
		var std_id = $('input[name="std_id"]').val();
		var ex_score = $("#score").val();
		var	level = $("#level option:selected").val();
		var subject = $("#subject option:selected").val();
		var term = $("#term option:selected").val();
		var yr = $("#ac_year option:selected").val();
		var class_score = $("#class_score").val();
		var stream = $("#stream option:selected").val();

		// alert('Stream:'+stream+' Subject:'+subject+' Test:'+test+' Grade:'+grade+' Term:'+term);


		$.ajax({
			url:"../../php/teachers/exam/edit.php",
			type:"POST",
			data:{
					exam_id:exam_id, std_id:std_id, class_score: class_score,
					level:level, s_id: stream, subject:subject, term:term,
					ex_score:ex_score, yr:yr, user_id:user_id
				 },
			dataType:"json",
			success: function(data){
				document.getElementById("myForm").reset();
				load_class();
				load_subject();
				load_term();
				load_stream();
				ac_year();
				alert(data.feedback);
				fetch_all_grades();
				hide_btn();

		}

			})
		};

	});

	// End of Database on update

// Delete Record
	$(document).on('click','#btn_delete', function(){
		$(this).closest('tr').css({"background-color":"#CD5C5C"});
		var currRow = $(this).closest('tr');
		var exam_id = $(this).data('delete');
		if (confirm("Are you sure you want to delete this record?")){
					$.ajax({
					url: "../../php/teachers/exam/delete.php",
					type:"POST",
					data: {exam_id:exam_id},
					dataType:"json",
					success: function(data){
						alert(data.result);
						currRow.fadeOut();
						fetch_all_grades();
					}
				});
			}

	});
// End of Record Delete


// Fetch streams
	function load_stream(){
		$.ajax({
			url:"../../php/teachers/exam/load_data/stream.php",
			type:"POST",
			dataType:"json",
			success: function(data){
				$('#stream').html(data.s_name);
			}
		})
	}

// Fetch Academic Year
	function ac_year(){
		$.ajax({
			url:"../../php/admin/academics/ac_year.php",
			type:"POST",
			dataType:"json",
			success: function(data)
				{
					$("#ac_year").html(data.result);
				}
		});
	}

// Load class
	function load_class(){
		$.ajax({
			url: "../../php/teachers/exam/load_data/class.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#level").html(data._class);
			}
		});
	}

// Load Subject
	function load_subject(){
		$.ajax({
			url: "../../php/teachers/exam/load_data/subject.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#subject").html(data.subject);
			}
		});
	}

	// Load Academic Term
	function load_term(){
		$.ajax({
			url: "../../php/teachers/exam/load_data/term.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#term").html(data.term);
			}
		});
	}

// Load Tests

	// List By Class
	function show_by_class(){
		$.ajax({
			url: "../../php/teachers/exam/load_data/class.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#show_class").html(data._class);
			}
		});
	}

// Display academic year
	function show_by_ac(){
		$.ajax({
			url: "../../php/admin/academics/ac_year.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$("#show_ac").html(data.result);
			}
		});
	}

// Filter

	$("#student").keyup(function(){
		var x  = $(this).val();

		if (x.length > 1) {
			$.ajax({
				url:"../../php/teachers/myclass/load_data/student_id.php",
				data: {x:x},
				type:"GET",
				dataType: "json",
				success: function(data){
					$('#student_result').fadeIn();
					$('#student_result').html(data);
				}
			});
		}else{

		}
	});

// Insert Student from Suggestion
	$(document).on('click', '.res_list',function(){
		$(".list-new").fadeOut();
		$("#student").val($(this).data("id"));
	});



	// Hide and show insert and edit buttons
	function hide_btn(){
		$('#edit').hide("slow");
		$('#insert').show("slow");
	}

	function rev_hide_btn(){
		$('#edit').show("slow");
		$('#insert').hide("slow");
	}

	// End of hide and show buttons


	// Check if exam conditions are set by clicking the set button
	function setConditions(){
		$(document).on('click','#insert, #edit', function(){
			if($("#exam_setup").val() !== "ok")
			{
				alert('Please set your exam conditions by clicking the set button');
				return false;
			}
		})
	}



		// Select All checkBox
		$(document).on('click','.inc_selectAll', function() {
				var thisTable = $(this).closest('.table');
			 	var checkedState = this.checked;
				$('.inc_thisBox:checkbox', thisTable).each(function(){
			  		this.checked = checkedState;
			  	})

			});


		// Check all Button
		$(document).on('click', '.inc_pub', function(){
			var exam_id = [];
			var table = $(this).closest(".widget-box");
				$('.inc_thisBox:checked', table).each(function(i){
				exam_id[i] = $(this).val();
			})
				if(exam_id.length < 1)
				{
					alert("Please select at least one checkbox");
					return false;
				}else{
					$.ajax({
						url:"../../php/teachers/exam/exam_result/exam_publish.php",
						data: {exam_id: exam_id, uname: user_id},
						type: "POST",
						dataType: "json",
						success:function(data)
						{
							alert(data.msg);
							fetch_all_grades();
						}
					});
				}



		})


})
