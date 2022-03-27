
all_results();

function all_results(){
  $.ajax({
      url: '../../php/students/terminal_report/student_reports.php',
      data:{user_id: curr_id},
      type: 'GET',
      dataType:'JSON',
      success: function(data)
      {
        document.querySelector(".row-fluid").innerHTML = data.output;
      }
  });
}

function print_document(event){
    var btn = event.target;
  	var table = btn.parentElement.parentElement.parentElement.parentElement;
  	var htmlToPrint = '' +
  			 '<style type="text/css">'
  			 +'table{margin:0 auto; font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;  width: 100%;}'+
  			 ' table th,td{align: center; padding:12px 15px;}' + 'thead th{text-align: center; background-color: #0A0A0A; color:  #000000;}'+
  			  'tr:nth-child(even){background-color: #f2f2f2;}'+
          'tbody tr{border-bottom: 1px solid #dddddd}'+
          'tbody tr:nth-of-type(even) {background-color: #f3f3f3;}'+
          'tbody tr:last-of-type {border-bottom: 2px solid #6c3f5e;}'+
          'thead tr{background-color: #6c3f5e; color: #ffffff; text-align: left;}'+'tfoot td:nth-child(3){display:none}, tfoot td:nth-child(1){color:#000000}</style>';
    newWin = window.open("");
    // newWin = document.write("<style> tfoot > td:nth-child(1){display:none}</style>");
  	newWin.document.write(table.outerHTML+htmlToPrint);
  	newWin.print();
  	newWin.close();
  }
