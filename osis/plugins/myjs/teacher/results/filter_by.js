$(document).ready(function(){

	// by_yr();
	by_class();
	by_sub();
	// by_str();

	function by_yr(){
		$.ajax({
			url:"../../php/teachers/result/load_yr.php",
			type:"POST",
			dataType:"json",
			success: function(data)
				{
					$("#by_yr").html(data.yr);
				}
		});
	}

	function by_class(){
		$.ajax({
			data: {user_id: user_id},
			url:"../../php/teachers/result/load_class.php",
			type:"POST",
			dataType:"json",
			success: function(data)
				{
					$("#level").html(data.result_class);
				}
		});
	}


	function by_sub(){
		$.ajax({
			data: {user_id: user_id},
			url:"../../php/teachers/result/load_sub.php",
			type:"POST",
			dataType:"json",
			success: function(data)
				{
					$("#by_sub").html(data.sub);
				}
		});
	}

	function by_str(){
		$.ajax({
			data: {user_id: user_id},
			url:"../../php/teachers/result/load_stream.php",
			type:"POST",
			dataType:"json",
			success: function(data)
				{
					$("#by_str").html(data.str);
				}
		});
	}


	$('#search').change(function(){
		var cl = $('#by_cl  option:selected').val();
		var sub = $('#by_sub option:selected').val();
		var pub = $('#pub option:selected').val();
		var yr = $('#yr option:selected').val();

		$.ajax({
			url: '../../php/teachers/result/load_by_sub.php',
			data:{sub:sub, uname:user_id, cl:cl, pub:pub, sub:sub, yr:yr},
			dataType: "JSON",
			type: "POST",
			success: function(data){
				$("#data_res").html(data.sub);
			}
		})
	})


});
