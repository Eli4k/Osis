$(document).ready(function(){

  load_this_class();

  function load_this_class(){
  	$.ajax({
  		url: '../../php/admin/terminal_reports/result_by_class.php',
  		data:{classes:class_id, cname:class_name},
  		dataType:'JSON',
  		type: 'POST',
  		success: function(data){
  			$('.container-fluid').html(data.output);
  		}
  	});
  }

           // Select All checkbox
               $(document).on('click', '.select_all', function(){
                   var tab = $(this).closest('.table');
                     var checkedState = this.checked;
                    $('.thisBox', tab).each(function(){
                        this.checked = checkedState;
                    })
               });
               // End

               // Publish Results
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
                    beforeSend: function(){                 
                      $('#err_msg').html("Sending message to "+student_id.length+" client(s) please wait...").addClass("alert alert-info alert-block").show('slow');
                    },
                    success: function(data){
                         $('#err_msg').html(data.msg).removeClass("alert alert-info alert-block").addClass("alert alert-success alert-block");

                        setTimeout(function(){
                          $('#err_msg').hide('slow');
                        }, 2000); 
                     load_this_class();

                    }
                  });
                 }
              });

            // End

                          // View Student Result
                         $(document).on('click','.view_result', function(){
                            var closest_result_table = $(this).closest(".row-fluid").find('#result_slip');
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
                                closest_result_table.html(data.output);
                                $('#class').html("CLASS: "+data.class_name);
                                $('#yr').html("ACADEMIC YEAR: "+data.yr_name);
                                 $('#name').html("NAME: "+data.fullname);
                                 $('#ac_term').html(data.term);
                              }
                            });
        });
       // View Result End



});
