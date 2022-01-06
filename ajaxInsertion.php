<?php

session_start();
include "./database/config.php";


/**
 * Insert New Batch To Session_tbl in Data Base
 */
if (isset($_POST['batchName'])) {
    $db->insert("session_tbl", $_POST['batchName']);
    echo 1;
}
/* ------------End-------------------- */

/**
 * delete Batch
 */
if (isset($_POST['batch_id']) && isset($_POST['user_name']) && isset($_POST['password'])) {
    $s = $db->check_exist('admin_tbl', array('admin_username' => $_POST['user_name'], 'admin_password' => $_POST['password']));
    if ($s == TRUE) {
        if ($db->delete('session_tbl', 'session_id', $_POST['batch_id'])) {
            
        }
        echo TRUE;
    } else {
        echo FALSE;
    }
}
/* ------------End-------------------- */

/**
 * Insert New Student To student_info and registeration_card_tbl in Data Base
 */
if (isset($_POST['studentInfo'])) {
    if (isset($_POST['updateStudentId'])) {
        $db->updateMultiWhereCondtion("student_info", $_POST['studentInfo'], array('student_id' => $_POST['updateStudentId']));
    } else {
        $studentAdmission = $_POST['studentAdmission'];
        $db->insert("student_info", $_POST['studentInfo']);
        $stdId = $db->get_last_id();
        $admission = array(
            'admission_fee' => $studentAdmission,
            'session_id' => $_POST['studentInfo']['session_id'],
            'student_id' => $stdId,
            'status' => 0
        );
        $cardInfo = array(
            'reg_card_status' => 0,
            'session_id' => $_POST['studentInfo']['session_id'],
            'student_id' => $stdId
        );

        $dmc = array(
            'session_id' => $_POST['studentInfo']['session_id'],
            'student_id' => $stdId,
            'semester_id' => $_POST['studentInfo']['semester_id'],
            'status' => 0
        );

        $db->insert("registration_card_tbl", $cardInfo);
        $db->insert("admission_tbl", $admission);
        $db->insert("dmc_tbl", $dmc);
    }




    echo 2;
}
/* ------------End-------------------- */

/**
 * Update reg_card_status in registeration_card_tbl in Data Base
 */
if (isset($_POST['cardStatusIds']) && isset($_POST['semesterId']) && isset($_POST['sessionId'])) {

    $semesterId = $_POST['semesterId'];
    $sessionId = $_POST['sessionId'];
    $cardStatusIds = $_POST['cardStatusIds'];
    foreach ($cardStatusIds as $key) {
        $db->updateMultiWhereCondtion("registration_card_tbl", array('reg_card_status' => 1, 'date' => date("d-m-Y")), array('student_id' => $key, 'session_id' => $sessionId));
    }




    echo 3;
}
/* ------------End-------------------- */

/**
 * Update reg_card_status in registeration_card_tbl in Data Base
 */
if (isset($_POST['studentIds']) && isset($_POST['semesterId']) && isset($_POST['sessionId'])) {

    $semesterId = $_POST['semesterId'];
    $sessionId = $_POST['sessionId'];
    $checkPassOut = $db->fetch_single_row('semester_tbl', 'semester_id', $semesterId);



    $studentIds = $_POST['studentIds'];
    foreach ($studentIds as $key) {
        $db->updateMultiWhereCondtion("student_info", array('semester_id' => $semesterId), array('student_id' => $key, 'session_id' => $sessionId));
        if (strcmp("Pass Out", $checkPassOut->semester_title) == 0) {
            $db->insert("diploma_tbl", array('status' => 0, 'session_id' => $sessionId, 'student_id' => $key));
        } else {
            $s = $db->check_exist('dmc_tbl', array('student_id' => $key, 'semester_id' => $semesterId));
            if ($s == FALSE) {
                $db->insert("dmc_tbl", array('status' => 0, 'semester_id' => $semesterId, 'session_id' => $sessionId, 'student_id' => $key));
            }
        }
    }

    echo 4;
}
/* ------------End-------------------- */


/**
 * Change Student Batch
 */
