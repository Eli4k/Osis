<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="#" enctype="multipart/form-data" method="POST">
        <input type="FILE" value="file" accept="csv" name="fileToUpload">
        <input type="submit" value="Upload">
    </form>
</body>
</html>

<?php

    if(isset($_POST)){
        
        $f_pointer = fopen($_FILES["fileToUpload"]["name"], "r");
        $key_arr = array();
        $arr_keys_count = 0;

        echo '<table><thead>';

        while(! feof($f_pointer)){
            $ar = fgetcsv($f_pointer);
           

            $arr_keys_count++;

            if($arr_keys_count==1){
               
                if(in_array(strtoupper("content type"), $ar)){
                  array_push($key_arr, array_search(strtoupper("content type"), $ar));
                }

                if(in_array(strtoupper("issn"), $ar)){
                    array_push($key_arr, array_search(strtoupper("issn"), $ar)); 
                  }

            }
            break;
            
        }
            for($i=0; $i < count($key_arr); $i++){
                $index = $key_arr[$i];
                echo "<th>".$ar[$index]."</th>";
            }


        echo '</thead><tbody>';
        while(! feof($f_pointer)){
            $ar = fgetcsv($f_pointer);
           

            $arr_keys_count++;

            if($arr_keys_count>1){
                // print_r($ar);

                 echo '<tr><td>'.$ar[$key_arr[0]].'</td><td>'.$ar[$key_arr[1]].'</td></tr>';
            }
           
        }
        echo '</tbody></table>';


        
    }
        fclose($f_pointer);

    
    
    

   
?>