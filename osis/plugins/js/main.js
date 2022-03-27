$(document).ready(function(){

		function fetch_class(){
			$.ajax({
				url: "../../php/admin/admin-students/class.php",
				type: "POST",
				dataType: "json",
				success: function(data)
				{
					$("#_class").html(data.class);
				}
			});
		}

		function fetch_streams(){
			$.ajax({
				url: "../../php/admin/admin-students/streams.php",
				type: "POST",
				dataType: "json",
				success: function(data)
				{
					$("#stream").html(data.streams);
				}
			});
		}

		 function fetch_data(){
	 	$.ajax({
			url:"../../php/admin/admin-students/select.php",
	 		type:"POST",
	 		dataType:"json",
	 		success: function(data){
	 			$("#customtd").hide();
	 			$("#tableBody").html(data.result);
			}
		});
	 }

	 	function peekaboo_1(){
	 		$('button[name="edit"]').hide();
	 		$('button[name="btn_add"]').show();
	 	}

	 	function peekaboo_2(){
	 		$('button[name="edit"]').show();
	 		$('button[name="btn_add"]').hide();
	 	}

	 	function clearForm(){
	 		var first = $('input[name="first"]').val('').focus();
			var last = $('input[name="last"]').val('');
			var dob = $('input[name="dob"]').val('');
			var adm = $('input[name="adm"]').val('');
			var email = $('input[name="email"]').val('');
			var contact = $('input[name="contact"]').val('');
			var _class = $('#_class > option:selected').text('');
			var school = $('#school > option:selected').text('');
	 	}

	 	// fetch_data();
	 	load_pagination(1);
		peekaboo_1();
		fetch_streams();
		fetch_class();
	 


$("#myForm").submit(function(event){
	event.preventDefault();

		var first = $('input[name="first"]').val();
		var last = $('input[name="last"]').val();
		var dob = $('input[name="dob"]').val();
		var adm = $('input[name="adm"]').val();
		var email = $('input[name="email"]').val();
		var contact = $('input[name="contact"]').val();
		var _class = $('#_class > option:selected').val();
		var stream = $('#stream > option:selected').val();


		if (first == "") {
			alert("Enter First Name");
			return false;
		}

		if (last == "") {
			alert("Enter Last Name");
			return false;
		}

		if (dob == "") {
			alert("Enter Date of Birth");
			return false;
		}

		if (adm == ""){
			alert("Enter Admission Date");
			return false;
		}

		if (email == ""){
			alert("Enter Email Address");
			return false;
		}

		if (contact == "") {
			alert("Enter Contact Number");
			return false;
		}

		if (_class == "") {
			alert("Choose Class for student");
			return false;
		}

		$.ajax({
			url:"../../php/admin/admin-students/insert.php",
			type:"POST",
			data:{first:first, last:last, dob:dob, adm:adm, email:email, contact:contact, _class:_class, stream:stream},
			dataType:"json",
			success:function(data){
				$("#msg").html(data.ins_msg);
				fetch_data();
				clearForm();
			}
		});



	});

// Table Edit button
	$(document).on('click','#btn_edit', function(){
		var std_id = $(this).data("id2");
		$.ajax({
			url: "../../php/admin/admin-students/sendEdit.php",
			type:"GET",
			data:{std_id:std_id},
			dataType:"json",
			success: function(data)
			{
				 $('input[name="first"]').val(data.fname);
				 $('input[name="last"]').val(data.lname);
				 $('input[name="dob"]').val(data.dob);
				 $('input[name="adm"]').val(data.adm);
				 $('input[name="email"]').val(data.email);
				 $('input[name="contact"]').val(data.contact);
				 $("#_class").find(":selected").text(data._class);
				 $("#stream").find(":selected").text(data.stream);
				  $("#_class").find(":selected").val(data.c_id);
				 $("#stream").find(":selected").val(data.s_id);
				 $("#h_input").val(data.sid);

				 peekaboo_2();
				 load_pagination();
			}

		});
	});	


// Edit Section
	$('button[name="edit"]').click(function(){
		var sid = $("#h_input").val();
		var first = $('input[name="first"]').val();
		var last = $('input[name="last"]').val();
		var dob = $('input[name="dob"]').val();
		var adm = $('input[name="adm"]').val();
		var email = $('input[name="email"]').val();
		var contact = $('input[name="contact"]').val();
		var c_id = $("#_class > option:selected").val();
		var s_id = $('#stream > option:selected').val();

		$(document).on('change','#stream > option:selected',fetch_streams());
		$(document).on('change','#_class > option:selected',fetch_class());

		if (first == "") {
			alert("Enter First Name");
			return false;
		}

		if (last == "") {
			alert("Enter Last Name");
			return false;
		}

		if (dob == "") {
			alert("Enter Date of Birth");
			return false;
		}

		if (adm == ""){
			alert("Enter Admission Date");
			return false;
		}

		if (email == ""){
			alert("Enter Email Address");
			return false;
		}

		if (contact == "") {
			alert("Enter Contact Number");
			return false;
		}

		$.ajax({
			url:"../../php/admin/admin-students/edit.php",
			type:"POST",
			data:{sid:sid, first:first, last:last, dob:dob, adm:adm, email:email, contact:contact, c_id:c_id, s_id:s_id},
			dataType:"json",
			success:function(data){
				alert("Record Updated");
				load_pagination();
				peekaboo_1();
				clearForm();
			}
		});
		
	});
	// End of Edit

 	// Delete Section
	$("#tableBody").on('click','#btn_delete',function(){
		var sid = $(this).data("id3");
		var currentRow = $(this).closest("tr");
		col1 = currentRow.find("td:eq(1)").html();	

		if (confirm("Are you sure you want to delete Student with this ID? "+col1)) {
			$.ajax({
				url: "../../php/admin/admin-students/delete.php",
				data:{sid:sid},
				type: "GET",
				dataType:"json",
				success:function(data)
				{
					$("#msg").html(data.del);
					load_pagination();

				}
			});
		}
		

	});
	// End of Section

	// Search Filter
	$('input[name="search"]').keyup(function(){
		var x = $(this).val();
		if (x !== ''){
				$.ajax({
				url:"../../php/admin/admin-students/students_data.php",
				data:{x:x},
				type:"GET",
				dataType:"json",
				success: function(data){
					$("#customtd").hide();
					$("#tableBody").html(data.filter);
				}
			});
		}
		else
		{
			load_pagination();
		}
		
	});
	// End of Filter

	// Pagination
	function load_pagination(page)
	{
		$.ajax({
			url:"../../php/admin/admin-students/pagination.php",
			type:"POST",
			data:{page:page},
			dataType:"json",
			success: function(data)
			{
				$("#tableBody").html(data.page);
				$("#pagi_link").html(data.link);
			}
		});
	}
	// End of pagination

	$(document).on('click','.pagination_link',function(){
		var page = $(this).attr("id");
		load_pagination(page);
	});

});