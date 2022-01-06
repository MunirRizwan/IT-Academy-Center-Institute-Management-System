<?php
include "./database/config.php";
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
        <style>
            table.fixed { table-layout:fixed; }
            table.fixed td { overflow: hidden; }
        </style>

    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <a href="index-2.html" class="logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <!--<b>A</b>H-admin-->
                        <img src="assets/dist/img/mini-logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <!--<b>Admin</b>H-admin-->
                        <img src="assets/dist/img/logo.png" alt="">
                    </span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top ">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-tasks"></span>
                    </a>

                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <?php require_once './sideBar.php'; ?>
            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header"> 
                    <div class="header-icon">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <div class="header-title">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1> Max Tech Computer Institute</h1>
                                <small> Your Satisfaction Is Our Motto</small>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a  class="btn btn-default m-b-5 m-r-2" href='<?php echo "allStudentInfo.php?session=$sessionId"; ?>'><i class="fa fa-users" style="margin-right:5px;"></i>  All Student </a>
                                <a  class="btn btn-default m-b-5 m-r-2" onclick="print_content('printtable', '<?php echo $sessionId; ?>')"><i class="fa fa-users"  style="margin-right:5px;"></i>  Prrint Student </a>
                            </div>

                        </div>



                    </div>

                </section>

                <!-- Main content -->

                <section class="content">
                    <div class="row" id="printtable">
                        <div c class=" col-sm-12"  style="visibility:hidden;border-left:  1px solid green;border-right:   1px solid green;position: relative;top: 0;left: 0;">
                            <table>
                                <tr>
                                    <td style="width: 45%;">
                                        ___________________________________________________________________________________
                                    </td>
                                    <td style="width: 30%;">
                                        ________________________________________________________
                                    </td>
                                    <td style="width: 20%;">
                                        ________________________________________
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php
                        if (isset($_POST['dues']) && isset($_POST['feeAmount']) && isset($_POST['voucher_check'])) {
                            $dues = $_POST['dues'];
                            $voucher_check = $_POST['voucher_check'];
                            $amount = $_POST['feeAmount'];
                        } else if (isset($_POST['student_check']) && isset($_POST['selectmonth'])) {
                            $month = $_POST['selectmonth'];
                            $voucher_check = $_POST['student_check'];
                            $amount = array();
                            $dues[] = array();
                            for ($i = 0; $i < sizeof($voucher_check); $i ++) {
                                $a = $db->fetch_multi_row('fee_tbl', array('fee_amount'), array('student_id' => $voucher_check[$i], 'month' => $month));
                                foreach ($a as $key) {
                                    $amount[] = $key->fee_amount;
                                    $dues[] = null;
                                }
                            }
                        }

                        function curdate() {
                            return date('d-m-Y');
                        }

                        for ($i = 0; $i < sizeof($voucher_check); $i ++) {
                            $studentInfo = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile', 'semester_id'), array('student_id' => $voucher_check[$i]));
                            foreach ($studentInfo as $studentKey) {
                                ?>


                                <div class="col-sm-12"  style="font-size: 17px;border: 1px solid silver;margin-bottom: 55px;padding-bottom: 10px;">

                                    <table class="fixed" style="width: 100%;">
                                        <col width="30%" />
                                        <col width="45%" />
                                        <col width="20%" />
                                        <tr>
                                            <td>
                                                <img src="images/max tech computer logo png.png" width="100px;"/>

                                            </td>
                                            <td class="text-center">
                                                <h4>MaxTech Computer Institue</h4>
                                                <p>khan plaza,Nishat chock,Mingora,swat</p>
                                                <p>Tel:0946-710566 - 700716 Cell: 03469994799</p>
                                                <p>E-mail :amjadmtci@yahoo.com Web:www.maxtech.edu.pk</p>
                                            </td>

                                            <td>
                                                <p style="margin-top: 15px;">NO : &nbsp;&nbsp;&nbsp;<?php echo $studentKey->student_id; ?></p>
                                                <br><br>
                                                <p>Date : <?php echo curdate(); ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><h4 class="text text-center">Received with thanks from</h4></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 1px solid #000;"><p style="">Mrs./Miss./Mr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $studentKey->student_name; ?></b></p></td>
                                            <td style="border-bottom: 1px solid #000;"><p style=""> RS : &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $amount[$i]; ?> </p></td>
                                            <td style="border-bottom: 1px solid #000;"><p style="">For The Month &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo date('M, Y'); ?></b> </p></td>
                                        </tr>
                                        <?php
                                        $semester_id = $studentKey->semester_id;

                                        $semestertitle = "";
                                        $semesterQ = $db->fetch_multi_row('semester_tbl', array('semester_title'), array('semester_id' => $semester_id));
                                        foreach ($semesterQ as $semesterKey) {
                                            $semestertitle = $semesterKey->semester_title;
                                        }
                                        ?>
                                        <tr>
                                            <td style="border-bottom: 1px solid #000;"><br><p>Course : &nbsp;&nbsp;&nbsp;&nbsp;<b>DIT <?php echo $semestertitle; ?></b></p></td>
                                            <td colspan="2" style="border-bottom: 1px solid #000;"><br><p> Dues & Month : &nbsp;&nbsp;&nbsp;&nbsp;<b><?php if ($dues[$i] != null) {
                                    echo $dues[$i];
                                } ?></b></p></td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <br>
                                                Total Amount :<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?php
                                                        if ($dues[$i] == null) {
                                                            echo $amount[$i];
                                                        } else {
                                                            echo $amount[$i] + $dues[$i];
                                                        }
                                                        ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></td>
                                            <td class="">
                                                <img src="images/paid5.png" alt="" width="200px" style="position: absolute;top: 80px;left: 500px;"/>
                                                <br>
                                                <span style="font-weight: bold;color: red;">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paid Date = 12/11/2019</span>
                                            </td>
                                            <td>

                                                <br><br>____________________________________<br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                Signature


                                            </td>
                                        </tr>
                                    </table>
                                </div>
        <?php if (!($i > 0 && $i % 3 == 0)) { ?>
                                    <br>
                                    <hr>

                                    <?php
                                }
                            }
                        }
                        ?>




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
            function print_content(content, session_id) {
                var student_ids = new Array(<?php echo implode(',', $voucher_check); ?>);
                var fee_amount = new Array(<?php echo implode(',', $amount); ?>);

                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {session_id: session_id, student_ids: student_ids, fee_amount: fee_amount},
                    type: 'POST',
                    success: function (data) {
                        var rest = document.body.innerHTML;
                        var printcon = document.getElementById(content).innerHTML;
                        document.body.innerHTML = printcon;
                        window.print();
                        document.body.innerHTML = rest;
                    }
                });




            }
        </script>


        <script>



            function updateTable(id) {
                var month = $('#month').val();
                alert(month);
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {month: month, session_id: id},
                    type: 'POST',
                    success: function (data) {
                        document.getElementById('feeDetailTable').innerHTML = data;


                    }
                });
            }

            function enableDisableCheckBox(id) {
                var checkbox = document.getElementById('checkId' + id);
                if (checkbox.checked == true) {
                    document.getElementById('feeAmount' + id).disabled = false;
                    $('#fee_dues' + id).prop('disabled', false);
                } else {
                    document.getElementById('feeAmount' + id).disabled = true;
                    $('#fee_dues' + id).prop('disabled', true);
                }

            }

            function checkAll(id) {
                var checkbox = document.getElementById('checkAll' + id);
                var checkBox = ".check" + id;

                if (checkbox.checked) {

                    $(checkBox).prop('checked', true);
                    $('.feeAmountInput' + id).prop('disabled', false);
                    $('.fee_dues').prop('disabled', false);

                } else {
                    $(checkBox).prop('checked', false);
                    $('.feeAmountInput' + id).prop('disabled', true);
                    $('.fee_dues').prop('disabled', true);
                }

            }

            function closeTable(id) {
                var panel = ".close" + id;
                $(panel).toggle(500);

            }

        </script>

        <script>
            $(document).ready(function () {
                $('input[name=fee_amount]').keyup(function () {
                    $('.feeAmountInput100').prop('value', $('input[name=fee_amount]').val());
                });
            });

        </script>







        <script>
            "use strict"; // Start of use strict

            //counter
            $('.count-number').counterUp({
                delay: 10,
                time: 5000
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

</html>