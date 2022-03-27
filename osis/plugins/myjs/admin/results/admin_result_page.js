$(document).ready(function(){
	// fetch_result_academic_year();
	// fetch_result_academic_term();
	fetch_result_class();
	fetch_student_result();



	$('#result_class tr td').hover(function(){
			$(this).css('background-color','#EAECEE');
			$(this).css('cursor','pointer');
	}, function(){
		$(this).css('background-color', 'inherit');
	});



	function fetch_result_academic_year(){
		$.ajax({
			url: "../../php/admin/terminal_reports/academic_yr.php",
			dataType: "JSON",
			type: "POST",
			success:function(data){
				$("#result_academic_yr").html(data.output);
			}
		})
	}

	function fetch_result_academic_term(){
		$.ajax({
			url: "../../php/admin/terminal_reports/academic_term.php",
			dataType: "JSON",
			type: "POST",
			success:function(data){
				$("#result_academic_term").html(data.output);
			}
		})
	}

	function fetch_result_class(){
		$.ajax({
			url: "../../php/admin/terminal_reports/result_class.php",
			dataType: "JSON",
			type: "POST",
			success:function(data){
				$("#result_class").html(data.output);
			}
		})
	}

	function fetch_student_result(){
		$.ajax({
			url:"../../php/admin/terminal_reports/exam_results.php",
			// dataType:{yr_id:yr_id, c_id:c_id, term_id:term_id},
			dataType: "JSON",
			type:"POST",
			success: function(data){
				$("#nameList").html(data.output);
			}
		})
	}

	$(document).on('click','.myres', function(){
			var btn = $(this).text();
			var student_id = $(this).data("std_id");
			var main_table = $(this).parents(".widget-box").find(".widget-title");
			var yr = main_table.data("yr");
			var c_id = main_table.next().data("class");
			var term = main_table.next().data("term");
			
			$.ajax({
				url: "../../php/admin/terminal_reports/view_results.php",
				data: {btn:btn, std:student_id, yr:yr, cid:c_id, term:term},
				dataType:"JSON",
				type: "POST",
				success: function(data){
					$('#studentResult').html(data.output);
					$('#clas').html("CLASS: "+data.class_name);
					$('#yr').html("ACADEMIC YEAR: "+data.yr_name);
					 $('#name').html("NAME: "+data.fullname);
					 $('#ac_term').html(data.term);
				}
			})
		})


	$(document).on('click', '.publish', function(){
		var email = [];
		var student_id = [];
		var table = $(this).parents(".table");
		var yr_id = $(this).parents(".widget-box").find(".widget-title").data("yr");//year id
		var term_id = $(this).parents(".widget-box").find(".widget-title").next().data("term");//term id
		var c_id = $(this).parents(".widget-box").find(".widget-title").next().data("class");//class id

		var term_name =  $(this).closest(".widget-box").find(".widget-title").next().find("h5").eq(1).html();// term name
		var yr_name = $(this).closest(".widget-box").find(".widget-title").data("yr_txt");//year name

		$(".thisBox:checked", table).each(function(i)
		{
			email[i] = $(this).val();
			student_id[i] = $(this).data("check_id");

		});

		if(email.length === 0 && student_id.length === 0)
		{
			alert("Please at least one checkbox");
		}else
		{
			$.ajax({
				url:"../../php/admin/terminal_reports/admin_publish.php",
				data: {yr_id:yr_id, yr_name: yr_name,  term_id:term_id, term_name:term_name, c_id:c_id, std:student_id, email:email},
				dataType:"JSON",
				type:"POST",
				success: function(data){
					fetch_student_result();
					alert(data.msg);
				}
			});
		}



	})

	$(document).on('click', '.select_all', function(){
		var checkedState = this.checked;
		var table = $(this).closest('.table');
		$('.thisBox', table).each(function(){
				this.checked = checkedState;
		})	
	})

	// Fetch results by Class
	$(document).on('click','#result_class tr td', function(){
		var c_id = $(this).data("c_id");
		$.ajax({
			url: "../../php/admin/terminal_reports/result_by_class.php",
			data: {c_id: c_id},
			type: "POST",
			dataType:"JSON",
			success: function(data){
				$('#nameList').html(data.output);
			}
		})
		
	})
	


})