if (isset($_POST['studentIds']) && isset($_POST['change_session_id'])) {
    $sessionId = $_POST['change_session_id'];

    $studentIds = $_POST['studentIds'];
    foreach ($studentIds as $key) {
        $db->updateMultiWhereCondtion("student_info", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("admission_tbl", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("dmc_tbl", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("registration_card_tbl", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("fee_tbl", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("fine_tbl", array('session_id' => $sessionId), array('student_id' => $key));
        $db->updateMultiWhereCondtion("diploma_tbl", array('session_id' => $sessionId), array('student_id' => $key));
    }

    echo 101;
}
/* ------------End-------------------- */


/**
 * delete student_info
 */
if (isset($_POST['deleteStudentId'])) {
    $student_ids = $_POST['deleteStudentId'];
    $db->delete('student_info', 'student_id', $student_ids);

    echo 6;
}
/* ------------End-------------------- */


/**
 * insert into fee_tbl in Data Base
 */
//if (isset($_POST['student_ids']) && isset($_POST['session_id']) && isset($_POST['fee_amount'])) {
//    $student_ids = $_POST['student_ids'];
//    $session_id = $_POST['session_id'];
//    $fee_amount = $_POST['fee_amount'];
//    $year = date("Y");
//    $month = date("F");
//    $date = date("Y/m/d");
//
//    for ($i = 0; $i < sizeof($student_ids); $i++) {
//        $fee = $fee_amount[$i];
//        $id = $student_ids[$i];
//
//        $semester_id = $db->fetch_single_row('student_info', 'student_id', $id);
//        $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$id' AND month='$month' AND year='$year'");
//
//        if (!($count > 0)) {
//            $db->insert("fee_tbl", array('fee_amount' => $fee, 'student_id' => $id, 'session_id' => $session_id, 'year' => $year,
//                'month' => $month, 'fee_date' => $date, 'semester_id' => $semester_id->semester_id, 'status' => 0));
//        } else {
//            $db->updateMultiWhereCondtion("fee_tbl", array('fee_amount' => $fee), array('student_id' => $id, 'month' => $month, 'year' => $year));
//            $uq = "update fee_tbl set fee_amount='$fee' where student_id='$id' and month='$month' and year ='$year'";
//        }
//    }
//
//    echo 5;
//}
/* ------------End-------------------- */

/**
 *  Update Status and Date into fee_tbl in Data Base
 */
if (isset($_POST['check']) && isset($_POST['student_ids']) && isset($_POST['session_id']) && isset($_POST['fee_amount'])) {
    $student_ids = $_POST['student_ids'];
    $session_id = $_POST['session_id'];
    $duesMonth = $_POST['duesMonth'];
    $fee_amount = $_POST['fee_amount'];
    $check = $_POST['check'];
    $year = date("Y");
    $month = date("F");
    $date = date("Y/m/d");

    if ($check == false) {
        for ($i = 0; $i < sizeof($student_ids); $i++) {
            $fee = $fee_amount[$i];
            $id = $student_ids[$i];

            $semester_id = $db->fetch_single_row('student_info', 'student_id', $id);
            $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$id' AND month='$month' AND year='$year'");

            if (!($count > 0)) {
                $db->insert("fee_tbl", array('fee_amount' => $fee, 'student_id' => $id, 'session_id' => $session_id, 'year' => $year,
                    'month' => $month, 'fee_date' => $date, 'semester_id' => $semester_id->semester_id, 'status' => 0));
            } else {
                $db->updateMultiWhereCondtion("fee_tbl", array('fee_amount' => $fee), array('student_id' => $id, 'month' => $month, 'year' => $year));
                $uq = "update fee_tbl set fee_amount='$fee' where student_id='$id' and month='$month' and year ='$year'";
            }
        }
    } else {



        for ($i = 0; $i < sizeof($student_ids); $i++) {

            $fee = $fee_amount[$i];
            $id = $student_ids[$i];
            $singleStudentMonths = explode("#", $duesMonth[$i]);
            $db->updateMultiWhereCondtion("fine_tbl", array('status' => 1), array('student_id' => $id, 'session_id' => $session_id));


            for ($j = 0; $j < sizeof($singleStudentMonths); $j++) {

                $feeStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('student_id' => $id, 'month' => $singleStudentMonths[$j], 'year' => $year));
                foreach ($feeStatus as $f) {
                    if ($f->status == 0) {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 1, 'fee_sumit_date' => $date), array('student_id' => $id, 'month' => $singleStudentMonths[$j], 'year' => $year));
                    } else {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 1), array('student_id' => $id, 'month' => $singleStudentMonths[$j], 'year' => $year));
                    }
                }
            }
        }
    }

    echo 5;
}
/* ------------End-------------------- */



