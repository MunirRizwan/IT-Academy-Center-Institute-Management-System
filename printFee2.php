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
                            <div class="col-sm-6 text-right">
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
                        $check = FALSE;
                        if (isset($_POST['dues_fee_submit'])) {
                            $check = TRUE;
                        }
                        $Duesmonth = array();
                        $month = null;
                        $voucher_check = array();
                        $submitDate = FALSE;
                        if (isset($_POST['dues']) && isset($_POST['feeAmount']) && isset($_POST['voucher_check'])) {
                            // $dues = $_POST['dues'];
                            $dues = $_POST['dues'];
                            $fine = $_POST['fine'];
                            $voucher_check = $_POST['voucher_check'];
                            $amount = $_POST['feeAmount'];
                        } else if (isset($_POST['student_check']) && isset($_POST['selectmonth'])) {
                            $submitDate = TRUE;
                            $month = $_POST['selectmonth'];
                            $voucher_check = $_POST['student_check'];
                            $amount = array();
                            $dues[] = array();
                            $fine = array();
                            for ($i = 0; $i < sizeof($voucher_check); $i ++) {
                                $a = $db->fetch_multi_row('fee_tbl', array('fee_amount', 'fine_amount'), array('student_id' => $voucher_check[$i], 'month' => $month));
                                foreach ($a as $key) {
                                    $amount[] = $key->fee_amount;
                                    $dues[] = null;
                                    $fine[] = $key->fine_amount;
                                }
                            }
                        }

                        function curdate() {
                            return date('d-m-Y');
                        }

                        for ($i = 0; $i < sizeof($voucher_check); $i ++) {
                            $total = 0;
                            $m = "";

                            $studentInfo = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile', 'semester_id'), array('student_id' => $voucher_check[$i]));
                            foreach ($studentInfo as $studentKey) {
                                $mon = date("F");
                                $feeCheck = true;
                                if ($check == TRUE) {
                                    $feeCount = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$studentKey->student_id' and month = '$mon'");
                                    if ($feeCount <= 0) {
                                        $feeCheck = FALSE;
                                    }
                                }

                                if ($feeCheck) {
                                    ?>

                                    <div class="col-sm-12"  style="line-height: 17px;font-size: 17px;border: 1px solid black;margin-bottom: 50px;padding-bottom: 10px;position: relative;top: 0;left: 0;" >

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
                                                    <p>Near Agriculture Bank, College Colony Saidu Sharif Swat</p>
                                                    <p>Tel:0946-729716 Cell: 03469470741</p>
                                                    <p>E-mail :junidmtci@gmail.com Web:www.maxtech.edu.pk</p>
                                                </td>

                                                <td>
                                                    <p style="margin-top: 15px;">NO : &nbsp;&nbsp;&nbsp;<?php echo $studentKey->student_id; ?></p>
                                                    <br><br>
                                                    <p>Date : <?php
                                                        if ($submitDate == TRUE) {
                                                            $subFeeDate = $db->fetch_multi_row('fee_tbl', array('fee_sumit_date'), array('student_id' => $voucher_check[$i], 'month' => $month));
                                                            foreach ($subFeeDate as $dkey) {
                                                                echo $dkey->fee_sumit_date;
                                                                break;
                                                            }
                                                        } else
                                                            echo curdate();
                                                        ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><h4 class="text text-center">Received with thanks from</h4></td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1px solid #000;"><p style="">Mrs./Miss./Mr&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $studentKey->student_name; ?></b></p></td>
                                                <td style="border-bottom: 1px solid #000;"><p style=""> RS : &nbsp;&nbsp;&nbsp;&nbsp;<b><?php
                                                            if ($check && $dues[$i] != null) {
                                                                $subFeeAmount = $db->fetch_multi_row('fee_tbl', array('fee_amount'), array('student_id' => $voucher_check[$i], 'month' => date("F")));
                                                                foreach ($subFeeAmount as $skey) {
                                                                    echo $skey->fee_amount;
                                                                    $amount[$i] = $skey->fee_amount;
                                                                    break;
                                                                }
                                                            } else {
                                                                echo $amount[$i];
                                                            }
                                                            ?>

                                                    </p></td>
                                                <td style="border-bottom: 1px solid #000;"><p style="">For The Month &nbsp;&nbsp;&nbsp;&nbsp;<b><?php
                                                            if ($dues[$i] != null) {
                                                                echo date('M, Y');
                                                            } else {
                                                                echo $month;
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
                                                <td style="border-bottom: 1px solid #000;"><br><p> Dues & Month : &nbsp;&nbsp;&nbsp;&nbsp;<b><?php
                                                            if ($dues[$i] != null) {
                                                                $m = date("F");
                                                                $d = $db->fetch_multi_row('fee_tbl', array('fee_amount', 'month', 'status'), array('student_id' => $voucher_check[$i]));
                                                                foreach ($d as $dkey) {
                                                                    if ($dkey->status != 1) {
                                                                        if (strcmp($dkey->month, date("F")) != 0) {
                                                                            echo $dkey->month . " : " . $dkey->fee_amount . ", ";
                                                                            $m = $m . '#' . $dkey->month;
                                                                        }
                                                                    }
                                                                }
                                                            } else {
                                                                $m = $month;
                                                            }
                                                            ?></b></p>

                                                </td>
                                                <?php
                                                if ($fine[$i] != 0) {

                                                    echo "<td style='border-bottom: 1px solid #000;'>Fine: <b>" . $fine[$i] . "</b></td>";
                                                } else {
                                                    echo "<td  style='border-bottom: 1px solid #000;'></td>";
                                                }
                                                ?>

                                            </tr>

                                            <?php
                                            ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #000;" colspan="3"><br><p>
                                                        Extra Fee : &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b>
  <?php
                                            if(isset($_POST['voucher_check'])) {
                                                ?>
                                                            <?php
                                                            
                                                            $f = $db->fetch_multi_row('fine_tbl', array('*'), array('student_id' => $voucher_check[$i]));
                                                            foreach ($f as $fKey) {
                                                                echo $fKey->fine_title . " ";
                                                                echo $fKey->fine_amount . ", ";
                                                                $fine[$i] += $fKey->fine_amount;
                                                            }
                                            }  else {
                                            echo "NULL";    
                                            }
                                                            ?>       


                                                        </b></p></td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <br>
                                                    Total Amount :<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php
                                                            if ($dues[$i] == null) {
                                                                echo $amount[$i] + $fine[$i];
                                                            } else {
                                                                echo $amount[$i] + $dues[$i] + $fine[$i];
                                                            }
                                                            ?>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></b></td>
                                                <td class="">
                                                    <?php if ($check == true) { ?>

                                                        <img src="images/paid5.png" alt="" width="200px" style="position: absolute;top: 80px;left: 500px;"/>
                                                        <br>


                                                    <?php } ?>
                                                </td>
                                                <td>

                                                    <br><br>____________________________________<br><br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                    Signature


                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php if (!($i > 0 && $i % 3 == 0)) { ?>

                        <br><br><br><br><br>

                                        <?php
                                    }
                                    $Duesmonth[] = $m;
                                } else {
                                    echo "<h3>Not Issue Yet to   :   $studentKey->student_name</h3>";
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
                var student_ids = [<?php echo implode(',', $voucher_check) ?>];
                var fee_amount = [<?php echo implode(',', $amount); ?>];
                var duesMonth = [<?php echo '"' . implode('", "', $Duesmonth) . '"' ?>];
                var check = <?php echo $check == 1 ? true : 0 ?>;

                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {duesMonth: duesMonth, check: check, session_id: session_id, student_ids: student_ids, fee_amount: fee_amount},
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