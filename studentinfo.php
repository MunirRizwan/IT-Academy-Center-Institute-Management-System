<?php
require_once './userSession.php';
include './backup.php';


$student_id = "";
if(isset($_GET['srudent_id'])){
    $student_id = $_GET['srudent_id'];
}else{
    
}

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

                        </div>



                    </div>
                </section>
                <!-- Main content -->

                <section class="content">
                    <div class="row">




                        <!-- Form controls -->
                        <div class="col-sm-12">
                            <div class="panel panel-bd lobidrag">
                                <div class="panel-heading">
                                    <div class="btn-group"> 
                                        <a class="btn btn-primary" href=""> <i class="fa fa-plus"></i>&nbsp; Add Category</a>  
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>SNO</th>
                                                    <th>Category Name</th>
                                                    <th>Category Image</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $fee = $db->fetch_multi_row('fee_tbl', array("*"), array('student_id' => $student_id));

                                                $sno = 1;
                                                foreach ($fee as $key) {
                                                    ?>

                                                    <tr>
                                                        <td><label><?php echo $sno; ?></label>   </td>
                                                        <td><?php echo $key->cat_title; ?></td>
                                                        <td><img src="images/<?php echo $key->cat_image; ?>" class="img-circle" alt="User Image" height="50" width="50"></td>
                                                        <td><span class="label-danger label label-default fa fa-trash" onclick="deleteCategory(<?php echo $key->cat_id; ?>)">&nbsp;</span></td>
                                                    </tr>

                                                    <?php
                                                    $sno++;
                                                }

                                                if ($sno == 1) {
                                                    echo "<tr><td colspan='3' style='color:red' class='text-center'>No Record!</td></tr>";
                                                }
                                                ?>




                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
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

            function  checkData() {

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