/**
 * select fee_tbl in Data Base
 */
if (isset($_POST['month'])) {

    $month = $_POST['month'];
    $_SESSION["selectMonth"] = $month;
    $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('session_id' => $_POST['session_id']));
    $i = 100;
    $sno = 1;
    $outPut = "";
    $totalDues = 0;
    $totalFee = 0;
    $totalStudentNotSubmit = 0;
    $totalStudentSubmit = 0;
    foreach ($allStudent as $key) {
        $status = 0;
        $feedetailsDuesStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('student_id' => $key->student_id, 'month' => $month));
        foreach ($feedetailsDuesStatus as $feeStatusKey) {
            $status = $feeStatusKey->status;
        }
        $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$key->student_id' AND month='$month'");
        $outPut = $outPut . "<tr>" . '<td><div class="checkbox checkbox-primary"><input type="checkbox" name="student_check[]"';
        if ($count <= 0) {
            $outPut.=' disabled ';
        } else {
            $outPut.=' class="check101" ';
        }
        $outPut .= 'value="' . $key->student_id . '"' .
                'onclick="enableDisableCheckBox(' . $i . ')" id="checkId' . $i . '"> <label for="checkId' . $i . '"></label></div></td> ' .
                '<td><label>' . $sno++ . '</label></td>' .
                '<td>' . $key->student_name . '</td>' .
                '<td>' . $key->student_fname . '</td>' .
                '<td>' . $key->student_address . '</td>' .
                '<td>' . $key->student_mobile . '</td>';

        if ($count > 0) {
            $feedetailsDues = $db->fetch_multi_row('fee_tbl', array('*'), array('student_id' => $key->student_id, 'month' => $month));
            foreach ($feedetailsDues as $feeKey) {
                $outPut = $outPut . '<td>' . $feeKey->fee_amount;
                if ($feeKey->fine_amount != 0) {
                    $outPut .= " + <span title='" . $feeKey->fine_title . "' style='color:red;'>" . $feeKey->fine_amount . "</span>";
                }
                $outPut .= '</td>';

                if ($feeKey->status == 0) {
                    $totalDues += $feeKey->fee_amount + $feeKey->fine_amount;
                    $totalStudentNotSubmit += 1;
                    $outPut = $outPut . "<td>0</td> <td>" . ($feeKey->fee_amount + $feeKey->fine_amount) . "</td><td>$feeKey->fee_date</td><td>Null</td>";
                    $outPut = $outPut . '<td><span class="label-default label label-warning">Pending</span></td>';
                } else if ($feeKey->status == 2) {
                    $totalFee += $feeKey->fee_submit_amount;
                    $totalDues += $feeKey->fee_amount + $feeKey->fine_amount - $feeKey->fee_submit_amount;
                    $totalStudentNotSubmit += 1;

                    $outPut .= "<td>$feeKey->fee_submit_amount</td>";
                    $outPut .= "<td>" . ($feeKey->fee_amount + $feeKey->fine_amount - $feeKey->fee_submit_amount) . "</td>";
                    $outPut .= "<td>$feeKey->fee_date</td>";
                    $outPut .= "<td>$feeKey->fee_sumit_date</td>";
                    $outPut .= '<td><span class="label-default label label-info" onclick="updateFee(' . $feeKey->fee_id . ')">Pending</span></td>';
                } else {


                    $totalStudentSubmit += 1;
                    $totalFee += $feeKey->fee_amount + $feeKey->fine_amount;

                    $outPut .= "<td>" . ($feeKey->fee_amount + $feeKey->fine_amount) . "</td>";
                    $outPut .= "<td>0</td>";
                    $outPut .= "<td>$feeKey->fee_date</td>";
                    $outPut .= "<td>$feeKey->fee_sumit_date</td>";
                    $outPut .= '<td><span class="label-default label label-success" onclick="updateFee(' . $feeKey->fee_id . ')">PAID</span></td>';
                }





                $outPut = $outPut . '</tr>';
            }
            $i++;
        } else {
            $outPut = $outPut . '<td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td><span class="label-default label label-danger">Not issued yet!</span></td></tr>';
            $i++;
        }
    }

    $outPut .= '<tr><td colspan="3">';
    $outPut .= '<span style="font-weight: bold;color: red;">Not Submitted Fee: ' . $totalStudentNotSubmit . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>' .
            '<span style="font-weight: bold;color: green;">Submited Fee: ' . $totalStudentSubmit . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';


    $outPut .= '<td  class="text-right"  colspan="7"><span style="font-weight: bold;color: red;">Total Dues: ' . ($totalDues) . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $outPut .= '<span style="font-weight: bold;color: green;">Total submited Fee: ' . $totalFee . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;color: orange;">Total: ' . ($totalFee + $totalDues) . '</span></td> </tr>';

    echo $outPut;
}
/* ------------End-------------------- */



