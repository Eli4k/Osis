<?php
session_start();
if ($_SESSION['loggedIn']!="yes") {
 header('Location: ../../index.php?msg=Enter username and password to login');
 exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>GAEC Basic School</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../../plugins/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../../plugins/css/fullcalendar.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-style.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-media.css" class="skin-color" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Eli</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<div class="btn-group rightzero"> <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a> <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a> </div>
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="#"><i class="icon icon-user"></i> <span class="text"><?php echo $_SESSION['fullname']; ?></span></a></li>
    <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#">new message</a></li>
        <li><a class="sInbox" title="" href="#">inbox</a></li>
        <li><a class="sOutbox" title="" href="#">outbox</a></li>
        <li><a class="sTrash" title="" href="#">trash</a></li>
      </ul>
    </li>
    <li class=""><a title="logout" href="../../php/logout.inc.php?logout=clicked"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>

<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Home</a><ul>
  <li class="active"><a href="index.php"><i class="icon icon-home"></i> <span>Home</span></a> </li>
  <li><a href="quiz.php"><i class="icon icon-list"></i> <span>Quiz</span></a> </li>
  <li> <a href="my-class.php"><i class="icon icon-book"></i> <span>Assessment Tests</span></a> </li>
  <li><a href="final_assessment.php"><i class="icon icon-th"></i> <span>Results</span></a></li>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
  <div class="container-fluid">
    <div class="quick-actions_homepage" width="100px">
      <select class="level">
      </select>
      <select class="subject">
      </select>
      <select class="stream">
      </select>
      <select class="ac_year">
      </select>
      <input type="button" id="go" value="GO" class="btn btn-info btn">
    </div>
   <div class="result">
   </div>
  </div>

</div>

</div>
</div>
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; Ghana Atomic Energy Comission.</a></div>
</div>
<script type="text/javascript">
  var user_id = <?php echo json_encode($_SESSION["uname"]); ?>;
  var tid = <?php echo json_encode($_SESSION["tid"]);?>;
</script>
<!-- <script src="../../plugins/myjs/teacher/results/filter_by.js"></script> -->
<script src="../../plugins/js/excanvas.min.js"></script>
<script src="../../plugins/js/jquery.min.js"></script>
<script src="../../plugins/js/jquery.ui.custom.js"></script>
<script src="../../plugins/js/bootstrap.min.js"></script>
<script src="../../plugins/js/jquery.flot.min.js"></script>
<script src="../../plugins/js/jquery.flot.resize.min.js"></script>
<script src="../../plugins/js/jquery.peity.min.js"></script>
<script src="../../plugins/js/fullcalendar.min.js"></script>
<script src="../../plugins/js/maruti.js"></script>
<script src="../../plugins/js/maruti.dashboard.js"></script>
<script src="../../plugins/js/maruti.chat.js"></script>
<script src="../../plugins/myjs/teacher/global_teacher_functions.js"></script>
<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();
          }
          // else, send page to designated URL
          else {
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
<script type="text/javascript">
  $.ajax({
    url: '../../php/teachers/final_assessments/load_all.php',
    type: 'POST',
    dataType:'JSON',
    data: {tid: user_id},
    success: function(data){
      document.querySelector(".result").innerHTML = data.output;
      console.log(data.error.error);
    }
  })
</script>
</body>
</html>
