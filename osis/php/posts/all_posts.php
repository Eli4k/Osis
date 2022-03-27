<?php 
	
	$con = new mysqli("localhost","root","","schoolportal");
	$output = '';
	$sql = $con->query("SELECT post_id, first_name, last_name, heading, 
							   message, heading, post_time FROM teachers t 
							   JOIN posts p ON p.tid = t.tid ORDER BY post_id DESC LIMIT 5 	
					  ");


	if (!empty($sql)) {
		while($row = $sql->fetch_assoc())
		{
		 $output .=  '
			 <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="../../plugins/img/demo/av1.jpg"> </div>
                <div class="article-post"> <span class="user-info"> By: '.$row["first_name"]." ".$row["last_name"].' / Date:'.$row["post_time"].'
                  <p><a href="javascript:void(0);">'.$row["heading"].'</a></a>
                   <p class="msg_body">'.$row["message"].'</p> 
                </div>
             </li>';
		}
	}

	$data = array("result" => $output);

	echo json_encode($data);
?>