/**
 * Select from fee_tbl dues by student_id
 */
if (isset($_POST['student_id'])) {
    $id = $_POST['student_id'];



    $fee = $db->fetch_multi_row('fee_tbl', array('fee_id', 'fee_amount', 'year', 'month', 'fee_date', 'fee_sumit_date', 'status'), array('student_id' => $_POST['student_id'], 'status' => 0));
    $data = "";
    $total = 0;
    $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$id' AND status=0");
    if ($count > 0) {
        $data .= "<input type='hidden' name='singleStudentId' value='" . $id . "'/>";
        $data .= '<table class="table table-bordered table-hover"><thead><tr><td> <div class="checkbox checkbox-primary">';
        $data .= "<input type='checkbox' id='checkAll103' onclick='checkAll(103)' /> <label for='checkAll103'></label> </div></td><td>S.no</td><td>Month</td>";
        $data .= "<td>Fee</td><td>Issue Date</td><td>submit Date</td><td>status</td></tr></thead><tbody id='singleFeeDetailsBody'>";

        $i = 500;
        $sno = 1;
        foreach ($fee as $key) {
            $data .= '<tr><td><div class="checkbox checkbox-primary"><input type="checkbox" name="singleStudentCheckIds[]" class="check103" value="' . $key->fee_id . '"' .
                    ' id="checkId' . $i . '"> <label for="checkId' . $i . '"></label></div></td> ';
            $data .= "<td>" . $sno . "</td>";
            $data .= "<td>" . $key->month . "</td><td>" . $key->fee_amount . "</td>";
            $data .= "<td>" . $key->fee_date . "</td>";
            if ($key->status == 0) {
                $data .= "<td>NULL</td><td><span class='label-default label label-danger'>Pending</span></td>";
            } else {
                $data .= "<td>" . $key->fee_sumit_date . "</td><td><span class='label-default label label-success'>PAID</span></td></tr>";
            }

            $total += $key->fee_amount;

            $i++;
            $sno++;
        }
        $data .= "</tbody></table><h4 class='text-left;'>Total Dues = $total<h4>";
    } else {
        $data = null;
    }


    echo $data;
}








/**
 * insert ref name and cnic to  diploma
 */
if (isset($_POST['refName']) && isset($_POST['CNIC']) && isset($_POST['feeId'])) {
    if (isset($_POST['dmc'])) {
        $db->updateMultiWhereCondtion("dmc_tbl", array('status' => 1, 'recived_ref_name' => $_POST['refName'], 'nic' => $_POST['CNIC'], 'issue_date' => date('d-m-Y')), array('dmc_id' => $_POST['feeId']));
        echo 9;
    } else {
        $db->updateMultiWhereCondtion("diploma_tbl", array('status' => 1, 'recived_ref_name' => $_POST['refName'], 'nic' => $_POST['CNIC'], 'issue_date' => date('d-m-Y')), array('diploma_id' => $_POST['feeId']));
        echo 7;
    }
}


/**
 * select All fee record where student_id = ? from fee table
 */
