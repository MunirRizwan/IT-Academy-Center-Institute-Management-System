<?php
require_once './userSession.php';
$sessionId = "";
if (isset($_GET['session'])) {
    $sessionId = $_GET['session'];
} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require_once './header.php'; ?>
    </head>
    <body class="hold-transition sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">

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
                                        <img src="assets/dist/img/avatar4.png" class="img-circle" height="40" width="40" alt="User Image">
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
                            <div class="col-sm-8">
                                <h1> Max Tech Computer Institute</h1>
                                <small> Your Satisfaction Is Our Motto</small>
                            </div>
                            <div class="col-sm-3">
                                <a href="feeDetails.php?session=<?php echo $sessionId; ?>"><li class="btn btn-success"><i class="fa fa-users"></i> Fee Detials</li></a>
                               
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Main content -->

                <section class="content">
                    <div class="row">

                        <div class="panel panel-bd">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">

                                    <div ><h3>Fine Fee Table </h3></div>

                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr><td>
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" id="checkAll101"
                                                               class="styled"
                                                               onclick="checkAll('<?php echo 101; ?>')" name="radioGroup"> 
                                                        <label for="<?php echo 'checkAll' . 101; ?>"></label>
                                                    </div>
                                                </td>
                                                <th>S.NO</th>
                                                <th>Name</th>
                                                <th>Father Name</th>
                                                <th>Address</th>
                                                <th>Contact</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
                                        $i = 1;
                                        $checkId = 1;
                                        $total = 0;
                                        $dues = 0;
                                        foreach ($allStudent as $key) {
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" 
                                                            <?php
                                                            ?>
                                                                   class="check101"
                                                                   id="<?php echo "checkId" . $checkId; ?>"   
                                                                   <?php
                                                                   ?>

                                                                   name="student_check[]"
                                                                   value="<?php echo $key->student_id; ?>">
                                                            <label for="<?php echo 'checkId' . $checkId; ?>"></label>
                                                    </td> 
                                                    <td><label><?php echo $i++; ?></label>   </td>
                                                    <td><?php echo $key->student_name; ?></td>
                                                    <td><?php echo $key->student_fname; ?></td>
                                                    <td><?php echo $key->student_address; ?></td>
                                                    <td><?php echo $key->student_mobile; ?></td>






                                                </tr>


                                            </tbody>


                                            <?php
                                            $checkId++;
                                        }
                                        ?>
                                        <tr>

                                        </tr>
                                    </table>
                                </div>





                                <div class="page-nation text-right">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#mymodel">Add Fine</button>
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



        <!--=====================================================================-->

        <div class="modal fade" id="mymodel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter Fine Title</label>
                            <input type="text" id="fine_title" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label>Enter Fine Amount</label>
                            <input type="text" id="fine_amount" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="addFine(<?php echo $sessionId; ?>)">Add Fine</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!--=====================================================================-->


        <script>

          function addFine(session_id){
              
              var fine_title = $("#fine_title").val();
              var fine_amount = $("#fine_amount").val();
              
              if(fine_title === ""){
                  alert("fine title may not be empty");
              }else if(fine_amount === ""){
                  alert("fine amount may not be empty"); 
              }else{
                  
                  
                    var stdfineIds = [];
                    $.each($('input[class=check101]:checked'), function () {
                        stdfineIds.push($(this).val());
                    });
                
                      $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {AddFineTitle: fine_title,fine_amount:fine_amount,stdfineIds :stdfineIds,session_id:session_id},
                        type: 'POST',
                        success: function (data) {
                            if (data == 150) {
                                swal({
                                    title: "Fine Added Successfully.",
                                    text: "",
                                    icon: "success",
                                    type: "success",
                                    confirmButtonColor: "#009889",
                                    confirmButtonText: "ADD"
                                }, function (isConfirm) {
                                    window.location.href = window.location.href;
                                });
                            } else {
                                swal("Error!", "Fine not added successfully.", "warning");
                            }

                        }
                    });
              }
              
          }
          
          
               function checkAll(id) {
                var checkbox = document.getElementById('checkAll' + id);
                var checkBox = ".check" + id;
                if (checkbox.checked) {

                    $(checkBox).prop('checked', true);
                    $('.feeAmountInput' + id).prop('disabled', false);
                } else {
                    $(checkBox).prop('checked', false);
                    $('.feeAmountInput' + id).prop('disabled', true);
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