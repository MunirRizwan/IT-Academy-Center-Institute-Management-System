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
                                <a href="allStudentInfo.php?session=<?php echo $sessionId; ?>"><li class="btn btn-success"><i class="fa fa-users"></i> All Student</li></a>
                                <a  class="btn btn-danger"  href='<?php echo "admissionpdf.php?session=$sessionId"; ?>'><i class="glyphicon glyphicon-floppy-save"></i>  Generate Pdf </a>
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

                                    <div ><h3>Admission Fee Table </h3></div>

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
                                                <th>Admission Fee</th>
                                                <th>Submit Date</th>
                                                <th>Status</th>
                                                <th>Cancel Fee</th>
                                            </tr>
                                        </thead>

                                        <?php
                                        $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
                                        $i = 1;
                                        $checkId = 1;
                                        $total = 0;
                                        $dues = 0;
                                        foreach ($allStudent as $key) {
                                            $c = FALSE;
                                            $admissionstatus = $db->fetch_multi_row('admission_tbl', array('status'), array('student_id' => $key->student_id));
                                            foreach ($admissionstatus as $akey) {
                                                if ($akey->status == 1) {
                                                    $c = TRUE;
                                                }
                                            }
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" 
                                                            <?php
                                                            if ($c == true) {
                                                                echo "disabled";
                                                            } else {
                                                                ?>
                                                                       class="check101 styled"
                                                                       id="<?php echo "checkId" . $checkId; ?>"   
                                                                       <?php
                                                                   }
                                                                   ?>

                                                                   name="<?php echo "semesterCheckBox" . $sessionId; ?>"
                                                                   value="<?php echo $key->student_id; ?>">
                                                            <label for="<?php echo 'checkId' . $checkId; ?>"></label>
                                                    </td> 
                                                    <td><label><?php echo $i++; ?></label>   </td>
                                                    <td><?php echo $key->student_name; ?></td>
                                                    <td><?php echo $key->student_fname; ?></td>
                                                    <td><?php echo $key->student_address; ?></td>
                                                    <td><?php echo $key->student_mobile; ?></td>

                                                    <?php
                                                    $admissionFee = $db->fetch_multi_row('admission_tbl', array('admission_id', 'status', 'admission_fee', 'submit_date'), array('student_id' => $key->student_id, 'session_id' => $sessionId));
                                                    $checkAdmissionFee = false;
                                                    foreach ($admissionFee as $aKey) {
                                                        ?>
                                                        <td><?php echo $aKey->admission_fee; ?></td>
                                                        <?php
                                                        if ($aKey->status == 0) {
                                                            $dues += $aKey->admission_fee;
                                                            ?>
                                                            <td>NULL</td>
                                                            <td><span class="label-default label label-danger" onclick="updateAdmssion(<?php echo $aKey->admission_id; ?>)">Pending</span></td>
                                                            <?php
                                                        } else {
                                                            $total += $aKey->admission_fee;
                                                            ?>
                                                            <td><?php echo $aKey->submit_date; ?></td>
                                                            <td><span class="label-default label label-success">Submitted</span></td>
                                                            <?php
                                                        }
                                                        ?>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right"
                                                                    onclick="deleteAdmissionFee('<?php echo $aKey->admission_id; ?>')"  title="Delete ">
                                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                            </button></td>  
                                                        <?php
                                                        $checkAdmissionFee = TRUE;
                                                        break;
                                                    }

                                                    if ($checkAdmissionFee == FALSE) {
                                                        echo '<td style="color:red;font-weight:bold;" align="center">-</td><td style="color:red;font-weight:bold;" align="center">-</td><td style="color:red;font-weight:bold;" align="center">-</td>';
                                                        ?>
                                                        <td>
                                                            <button  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="right"
                                                                     onclick="addAdmissionFee('<?php echo $key->student_id; ?>',<?php echo $sessionId; ?>)"  title="Add fee ">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button></td> 
                                                        <?php
                                                    }
                                                    ?>




                                                </tr>


                                            </tbody>


                                            <?php
                                            $checkId++;
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="9">
                                                <span style="font-weight: bold;color: red;">Total Dues: <?php echo $dues; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="font-weight: bold;color: green;">Total submited Fee: <?php echo $total; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="font-weight: bold;color: orange;">Total: <?php echo $dues + $total; ?></span><br><br>
                                            </td>
                                        </tr>
                                    </table>
                                </div>





                                <div class="page-nation text-right">
                                    <button type="button" class="btn btn-info  m-b-5 m-r-2" 
                                            onclick="updateAdmissionStatus('<?php echo $sessionId; ?>')"
                                            >Submit Admission Fee</button>
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

            function addAdmissionFee(std_id,session_id) {
                swal({
                    title: "Admission Fee!",
                    text: "Please Enter the Admission Fee:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Enter Admission Fee  Here"
                }, function (inputValue) {
                    if (inputValue === false)
                        return false;
                    if (inputValue === "") {
                        swal.showInputError("You need to write something!");
                        return false;
                    }
                    $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {AddAdmissionFeeStdId: std_id,admission_fee:inputValue,session_id:session_id},
                        type: 'POST',
                        success: function (data) {
                            if (data == 110) {
                                swal({
                                    title: "Admission fee Added Successfully.",
                                    text: "",
                                    icon: "success",
                                    type: "success",
                                    confirmButtonColor: "#009889",
                                    confirmButtonText: "ADD"
                                }, function (isConfirm) {
                                    window.location.href = window.location.href;
                                });
                            } else {
                                swal("Error!", data, "warning");
                            }

                        }
                    });
//                    swal("Nice!", "You wrote: " + inputValue, "success");
                });
            }

            function deleteAdmissionFee(id) {
                swal({
                    title: "Are you sure?",
                    text: "Are you sure to delete Admission fee!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true},
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: 'ajaxInsertion.php',
                            data: {deleteAdmissionFee: id},
                            type: 'POST',
                            success: function (data) {
                                if (data == 100) {
                                    swal({
                                        title: "Admission fee deleted Successfully.",
                                        text: "",
                                        icon: "success",
                                        type: "success",
                                        confirmButtonColor: "#009889",
                                        confirmButtonText: "OK"
                                    }, function (isConfirm) {
                                        window.location.href = window.location.href;
                                    });
                                } else {
                                    swal("Error!", data, "warning");
                                }

                            }
                        });
                    }
                });
            }

            function updateAdmissionStatus(sessionId) {

                var semesterCheckBoxName = "semesterCheckBox" + sessionId;
                var admissionStatusIds = [];
                $.each($('input[name=' + semesterCheckBoxName + ']:checked'), function () {
                    admissionStatusIds.push($(this).val());
                });
                swal({
                    title: "Are you sure?",
                    text: "Your will never un submit fee!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true},
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: 'ajaxInsertion.php',
                            data: {admissionStatusIds: admissionStatusIds, sessionId: sessionId},
                            type: 'POST',
                            success: function (data) {
                                if (data == 13) {
                                    swal({
                                        title: "Fee submitted Successfully.",
                                        text: "",
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
                });

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



            function updateAdmssion(id) {

                swal({
                    title: "Are you sure to submit?",
                    text: "Your will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true},
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: 'ajaxInsertion.php',
                            data: {admissionFee: id},
                            type: 'POST',
                            success: function (data) {
                                if (data == 12) {
                                    swal({
                                        title: "Admission Fee submitted Successfully!",
                                        text: "",
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
                });



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