if (isset($_POST['singleFeeId'])) {
    $admissionfee = $db->fetch_multi_row('admission_tbl', array('*'), array('student_id' => $_POST['singleFeeId']));
    $fee = $db->fetch_multi_row('fee_tbl', array('fee_id', 'fee_submit_amount', 'fee_amount', 'year', 'month', 'fee_date', 'fee_sumit_date', 'status', 'fine_title', 'fine_amount'), array('student_id' => $_POST['singleFeeId']));
    $data = "<input type='hidden' id='single_fee_id' name='singleStudentId' value='" . $_POST['singleFeeId'] . "'/>";

    $sno = 1;
    $t = 0;
    $d = 0;
    foreach ($admissionfee as $admissionkey) {
        $data .= "<tr style='color:red;font-weight:bold'><td></td><td>$sno</td><td>Admission Fee</td><td>$admissionkey->admission_fee</td>";
        $data .= "<td>-</td><td></td><td></td><td>$admissionkey->submit_date</td>";
        if ($admissionkey->status == 1) {
            $data .= "<td><span class='label-default label label-success' >Submitted</span></td></tr>";
            $t += $admissionkey->admission_fee;
        } else {
            $data .= "<td><span  class='label-default label label-danger' style='cursor: pointer;' onclick='submitadmission(" . $_POST['singleFeeId'] . "," . $admissionkey->session_id . ")' >pending</span></td></tr>";
            $d += $admissionkey->admission_fee;
        }
        $sno++;
    }

    $i = 500;

    foreach ($fee as $key) {
        $data .= '<tr><td><div class="checkbox checkbox-primary"><input type="checkbox" name="singleStudentCheckIds[]"';
        if ($key->status == 1) {
            $data .= ' class="check102" ';
            $t += $key->fee_amount + $key->fine_amount;
        } else if ($key->status == 2) {
            $data .= ' class="check102" ';
            $t += $key->fine_amount + $key->fee_submit_amount;
            $d += $key->fee_amount + $key->fine_amount - $key->fee_submit_amount;
        } else {
            $data .= ' class="check102" ';
            $d += $key->fee_amount + $key->fine_amount;
        }
        $data .= 'value="' . $key->fee_id . '"' .
                'onclick="enableDisableCheckBox($i)" id="checkId' . $i . '"> <label for="checkId' . $i . '"></label></div></td> ';
        $data .= "<td>" . $sno . "</td>";
        $data .= "<td>" . $key->month . "</td><td>" . $key->fee_amount;
        if ($key->fine_amount != 0) {
            $data .= " + <span title='" . $key->fine_title . "' style='color:red'>" . $key->fine_amount;
        }
        $data .= "</td>";

        if ($key->status == 0) {
            $data .= "<td>0</td><td>" . ($key->fee_amount + $key->fine_amount) . "</td>";
        } else if ($key->status == 2) {
            $data .= "<td>$key->fee_submit_amount</td><td>" . ($key->fee_amount + $key->fine_amount - $key->fee_submit_amount) . "</td>";
        } else {
            $data .= "<td>" . ($key->fee_amount + $key->fine_amount) . "</td><td>0</td>";
        }

        $data .= "<td>" . $key->fee_date . "</td>";
        if ($key->status == 0) {
            $data .= "<td>NULL</td><td><span class='label-default label label-danger'>Pending</span></td>";
        } else if ($key->status == 2) {
            $data .= "<td>" . $key->fee_sumit_date . "</td><td><span class='label-default label label-warning' onclick='updateFee(" . $key->fee_id . ")'>pending</span></td></tr>";
        } else {
            $data .= "<td>" . $key->fee_sumit_date . "</td><td><span class='label-default label label-success' onclick='updateFee(" . $key->fee_id . ")'>PAID</span></td></tr>";
        }


        $i++;
        $sno++;
    }

    $data .= '<tr class="text-right"><td colspan="9"><span style="font-weight: bold;color: red;">Total Dues: ' . ($d) . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $data .= '<span style="font-weight: bold;color: green;">Total submited Fee: ' . $t . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;color: orange;">Total: ' . ($t + $d) . '</span></td> </tr>';


    $data .= "";

    echo $data;
}


/**
 * select All Fine record where student_id = ? from fee table
 */
