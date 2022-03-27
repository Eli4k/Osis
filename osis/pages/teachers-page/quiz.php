<?php
session_start();
  if ($_SESSION['loggedIn'] != "yes") {
    header('Location: ../../index.php?msg=Login to your Account');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>GAEC Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../../plugins/css/bootstrap.min.css" />
<link rel="stylesheet" href="../../plugins/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../../plugins/css/fullcalendar.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-style.css" />
<link rel="stylesheet" href="../../plugins/css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="../../home_page/css/kiddos.css"/>
<link rel="stylesheet" href="../../plugins/mycss/custom_table.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>
<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">GAEC Admin</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-messaages-->
<div class="btn-group rightzero"> <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a> <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a> </div>
<!--close-top-Header-messaages-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class="" ><a title="" href="#"><i class="icon icon-user"></i> <span class="text" id="curr_user"></span></a></li>
    <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#">new message</a></li>
        <li><a class="sInbox" title="" href="#">inbox</a></li>
        <li><a class="sOutbox" title="" href="#">outbox</a></li>
        <li><a class="sTrash" title="" href="#">trash</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="../../php/logout.inc.php?logout=clicked"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->

</div>
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a><ul>
  <li class="active"><a href="index.php"><i class="icon icon-home"></i> <span>Home</span></a> </li>
  <li><a href="quiz.php"><i class="icon icon-list"></i> <span>Quiz</span></a> </li>
  <li> <a href="my-class.php"><i class="icon icon-book"></i> <span>Assessment Tests</span></a> </li>
  <li><a href="final_assessment.php"><i class="icon icon-th"></i> <span>Results</span></a></li>
</div>
  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="../index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#" class="current">Quiz</a>
      </div>
    </div>
    <div class="req_response"></div>
    <div class="container-fluid">
          <div>
           <div class="row-fluid">
            <div class="widget-box">
              <div class="widget-title">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a data-toggle="tab" href="#new_quiz">NEW QUIZ</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#all_quiz">QUIZ INFO</a>
                  </li>
                </ul>
              </div>
              <div class="widget-content tab-content">
                <div id="new_quiz" class="tab-pane active">
                  <div class="row-fluid">
                          <div class="span8">
                              <div class="widget-box">
                                <div class="widget-title">
                                  <span class="icon"><i class="icon-list-alt"></i></span>
                                  <h5>Quiz</h5>
                                  <h5>No.: <span id="ex_num"></span></h5>
                                </div>
                                <div class="widget-content nopadding">
                                  <form class="form-horizontal" method="POST" id="quiz-form">
                                    <div class="form-actions" style="align-text: center">
                                      <div class="control-groups">
                                        <button type="button" title="Add Another Question" id="add_qst" class="btn btn-secondary btn">Add A Question</button>
                                        <button type="submit" title="Post Questions" name="submit" class="btn btn-secondary btn">Sumbit</button>
                                      </div>
                                    </div>
                                  </form>
                                  <input type="hidden" id="quiz_num">
                                </div>
                              </div>
                          </div>
                          <div class="span4">
                            <div class="widget-box">
                              <div class="widget-title">
                                <span class="icon"><i class="icon-wrench"></i></span>
                                <h5>Quiz Setup</h5>
                              </div>
                              <div class="widget-content nopadding">
                                <form class="form-horizontal">
                                    <div id="settings_form">
                                <!-- Quiz Duration   -->
                                  <div class="control-group">
                                  <span class="help-block">Set the time duration for the test</span>
                                    <div class="controls">
                                      <input type="number" name="hours" max="60" min="00" size="2" placeholder="Hours">
                                      <input type="number" name="minutes"  max="60" min="00" size="2" placeholder="Minutes">
                                    </div>
                                  </div>

                                  <!-- Subject -->
                                  <div class="control-group">
                                    <label class="control-label">Subject : </label>
                                    <div class="controls">
                                        <select class="subject">
                                        </select>
                                    </div>
                                  </div>
                                  <!-- End -->

                                  <!-- Term -->
                                  <div class="control-group">
                                      <label class="control-label">Term : </label>
                                    <div class="controls">
                                        <!-- <span class="help-block">Academic Term</span> -->
                                        <select class="term">
                                        </select>
                                    </div>
                                  </div>
                                  <!-- End -->

                                  <!-- Class -->
                                  <div class="control-group">
                                    <label class="control-label">Class : </label>
                                    <div class="controls">
                                      <select class="level">

                                      </select>
                                    </div>
                                  </div>
                                  <!-- End -->

                                  <!-- Stream -->
                                  <div class="control-group">
                                    <label class="control-label">Stream : </label>
                                    <div class="controls">
                                        <!-- <span class="help-block">Select Stream</span> -->
                                        <select class="stream">
                                        </select>
                                    </div>
                                  </div>

                                  <!-- Academic Year -->
                                  <div class="control-group">
                                      <label class="control-label">Academic Yr : </label>
                                    <div class="controls">
                                        <!-- <span class="help-block">Academic Year</span> -->
                                        <select class="ac_year">
                                        </select>
                                    </div>
                                  </div>
                                </div>
                                    <div class="form-actions">
                                              <button title="Change Settings"type="button" class="btn btn-secondary btn" name="setup_edit">Edit <span class="icon"><i class="icon-edit"></i></span></button>
                                              <button title="Save Changes" type="button" class="btn btn-success btn" name="setup_save">Save <span class="icon"><i class="icon-check"></i></span></button>
                                      </div>
                                </form>
                              </div>

                            </div>
                          </div>
                  </div>
                </div>
                <div id="all_quiz" class="tab-pane">
                  <div class="all">
                    <div class="row-fluid">
                      <div class="span12">
                        <table class="table dataTables table-bordered">
                          <thead>
                          </thead>
                        </table>
                      </div>
                      <div class="filter_result">
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
           </div>
          </div>
    </div>
  </div>


<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; GAEC Basic School. Brought to you by <a href="http://liveksystems.com">GAEC BASIC SCHOOL</a> </div>
</div>
<!-- <script src="../../plugins/js/postBody.js"></script> -->
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
<script src="../../plugins/myjs/teacher/quiz.js"></script>
<script type="text/javascript">
  var curr_user = '<?php echo $_SESSION["fullname"];?>';
  var curr_id = '<?php echo $_SESSION["uname"];?>';
  var user_id = '<?php echo $_SESSION["uname"];?>';

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
<script src="../../plugins/myjs/teacher/list_quiz.js">
</script>
<script src="../../plugins/myjs/teacher/global_teacher_functions.js"></script>
</body>
</html>
