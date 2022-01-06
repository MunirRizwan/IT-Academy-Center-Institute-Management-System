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
        <style>
            table.fixed { table-layout:fixed; }
            table.fixed td { overflow: hidden; }
        </style>

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
                            <div class="col-sm-4">
                                <h1> Max Tech Computer Institute</h1>
                                <small> Your Satisfaction Is Our Motto</small>
                            </div>
                            <div class="col-sm-7 text-right">
                                <a  class="btn btn-warning m-b-5 m-r-2" href='<?php echo "allStudentInfo.php?session=$sessionId"; ?>'><i class="fa fa-users" style="margin-right:5px;"></i>  All Student </a>
                                <a  class="btn btn-info  m-b-5 m-r-2"  href='<?php echo "feeDetails.php?session=$sessionId"; ?>'><i class="fa fa-dollar"></i>  fee details </a>
                                <a  class="btn btn-default m-b-5 m-r-2" onclick="print_content('printtable', '<?php echo $sessionId; ?>')"><i class="fa fa-users"  style="margin-right:5px;"></i>  Print Fee </a>
                            </div>

                        </div>



                    </div>

                </section>

                <!-- Main content -->

                <section class="content">
                    <div class="row" id="printtable">
                        <div c class=" col-sm-12"  style="visibility:hidden;border-left:  1px solid green;border-right:   1px solid green;">
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
                        $fine = 0;
                        if (isset($_POST['singleFeeSubmit']) && isset($_POST["singleStudentId"]) && isset($_POST['singleStudentCheckIds'])) {
                            $stdId = $_POST['singleStudentId'];
                            $feeIds = $_POST['singleStudentCheckIds'];
                            $fine_id = array();
                            if(isset($_POST['singleStudentFineIds'])){
                                $fine_id = $_POST['singleStudentFineIds'];
                            }
                            $fee_amount = array();
                            $total = 0;

                            $month = array();
                            $status = array();
                            $date = array();
                            $subFeeDate = FALSE;
                            for ($i = 0; $i < sizeof($feeIds); $i++) {
                                $d = $db->fetch_multi_row('fee_tbl', array('fee_amount', 'month', 'status', 'fee_sumit_date', 'fine_amount'), array('fee_id' => $feeIds[$i]));
                                foreach ($d as $Key) {
                                    $f = $Key->fee_amount;
                                    $fi = $Key->fine_amount;
                                    $m = $Key->month;
                                    $s = $Key->status;
                                    $d = $Key->fee_sumit_date;
                                    if ($i == 0 && $s == 1) {
                                        $subFeeDate = TRUE;
                                    }
                                    array_push($fee_amount, $f);
                                    array_push($month, $m);
                                    array_push($status, $s);
                                    array_push($date, $d);
                                    $total += $f;
                                    $fine += $fi;
                                }
                            }

                            function curdate() {
                                return date('d-m-Y');
                            }

                            $studentInfo = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile', 'semester_id'), array('student_id' => $stdId));
                            $i = 0;
                            foreach ($studentInfo as $studentKey) {
                                ?>

                                <div class="col-sm-12"  style="line-height: 17px;font-size: 17px;border: 1px solid silver;margin-bottom: 55px;padding-bottom: 10px;position: relative;top: 0;left: 0;" >

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
                                                <p>Date : <?php
                                                    if ($subFeeDate == TRUE) {
                                                        echo $date[$i];
                                                    } else
                                                        echo curdate();

                                                    $i++;
                                                    ?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><h4 class="text text-center">Received with thanks from</h4></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom: 1px solid #000;"><p style="">Mrs./Miss./Mr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $studentKey->student_name; ?></b></p></td>
                                            <td style="border-bottom: 1px solid #000;"><p style=""> RS : &nbsp;&nbsp;&nbsp;&nbsp;<b>
                                                        <?php
                                                        for ($x = 0; $x < sizeof($month); $x++) {
                                                            if (strcmp($month[$x], date("F")) == 0)
                                                                echo $fee_amount[$x];
                                                        }
                                                        ?>
                                                </p></td>
                                            <td style="border-bottom: 1px solid #000;"><p style="">For The Month &nbsp;&nbsp;&nbsp;&nbsp;<b><?php
                                                        for ($x = 0; $x < sizeof($month); $x++) {
                                                            if (strcmp($month[$x], date("F")) == 0)
                                                                echo $month[$x];
                                                        }
                                                        ?></b> </p></td>
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
                                            <td colspan="" style="border-bottom: 1px solid #000;"><br><p> Dues & Month : &nbsp;&nbsp;&nbsp;&nbsp;<b><?php
                                                        for ($x = 0; $x < sizeof($month); $x++) {
                                                            if (strcmp($month[$x], date("F")) != 0)
                                                                echo $fee_amount[$x] . " " . $month[$x] . ", ";
                                                        }
                                                        ?></b></p></td>

                                            <?php
                                            if ($fine != 0) {
                                                echo "<td style='border-bottom: 1px solid #000;'>Fine: <b>" . $fine . "</b></td>";
                                            } else {
                                                echo "<td  style='border-bottom: 1px solid #000;'></td>";
                                            }
                                            ?>

                                        </tr>
                                        <?php
                                        if (sizeof($fine_id) > 0) {
                                            ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #000;" colspan="3"><br><p>
                                                        Extra Fee : &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>

                                                            <?php
                                                            for ($i = 0; $i < sizeof($fine_id); $i++) {
                                                                $f = $db->fetch_multi_row('fine_tbl', array('*'), array('fine_id' => $fine_id[$i]));
                                                                foreach ($f as $fKey) {
                                                                    echo $fKey->fine_title . " ";
                                                                    echo $fKey->fine_amount . ", ";
                                                                    $fine = $fine+$fKey->fine_amount;
                                                                }
                                                            }
                                                            ?>       


                                                        </b></p></td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <br>
                                                Total Amount :<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <?php echo $total + $fine; ?>

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></td>
                                            <td class="">
                                                <img src="images/paid5.png" alt="" width="200px" style="position: absolute;top: 80px;left: 500px;"/>
                                                <br>

                                            </td>
                                            <td>

                                                <br><br>____________________________________<br><br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                Signature


                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
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

                var feeIds = [<?php echo implode(',', $feeIds) ?>];
                var fineids = [<?php echo implode(',', $fine_id) ?>];
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {feeIds: feeIds,fineids:fineids},
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