if (isset($_POST['singleFineId'])) {
    $fineFee = $db->fetch_multi_row('fine_tbl', array('*'), array('student_id' => $_POST['singleFineId']));
    $data = "";

    $i = 1000;
    $sno = 1;
    $t = 0;
    $d = 0;
    foreach ($fineFee as $fineFeeKey) {

        $data .= '<tr><td><div class="checkbox checkbox-primary"><input type="checkbox" name="singleStudentFineIds[]"';
        if ($fineFeeKey->status == 1) {
            $data .= " disabled ";
            $data .= " value='" . $fineFeeKey->fine_id . "' id='checkId" . $i . "'><label for='checkId" . $i . "'></label></div></td>";
        } else {
            $data .= " class='check103' ";
            $data .= " value='" . $fineFeeKey->fine_id . "' id='checkId" . $i . "'><label for='checkId" . $i . "'></label></div></td>";
        }

        $data .= "<td>$sno</td><td>$fineFeeKey->fine_title</td><td>$fineFeeKey->fine_amount</td>";
        if ($fineFeeKey->status == 1) {
            $data .= "<td><span class='label-default label label-success' >Submitted</span></td></tr>";
            $t += $fineFeeKey->fine_amount;
        } else {
            $data .= "<td><span  class='label-default label label-danger' style='cursor: pointer;' >pending</span></td></tr>";
            $d += $fineFeeKey->fine_amount;
        }
    
        
        $data .= "</tr>";


        $sno++;
        $i++;
    }
    
           $data .= '<tr class="text-right"><td colspan="5"><span style="font-weight: bold;color: red;">Total Fine: ' . ($d) . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    $data .= '<span style="font-weight: bold;color: green;">Total submited Fine: ' . $t . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;color: orange;">Total: ' . ($t + $d) . '</span></td> </tr>';



    echo $data;
}


/**
 * Update status and date fee_tbl
 */
if (isset($_POST['feeIds']) || isset($_POST['fineids'])) {

    if (isset($_POST['fineids'])) {
        $fine_ids = $_POST['fineids'];
        for ($i = 0; $i < sizeof($fine_ids); $i++) {
            $db->updateMultiWhereCondtion("fine_tbl", array('status' => 1), array('fine_id' => $fine_ids[$i]));
        }
    }

    if (isset($_POST['feeIds'])) {

        if (isset($_POST['status'])) {
            $ids = $_POST['feeIds'];
            for ($i = 0; $i < sizeof($ids); $i++) {

                $feeStatus = $db->fetch_multi_row('fee_tbl', array('*'), array('fee_id' => $ids[$i]));
                foreach ($feeStatus as $f) {
                    if ($f->status == 0) {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 2, 'fee_submit_amount' => $_POST['fee'], 'fee_sumit_date' => date('Y/m/d')), array('fee_id' => $ids[$i]));
                        echo TRUE;
                    } else if (status == 2) {
                        if ($f->fee_submit_amount + $_POST['fee'] > $f->fee_amount) {
                            echo FALSE;
                        } else {
                            $db->updateMultiWhereCondtion("fee_tbl", array('status' => 2, 'fee_submit_amount' => $_POST['fee'] + $f->fee_submit_amount, 'fee_sumit_date' => date('Y/m/d')), array('fee_id' => $ids[$i]));
                            echo TRUE;
                        }
                    }
                }
            }
        } else {
            $ids = $_POST['feeIds'];
            for ($i = 0; $i < sizeof($ids); $i++) {

                $feeStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('fee_id' => $ids[$i]));
                foreach ($feeStatus as $f) {
                    if ($f->status == 0) {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 1, 'fee_sumit_date' => date('Y/m/d')), array('fee_id' => $ids[$i]));
                    } else if ($f->status == 2) {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 1, 'fee_sumit_date' => date('Y/m/d')), array('fee_id' => $ids[$i]));
                    } else {
                        $db->updateMultiWhereCondtion("fee_tbl", array('status' => 1), array('fee_id' => $ids[$i]));
                    }
                }
            }
            echo 8;
        }
    }
}



/**
 * Change user Name password
 */
if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['newUser']) && isset($_POST['newPass'])) {
    $db->updateMultiWhereCondtion("admin_tbl", array('admin_username' => $_POST['newUser'], 'admin_password' => $_POST['newPass']), array('admin_username' => $_POST['user'], 'admin_password' => $_POST['pass']));
    echo 11;
}

