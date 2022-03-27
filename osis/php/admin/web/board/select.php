<?php
  include '../../../../config.php';

  $result='';

  $query="SELECT * FROM board";
  $query_exec = $con->query($query);
  if($query_exec){
    $i=1;
    while($row = $query_exec->fetch_assoc())
    {
        $board_id = $row["board_id"];
        $name = $row["name"];
        $position = $row["position"];
        $profile = $row["image"];

      $result.='<tr>
          <td width="1px">'.$i.'</td>
          <td align="center"><img src="../../php/admin/web/board/'.$profile.'" style="border-radius:50%; width: 70px; height: 70px;"></td>
          <td align="center">'.$name.'</td>
          <td>'.$position.'</td>
          <td><button onclick="delete_board(event);" class="btn btn-secondary btn-mini" data-id="'.$board_id.'">Delete</button></td>
      </tr>';
      $i++;
    }
  }else{
      $result.='<tr><td> Something went wrong: '.$con->error.'</td></tr>';
  }

  $data = array("output" => $result);
  echo json_encode($data);

  $con->close();
?>
