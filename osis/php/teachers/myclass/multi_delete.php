<?php
  if(isset($_POST['id']))
  {
      $data = var_dump($_POST['id']);
  }
?>
<html>
    <head>
        <title>
            
        </title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>
    <body>
       
        <table class="checkTable">
             <tr>
                <th><input type="checkbox" class="selectAll"></th>
                <th><button class="mail_button">Mail</button></th>
            </tr>
            <tr>
                <td><input type="checkbox" name="ch" id="1" value="1"></td>
                <td>Senam</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="ch" id="2" value="1"></td>
                <td>Eli</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="ch" id="3" value="1"></td>
                <td>Seli</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="ch" id="4" value="1"></td>
                <td>Setor</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="ch" id="5" value="1"></td>
                <td>Vandam</td>
            </tr>
           
        </table>
        
        <script>
            $(document).ready(function(){
               $(".selectAll").bind('click',function(){
                     var tab = $(this).closest('.checkTable');
                     var checkedState = this.checked;
                    $(':checkbox', tab).each(function(){
                        this.checked = checkedState;
                    })
               });
               
               $(".mail_button").click(function(){
                   if(confirm("Are you sure you want to delete this?"))
                   {
                    var id = [];
                    
                    $('input[name="ch"]:checked').each(function(i){
                        id[i]= $(this).val();
                        
                    });
                    
                    if(id.length === 0)//tell you if the array is empty
                    {
                        alert("Please Select at least one chekbox");
                    }else{
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: {grade:id, email:email},
                            dataType: 'JSON',
                            success: function(data){
                               alert(data.data);
                            }
                        })
                    }
                   }else{
                       return false;
                   }
               })
               
               
            });
        </script>
    </body>
    
</html>