/**
 * Update dynaimic fee amount
 */
if (isset($_POST['dynaicFeeId'])) {

    $dynamicFeeSelection = $db->countRow("select * from dynamic_fee_tbl");
    if ($dynamicFeeSelection > 0) {
        $db->updateMultiWhereCondtion("dynamic_fee_tbl", array('dynamic_fee_amount' => $_POST['feeAmount']), array('dynamic_fee_id' => $_POST['dynaicFeeId']));
    } else {
        $db->insert("dynamic_fee_tbl", array('dynamic_fee_amount' => $_POST['feeAmount']));
    }
    echo 12;
}

/**
 * Update Admission fee amount
 */
if (isset($_POST['admissionFee'])) {
    $db->updateMultiWhereCondtion("admission_tbl", array('status' => '1', 'submit_date' => date('d-m-Y')), array('admission_id' => $_POST['admissionFee']));
    echo 12;
}





/**
 * Update admission status in Admission table in Data Base
 */
if (isset($_POST['admissionStatusIds']) && isset($_POST['sessionId'])) {
    $sessionId = $_POST['sessionId'];
    $admissionStatusIds = $_POST['admissionStatusIds'];
    foreach ($admissionStatusIds as $key) {
        $db->updateMultiWhereCondtion("admission_tbl", array('status' => 1, 'submit_date' => date("d-m-Y")), array('student_id' => $key, 'session_id' => $sessionId));
    }
    echo 13;
}



/**
 * Update fineTitle and  fineAmount fee_tbl
 */
if (isset($_POST['fineIds'])) {
    $month = $_POST['fineMonth'];
    $fineIds = $_POST['fineIds'];
    $fineTitle = $_POST['fineTitle'];
    $fineAmount = $_POST['fineAmount'];
    for ($i = 0; $i < sizeof($fineIds); $i++) {

        $feeStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('student_id' => $fineIds[$i], 'month' => $month));
        foreach ($feeStatus as $f) {
            if ($f->status == 0) {
                $db->updateMultiWhereCondtion("fee_tbl", array('fine_title' => $fineTitle, 'fine_amount' => $fineAmount), array('student_id' => $fineIds[$i], 'month' => $month));
            }
        }
    }
    echo 16;
}

/**
 * Cancel fee and  status = 0 fee_tbl
 */
if (isset($_POST['cancelFeeId'])) {
    $db->updateMultiWhereCondtion("fee_tbl", array('status' => 0), array('fee_id' => $_POST['cancelFeeId']));
    echo 14;
}

/**
 * delete fineTitle and  fineAmount fee_tbl
 */
if (isset($_POST['deletefineIds'])) {
    $fineIds = $_POST['deletefineIds'];
    $month = $_POST['fineMonth'];
    for ($i = 0; $i < sizeof($fineIds); $i++) {
        $feeStatus = $db->fetch_multi_row('fee_tbl', array('status'), array('student_id' => $fineIds[$i], 'month' => $month));
        foreach ($feeStatus as $f) {
            if ($f->status == 0) {
                $db->updateMultiWhereCondtion("fee_tbl", array('fine_title' => "", 'fine_amount' => 0), array('student_id' => $fineIds[$i], 'month' => $month));
            }
        }
    }
    echo 15;
}

/**
 *  select month of fee 
 */
if (isset($_POST['advance_fee_student_id']) && isset($_POST['advancemonth'])) {
    $student_id = $_POST['advance_fee_student_id'];
    $fee_amount = $_POST['fee_amount'];
    $advancemonth = $_POST['advancemonth'];
    $session_id = $_POST['session_id'];
    $year = date("Y");
    $date = date("Y/m/d");
    for ($i = 0; $i < sizeof($advancemonth); $i++) {
        $fee = $fee_amount;
        $id = $student_id;
        $month = $advancemonth[$i];

        $semester_id = $db->fetch_single_row('student_info', 'student_id', $id);
        $count = $db->countRow("SELECT COUNT(*) FROM fee_tbl where student_id = '$id' AND month='$month' AND year='$year'");

        if (!($count > 0)) {
            $db->insert("fee_tbl", array('fee_amount' => $fee, 'student_id' => $id, 'session_id' => $session_id, 'year' => $year,
                'month' => $month, 'fee_date' => $date, 'semester_id' => $semester_id->semester_id, 'status' => 0));
        } else {
            $db->updateMultiWhereCondtion("fee_tbl", array('fee_amount' => $fee), array('student_id' => $id, 'month' => $month, 'year' => $year, 'status' => 0));
            //$uq = "update fee_tbl set fee_amount='$fee' where student_id='$id' and month='$month' and year ='$year'";
        }
    }
}


