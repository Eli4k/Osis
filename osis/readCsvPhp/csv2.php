<?php

    ini_set("allow_url_fopen", 1);


    if(isset($_FILES)){
        $headers = array('FIRSTNAME', 'LASTNAME', 'OTHERNAME', 'DATE OF BIRTH', 'DATE REGISTERED', 'GENDER', 'EMAIL', 'CONTACT');
        echo csvHeader($headers, $_FILES["fileToUpload"]["tmp_name"]);
    }else{
        echo "Something is wrong";  
        exit();
    }


        function csvHeader($array, $csvFile){
          
            $file = fopen($csvFile,"r");
            $ar = fgetcsv($file);
            $csvHeaders = array();
            $blank_keys = array();
            $table="";

            function lowerCaseArr($arr){ return strtolower($arr);}

            $lkey_arr = array_map("lowerCaseArr", $ar);
        
            $table ='<thead><tr>';
            foreach($array as $key => $value){
                if(in_array(strtolower($value), $lkey_arr)){
                    array_push($csvHeaders, array_search($value, $ar));
                    }else{
                    array_push($csvHeaders, NULL);
                    }
                    $table.='<th>'.$value.'</th>';       
             }
             $table.= '</tr></thead><tbody id="tbody">';

             $counter = 0;

            while(!feof($file)){
                $counter++;
                $table.='<tr>';
             if($counter > 1){
                    $row = fgetcsv($file);
                for($i=0; $i<count($csvHeaders); $i++){
                   if(isset($row[$csvHeaders[$i]])){
                       $data = $row[$csvHeaders[$i]];
                      if($i==3 || $i==4){
                           $table.='<td><input type="date" value="'.date('Y-m-d', strtotime($data)).'" required></td>';
                       }else{$table.='<td><input type="text" value="'.$data.'" required></td>';}
                       
                   }else if(!isset($row[$csvHeaders[$i]])){
                      if($i == 3 || $i == 4){
                          $table.='<td><input type="date" required></td>';
                      }else{
                        $table.='<td><input type="text"/></td>';
                      } 
                       
                   }
                }
            }
           
            $table.='</tr>';
        }
        $table.='</tbody>';

        $data = array("tbl_arr" => $table, "arr_data" => $csvHeaders);
            return json_encode($data);
        }   

    
   
?>