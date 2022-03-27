$(document).ready(function(){
	load_ac_yr();
	hide_edit();
	clearForm();
	button_fade();
	load_class();
	load_subjects();
	load_stream();

	function hide_edit(){
		$('#sub_acc > input[type = "button"]').hide('slow');
		$('#class_acc > input[type = "button"]').hide('slow');
		$('#stream_acc > input[type = "button"]').hide('slow');
		$('#academic_yr > input[type = "button"]').hide('slow');
	}



	function clearForm(){
		$("#sub").val('');
		$('#sub_acc > input[type="hidden"]').val('');
		$("#class_data").val('');
		$('#class_acc > input[type="hidden"]').val('');
		$("#ac_yr").val('');
		$('#ac_yr_acc > input[type="hidden"]').val('');
		$("#stream").val('');
		$('#stream_acc > input[type="hidden"]').val('');
	}

	function button_fade(){
		$('#sub_acc > input[type="button"]').hide('slow');
		$('#sub_acc > input[type="submit"]').show('slow');
	}

	function inverse_fade(){
		$('#stream_acc > input[type="button"]').fadeIn('slow');
		$('#stream_acc > input[type="submit"]').fadeOut('slow');
	}

	function load_ac_yr(){
		$.ajax({
			url: "../../php/admin/admin_acc/ac_year.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$('#ac_id').html(data.year);
			}
		});
	}

	function load_class(){
		$.ajax({
			url: "../../php/admin/admin_acc/class.php",
			type: "POST",
			dataType: "json",
			success: function(data){
			$('#classBody').html(data.class);
			}
		});
	}

	function load_subjects(){
		$.ajax({
			url: "../../php/admin/admin_acc/subject.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$('#sub_body').html(data.subject);
			}
		});
	}

	function load_stream(){
		$.ajax({
			url: "../../php/admin/admin_acc/streams.php",
			type: "POST",
			dataType: "json",
			success: function(data){
				$('#streamBody').html(data.streams);
			}
		});
	}

	// Insert Stream
	$("#stream_acc").submit(function (event){
		event.preventDefault();

		var stream = $("#stream").val();
		var stval = $('#stream_acc > input[type="submit"]').val();

		if (stream == ''){
			alert("Enter data for Stream");
			return false;
		}

		$.ajax({
			url: "../../php/admin/admin_acc/crudStream.php",
			type: "POST",
			data: {stream: stream, stval:stval},
			dataType:"json",
			success: function(){
				alert("Data Inserted");
				clearForm();
				load_stream();
			}
		});
	});


	// Edit Stream
	$(document).on('click','#btn_edit',function(){
		var s_id = $(this).data("sid");

		$.ajax({
			url: "../../php/admin/admin_acc/crudStream.php",
			type: "GET",
			data:{s_id:s_id},
			dataType: "json",
			success: function(data){
				$("#stream").val(data.stream_name);
				$('#stream_acc > input[type="hidden"]').val(data.stream_id);
				inverse_fade();
			}
		});
	});



	$('#stream_acc > input[type="button"]').click(function(){
		var s_name = $("#stream").val();
		var sid = $('#stream_acc > input[type="hidden"]').val();

		$.ajax({
			url: "../../php/admin/admin_acc/crudStream.php",
			type: "POST",
			data:{s_name:s_name, sid:sid},
			dataType:"json",
			success: function(){
				button_fade();
				load_stream();
				clearForm();
			}
		});
	});

	// End Of Edit

	// Delete Stream
	$(document).on('click','#btn_delete', function(){
		var del_id = $(this).data("s_id");
		var currentRow = $(this).closest('tr');
		var col_data = currentRow.find("td:eq(1)").html();

		if (confirm("Are you sure want to delete "+col_data+"?"))
		 {
			$.ajax({
				url: "../../php/admin/admin_acc/crudStream.php",
				data: {col_data:col_data, del_id:del_id},
				dataType: "json",
				type: "GET",
				success: function(data){
					currentRow.fadeOut('slow');
					load_stream();
					alert(data.s_msg);
				}
			});
		 }
	});




	/*
		Subjects Cruds
	*/

	// Insert Subject
	$("#sub_acc").submit(function (event){
		event.preventDefault();

		var sub = $("#sub").val();
		var sub_data = $('#sub_acc > input[type="submit"]').val();

		if (sub == ''){
			alert("Enter Subject name");
			return false;
		}

		$.ajax({
			url: "../../php/admin/admin_acc/crudSubjects.php",
			type: "POST",
			data: {sub:sub, sub_data:sub_data},
			dataType:"json",
			success: function(){
				alert("Data Inserted");
				// clearForm();
				load_subjects();
			}
		});
	});




			// Edit Subject
			$(document).on('click','#sub_edit',function(){
				var sub_id = $(this).data("sub_id");

				$.ajax({
					url: "../../php/admin/admin_acc/crudSubjects.php",
					type: "GET",
					data:{sub_id:sub_id},
					dataType: "json",
					success: function(data){
						$("#sub").val(data.sub_name);// inverse_fade();
						$('#sub_acc > input[type="hidden"]').val(data.sub_id);
						$('#sub_acc > input[type="submit"]').hide('slow');
						$('#sub_acc > input[type="button"]').show('slow');

					}
				});
			});



			$('#sub_acc > input[type="button"]').click(function(){
				var edit_btn = $(this).val();
				var sub_name = $("#sub").val();
				var sub_id = $('#sub_acc > input[type="hidden"]').val();

				$.ajax({
					url: "../../php/admin/admin_acc/crudSubjects.php",
					type: "POST",
					data:{edit_btn:edit_btn, sub_name:sub_name, sub_id:sub_id},
					dataType:"json",
					success: function(data){
						alert(data.result);
						$('#sub_acc > input[type="submit"]').show('slow');
						$('#sub_acc > input[type="button"]').hide('slow');
						button_fade();
						load_subjects();
						clearForm();
					}
				});
			});

			// End Of Edit Subject

			// Delete Subject
			$(document).on('click','#sub_delete', function(){
				var sub_del_id = $(this).data("sub_id2");
				var currentRow = $(this).closest('tr');
				var sub_col_data = currentRow.find("td:eq(1)").html();

				if (confirm("Are you sure want to delete "+sub_col_data+"?"))
				 {
					$.ajax({
						url: "../../php/admin/admin_acc/crudSubjects.php",
						data: {sub_col_data:sub_col_data, sub_del_id:sub_del_id},
						dataType: "json",
						type: "GET",
						success: function(data){
							alert(data.delete);
							currentRow.hide('slow');
							// load_subjects();
						}
					});
				 }

			});



			// End Of Subjects



			// Insert Class

	$("#class_acc").submit(function(event){
		event.preventDefault();

		var class_name = $("#class_data").val();
		var class_button = $('#class_acc > input[type="submit"]').val();

		if (class_name == ''){
			alert("Enter class name");
			return false;
		}

		$.ajax({
			url: "../../php/admin/admin_acc/crudClass.php",
			type: "POST",
			data: {class_button: class_button, class_name: class_name},
			dataType:"json",
			success: function(data){
				alert(data.insert);
				// clearForm();
				load_class();
			}
		});
	});




			// Edit Class
			$(document).on('click','#class_edit',function(){
				var c_id = $(this).data("c_id");

				$.ajax({
					url: "../../php/admin/admin_acc/crudClass.php",
					type: "GET",
					data: {c_id:c_id},
					dataType: "json",
					success: function(data){
						$("#class_data").val(data.c_name);// inverse_fade();
						$('#class_acc > input[type="hidden"]').val(data.c_id);
						$('#class_acc > input[type="submit"]').hide('slow');
						$('#class_acc > input[type="button"]').show('slow');

					}
				});
			});



			$('#class_acc > input[type="button"]').click(function(){
				var edit_btn = $(this).val();
				var  class_name= $("#class_data").val();
				var class_id = $('#class_acc > input[type="hidden"]').val();

				$.ajax({
					url: "../../php/admin/admin_acc/crudClass.php",
					type: "POST",
					data:{edit_btn:edit_btn, class_id:class_id, class_name:class_name},
					dataType:"json",
					success: function(data){
						alert(data.class_result);
						$('#sub_acc > input[type="submit"]').show('slow');
						$('#sub_acc > input[type="button"]').hide('slow');
						button_fade();
						load_class();
						clearForm();
					}
				});
			});

			// End Of Class Edit

			// Delete Class
			$(document).on('click','#class_delete', function(){
				var class_del_id = $(this).data("c_id2");
				var currentRow = $(this).closest('tr');
				var class_col_data = currentRow.find("td:eq(1)").html();

				if (confirm("Are you sure want to delete "+class_col_data+"?"))
				 {
					$.ajax({
						url: "../../php/admin/admin_acc/crudClass.php",
						data: {class_col_data:class_col_data, class_del_id:class_del_id},
						dataType: "json",
						type: "GET",
						success: function(data){
							alert(data.class_delete);
							currentRow.hide('slow');
							// load_subjects();
						}
					});
				 }

			});


	// Insert Academic Year
	$("#academic_yr").submit(function(event){
		event.preventDefault();

		var ac_yr = $("#ac_yr").val();
		var yr_btn = $('#academic_yr > input[type="submit"]').val();

		if (ac_yr == ''){
			alert("Enter Academic Year");
			return false;
		}

		$.ajax({
			url: "../../php/admin/admin_acc/crudAcademic_yr.php",
			type: "POST",
			data: {yr_btn: yr_btn, ac_yr: ac_yr},
			dataType:"json",
			success: function(data){
				alert(data.insert_yr);
				 clearForm();
				load_ac_yr();
			}
		});
	});




			// Edit Class
			$(document).on('click','#yr_edit',function(){
				var yr_id = $(this).data("yr");

				$.ajax({
					url: "../../php/admin/admin_acc/crudAcademic_yr.php",
					type: "GET",
					data: {yr_id:yr_id},
					dataType: "json",
					success: function(data){
						$("#ac_yr").val(data.yr_name);// inverse_fade();
						$('#academic_yr > input[type="hidden"]').val(data.yr_id);
						$('#academic_yr > input[type="submit"]').hide('slow');
						$('#academic_yr > input[type="button"]').show('slow');

					}
				});
			});



			$('#academic_yr > input[type="button"]').click(function(){
				var y_btn = $(this).val();
				var  yr_name = $("#ac_yr").val();
				var y_id = $('#academic_yr > input[type="hidden"]').val();

				$.ajax({
					url: "../../php/admin/admin_acc/crudAcademic_yr.php",
					type: "POST",
					data:{y_id:y_id, yr_name:yr_name, y_btn:y_btn},
					dataType:"json",
					success: function(data){
						alert(data.yr_result);
						$('#academic_yr > input[type="submit"]').show('slow');
						$('#academic_yr > input[type="button"]').hide('slow');
						button_fade();
						load_ac_yr();
						clearForm();
					}
				});
			});

			// End Of Year Edit

			// Delete Year
			$(document).on('click','#yr_delete', function(){
				var yr_del_id = $(this).data("yr2");
				var currentRow = $(this).closest('tr');
				var yr_col_data = currentRow.find("td:eq(1)").html();

				if (confirm("Are you sure want to delete "+yr_col_data+"?"))
				 {
					$.ajax({
						url: "../../php/admin/admin_acc/crudAcademic_yr.php",
						data: {yr_col_data:yr_col_data, yr_del_id:yr_del_id},
						dataType: "json",
						type: "GET",
						success: function(data){
							alert(data.yr_delete);
							currentRow.hide('slow');
							load_ac_yr();
						}
					});
				 }

			});

		// Activate year
		$(document).on('click', '#yr_activate', function(){
			var yr_act = $(this).data('yr');
			$.ajax({
				url: '../../php/admin_acc/activate_yr.php',
				data:{yr_id: yr_act},
				dataType: 'json',
				type:'GET',
				success: function(data){
					console.log(data.year+" is now active");
				}
			})
		})




});
