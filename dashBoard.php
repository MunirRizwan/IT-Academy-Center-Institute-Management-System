<?php
require_once './userSession.php';
include './backup.php';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require_once './header.php'; ?>
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">

                <!--===========MODEL Change PassWord BATCH============-->
                <div class="md-modal md-effect-4" id="user">
                    <div class="md-content">
                        <h3 style="background-color: #009889;color: white;">Change username / password</h3>
                        <div class="n-modal-body" style="">
                            <div style="font-weight: bold;color: red;" id="changeError">

                            </div>
                            <div class="form-group">
                                <label for="userName">User Name : </label>
                                <input type="text" autofocus value="<?php echo $_SESSION["username"]; ?>"  class="form-control" placeholder="e.g: DIT may-2019 to may-2020" id="userName">
                            </div>
                            <div class="form-group">
                                <label for="oldPassword">Enter the Old Password : </label>
                                <input type="password" autofocus class="form-control" placeholder="******" id="oldPassword">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Enter the New Password : </label>
                                <input type="password" autofocus class="form-control" placeholder="******" id="newPassword">
                            </div>

                            <br><br>
                            <div class="text-right">
                                <hr>
                                <input type="button" class="btn btn-danger md-close" value="Close me!"/>
                                <input type="button" class="btn btn-success" style="margin-left: 5px;" onclick="changeUser('<?php echo $_SESSION["username"]; ?>', '<?php echo $_SESSION["password"]; ?>')" value="ADD"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md-overlay"></div>
                <!--===========END MODEL ADD BATCH============-->
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top ">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-tasks"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown dropdown-user admin-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                                    <div class="user-image">
                                        <img src="images/1.jpg" class="img-circle" height="40" width="40" alt="User Image">
                                    </div>
                                </a>
                                <ul class="dropdown-menu">

                                    <li class="md-trigger m-b-5 m-r-2" style="cursor: pointer;" data-modal="user"><a ><i class="fa fa-users"></i>Change username / password</a></li>
                                    <li style="cursor: pointer;"><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>

                                    <?php require_once './LogOutChangePassWord.php'; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </nav>
            </header>
            <!-- =============================================== -->
            <?php require_once './sideBar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header"> 
                    <div class="header-icon">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <div class="header-title">
                        <div class="row">
                            <div class="col-sm-4">
                                <h1> Max Tech Computer Institute</h1>
                                <small> Your Satisfaction Is Our Motto</small>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button class="btn btn-warning md-trigger m-b-5 m-r-2" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i> Search</button>


                                <!-- Modal -->
                                <div id="myModal" class="modal fade text-left" role="dialog">
                                    <div class="modal-dialog  modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Search Student</h4>
                                            </div>
                                            <div class="modal-body">
                                                <label>Enter Name:</label>
                                                <input onkeyup="checkData()" type="text" name="search" class="form-control" id="search"/>
                                                <br><br>
                                                
                                                 <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>F Name</th>
                                                                <th>Batch</th>
                                                                <th>Info</th>
                                                                <th>Fee details</th>
                                                                <th>Admission Fee</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody id="searchTableBody">
                                                            
                                                        </tbody>
                                                 </table>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
								
								
								 <button class="btn btn-success md-trigger m-b-5 m-r-2" data-toggle="modal" data-target="#myModal2"><i class="pe-7s-add-user"></i> Add New Batch</button>


                                <!-- Modal -->
                                <div id="myModal2" class="modal fade text-left" role="dialog">
                                    <div class="modal-dialog  modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                             <div class="md-content">
                                        <h3 style="background-color: #009889;color: white;">Add New Batch</h3>
                                        <div class="n-modal-body" style="">
                                            <div class="form-group" id="divBatch">
                                                <label for="addNewBatch">Enter the New Batch Name : </label>
                                                <input type="text" autofocus class="form-control" placeholder="e.g: DIT may-2019 to may-2020" id="addNewBatchInput">
                                            </div>

                                            <br><br>
                                            <div class="text-right">
                                                <hr>
                                                <input type="button" class="btn btn-danger md-close" value="Close me!"/>
                                                <input type="button" class="btn btn-success" style="margin-left: 5px;" onclick="addNewBatch()" value="ADD"/>
                                            </div>
                                        </div>
                                    </div>
                                        </div>

                                    </div>
                                </div>




                            </div>
                        </div>



                    </div>
                </section>
                <!-- Main content -->

                <section class="content">
                    <div class="row">







                        <div class="col-sm-6">
                            <h3 style="text-align: center;border-bottom: 1px solid silver;">Current Session</h3>
                            <?php
                            $i = 0;
                            $AllBatch = $db->fetch_all_order('session_tbl', 'session_id');
                            foreach ($AllBatch as $key) {
                                $id = $key->session_id;
                                $studentCount = $db->countRow("SELECT COUNT(*) FROM student_info where session_id = '$id'");
                                ?>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    <a href="allStudentInfo.php?session=<?php echo $id ?>">
                                        <div class="panel panel-bd cardbox" style="height: 130px;">
                                            <div class="panel-body">
                                                <div class="statistic-box" >
                                                    <h2 style=""><span class="count-number"><?php echo $studentCount; ?></span>
                                                    </h2>
                                                </div>
                                                <div class="items">
                                                    <i style="margin: 10px;" class="fa fa-users fa-2x"></i>
                                                    <h4 style="padding-top: 10px;"><?php
                                                        echo $key->session_title;
                                                        if ($i == 0) {
                                                            echo "  (1st Semester)";
                                                        }
                                                        if ($i == 1) {
                                                            echo "  (2nd Semester)";
                                                        }
                                                        ?>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


    <?php $i++;
    if ($i == 2) {
        break;
    }
} ?>

                        </div>
                        <div class=" col-sm-6" style="padding-bottom: 50px;border-left: 2px solid green;">
                            <h3 style="text-align: center;border-bottom: 1px solid silver;">Previous Session</h3>

