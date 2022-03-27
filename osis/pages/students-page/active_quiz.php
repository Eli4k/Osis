<?php
  session_start();
    if ($_SESSION['loggedIn'] !='yes') {
      header('Location: ../../index.php?msg=Enter Username and Password');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>GAEC Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../../plugins/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/css/bootstrap-responsive.min.css"/>
<link rel="stylesheet" href="../../plugins/css/fullcalendar.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-style.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-media.css" class="skin-color" />
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">GAEC BASIC SCHOOL</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<div class="btn-group rightzero"> <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a> <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a> </div>
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class="" ><a title="" href="#"><i class="icon icon-user"></i> <span class="text" id="curr_user"></span></a></li>
    <li class=""><a title="" href="../../php/logout.inc.php?logout=clicked"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>

<!--close-top-Header-menu-->

<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a><ul>
    <li class="active"><a href="index.php"><i class="icon icon-home"></i> <span>Home</span></a> </li>
    <li> <a href="students_profile.php"><i class="icon icon-user"></i> <span>Profile</span></a> </li>
    <li> <a href="quiz.php"><i class="icon icon-list"></i> <span>Quiz</span></a> </li>
    <li> <a href="assessment_test.php"><i class="icon icon-list"></i> <span>Class Assessment Test</span></a></li>
    <li> <a href="student_report.php"><i class="icon icon-book"></i> <span>End Of Term Results</span></a></li>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
  <div class="container-fluid">
      <div class="row">
        <div class="span9">
          <div class="widget-box">
            <div class="widget-title" id="heading">
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" id="quiz_form" method="POST">
              </form>
            </div>
          </div>
        </div>
        <div class="span3">
          <div class="widget-box">
            <div class="widget-title">
              <h5>Time Left</h5>
            </div>
            <div class="widget-content nopadding" id="countdown">
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; GAEC BASIC SCHOOL</div>
</div>
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

<script type="text/javascript">
var curr_user = '<?php echo $_SESSION["fullname"];?>';
var sid = '<?php echo $_SESSION["sid"];?>';
var curr_id = '<?php echo $_SESSION["uname"];?>';
var class_id = '<?php echo $_GET["class"];?>';
var stream = '<?php echo $_SESSION["stream"];?>';
var ex = '<?php echo $_GET["ex"]?>';
var term = '<?php echo $_GET["term"]?>';
var yr = '<?php echo $_GET["yr"]?>';
var sub = '<?php echo $_GET["sub"]?>';

document.getElementById("curr_user").innerHTML = curr_user;

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
<script src="../../plugins/myjs/student/quiz/functions.js"></script>
</body>
</html>
