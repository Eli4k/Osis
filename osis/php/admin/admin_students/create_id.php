<?php
require '../../../config.php';

$total=NULL;
$msg="";
$new_id="";

if(isset($_GET)){
  $stream = $con->real_escape_string($_GET["stream"]);
  $adm_yr = $con->real_escape_string($_GET["adm"]);
  $_char = $con->real_escape_string($_GET["char"]);

  $yr = date("Y", strtotime($adm_yr));

  $sql =$con->query("SELECT count(sid) as total FROM students WHERE YEAR(admission_date) = '$yr' AND s_id = '$stream'");

  if($sql){
      $data = $sql->fetch_assoc();
      $total = intval($data["total"]);
      $total = $total+1;
      $new_id.= substr($_char,0,1).$yr.str_pad($total,4,"0",STR_PAD_LEFT);
      $msg.="Creation of id successful";
    }else{
      $msg = "Something went wrong".$con->error;
  }
}else{$msg ="Something went wrong: ".$con->error;}

$data = array("id" => $new_id, "msg"=>$msg);

echo json_encode($data);
$con->close();

?>
