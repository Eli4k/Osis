<?php

require '../../../../config.php';

$class_assigned=$subject_assigned=$academic_year=$ac_term=$test_type="";
$error = array();

if(isset($_POST["user_id"])){
  $user_id = $con->real_escape_string($_POST["user_id"]);

// Load test type
  $test_query = $con->query("SELECT * FROM test");
    if(!$test_query){
      $error["error"]= "Error: ".$con->error;
    }else{
      foreach($test_query as $test_data){
        $test_id = $test_data["test_id"];
        $test = $test_data["t_name"];
          $test_type.= '<option value="'.$test_id.'">'.$test.'</option>';
      }
    }
// End

// Load class assigned to teacher
  $class_query = $con->query("SELECT class_assigned FROM teachers WHERE teacher_id = '$user_id'");
    if(!$class_query){
      $error["error"] = "Error: ".$con->error;
    }else{
      foreach($class_query as $class_load_data){
        $array_class =  explode(",", $class_load_data["class_assigned"]);
          for($i=0; $i<count($array_class); $i++){
              $c_id = $array_class[$i];

              $sub_class_query = $con->query("SELECT cname FROM class WHERE c_id = '$c_id'");
              if($sub_class_query){
                foreach($sub_class_query as $sub_class_assigned){
                  $cname = $sub_class_assigned["cname"];

                  $class_assigned.= '<option value="'.$c_id.'">'.$cname.'</option>';
                }
              }else{
                $error["error"]= "Error: ".$con->error;
              }

          }
      }
    }
  // End

  // Load subject assigned to teacher
    $subject_query = $con->query("SELECT sub_assigned FROM teachers WHERE teacher_id = '$user_id'");
      if(!$subject_query){
        $error["error"] = "Error: ".$con->error;
      }else{
        foreach($subject_query as $subject_load_data){
          $array_subjects =  explode(",", $subject_load_data["sub_assigned"]);
            for($i=0; $i<count($array_subjects); $i++){
                $sub_id = $array_subjects[$i];

                $sub_subject_query = $con->query("SELECT sub_name FROM subjects WHERE sub_id = '$sub_id'");
                if($sub_subject_query){
                  foreach($sub_subject_query as $sub_subject_assigned){
                    $sub_name = $sub_subject_assigned["sub_name"];
                    $subject_assigned.= '<option value="'.$sub_id.'">'.$sub_name.'</option>';
                  }
                }else{
                  $error["error"]= "Error: ".$con->error;
                }
            }
        }
      }
    // End

    // Load academic year
    $year_query = $con->query("SELECT * FROM academic_year");
      if(!$year_query){
        $error["error"]= "Error: ".$con->error;
      }else{
        foreach($year_query as $year_data){
          $yr_id = $year_data["yr_id"];
          $year = $year_data["ac_yr"];
            $academic_year.= '<option value="'.$yr_id.'">'.$year.'</option>';
        }
      }
    // End
  }





$data = array("test_type" => $test_type,
              "class_assigned" => $class_assigned,
              "Error" => $error,
              "subject_assigned" => $subject_assigned,
              "academic_year" => $academic_year);

echo json_encode($data);

?>
