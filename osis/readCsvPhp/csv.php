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

    if(isset($_FILES)){
        $headers = array("CONTENT TYPE", "ISSN", "ABBR", "e-ISSN");
        csvHeader($headers, $_FILES["fileToUpload"]["name"]);
    }
    

        function csvHeader($array, $csvFile){
            $counter = 0;
            $csvHeaders = array();
            $openedFile = fopen($csvFile, "r");
              echo "<table>";
            while(!feof($openedFile)){
                $counter++;
                    $ar = fgetcsv($openedFile);
                
                    // Col headers
                    if($counter == 1){
                        echo "<thead><tr>";
                        for($i=0; $i<count($array); $i++){
                            if(in_array($array[$i], $ar)){
                                array_push($csvHeaders, array_search($array[$i], $ar));
                            }

                            $header_key = $csvHeaders[$i];

                            echo "<th>$ar[$header_key]</th>";
                        }
                             echo "</tr></thead>";
                    };

                    // Col body
                    echo "<tbody>";
                    if($counter > 1){
                        echo "<tr>";
                        for($i = 0; $i < count($csvHeaders); $i++){
                            $index = $csvHeaders[$i];
                            echo '<td><input type="text" value="'.$ar[$index].'"</td>';
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>";    
            } 
            echo "</table>";
        }
    

   
?>