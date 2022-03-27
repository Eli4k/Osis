$(document).ready(function(){
	load_result();
	function load_result()
	{
		$.ajax({
			url: "../../php/teachers/result/load_results.php",
			type: "POST",
			data: {uname: user_id},
			dataType: "JSON",
			success: function(data){
				$(".data_res").html(data.output);
			}
		})
	};
            // Select All checkbox
               $(document).on('click', '.selectAll', function(){
               		 var tab = $(this).closest('.table');
                     var checkedState = this.checked;
                    $('.theBox', tab).each(function(){
                        this.checked = checkedState;
                    })
               });
               // End

               // Publish Results
               $(document).on('click','.publish', function(){

               		var btn_tab = $(this).closest('.table');
                   if(confirm("Are you sure you want to publish these results?"))
                   {
                    var id = [];
                    var email = [];
                    var subject = $(this).parents(".widget-box").find('.widget-title').find("h5").eq(0).html();//Table Subject
                    var cname = $(this).parents(".widget-box").find('.widget-title').find("h5").eq(1).html();//table classname
                    var test =  $(this).parents(".widget-box").find('.widget-title').find("h5").eq(3).html();//table test name
                    var ac =  $(this).parents(".widget-box").find('.widget-title').find("h5").eq(2).html();//table academic yr
   
                    $('.theBox:checked', btn_tab).each(function(i){
                        id[i]= $(this).val();   
                        email[i] = $(this).data('email');

                    });
                    
                    if(id.length === 0 && email.length === 0)//alert message if array is empty
                    {
                        alert("Please Select at least one chekbox");
                    }else{
                        $.ajax({
                            url: '../../php/teachers/email/publish.php',
                            type: 'POST',
                            data: {grade:id, email:email, cname:cname, sub:subject, tname:test, term:ac},
                            dataType: 'JSON',
                            success: function(data){
                               alert(data.msg);
                               load_result();
                            }
                        })
  					
                    }
            	}else{
            		return false;
            	}
               		
            });
               // End




            
               
})