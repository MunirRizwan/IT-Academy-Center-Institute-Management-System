<?php
require_once './userSession.php';
$sessionId = "";
if (isset($_GET['session'])) {
    $sessionId = $_GET['session'];
} else {
    header('Location: index.php');
}
$month = date("F");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require_once './header.php'; ?>


    </head>
    <body class="hold-transition sidebar-mini sidebar-collapse">
        <script>
            var student_id = [];
        </script>

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
                            <div class="col-sm-7">
                                <h1> Max Tech Computer Institute</h1>
                                <small> Your Satisfaction Is Our Motto</small>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a  class="btn btn-primary m-b-5 m-r-2" href='<?php echo "allStudentInfo.php?session=$sessionId"; ?>'><i class="fa fa-users" style="margin-right:5px;"></i>  All Student </a>
                                <a  class="btn btn-danger m-b-5 m-r-2" href='<?php echo "AllAddFine.php?session=$sessionId"; ?>'><i class="fa fa-users" style="margin-right:5px;"></i>  Add Fine </a>

                            </div>

                        </div>



                    </div>

                </section>

                <!-- Main content -->

                <section class="content">
                    <div class="row">



                        <?php
                        $dynamicFee = "";
                        $dynamicFeeId = "";
                        $dynamic_fee = $db->fetch_all('dynamic_fee_tbl');
                        foreach ($dynamic_fee as $dkey) {
                            $dynamicFeeId = $dkey->dynamic_fee_id;
                            $dynamicFee = $dkey->dynamic_fee_amount;
                            break;
                        }
                        $sessionTitle = $db->fetch_multi_row('session_tbl', array('session_title'), array('session_id' => $sessionId));
                        foreach ($sessionTitle as $skey) {
                            ?>
                            <h3 class="col-sm-12 text-center">Batch : <?php echo $skey->session_title; ?> <hr></h3><br>
                            <?php
                        }
                        ?>


                        <BR><BR>
                        <BR><BR>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            <?php
                            $classIds = 100;
                            $count = $db->countRow("SELECT COUNT(*) FROM student_info where  session_id='$sessionId'");
                            if ($count > 0) {
                                ?>
                                <div class="panel panel-bd">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div><h3>Issue Fee:   <?php echo date("F Y"); ?> <span style="float: right;color: green;" class="fa fa-plus"></span></h3></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <form  name="fo" method="post" action="printFee2.php?session=<?php echo $sessionId; ?>" >
                                                <div class="row">
                                                    <div class="panel-header">
                                                        <div class="col-sm-2">

                                                        </div>
                                                        <div class="col-sm-2">

                                                        </div>
                                                        <div class="col-sm-4">

                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="dataTables_length">
                                                                <div class="input-group custom-search-form">
                                                                    <input type="search" class="form-control" id="tableSearch" placeholder="search..">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary" type="button" onclick="hello()">
                                                                            <span class="glyphicon glyphicon-search"></span>
                                                                        </button>
                                                                    </span>
                                                                </div><!-- /input-group -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-condensed" >
                                                        <thead>
                                                            <tr>
                                                                <th>

                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox"  name="radioGroup"  id="<?php echo 'checkAll' . $classIds; ?>" onclick="checkAll('<?php echo $classIds; ?>')">
                                                            <label for="<?php echo 'checkAll' . $classIds; ?>"></label>
                                                        </div>

                                                        </th>
                                                        <th>S.NO</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th style="width: 110px;">
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="inputFeeAmount" value="<?php echo $dynamicFee; ?>"  name="fee_amount" style="padding-left:10px;"/>
                                                            <span class="input-group-btn">
                                                                <button type="button" onclick="updateDynamicFee('<?php echo $dynamicFeeId ?>')" class="btn btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                            </span>
                                                        </div>



                                                        </th>
                                                        <th title="current month fee">CM fee</th>
                                                        <th>Dues</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody   id="issueFeeTable">
                                                            <?php
                                                            $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
                                                            $i = 1;
                                                            foreach ($allStudent as $key) {
                                                                $dues = 0;
                                                                $fine = 0;
                                                                $cmfinetitle = "";
                                                                $cmfine = 0;
                                                                $currentFee = "";
                                                                $currestMonthfee = $db->custom_query("SELECT fee_submit_amount,status,fee_amount,fine_title,fine_amount  FROM fee_tbl WHERE month = '$month' and student_id = '$key->student_id' and session_id = '$sessionId'");
                                                                $currentMonthStatus = FALSE;
                                                                foreach ($currestMonthfee as $c) {
                                                                    if ($c->status == 1) {
                                                                        $currentMonthStatus = TRUE;
                                                                        $currentFee = $c->fee_amount;
                                                                        $cmfine = $c->fine_amount;
                                                                        $cmfinetitle = $c->fine_title;
                                                                    } else if ($c->status == 2) {
                                                                        $currentFee = $c->fee_amount - $c->fee_submit_amount;
                                                                        $cmfine = $c->fine_amount;
                                                                        $cmfinetitle = $c->fine_title;
                                                                    } else {
                                                                        $currentFee = $c->fee_amount;
                                                                        $cmfine = $c->fine_amount;
                                                                        $cmfinetitle = $c->fine_title;
                                                                    }
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="checkbox checkbox-primary">
                                                                            <input type="checkbox"
                                                                                   name="voucher_check[]"
                                                                                   <?php
                                                                                   if ($currentMonthStatus == true) {
                                                                                       echo "disabled";
                                                                                   } else {
                                                                                       ?>
																					   
                                                                                       class="<?php echo "check" . $classIds; ?>"
                                                                                       id="<?php echo "checkId" . $i; ?>"
                                                                                       onclick="enableDisableCheckBox('<?php echo $i; ?>')" 
                                                                                       <?php
                                                                                   }
                                                                                   ?>

                                                                                   value="<?php echo $key->student_id; ?>"

                                                                                   >

                                                                            <label for="<?php echo 'checkId' . $i; ?>"></label>
                                                                        </div>
                                                                        <script>
                                                                            student_id.push(<?php echo $key->student_id; ?>);
                                                                        </script>


                                                                    </td> 
                                                                    <td><label><?php echo $i; ?></label>   </td>
                                                                    <td><?php echo $key->student_name; ?></td>
                                                                    <td><?php echo $key->student_fname; ?></td>
                                                                    <td><?php echo $key->student_address; ?></td>
                                                                    <td><?php echo $key->student_mobile; ?></td>
                                                                    <th><input type="number"  <?php
                                                                        if ($currentMonthStatus == true) {
                                                                            echo "disabled";
                                                                            ?>
                                                                                   class="form-control"
                                                                                   <?php
                                                                               } else {
                                                                                   ?>
                                                                                   class="<?php echo 'feeAmountInput' . $classIds; ?> form-control"
                                                                                   disabled=""
                                                                                   <?php
                                                                               }
                                                                               ?> name="feeAmount[]"  value="<?php echo $dynamicFee; ?>" id="<?php echo "feeAmount" . $i; ?>"  

                                                                               style="padding-left:10px;"
                                                                               /></th>
                                                                    <td><?php
                                                                        $pfine = "";
                                                                        if ($cmfine != 0) {
                                                                            $pfine = ' + <span title=' . $cmfinetitle . ' style="color:green;"> ' . $cmfine . '</span>';
                                                                        }
                                                                        if ($currentMonthStatus) {

                                                                            echo "<span style='color:#58B11B;'><b>PAID</b> $currentFee $pfine</span>";
                                                                        } else {
                                                                            echo "<span style='color:orange;'><b>" . $currentFee . $pfine . "</b></span>";
                                                                        }
                                                                        ?></td>
                                                                    <?php
                                                                    $feeDues = $db->custom_query("SELECT * FROM fee_tbl WHERE month != '$month' and student_id = '$key->student_id' and session_id = '$sessionId'");

                                                                    $fineTitle = "";
                                                                    foreach ($feeDues as $dueskey) {
                                                                        if ($dueskey->status == 0) {
                                                                            $dues += $dueskey->fee_amount;
                                                                            $fine += $dueskey->fine_amount;
                                                                            $fineTitle = $dueskey->fine_title;
                                                                        } else if ($dueskey->status == 2) {
                                                                            $dues += $dueskey->fee_amount - $dueskey->fee_submit_amount;
                                                                            $fine += $dueskey->fine_amount;
                                                                            $fineTitle = $dueskey->fine_title;
                                                                        }
                                                                    }
                                                                    if ($dues == 0) {
                                                                        //   $dues = "-";
                                                                    }
                                                                    if ($fine == 0) {
                                                                        ?>
                                                                <input type="hidden" name="fine[]" <?php if ($currentMonthStatus == FALSE) { ?> class="fee_fine"  <?php } ?>  id="<?php echo "fee_fine" . $i; ?>" size="2"  disabled  value="<?php echo $fine + $cmfine; ?>" style="height:35px">
                                                                <?php
                                                                $fine = "";
                                                            } else {
                                                                ?>
                                                                <input type="hidden" name="fine[]" <?php if ($currentMonthStatus == FALSE) { ?> class="fee_fine"  <?php } ?>  id="<?php echo "fee_fine" . $i; ?>" size="2"  disabled  value="<?php echo $fine + $cmfine; ?>" style="height:35px">
                                                                <?php
                                                            }

                                                            $fines = $db->fetch_multi_row('fine_tbl', array('*'), array('student_id' => $key->student_id));

                                                            //$feeDues = $db->fetch_multi_row('fee_tbl', array('fee_amount'), array('student_id' => $key->student_id, 'session_id' => $sessionId, 'status' => 0));
                                                            foreach ($fines as $finesKey) {
                                                                if ($finesKey->status == 0) {
                                                                    $fine += $finesKey->fine_amount;
                                                                }
                                                            }

                                                            if ($fine > 0) {
                                                                $fine = " + " . $fine;
                                                            }
                                                            ?>




                                                            <td style="color:red;"><?php echo "<b>" . $dues . "<span title='" . $fineTitle . "'>" . $fine . "</span>" . "</b>"; ?></td>
                                                            <input type="hidden" name="dues[]" <?php if ($currentMonthStatus == FALSE) { ?> class="fee_dues" <?php } ?>  id="<?php echo "fee_dues" . $i; ?>" size="2"  disabled  value="<?php echo $dues; ?>" style="height:35px">


                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>





                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <?php
                                                                $t = 0;
                                                                $d = 0;
                                                                $totalStudentSubmit = 0;
                                                                $totalStudentNotSubmit = 0;
                                                                $f = $db->fetch_multi_row('fee_tbl', array('fee_amount', 'fee_submit_amount', 'status', 'fine_amount'), array('session_id' => $sessionId));
                                                                foreach ($f as $fKey) {
                                                                    if ($fKey->status == 0) {
                                                                        $d += $fKey->fee_amount + $fKey->fine_amount;
                                                                        $totalStudentNotSubmit += 1;
                                                                    } else if ($fKey->status == 2) {
                                                                        $d += $fKey->fee_amount + $fKey->fine_amount - $fKey->fee_submit_amount;
                                                                        $t += $fKey->fee_submit_amount;
                                                                        $totalStudentNotSubmit += 1;
                                                                    } else {
                                                                        $totalStudentSubmit += 1;
                                                                        $t += $fKey->fee_amount + $fKey->fine_amount;
                                                                    }
                                                                }

                                                                $fines = $db->fetch_multi_row('fine_tbl', array('*'), array('session_id' => $sessionId));

                                                                //$feeDues = $db->fetch_multi_row('fee_tbl', array('fee_amount'), array('student_id' => $key->student_id, 'session_id' => $sessionId, 'status' => 0));
                                                                foreach ($fines as $finesKey) {
                                                                    if ($finesKey->status == 0) {
                                                                        $d += $finesKey->fine_amount;
                                                                    } else {
                                                                        $t += $finesKey->fine_amount;
                                                                    }
                                                                }
                                                                ?>
                                                                <td colspan="3">
                                                                    <span style="font-weight: bold;color: red;">Not Submitted Fee: <?php echo $totalStudentNotSubmit; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                                                    <span style="font-weight: bold;color: green;">Submited Fee: <?php echo $totalStudentSubmit; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </td>

                                                                <td colspan="7" class="text-right">

                                                                    <span style="font-weight: bold;color: red;">Total Dues: <?php echo $d; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <span style="font-weight: bold;color: green;">Total submited Fee: <?php echo $t; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <span style="font-weight: bold;color: orange;">Total: <?php echo $d + $t; ?></span><br><br>
                                                                </td>
                                                            </tr>
                                                        </tfoot>


                                                    </table>
                                                </div>
                                                <br>

                                                <div class="page-nation text-right">
												
												

													<button type="button" class="btn btn-default md-trigger m-b-5 m-r-2" data-modal="<?php echo "modal2-"; ?>">Change Batch</button>


                                                    <!--===========MODEL Select Semester============-->
                                                    <div class="md-modal md-effect-4 text-left" id="<?php echo "modal2-"; ?>">
                                                        <div class="md-content">
                                                            <h3 style="background-color: #009889;color: white;">SELECT Batch</h3>
                                                            <div class="n-modal-body" style="">
                                                                <div class="form-group">
                                                                    <label for="student_batch">Select Batch : </label>
                                                                    <select class="form-control" id="student_batch">
                                                                        <?php
                                                                        $allSession = $db->fetch_all('session_tbl');
                                                                        foreach ($allSession as $sessionKey) {
                                                                            ?>
                                                                            <option value="<?php echo $sessionKey->session_id; ?>">
                                                                                <?php echo $sessionKey->session_title; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <br><br>
                                                                <div class="text-right">
                                                                    <hr>
                                                                    <input type="button" class="btn btn-danger md-close" value="Close me!"/>
                                                                    <input type="button" class="btn btn-success" style="margin-left: 5px;" onclick="updateBatch()" value="Change Batch"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="md-overlay"></div>
                                                    <!--===========END Select Batch============-->


                                                    <input type="submit" name="feecard" class="btn btn-warning"
                                                           value="Print Fee Card"
                                                           >
														   
                                                    <button type="submit" name="dues_fee_submit" class="btn btn-danger">Submit Fees</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
    <?php
    $classIds++;
}
?>

                            <?php
                            $selectMonth = date("F");
                            if (isset($_SESSION["selectMonth"])) {
                                $selectMonth = $_SESSION["selectMonth"];
                            }
                            ?>
                            <br>
                            <div class="panel panel-bd">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                            <div><h3>Fee Detail <span style="float: right;color: green;" class="fa fa-plus"></span></h3></div>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <form  name="fo" method="post" action="printFee2.php?session=<?php echo $sessionId; ?>" >
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="panel-header">
                                                    <div class="col-sm-2">
                                                        <label>Fine Title:</label>
                                                        <input type="text" value="Late Fee" class="form-control" id="fineTitle" placeholder="RS:100">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label>Fine Amount:</label>
                                                        <div class="input-group custom-search-form">
                                                            <input type="number" class="form-control" id="fineAmount" placeholder="">
                                                            <span class="input-group-btn">
                                                                <label>Fine Amount</label>
                                                                <button  class="btn btn-primary" type="button" onclick="addFine()">
                                                                    <span class="fa fa-plus"></span>
                                                                </button>
                                                                <button type="button" class="btn btn-danger" onclick="deleteFine()"><span class="fa fa-trash"></span></button>  
                                                            </span>
                                                        </div><!-- /input-group -->
                                                    </div>
                                                    <div class="col-sm-3">

                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="dataTables_length">
                                                            <div class="form-group">
                                                                <label for="sel1">Select list:</label>
                                                                <select class="form-control" required name="selectmonth"  id="month"  onchange="updateTable('<?php echo $sessionId; ?>')">

                                                                    <option  <?php if (strcmp($selectMonth, "January") == 0) echo'selected'; ?> value="January">january</option>
                                                                    <option <?php if (strcmp($selectMonth, "Febuary") == 0) echo'selected'; ?>  value="Febuary">febuary</option>
                                                                    <option <?php if (strcmp($selectMonth, "March") == 0) echo'selected'; ?> value="March">march</option>
                                                                    <option <?php if (strcmp($selectMonth, "April") == 0) echo'selected'; ?> value="April">April</option>
                                                                    <option <?php if (strcmp($selectMonth, "May") == 0) echo'selected'; ?> value="May">May</option>
                                                                    <option <?php if (strcmp($selectMonth, "June") == 0) echo'selected'; ?> value="June">June</option>
                                                                    <option <?php if (strcmp($selectMonth, "July") == 0) echo'selected'; ?> value="July">July</option>
                                                                    <option <?php if (strcmp($selectMonth, "August") == 0) echo'selected'; ?> value="August">August</option>
                                                                    <option <?php if (strcmp($selectMonth, "September") == 0) echo'selected'; ?> value="September">September</option>
                                                                    <option <?php if (strcmp($selectMonth, "October") == 0) echo'selected'; ?> value="October">October</option>
                                                                    <option <?php if (strcmp($selectMonth, "November") == 0) echo'selected'; ?> value="November">November</option>
                                                                    <option <?php if (strcmp($selectMonth, "December") == 0) echo'selected'; ?> value="December">December</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="table-responsive">

                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th><div class="checkbox checkbox-primary">
                                                        <input type="checkbox"  name="radioGroup"  id="<?php echo 'checkAll' . $classIds; ?>" onclick="checkAll('<?php echo $classIds; ?>')">
                                                        <label for="<?php echo 'checkAll' . $classIds; ?>"></label>
                                                    </div>
                                                    </th>
                                                    <th>S.NO</th>
                                                    <th>Name</th>
                                                    <th>Father Name</th>
                                                    <th>Address</th>
                                                    <th>Contact</th>
                                                    <th>Fee Amount</th>
                                                    <th>submitted Fee</th>
                                                    <th>Remaning Fee</th>
                                                    <th>Issue Date</th>
                                                    <th>Submit  Date</th>
                                                    <th>Fee  Status</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id='feeDetailTable'>

<?php
$allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $sessionId));
$sno = 1;
$totalDues = 0;
$totalFee = 0;
$totalStudentSubmit = 0;
$totalStudentNotSubmit = 0;
foreach ($allStudent as $key) {
    $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$key->student_id' AND month='$selectMonth'");
    $dues = 0;
    $countStudent = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$key->student_id' AND month='$selectMonth'");
    $status = 0;
    $feedetailsDuesStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('student_id' => $key->student_id, 'month' => $month));
    foreach ($feedetailsDuesStatus as $feeStatusKey) {
        $status = $feeStatusKey->status;
    }
    ?>
                                                        <t>
                                                            <td><div class="checkbox checkbox-primary">
                                                                    <input type="checkbox"
                                                                           name="student_check[]"
    <?php
    if ($count <= 0) {
        echo 'disabled';
    } else {
        ?>
                                                                               class="<?php echo "check" . $classIds; ?>"
                                                                               id="<?php echo "checkId" . $i; ?>"
    <?php } ?>
                                                                           value="<?php echo $key->student_id; ?>"

                                                                           >
                                                                    <label for="<?php echo 'checkId' . $i; ?>"></label>
                                                                </div>
                                                            </td> 
                                                            <td><label><?php echo $sno++; ?></label>   </td>
                                                            <td><?php echo $key->student_name; ?></td>
                                                            <td><?php echo $key->student_fname; ?></td>
                                                            <td><?php echo $key->student_address; ?></td>
                                                            <td><?php echo $key->student_mobile; ?></td>

    <?php
    if ($countStudent > 0) {
        $feedetailsDues = $db->fetch_multi_row('fee_tbl', array('fee_id', 'fee_submit_amount', 'fee_amount', 'status', 'fee_date', 'fee_sumit_date', 'fine_title', 'fine_amount'), array('student_id' => $key->student_id, 'month' => $selectMonth));
        foreach ($feedetailsDues as $feeKey) {
            ?>
                                                                    <td><?php
                                                                    echo $feeKey->fee_amount;
                                                                    if ($feeKey->fine_amount != 0) {
                                                                        echo " + <span title='" . $feeKey->fine_title . "' style='color:red;'>" . $feeKey->fine_amount . "</span>";
                                                                    }
                                                                    ?>
                                                                    </td>
                                                                        <?php
                                                                        if ($feeKey->status == 0) {
                                                                            ?>

                                                                        <td>0</td>
                                                                        <td><?php echo $feeKey->fee_amount + $feeKey->fine_amount; ?></td>
                                                                        <td><?php
                                                        echo $feeKey->fee_date;
                                                        $totalDues += $feeKey->fee_amount + $feeKey->fine_amount;
                                                        $totalStudentNotSubmit += 1;
                                                                            ?></td>
                                                                        <td>Null</td>
                                                                        <td><span class="label-default label label-warning">Pending</span></td>
                <?php
            } else if ($feeKey->status == 2) {
                $totalFee += $feeKey->fee_submit_amount;
                $totalDues += $feeKey->fee_amount + $feeKey->fine_amount - $feeKey->fee_submit_amount;
                $totalStudentNotSubmit += 1;
                ?>
                                                                        <td><?php echo $feeKey->fee_submit_amount; ?></td>
                                                                        <td><?php echo ($feeKey->fee_amount + $feeKey->fine_amount - $feeKey->fee_submit_amount); ?></td>
                                                                        <td><?php echo $feeKey->fee_date; ?></td>
                                                                        <td><?php echo $feeKey->fee_sumit_date; ?></td>
                                                                        <td><span class="label-default label label-info" onclick="updateFee(<?php echo $feeKey->fee_id; ?>)">Pending</span></td>
                <?php
            } else {
                $totalFee += $feeKey->fee_amount + $feeKey->fine_amount;
                $totalStudentSubmit += 1;
                ?>
                                                                        <td><?php echo $feeKey->fee_amount + $feeKey->fine_amount; ?></td>
                                                                        <td>0</td>
                                                                        <td><?php echo $feeKey->fee_date; ?></td>
                                                                        <td><?php echo $feeKey->fee_sumit_date; ?></td>
                                                                        <td><span class="label-default label label-success" onclick="updateFee(<?php echo $feeKey->fee_id; ?>)">PAID</span></td>
                <?php
            }
            ?>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                $i++;
                                                            } else {
                                                                ?>
                                                                <td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td><span class="label-default label label-danger">Not issued yet!</span></td>
                                                                </tr>
        <?php
    }
}
?>
                                                        <tr>
                                                            <td colspan="3">
                                                                <span style="font-weight: bold;color: red;">Not Submitted Fee: <?php echo $totalStudentNotSubmit; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                                                <span style="font-weight: bold;color: green;">Submited Fee: <?php echo $totalStudentSubmit; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            </td>
                                                            <td colspan="9" class="text-right">
                                                                <span style="font-weight: bold;color: red;">Total Dues: <?php echo $totalDues; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <span style="font-weight: bold;color: green;">Total submited Fee: <?php echo $totalFee; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <span style="font-weight: bold;color: orange;">Total: <?php echo $totalFee + $totalDues; ?></span><br><br>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                </table>

                                            </div>
                                            <br>

                                            <div class="page-nation text-right">
    <!--                                            <input type="submit" name="dues_fee_card" class="btn btn-info"
                                                       value="Print Fee Card"
                                                       >-->


                                                <br><br><br><br>

                                                <button type="submit" name="dues_fee_submit" class="btn btn-danger">Submit Fees</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> <!-- /.content -->
                <!-- Modal large -->
                <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <form  name="fo3" method="post" action="singleFeePrint.php?session=<?php echo $sessionId; ?>" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h1 class="modal-title">Fee Record</h1>
                                </div>
                                <div class="modal-body" id="singleFeeDetails">
                                    <div class="table-responsive">
                                        <h3>Fee Table: </h3>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>      
                                                    <td> <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" id="<?php echo 'checkAll' . 102; ?>" onclick="checkAll('<?php echo 102; ?>')" />
                                                            <label for="<?php echo 'checkAll' . 102; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <th>S.no</th>
                                                    <th>Month</th>
                                                    <th>Fee</th>
                                                    <th>submitted fee</th>
                                                    <th>remaining</th>
                                                    <th>Issue Date</th>
                                                    <th>submit Date</th>
                                                    <th>status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="singleFeeDetailsBody">

                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="table-responsive">
                                        <h3>Fine Table: </h3>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>      
                                                    <td> <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" id="<?php echo 'checkAll' . 103; ?>" onclick="checkAll('<?php echo 103; ?>')" />
                                                            <label for="<?php echo 'checkAll' . 103; ?>"></label>
                                                        </div>
                                                    </td>
                                                    <th>S.no</th>
                                                    <th>Fine Title</th>
                                                    <th>Fine Amount</th>
                                                    <th>status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="singleFineDetailsBody">

                                            </tbody>

                                            <tfoot>

                                                <tr>
                                                    <td colspan="5">
                                                        <button type="button"  class="btn btn-danger pull-right" onclick="deleteFine2()">Delete Fine</button>

                                                    </td>
                                                </tr>

                                            </tfoot>

                                        </table>

                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                                    <button type="button"  class="btn btn-warning pull-left" data-toggle="modal" data-target="#advanceFeeModal">Advance Fee</button>
                                    <button type="button"  class="btn btn-warning"  data-toggle="modal" data-target="#myModalHalfFee">Submit Half Fee</button>
                                    <button type="button"  class="btn btn-default" onclick="submitFee()" >Submit Fee</button>
                                    <button type="submit" name="singleFeeSubmit" class="btn btn-success">Print</button>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <!-- Half Fee Modal -->
                <div id="myModalHalfFee" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h1 class="modal-title">Custom Fee Submission</h1>
                            </div>
                            <div class="modal-body">
                                <div id="diplomaModel">
                                    <div class="form-group">
                                        <label for="user">Enter Amount you want to submit : </label>
                                        <input type="text" autofocus required="" class="form-control" placeholder="e.g: 500" id="half_fee_submit">

                                    </div>
                                </div>


                                <br><br>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="button" onclick="submitHalfFee2()" class="btn btn-success">Submit</button>
                            </div>
                        </div><!-- /.modal-content -->

                    </div>
                </div>


                <!-- Modal For Advance Fee -->
                <div class="modal fade" id="advanceFeeModal" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Advance Fee</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <div class="form-group">
                                            <label>Enter the Fee Amount:</label>
                                            <input type="text" id="advancefee" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="January" class="advancemonth"  name="advancemonth[]"  id="A1">
                                                <label for="A1">January</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="Febuary" class="advancemonth" name="advancemonth[]"  id="A2">
                                                <label for="A2">Febuary</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="March" class="advancemonth" name="advancemonth[]"  id="A3">
                                                <label for="A3">March</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="April" class="advancemonth" name="advancemonth[]"  id="A4">
                                                <label for="A4">April</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="May"  name="advancemonth[]" class="advancemonth" id="A5">
                                                <label for="A5">May</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="June"  name="advancemonth[]" class="advancemonth" id="A6">
                                                <label for="A6">June</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="July" class="advancemonth" name="advancemonth[]"  id="A7">
                                                <label for="A7">July</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="August"  name="advancemonth[]" class="advancemonth"  id="A8">
                                                <label for="A8">August</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="September"  name="advancemonth[]" class="advancemonth" id="A9">
                                                <label for="A9">September</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="October"  name="advancemonth[]" class="advancemonth" id="A10">
                                                <label for="A10">October</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="November"  name="advancemonth[]" class="advancemonth"  id="A11">
                                                <label for="A11">November</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" value="December"  name="advancemonth[]"  class="advancemonth" id="A12">
                                                <label for="A12">December</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="advanceFee('<?php echo $sessionId; ?>')" class="btn btn-success" data-dismiss="modal">Add Fee</button>
                                </div>
                            </div>

                        </div>
                    </div>


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
                $(document).ready(function () {
                    $("#tableSearch").on("keyup", function () {
                        var value = $(this).val().toLowerCase();
                        $("#currenMonthFee tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            </script>



            <script>
                $(document).ready(function () {
                    //
                    $('#issueFeeTable').on('click', 'tr', function (e) {

                        if (e.target.tagName == "INPUT" || e.target.tagName == "LABEL" || e.target.tagName == "DIV") {

                            // stop the bubbling to prevent firing the row's click event
                            e.stopPropagation();
                        } else {
                            var rowId = $(this).closest('tr').index();
                            var singleFeeId = student_id[rowId];
                            $.ajax({
                                url: 'ajaxInsertion.php',
                                data: {singleFeeId: singleFeeId},
                                type: 'POST',
                                success: function (data) {
                                    document.getElementById('singleFeeDetailsBody').innerHTML = data;

                                    $.ajax({
                                        url: 'ajaxInsertion.php',
                                        data: {singleFineId: singleFeeId},
                                        type: 'POST',
                                        success: function (data) {
                                            document.getElementById('singleFineDetailsBody').innerHTML = data;
                                            $('#modal-lg').modal('show');
                                        }
                                    });

                                }
                            });
                        }
                    });

                });

            </script>



            <script>

                function deleteFine2() {
                    var fineIds = [];
                    $.each($('input[class=check103]:checked'), function () {
                        fineIds.push($(this).val());
                    });
                    if (fineIds.length > 0) {

                        swal({
                            title: "Are you sure!",
                            text: "Are you sure to Cancel Fine?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, Cancel it!",
                            cancelButtonText: "cancel",
                            closeOnConfirm: false,
                            closeOnCancel: true},
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    url: 'ajaxInsertion.php',
                                    data: {deleteFineId: fineIds},
                                    type: 'POST',
                                    success: function (data) {
                                        if (data == 160) {
                                            swal({
                                                title: "Fine Deleted succesfully",
                                                text: "",
                                                icon: "success",
                                                type: "success",
                                                confirmButtonColor: "#009889",
                                                confirmButtonText: "OK"
                                            }, function (isConfirm) {
                                                window.location.href = window.location.href;
                                            });
                                        } else {
                                            alert("Not Delted");
                                        }

                                    }
                                });
                            }
                        });

                    }
                }

                function submitHalfFee2() {
                    var fee = $('#half_fee_submit').val();
                    var feeids = [];
                    $.each($('input[class=check102]:checked'), function () {
                        feeids.push($(this).val());
                    });
                    if (feeids.length > 0) {
                        $.ajax({
                            url: 'ajaxInsertion.php',
                            data: {feeIds: feeids, status: 2, fee: fee},
                            type: 'POST',
                            success: function (data) {
                                if (data == false) {

                                } else {
                                    swal({
                                        title: "Half Fee submitted succesfully",
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
                }

                function submitadmission(std_id, session_id) {
                    var student_id = [];
                    student_id.push(std_id);
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
                                data: {admissionStatusIds: student_id, sessionId: session_id},
                                type: 'POST',
                                success: function (data) {
                                    if (data == 13) {
                                        swal({
                                            title: "Admission Fee submitted Successfully.",
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


                function submitFee() {
                    var feeids = [];
                    var fineIds = [];
                    $.each($('input[class=check102]:checked'), function () {
                        feeids.push($(this).val());
                    });
                    $.each($('input[class=check103]:checked'), function () {
                        fineIds.push($(this).val());
                    });
                    if (feeids.length > 0 || fineIds.length > 0) {
                        $.ajax({
                            url: 'ajaxInsertion.php',
                            data: {feeIds: feeids, fineids: fineIds},
                            type: 'POST',
                            success: function (data) {
                                swal({
                                    title: "Fee submitted succesfully",
                                    text: "",
                                    icon: "success",
                                    type: "success",
                                    confirmButtonColor: "#009889",
                                    confirmButtonText: "OK"
                                }, function (isConfirm) {
                                    window.location.href = window.location.href;
                                });

                            }
                        });
                    }

                }




                function advanceFee(id) {
                    var student_id = $("#single_fee_id").val();
                    var advancefee = $("#advancefee").val();
                    var advancefeemonth = [];
                    //   alert(student_id);

                    $.each($('input[class=advancemonth]:checked'), function () {
                        advancefeemonth.push($(this).val());
                    });

                    $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {advance_fee_student_id: student_id, fee_amount: advancefee, advancemonth: advancefeemonth, session_id: id},
                        type: 'POST',
                        success: function (data) {
                            swal({
                                title: "Advance Fee added succesfully",
                                text: "",
                                icon: "success",
                                type: "success",
                                confirmButtonColor: "#009889",
                                confirmButtonText: "OK"
                            }, function (isConfirm) {
                                window.location.href = window.location.href;
                            });
                        }
                    });



                }


                function deleteFine() {
                    var deletefineIds = [];
                    var fineMonth = document.getElementById('month').value;
                    $.each($('input[class=check101]:checked'), function () {
                        deletefineIds.push($(this).val());
                    });
                    swal({
                        title: "Are you sure!",
                        text: "Are you sure to Cancel Fine?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Cancel it!",
                        cancelButtonText: "cancel",
                        closeOnConfirm: false,
                        closeOnCancel: true},
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: 'ajaxInsertion.php',
                                data: {deletefineIds: deletefineIds, fineMonth: fineMonth},
                                type: 'POST',
                                success: function (data) {
                                    if (data == 15) {
                                        swal({
                                            title: "Fine Cancled Successfully.",
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

                function updateFee(id) {

                    swal({
                        title: "Are you sure!",
                        text: "Are you sure to Cancel Fee?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Cancel it!",
                        cancelButtonText: "cancel",
                        closeOnConfirm: false,
                        closeOnCancel: true},
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: 'ajaxInsertion.php',
                                data: {cancelFeeId: id},
                                type: 'POST',
                                success: function (data) {
                                    if (data == 14) {
                                        swal({
                                            title: "Fee Cancled Successfully.",
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

                function addFine() {

                    var fineIds = [];
                    var fineMonth = document.getElementById('month').value;
                    alert(fineMonth);
                    var fineTitle = $("#fineTitle").val();
                    var fineAmount = $("#fineAmount").val();
                    $.each($('input[class=check101]:checked'), function () {
                        fineIds.push($(this).val());
                    });

                    swal({
                        title: "Are you sure!",
                        text: "Are you sure to Add Fine?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, add it!",
                        cancelButtonText: "cancel",
                        closeOnConfirm: false,
                        closeOnCancel: true},
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: 'ajaxInsertion.php',
                                data: {fineIds: fineIds, fineMonth: fineMonth, fineTitle: fineTitle, fineAmount: fineAmount},
                                type: 'POST',
                                success: function (data) {
                                    if (data == 16) {
                                        swal({
                                            title: "Fine Added Successfully.",
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


                function updateDynamicFee(feeId) {
                    $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {dynaicFeeId: feeId, feeAmount: $("#inputFeeAmount").val()},
                        type: 'POST',
                        success: function (data) {
                            window.location.href = window.location.href;


                        }
                    });
                }

                function updateTable(id) {
                    var month = $('#month').val();
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
                        $('#fee_fine' + id).prop('disabled', false);
                    } else {
                        document.getElementById('feeAmount' + id).disabled = true;
                        $('#fee_dues' + id).prop('disabled', true);
                        $('#fee_fine' + id).prop('disabled', true);
                    }

                }

                function checkAll(id) {
                    var checkbox = document.getElementById('checkAll' + id);
                    var checkBox = ".check" + id;

                    if (checkbox.checked) {

                        $(checkBox).prop('checked', true);
                        $('.feeAmountInput' + id).prop('disabled', false);
                        $('.fee_dues').prop('disabled', false);
                        $('.fee_fine').prop('disabled', false);

                    } else {
                        $(checkBox).prop('checked', false);
                        $('.feeAmountInput' + id).prop('disabled', true);
                        $('.fee_dues').prop('disabled', true);
                        $('.fee_fine').prop('disabled', true);
                    }

                }

                function closeTable(id) {
                    var panel = ".close" + id;
                    $(panel).toggle(500);

                }
				
				
				
            function updateBatch() {
                var session_id = $("#student_batch").val();
				var semesterCheckBoxName = "check100";
                var studentIds = [];
                $.each($('input[class=' + semesterCheckBoxName + ']:checked'), function () {
                   studentIds.push($(this).val());
                 });
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {studentIds: studentIds, change_session_id: session_id},
                    type: 'POST',
                    success: function (data) {
                        if (data == 101) {
                            swal({
                                    title: "Student Batch Change Successfully.",
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