$(document).ready(function(){
	$('input[name="search"]').keyup(function(){
		var x = $(this).val();

		if (x !== ''){
				$.ajax({
				url:"../../php/admin/admin_teachers/filter.php",
				data:{x:x},
				dataType:"json",
				type:"GET",
				success: function(search){
					$("#tableBody").html(search.filter);
				}
			});
		}
		else
		{
			load_teacher_info();
		}

	});




	// Select with checkbox

	$(document).on('click', '.teacher_selectAll', function(){
		var checkedState = this.checked;
		var thisTable = $(this).closest(".table");

		$('.this_teacher_select', thisTable).each(function(){
			this.checked = checkedState;
		});
	});


	$(document).on('click','#acc_notif', function(){
		var thisTable = $(this).closest('widget-box');
		var teacher_id = [];

		$('.this_teacher_select:checked').each(function(i){
			teacher_id[i] = $(this).data('t_id');
		})

		if(teacher_id.length < 1)
				{
					alert("Please select at least one checkbox");
					return false;
				}else{
					$.ajax({
						url:"../../php/admin/admin_teachers/email/email.php",
						data: {tid:teacher_id},
						type: "POST",
						dataType: "json",
						success:function(data)
						{
							alert(data.msg);
							load_teacher_info();
						}
					});

				}
			});



});
