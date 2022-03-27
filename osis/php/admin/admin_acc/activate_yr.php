<?php

  require '../../config.php';

  if(isset($_GET['yr_id']))
  {
    $yr_id = $_GET['yr_id'];
    $query = $con->query("UPDATE academic_year SET  status = 1 WHERE yr_id = '$yr_id'");
  }

?>
