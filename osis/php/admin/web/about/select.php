<?php
  include 'config.php';

  $output = '<section class="ftco-section ftco-no-pt ftc-no-pb">
    <div class="container">
      <div class="row">
        <div class="col-md-10 order-md-last wrap-about py-5 wrap-about bg-light">
          <div class="text px-4 ftco-animate">
            <h2 class="mb-4">About us</h2>
            <div class="about_content">';

  $query="SELECT * FROM about";
  $query_exec = $con->query($query);

  if($query_exec){
    while($row = $query_exec->fetch_assoc())
    {
      // $data = array("content" => $row["content"]);
      // echo json_encode($data);
      $output.= $row["content"];
    }
  }
$output.='</div>
</div>
</div>
</div>
</div>
</section>';
  echo $output;
  $con->close();

?>
