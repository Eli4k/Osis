load_about();
load_board();
load_blog();
load_contact();

 function load_about(){
     $.ajax({
     url: "web/about.php",
     type:"post",
     dataType:"json",
     success: function(data){
       document.querySelector("#about").innerHTML = data.output;
       setTimeout(() => {
         var script = document.createElement("script");
         script.setAttribute('src', '../../plugins/myjs/admin/about.js');
         document.body.appendChild(script);
       }, 1000);
     }
   });
 }



function load_board (){
   $.ajax({
     url: "web/board.php",
     type:"post",
     dataType:"json",
     success: function(data){
        document.querySelector("#board .row-fluid").innerHTML = data.output;

       setTimeout(() => {
         var script = document.createElement("script");
         script.setAttribute('src', '../../plugins/myjs/admin/board.js');
         document.body.appendChild(script);
       }, 1000);  
     }
   });

 }

 function load_blog(){
     $.ajax({
     url: "web/blog.php",
     type:"post",
     dataType:"json",
     success: function(data){
       document.querySelector("#blog > div ").innerHTML = data.output;
     }
   });

  setTimeout(() => {
    var script = document.createElement('script');
    script.setAttribute('src', '../../plugins/myjs/admin/blog.js');
    document.body.appendChild(script);
  }, 1000);

  
 }




function load_contact(){
  setTimeout(() => {
    var script = document.createElement('script');
    script.setAttribute('src', '../../plugins/myjs/admin/contact.js');
    document.body.appendChild(script);
  }, 1000);
    $.ajax({
      url: "web/contact.php",
      type:"post",
      dataType:"json",
      success: function(data){
        document.querySelector("#contact > div").innerHTML = data.output;
      }
    });
}