/**
 * delete admission fee
 */
if (isset($_POST['deleteAdmissionFee'])) {
    $deleteAdmissionFee = $_POST['deleteAdmissionFee'];

    if ($db->delete('admission_tbl', 'admission_id', $deleteAdmissionFee)) {
        echo 100;
    } else {
        echo "Admission not Deleted";
    }
}


/**
 * Add admission fee
 */
if (isset($_POST['AddAdmissionFeeStdId'])) {
    $AddAdmissionFeeStdId = $_POST['AddAdmissionFeeStdId'];
    $session_id = $_POST['session_id'];
    $admission_fee = $_POST['admission_fee'];
    $data = array(
        'admission_fee' => $admission_fee,
        'session_id' => $session_id,
        'student_id' => $AddAdmissionFeeStdId,
        'status' => 0
    );

    if ($db->insert('admission_tbl', $data)) {
        echo 110;
    } else {
        echo "Admission Fee not Inserted Successfully  ";
    }
}



/**
 * Search Student
 */
if (isset($_POST['searchStudent'])) {
    $searchStudent = $_POST['searchStudent'];
    $searchStudent = "%" . $searchStudent . "%";

    $result = $db->custom_query("SELECT * FROM student_info WHERE student_name LIKE '$searchStudent'");
    $data = "";
    foreach ($result as $r) {
        $sr = $db->fetch_single_row("session_tbl", "session_id", $r->session_id);
        $session = $sr->session_title;
        $session_id = $sr->session_id;
        $data .= "<tr><td>$r->student_name</td><td>$r->student_fname</td><td>$session</td>";

        $data .= "<td><form action = 'allStudentInfo.php?session=" . $session_id . "' method = 'post'>"
                . "<input type = 'hidden'  name='student_search' value='" . $r->student_id . "' />"
                . "<input type = 'submit' class='btn btn-info' value='info' /></form >"
                . "</td>";

        $data .= "<td><form action = 'feeDetails.php?session=" . $session_id . "' method = 'post'>"
                . "<input type = 'hidden'  name='student_search' value='" . $r->student_id . "' />"
                . "<input type = 'submit' class='btn btn-warning' value='Fee details' /></form >"
                . "</td>";

        $data .= "<td><form action = 'admissionFee.php?session=" . $session_id . "' method = 'post'>"
                . "<input type = 'hidden'  name='student_search' value='" . $r->student_id . "' />"
                . "<input type = 'submit' class='btn btn-danger' value='Admission Fee' /></form >"
                . "</td>";


        $data .= "</tr>";
    }

    echo $data;
}

/**
 * ADD fineTitle and  fineAmount fee_tbl
 */
if (isset($_POST['AddFineTitle'])) {

    $stdfineIds = $_POST['stdfineIds'];
    $AddFineTitle = $_POST['AddFineTitle'];
    $fine_amount = $_POST['fine_amount'];
    $session_id = $_POST['session_id'];
    for ($i = 0; $i < sizeof($stdfineIds); $i++) {

        $feeStatus = $db->insert('fine_tbl', array('fine_title' => $AddFineTitle, 'fine_amount' => $fine_amount,
            'student_id' => $stdfineIds[$i], 'session_id' => $session_id, 'status' => 0));
    }
    echo 150;
}


/**
 * delete Fine fee
 */
if (isset($_POST['deleteFineId'])) {
    $deleteFineId = $_POST['deleteFineId'];
    
    for($i=0; $i<sizeof($deleteFineId); $i++){

    if ($db->delete('fine_tbl', 'fine_id', $deleteFineId[$i])) {
        echo 160;
    } else {
        echo "Fine not Deleted";
    }
    }
}




/*
 * 1    =>         Batch Insertion / session insertion
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 */
?>
