<?php

include  'config.php';
$sidebar = "";
if($_GET["content"]);

$id = $_GET['content'];

$query = $con->query("SELECT blog_id FROM blog WHERE blog_id != $id LIMIT 3");
if($query && !empty($query))
{
  while($row = $query->fetch_assoc())
  {
    $sidebar.='<div class="block-21 mb-4 d-flex">';
    $new_id = $row["blog_id"];
    $new_data = $con->query("SELECT * FROM blog WHERE blog_id = $new_id");
    foreach($new_data as $data)
    {
      $sidebar.='<a class="blog-img mr-4" style="background-image: url(php/admin/events/'.$data["title_media"].');"></a>
      <div class="text">
        <h3 class="heading"><a href="blog-single.php?content='.$new_id.'">'.$data["blog_title"].'</a></h3>
        <div class="meta">
          <div><a href="blog-single.php?content='.$new_id.'"><span class="icon-calendar"></span> '.date("M.d.Y", strtotime($data["blog_date"])).'</a></div>
          <div><a href="blog-single.php?content='.$new_id.'"><span class="icon-person"></span>Admin</a></div>
        </div>
      </div>';
    }
    $sidebar.='</div>';
  }
  echo $sidebar;
}

?>
