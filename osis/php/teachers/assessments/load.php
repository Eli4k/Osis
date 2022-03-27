<?php
  require '../../../config.php';

  $error = array();
  $output="";

  if(isset($_POST)){
      $user_id = $_POST["user_id"];

      $test_type = $con->query("SELECT DISTINCT ta.test_id, t.t_name FROM test_archives ta
                                JOIN test t ON t.test_id = ta.test_id WHERE tid = '$user_id' ");

      if(!$test_type){
          $error["error"] = "Error: ".$con->error;
      }else{
        // Load test type
        if(!empty($test_type)){

            $test_id = $test["test_id"];
            $test_name = $test["t_name"];

            $output.= '<div class="widget-box">
                          <div class="widget-box"><h5>'.$test_name.'</h5></div>
                          <table class="table dataTables table-bordered">
                            <thead><tr><th>#</th><th>Ex</th></tr></thead>
                            <tbody>';

                  $test_Exid = $con->query("SELECT DISTINCT(ex_id) FROM test_archives WHERE test_id = '$test_id' AND tid = '$user_id'
                                              AND term_id = '$term_id' AND c_id = '$c_id' AND s_id = '$s_id' AND yr_id = '$yr_id'");

                  if(!$test_Exid){
                    $error["error"] = "Error".$con->error;
                  }else{
                    // Load exercise ID
                    if(!empty($test_Exid)){
                      foreach($test_Exid as $ex){
                        $ex_id = $ex["ex_id"];

                          $class_score = $con->query("SELECT COUNT(ex_id) AS overall FROM test_archives WHERE test_id = '$test_id' AND tid = '$user_id'
                                                      AND term_id = '$term_id' AND c_id = '$c_id' AND s_id = '$s_id' AND yr_id = '$yr_id'");

                          if(!$class_score){
                            $error["error"] = "Error: ".$con->error;
                          }else{
                            if(!empty($class_score)){ //Load class score
                              foreach($class_score AS $class_grade){
                                $overall = $class_grade["ex_id"];

                                $output.='<tr><td><input type="checkbox" value="'.$ex_id.'"></td><td>'.$ex_id.'</td><td>'.$overall.'</td></tr>';
                              }
                            }else{ //End
                              $error["error"] = "No data available";
                            }
                          }
                      }
                    } //End
                    else{
                      $error["error"] = "No data avaliable";
                    }
                    $output.='<tfoot><tr><td colspan="3"><button class="btn btn-info btn">Add To Class Score</button></td></tr></tfoot>';
                  }
                  $output.='</div>';
          } //End
        }
  }

  $data = array("error" => $error,
                "output" => $output);

  echo json_encode($data);

  $con->close();

?>