<?php
foreach ($AllBatch as $key) {
    $id = $key->session_id;
    $studentCount = $db->countRow("SELECT COUNT(*) FROM student_info where session_id = '$id'");
    ?>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <a href="allStudentInfo.php?session=<?php echo $id ?>">
                                        <div class="panel panel-bd cardbox"  style="height: 130px;">
                                            <div class="panel-body">
                                                <div class="statistic-box" >
                                                    <h2 style=""><span class="count-number"><?php echo $studentCount; ?></span>
                                                    </h2>
                                                </div>
                                                <div class="items">
                                                    <i style="margin: 10px;" class="fa fa-users fa-2x"></i>
                                                    <h4 style="padding-top: 10px;"><?php echo $key->session_title; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>


<?php } ?>


                        </div>


                    </div>



                </section> <!-- /.content -->

            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
                <strong>Copyright &copy; 2019 <a href="#">maxtech.edu.pk</a>.</strong> All rights reserved.
            </footer>
        </div> <!-- ./wrapper -->
        <!-- the overlay element -->

        <!-- ./wrapper -->
        <!-- Start Core Plugins-->
<?php require_once './footerJavaScript.php'; ?>
        <!-- End Page Lavel Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->


        <script>
            
           function  checkData(){
               
               var search = $("#search").val();
                 $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {searchStudent: search},
                        type: 'POST',
                        success: function (data) {
                            document.getElementById('searchTableBody').innerHTML = data;

                        }
                    });
            }
            
            function addNewBatch() {

                if ($("#addNewBatchInput").val() == "") {
                    $("#stdName").focus();
                    $("#divBatch").addClass("has-error");
                } else {
                    var batchName = {
                        "session_title": $("#addNewBatchInput").val()
                    };
                    $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {batchName: batchName},
                        type: 'POST',
                        success: function (data) {
                            if (data == 1) {
                                swal({
                                    title: "Good job!",
                                    text: "Session Added Succesfully",
                                    icon: "success",
                                    type: "success",
                                    confirmButtonColor: "#009889",
                                    confirmButtonText: "OK"
                                }, function (isConfirm) {
                                    window.location.href = window.location.href;
                                });
                            }

                        }
                    });
                }
            }


        </script>







        <script>
            "use strict"; // Start of use strict

            //counter
            $('.count-number').counterUp({
                delay: 5,
                time: 500
            });


            // Message
            $('.message_inner').slimScroll({
                size: '3px',
                height: '320px'
            });

            //emojionearea
            $(".emojionearea").emojioneArea({
                pickerPosition: "top",
                tonesStyle: "radio"
            });

            //monthly calender
            $('#m_calendar').monthly({
                mode: 'event',
                //jsonUrl: 'events.json',
                //dataType: 'json'
                xmlUrl: 'events.xml'
            });





        </script>

    </body>

    <!-- Mirrored from healthadmin.thememinister.com/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Apr 2018 04:46:41 GMT -->
</html>