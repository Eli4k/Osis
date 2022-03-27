<?php
require '../../../../config.php';


$output="";
if(isset($_POST["tid"]))
{
  $tid = $_POST["tid"];
  $class_total = 0;

  $query = $con->query("SELECT DISTINCT c.cname, cs.term_id, term.term_name, cs.c_id, cs.sub_id, sub.sub_name, cs.s_id, cs.yr_id, y.ac_yr, cs.used FROM class_score cs
			                     JOIN class c ON cs.c_id = c.c_id
                           JOIN academic_year y ON cs.yr_id = y.yr_id
                           JOIN term term ON cs.term_id = term.term_id
                           JOIN subjects sub ON cs.sub_id = sub.sub_id WHERE tid = '$tid' AND cs.term_id ORDER by cs.yr_id DESC");

  if($query){
    if(!empty($query)){
      foreach($query as $assessment_info){
        $c_id = $assessment_info["c_id"];
        $cname = $assessment_info["cname"];
        $sub_id = $assessment_info["sub_id"];
        $sub_name = $assessment_info["sub_name"];
        $yr_id = $assessment_info["yr_id"];
        $year = $assessment_info["ac_yr"];
        $s_id = $assessment_info["s_id"];
        $term_id = $assessment_info["term_id"];
        $term_name = $assessment_info["term_name"];
        $used = $assessment_info["used"];

        if($used == "1"){
          $output.='<div class="row span4">
                    <div class="widget-box">
                        <div class="widget-title" data-class="'.$c_id.'" data-sub="'.$sub_id.'"  data-year="'.$yr_id.'">
                            <h5>'.$cname.'</h5><h5>'.$sub_name.'</h5> </div>
                        <div class="widget-title"><h5>'.$year.'</h5> <h5>'.$term_name.'</h5></div>
                          <table class="table dataTables table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>EXERCISE</th>
                                  <th>Grade %</th>
                                  <th>ACTION</th>
                                </tr>
                              </thead>
                              <tbody>';
        }else{
          $output.='<div class="row span4">
                    <div class="widget-box">
                        <div class="widget-title" data-class="'.$c_id.'" data-sub="'.$sub_id.'"  data-year="'.$yr_id.'">
                            <h5>'.$cname.'</h5><h5>'.$sub_name.'</h5><button style="float: right; margin:4px" class="btn btn-info btn" onclick="generateCustom(event);" data-sub="'.$sub_id.'" data-yr="'.$yr_id.'" data-c_id="'.$c_id.'" data-term="'.$term_id.'" data-stream="'.$s_id.'">Generate</button></div>
                        <div class="widget-title"><h5>'.$year.'</h5> <h5>'.$term_name.'</h5></div>
                          <table class="table dataTables table-bordered">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>EXERCISE</th>
                                  <th>Grade %</th>
                                  <th>ACTION</th>
                                </tr>
                              </thead>
                              <tbody>';
        }



            $exercises = $con->query("SELECT DISTINCT ex_id, cs.test_id, tt.t_name, percent_score FROM class_score cs
              JOIN test tt ON cs.test_id = tt.test_id
              WHERE tid='$tid' AND sub_id = '$sub_id' AND c_id = '$c_id' AND yr_id = '$yr_id' AND term_id = '$term_id'");
            if($exercises){
              $i=1;
              if(!empty($exercises)){
                    foreach($exercises as $ex_id){
                      $test_id = $ex_id["test_id"];
                      $test = $ex_id["t_name"];
                      $ex = $ex_id["ex_id"];
                      $score = $ex_id["percent_score"];
                      $output.='<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$test.' - '.$ex.'</td>
                                    <td data-test = "'.$test_id.'">'.$score.'</td>
                                    <td><button onclick="edit_assessment(event);" data-term="'.$term_id.'" data-yr="'.$yr_id.'" data-level="'.$c_id.'" data-test="'.$test_id.'" data-sub="'.$sub_id.'" data-ex="'.$ex.'" data-stream="'.$s_id.'">Edit</button>
                                      <button onclick="remove_assessment(event);" data-term="'.$term_id.'" data-yr="'.$yr_id.'" data-level="'.$c_id.'" data-test="'.$test_id.'" data-sub="'.$sub_id.'" data-ex="'.$ex.'" data-stream="'.$s_id.'">Remove</button>
                                      <a target="_blank" href="results.php?term='.$term_id.'&&yr='.$yr_id.'&&level='.$c_id.'&&test='.$test_id.'&&sub='.$sub_id.'&&ex='.$ex.'&&stream='.$s_id.'&&tid='.$tid.'"><button>View</button></a>
                                    </td></tr>';
                          $i++;
                    }
              }else{
                $output.='<tr><td colspan="2"> No records available</tr>';
              }
            }else{
              $output.='<tr><td colspan="2"> Error:'.$con->error.'</tr>';
            }

            $output.='</tbody></table></div></div>';
      }
    }
  }
}

$data = array("output" => $output);
echo json_encode($data);

?>
