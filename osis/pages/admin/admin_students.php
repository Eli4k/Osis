  <?php
  session_start();
    if ($_SESSION['loggedIn'] != "yes") {
      header('Location: ../../index.php?msg=Login to your Account');
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
  <script type="text/javascript" src="../../plugins/myjs/parser/papaparse.min.js"></script>
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
      <li class=""><a title="" href="#"><i class="icon icon-user"></i> <span class="text" id="curr_user"></span></a></li>
      <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a class="sAdd" title="" href="#">new message</a></li>
          <li><a class="sInbox" title="" href="#">inbox</a></li>
          <li><a class="sOutbox" title="" href="#">outbox</a></li>
          <li><a class="sTrash" title="" href="#">trash</a></li>
        </ul>
      </li>
      <li class=""><a title="logout" href="../../php/admin_logout.inc.php?logout=clicked"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
    </ul>
  </div>
  <!--close-top-Header-menu-->

  <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Home</a><ul>
      <li><a href="index.php"><i class="icon icon-home"></i> <span>Home</span></a> </li>
      <li class="active"> <a href="admin_students.php"><i class="icon icon-user"></i> <span>Students</span></a> </li>
      <li><a href="admin_teachers.php"><i class="icon icon-briefcase"></i> <span>Teachers</span></a></li>
      <li><a href="pupils_report.php"><i class="icon icon-list"></i> <span>Report Slip</span></a></li>
      <li><a href="website.php"><i class="icon icon-globe"></i> <span>Website</span></a></li>
      <li><a href="admin_acc.php"><i class="icon icon-book"></i> <span>Curriculum</span></a></li>

  </div>
  <div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>Home</a></div>
      <p id="msg"></p>
    </div>
    <div class="container-fluid">
      <div class="quick-actions_homepage">
        <ul class="quick_actions">
          <li>
            </li>
        </ul>
      </div>
      <div class="row-fluid">
          <div class="span12">
            <div class="widget-box">
              <div class="widget-title">
                <ul class="nav nav-tabs">
                  <li class="active">
                    <a href="#view" data-toggle="tab">Students</a>
                  </li>
                  <li>
                    <a href="#add" data-toggle="tab">Add / Edit Students Info</a>
                  </li>
                  <li>
                    <a href="#multi_add" data-toggle="tab">Add From File</a>
                  </li>
                </ul>
              </div>
              <div class="widget-content tab-content">
                <div id="view" class="tab-pane active">
                  <div class="row-fluid">
                    <div class="span12">
                      <div class="widget-box">
                        <div class="widget-title">
                          <h5>All Students</h5>
                          <h5 id="total"></h5>
                          <div class="btn-group" style="float:left; margin:4px">
                            <button class="btn">Action</button>
                            <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li onclick="clickList(event);"><a href="javascript:void(0)" data-action="promote">Promote</a></li>
                              <li onclick="clickList(event);"><a href="javascript:void(0)" data-action="revert" >Revert Class</a></li>
                              <li onclick="clickList(event);"><a href="javascript:void(0)" data-action="transfer" >Transfer</a></li>
                              <li onclick="clickList(event);"><a href="javascript:void(0)" data-action="alumni" >Alumni</a></li>
                            </ul>
                          </div>
                          <button type="button" id="go" name="button" style="float:right; margin:4px">Search</button>
                          <select id="stream" class="span2" style="float:right; margin:4px"></select>
                          <select id="level" class="span2" style="float:right; margin:4px"></select>
                          <input type="text" name="search" style="float:right; margin:4px" class="span3" placeholder="Search by name, class, stream or Id">
                          <button type="button" id="print" name="print" style="float:right; margin:4px" class="btn btn-info btn">Print</button>
                        </div>
                        <div class="widget-content nopadding">
                          <table class="table dataTables table-bordered all_stud_table" id="student_table_data">
                            <thead>
                              <tr>
                                <th width="1%"><input type="checkbox" id="all_students"></th>
                                <th width="5%">ID</th>
                                <th width="15%">FULL NAME</th>
                                <th width="7%">STREAM</th>
                                <th width="7%">CLASS</th>
                                <th width="8%">DATE OF BIRTH</th>
                                <th width="11%">EMAIL</th>
                                <th width="11%">CONTACT</th>
                                <th width="6%">STATUS</th>
                                <th width="11%">ACTION</th>
                              </tr>
                            </thead>
                            <tbody class="tbody"></tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="add" class="tab-pane">
                  <div class="row-fluid">
                    <div class="widget-box span6">
                      <div class="widget-title">
                        <h5>Add Student</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <form class="form-horizontal">
                          <div class="control-group">
                            <label class="control-label">First Name: </label>
                            <div class="controls">
                              <input type="text" name="first" class="span11" required>
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Last Name: </label>
                            <div class="controls">
                              <input type="text" name="last" class="span11" required>
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Other Name: </label>
                            <div class="controls">
                              <input type="text" name="other" class="span11">
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Date of birth: </label>
                            <div class="controls">
                              <input type="date" name="dob" class="span11" required>
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Gender: </label>
                            <div class="controls">
                              <select id="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Contact: </label>
                            <div class="controls">
                              <input type="text" name="contact" class="span11" required>
                            </div>
                          </div>
                          <div class="control-group">
                            <label class="control-label">Email: </label>
                            <div class="controls">
                              <input type="email" name="email" class="span11">
                            </div>
                          </div>
                          <div class="form-actions">
                              <input type="submit" name="Add" class="btn btn-primary btn" value="Add">
                              <input type="hidden">
                              <button class="btn btn-warning btn" name="Save">Save</button>
                              <button class="btn btn-danger btn" name="Cancel">Cancel</button>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="span6">
                      <div class="widget-box">
                        <div class="widget-title">
                          <h5>Assign Class</h5>
                        </div>
                        <div class="widget-content nopadding">
                          <div class="row-fluid">
                            <div class="span12">
                              <div class="control-group">
                                <label class="control-label">Student ID: </label>
                                <div class="controls">
                                  <input type="text" name="student_id" class="span11" disabled>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Date Registered: </label>
                                <div class="controls">
                                  <input type="date" name="adm" class="span11" required>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Stream: </label>
                                <div class="controls">
                                    <select class="span11" id="stream">

                                    </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Entry Class: </label>
                                <div class="controls">
                                  <select class="span11" name="">

                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Current Class: </label>
                                <div class="controls">
                                  <select class="span11" name="">

                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="multi_add" class="tab-pane">

                      <h3><strong>Note</strong> File must have column headers in the following order</h3>
                      <h5>Firstname, Lastname, Othername, Date of Birth, Date Registered,  Gender, Email, Contact</h5>
                <form action="" enctype="multipart form-data">
                <input class="btn btn-secondary btn" onchange = "checkExt(event);" type="file" accept=".csv">
                  <input type="submit" value="Import Csv"  class="btn btn-success btn">
                </form>
                  

                    <div class="widget-box">
                      <div class="widget-title">
                        <h5>Add data From Csv Files</h5>
                        <h5>Entry Class: </h5><select style="float:left; margin:4px"></select>
                          <select style="float:left; margin:4px"></select>
                          <button class="btn btn-info btn" style="float:left; margin:4px">Upload</button>
                      </div>
                      <table class="table dataTables table-bordered" id="file_upl_tbl" style="width:100%">
                      </table>
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
  </div>
  <div class="row-fluid">
    <div id="footer" class="span12"> 2020 &copy; Ghana Atomic Energy Comission.</a></div>
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
  <script src="../../plugins/js/maruti.chat.js"></script>
  <!-- <script src="../../plugins/myjs/admin/students/students.js"></script> -->



  <script type="text/javascript">
     var curr_user = '<?php echo $_SESSION["fullname"];?>';
    var curr_id = '<?php echo $_SESSION["uname"];?>';

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
  <script src="../../plugins/myjs/admin/students/students.js"></script>
  <!-- <script src="../../plugins/myjs/teacher/global_teacher_functions.js"></script> -->
  </body>
  </html>
