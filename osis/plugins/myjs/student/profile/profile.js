$.ajax({
  url: '../../../php/students/profile/select.php',
  dataType: 'JSON',
  type: "POST",
  data: {user_id: curr_id},
  success: function(data){
    document.querySelector("#user_data").innerHTML = data.output;
  }
});                                                                                                                                                                                                                                                                                                                                                             
