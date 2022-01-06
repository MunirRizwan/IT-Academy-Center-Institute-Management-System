<?php
require_once './userSession.php';
$sessionId = "";
if (isset($_GET['session'])) {
    $sessionId = $_GET['session'];
} else {
    header('Location: index.php');
}

// $alldmc = $db->fetch_all('dmc_tbl');
//                            $classIds = 1;
//                            foreach ($alldmc as $dmckey) {
//                                $db->updateMultiWhereCondtion("dmc_tbl", array('semester_id'=>3), array('dmc_id' => $dmckey->dmc_id));
//                            }
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require_once './header.php'; ?>
        <style>
            .checkbox {
                margin-top: 0px;
                margin-bottom: 15px;
                margin-left: 10px;
            }
            .checkbox label {

                min-height: 0px;
                padding-left: 0px;
                cursor: pointer;
            }

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
                                <!--===========MODEL ADD STUDENT============-->
                                <div class="md-modal md-effect-4 text-left addClass" id="modal-4">
                                    <div class="md-content">
                                        <h3 style="background-color: #009889;color: white;">ADD NEW STUDENT</h3>
                                        <div class="n-modal-body" style="">
                                            <form role="form" data-toggle="validator">
                                                <div class="form-group" id="divName">
                                                    <label for="stdName">Enter Name : </label>
                                                    <input type="text" autofocus class="form-control" placeholder="e.g: ALI" id="stdName">
                                                </div>
                                                <div class="form-group" id="divFName">
                                                    <label for="stdFName">Enter Father Name : </label>
                                                    <input type="text" autofocus class="form-control" placeholder="e.g: Khan" id="stdFName">
                                                </div>
                                                <div class="form-group" id="divAddress">
                                                    <label for="stdAddress">Enter Address : </label>
                                                    <input type="text" autofocus class="form-control" placeholder="e.g: Swat" id="stdAddress">
                                                </div>
                                                <div class="form-group" id="divMobile">
                                                    <label for="stdContact">Enter Contact : </label>
                                                    <input type="number" autofocus class="form-control" placeholder="e.g: 03498498567" id="stdContact">
                                                </div>

                                                <div class="form-group" id="divAdmission">
                                                    <label for="stdAdmission">Enter Admission Fee : </label>
                                                    <input type="number" autofocus class="form-control" placeholder="e.g: 2000" id="stdAdmission">
                                                </div>

                                                <br><br>
                                                <div class="text-right">
                                                    <hr>
                                                    <input type="button" class="btn btn-success" id="addButton" style="margin-left: 5px;" onclick="addNewStudent('<?php echo $sessionId; ?>')" value="ADD"/>
                                                    <input type="button" onclick=" window.location.href = window.location.href;" class="btn btn-danger md-close" value="Close me!"/>

                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group" role="group">
                                    <button  class="btn btn-warning md-trigger m-b-5 m-r-2" id="addstudent_id" data-modal="modal-4"><i class="fa fa-plus"></i>  Add Student </button>
                                    <a  class="btn btn-info  m-b-5 m-r-2"  href='<?php echo "feeDetails.php?session=$sessionId"; ?>'><i class="fa fa-dollar"></i>  fee details </a>
                                    <a  class="btn btn-default  m-b-5 m-r-2" style="background: #4081ED; color: #fff;"  href='<?php echo "admissionFee.php?session=$sessionId"; ?>'><i class="fa fa-dollar"></i>  Admission Fee </a>
                                    <a  class="btn btn-danger  m-b-5 m-r-2"  href='<?php echo "pdf.php?session=$sessionId"; ?>'><i class="glyphicon glyphicon-floppy-save"></i>  Generate Pdf </a>

                                </div>



                            </div>

                        </div>



                    </div>

                </section>

                <!-- Main content -->

                <section class="content">
                    <div class="row">

                        <?php
                        $sessionTitle = $db->fetch_multi_row('session_tbl', array('session_title', 'session_id'), array('session_id' => $sessionId));
                        foreach ($sessionTitle as $skey) {
                            ?>
                            <h3 class="col-sm-12 text-center">Batch : <?php echo $skey->session_title; ?>
                                &nbsp;&nbsp;
                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" onclick="deleteBatch('<?php echo $skey->session_id; ?>')" title="Delete Batch"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <hr></h3><br>

                            <?php
                        }
                        ?>


                        <BR><BR>
                        <BR><BR>


                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true"> 
                            <?php
                            $allSemester = $db->fetch_all('semester_tbl');
                            $classIds = 1;
                            $checkId = 1;

                            foreach ($allSemester as $semesterkey) {
                                $semesterId = $semesterkey->semester_id;
                                $semesterTitle = $semesterkey->semester_title;

                                $count = $db->countRow("SELECT COUNT(*) FROM student_info where semester_id = '$semesterId' AND session_id='$sessionId'");

                                if ($count > 0 && strcmp($semesterTitle, "Pass Out") != 0) {
                                    ?>



                                    <div class="panel panel-bd">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $classIds; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <div ><h3>
                                                            <?php echo $semesterTitle; ?>
                                                            <span style="float: right;color: green;" class="fa fa-plus"></span>
                                                        </h3></div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $classIds; ?>" class="panel-collapse collapse <?php if ($classIds == 1) { ?> in <?php } ?>" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" id="<?php echo 'checkAll' . $classIds; ?>"
                                                                   class="styled"
                                                                   onclick="checkAll('<?php echo $classIds; ?>')" name="radioGroup"> 
                                                            <label for="<?php echo 'checkAll' . $classIds; ?>"></label>
                                                        </div>

                                                        </th>
                                                        <th>S.NO</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Address</th>
                                                        <th>Contact</th>
                                                        <th>Card Status</th>
                                                        <th>Update</th>
                                                        </tr>
                                                        </thead>

                                                        <?php
                                                        $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('semester_id' => $semesterId, 'session_id' => $sessionId));
                                                        $i = 1;
                                                        foreach ($allStudent as $key) {
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="checkbox checkbox-primary">
                                                                            <input type="checkbox"
                                                                                   <?php
                                                                                   if(isset($_POST['student_search'])){
                                                                                       if($_POST['student_search'] == $key->student_id ){
                                                                                       echo 'checked ';
                                                                                       }
                                                                                   }
                                                                                   ?>
                                                                                   id="<?php echo "checkId" . $checkId; ?>"  class="<?php echo "check" . $classIds; ?> styled" 
                                                                                   name="<?php echo "semesterCheckBox" . $semesterId; ?>"
                                                                                   value="<?php echo $key->student_id; ?>">
                                                                            <label for="<?php echo 'checkId' . $checkId; ?>"></label>
                                                                    </td> 
                                                                    <td>
                                                                        <label><?php echo $i; ?></label>   
                                                                    </td>
                                                                    <td><?php echo $key->student_name; ?></td>
                                                                    <td><?php echo $key->student_fname; ?></td>
                                                                    <td><?php echo $key->student_address; ?></td>
                                                                    <td><?php echo $key->student_mobile; ?></td>

                                                                    <?php
                                                                    $cardStatus = $db->fetch_multi_row('registration_card_tbl', array('reg_card_status', 'date'), array('student_id' => $key->student_id, 'session_id' => $sessionId));
                                                                    foreach ($cardStatus as $cardKey) {
                                                                        if ($cardKey->reg_card_status == 0) {
                                                                            ?>
                                                                            <td><span class="label-default label label-danger">Pending</span></td>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <td><span class="label-default label label-success">Issued <?php echo $cardKey->date; ?></span></td>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                    }
                                                                    ?>

                                                                    <td>
                                                                        <button class="btn btn-info btn-sm" data-toggle="tooltip"  data-placement="left" 
                                                                                onclick="updateStudent('<?php echo $key->student_id; ?>',
                                                                                                            '<?php echo $key->student_name; ?>', '<?php echo $key->student_fname; ?>',
                                                                                                            '<?php echo $key->student_address; ?>', '<?php echo $key->student_mobile; ?>', '<?php echo $key->student_id; ?>')"


                                                                                title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" onclick="deleteStudent('<?php echo $key->student_id; ?>')" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                                    </td>
                                                                </tr>


                                                            </tbody>


                                                            <?php
                                                            $i++;
                                                            $checkId++;
                                                        }
                                                        ?>
                                                    </table>
                                                </div> 
                                                <br>

                                                <div class="page-nation text-right">

                                                    <!--===========MODEL Select Semester============-->
                                                    <div class="md-modal md-effect-4 text-left" id="<?php echo "modal2-" . $semesterId; ?>">
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
                                                                    <input type="button" class="btn btn-success" style="margin-left: 5px;" onclick="updateBatch('<?php echo $semesterId ?>')" value="Change Batch"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="md-overlay"></div>
                                                    <!--===========END Select Batch============-->

                                                    <button type="button" class="btn btn-default md-trigger m-b-5 m-r-2" data-modal="<?php echo "modal2-" . $semesterId; ?>">Change Batch</button>






                                                    <button type="button" class="btn btn-info  m-b-5 m-r-2" 
                                                            onclick="updateCardStatus('<?php echo $semesterId ?>', '<?php echo $sessionId; ?>')"
                                                            >Card Issue</button>
                                                    <!--===========MODEL Select Semester============-->
                                                    <div class="md-modal md-effect-4 text-left" id="<?php echo "modal-" . $semesterId; ?>">
                                                        <div class="md-content">
                                                            <h3 style="background-color: #009889;color: white;">SELECT SEMESTER</h3>
                                                            <div class="n-modal-body" style="">
                                                                <div class="form-group">
                                                                    <label for="semesterOption">Select Semester : </label>
                                                                    <select class="form-control" id="semesterOption">
                                                                        <?php
                                                                        $allSemester2 = $db->fetch_all('semester_tbl');
                                                                        foreach ($allSemester2 as $semesterkey2) {
                                                                            ?>
                                                                            <option value="<?php echo $semesterkey2->semester_id; ?>">
                                                                                <?php echo $semesterkey2->semester_title; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <br><br>
                                                                <div class="text-right">
                                                                    <hr>
                                                                    <input type="button" class="btn btn-danger md-close" value="Close me!"/>
                                                                    <input type="button" class="btn btn-success" style="margin-left: 5px;" onclick="updatePromote('<?php echo $semesterId ?>', '<?php echo $sessionId; ?>')" value="PROMOTE"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="md-overlay"></div>
                                                    <!--===========END Select Semester============-->

                                                    <button type="button" class="btn btn-danger md-trigger m-b-5 m-r-2" data-modal="<?php echo "modal-" . $semesterId; ?>">Promote</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <?php
                                    $classIds++;
                                    ?>

                                    <!--============================DMC module===================-->


                                    <div class="panel panel-bd">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $classIds; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <div ><h3><?php echo $semesterTitle; ?> DMC Table <span style="float: right;color: green;" class="fa fa-plus"></span></h3></div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $classIds; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Name</th>
                                                                <th>Father Name</th>
                                                                <th>Address</th>
                                                                <th>Contact</th>
                                                                <th>Reference Name</th>
                                                                <th>Reference CNIC</th>
                                                                <th>DMC Status</th>
                                                            </tr>
                                                        </thead>

                                                        <?php
                                                        $dmc_student = $db->fetch_multi_row('dmc_tbl', array('dmc_id', 'status', 'issue_date', 'recived_ref_name', 'nic', 'student_id'), array('semester_id' => $semesterId, 'session_id' => $sessionId));
                                                        $i = 1;
                                                        foreach ($dmc_student as $dmcKey) {
                                                            $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('student_id' => $dmcKey->student_id, 'session_id' => $sessionId));
                                                            foreach ($allStudent as $key) {
                                                                ?>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label><?php echo $i++; ?></label>   </td>
                                                                        <td><?php echo $key->student_name; ?></td>
                                                                        <td><?php echo $key->student_fname; ?></td>
                                                                        <td><?php echo $key->student_address; ?></td>
                                                                        <td><?php echo $key->student_mobile; ?></td>

                                                                        <?php
                                                                        if ($dmcKey->status == 0) {
                                                                            ?>
                                                                            <td>NULL</td>
                                                                            <td>NULL</td>
                                                                            <td><span class="label-default label label-danger"  data-toggle="modal" data-target="#modal-DMC"
                                                                                      onclick="checkDuesDMC('<?php echo $dmcKey->dmc_id; ?>', '<?php echo $key->student_id; ?>')">Pending</span></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                            <td><?php echo $dmcKey->recived_ref_name; ?></td>
                                                                            <td><?php echo $dmcKey->nic; ?></td>
                                                                            <td><span class="label-default label label-success">Issued <?php echo $dmcKey->issue_date; ?></span></td>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                        ?>


                                                                    </tr>


                                                                </tbody>


                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>


                                    <?php
                                    $classIds++;
                                } else if ($count > 0 && strcmp($semesterTitle, "Pass Out") == 0) {
                                    ?>


                                    <div class="panel panel-bd">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $classIds; ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <div ><h3>Diploma Table <span style="float: right;color: green;" class="fa fa-plus"></span></h3></div>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse<?php echo $classIds; ?>" class="panel-collapse collapse <?php if ($classIds == 1) { ?> in <?php } ?>" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>S.NO</th>
                                                                <th>Name</th>
                                                                <th>Father Name</th>
                                                                <th>Address</th>
                                                                <th>Contact</th>
                                                                <th>Reference Name</th>
                                                                <th>Reference CNIC</th>
                                                                <th>Diploma Status</th>
                                                            </tr>
                                                        </thead>

                                                        <?php
                                                        $allStudent = $db->fetch_multi_row('student_info', array('student_id', 'student_name', 'student_fname', 'student_address', 'student_mobile'), array('semester_id' => $semesterId, 'session_id' => $sessionId));
                                                        $i = 1;
                                                        foreach ($allStudent as $key) {
                                                            ?>
                                                            <tbody>
                                                                <tr>
                                                                    <td><label><?php echo $i; ?></label>   </td>
                                                                    <td><?php echo $key->student_name; ?></td>
                                                                    <td><?php echo $key->student_fname; ?></td>
                                                                    <td><?php echo $key->student_address; ?></td>
                                                                    <td><?php echo $key->student_mobile; ?></td>

                                                                    <?php
                                                                    $DiplomaStatus = $db->fetch_multi_row('diploma_tbl', array('diploma_id', 'status', 'recived_ref_name', 'nic', 'issue_date'), array('student_id' => $key->student_id, 'session_id' => $sessionId));
                                                                    foreach ($DiplomaStatus as $diplomaKey) {

                                                                        if ($diplomaKey->status == 0) {
                                                                            ?>
                                                                            <td>NULL</td>
                                                                            <td>NULL</td>
                                                                            <td ><span class="label-default label label-danger" data-toggle="modal" data-target="#modal-lg"
                                                                                       onclick="checkDues('<?php echo $diplomaKey->diploma_id; ?>', '<?php echo $key->student_id; ?>')" >Pending</span></td>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                            <td><?php echo $diplomaKey->recived_ref_name; ?></td>
                                                                            <td><?php echo $diplomaKey->nic; ?></td>
                                                                            <td><span class="label-default label label-success">Issued <?php echo $diplomaKey->issue_date; ?></span></td>
                                                                            <?php
                                                                        }
                                                                        break;
                                                                    }
                                                                    ?>


                                                                </tr>


                                                            </tbody>


                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <!--============================End Diploma module===================->
                                    <?php
                                    $classIds++;
                                    ?>
                   
                                    <?php
                                    //$classIds++;
                                }
                                ?>
                            <?php } ?>


</div>  
                            <!--===========MODEL Diploma Semester============-->
                            <div class="modal fade" id="modal-lg" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form  name="fo3" method="post" action="singleFeePrint.php?session=<?php echo $sessionId; ?>" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h1 class="modal-title">Fee Detail</h1>
                                            </div>
                                            <div class="modal-body" id="singleFeeDetails">
                                                <div id="diplomaModel">
                                                    <div class="form-group">
                                                        <input type="hidden"   id="dmcDiplomaId">
                                                        <label for="ref">Enter Reference Name : </label>
                                                        <input type="text" autofocus class="form-control" placeholder="e.g: ALI" id="ref">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cnic">Enter CNIC : </label>
                                                        <input type="text" autofocus class="form-control" placeholder="e.g: 15606-74874343-1" id="cnic">
                                                    </div>
                                                </div>


                                                <br><br>

                                            </div>
                                            <div class="modal-footer" id="DiplomaFooter">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="submit" name="singleFeeSubmit" class="btn btn-success">Submit Fee</button>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->



                            <!--===========MODEL admin login============-->
                            <div class="modal fade" id="modal_login" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h1 class="modal-title">Enter Your admin user name and password</h1>
                                        </div>
                                        <div class="modal-body" id="singleFeeDetails">
                                            <div id="diplomaModel">
                                                <div class="form-group">
                                                    <input type="hidden"   id="batch">
                                                    <label for="user">Enter user Name : </label>
                                                    <input type="text" autofocus required="" class="form-control" placeholder="e.g: ALI" id="user">

                                                </div>
                                                <div class="form-group">
                                                    <label for="pass">Enter Password : </label>
                                                    <input type="password" autofocus required="" class="form-control" placeholder="****" id="pass">
                                                </div>
                                            </div>


                                            <br><br>

                                        </div>
                                        <div class="modal-footer" id="DiplomaFooter">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <button type="button" onclick="deleteBatch2()" class="btn btn-success">Delete</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!--===========MODEL DMC Semester============-->
                            <div class="modal fade" id="modal-DMC" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form  name="fo3" method="post" action="singleFeePrint.php?session=<?php echo $sessionId; ?>" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h1 class="modal-title">Fee Detail</h1>
                                            </div>
                                            <div class="modal-body" id="singleFeeDetails">
                                                <div id="DMCModel">
                                                </div>


                                                <br><br>

                                            </div>
                                            <div class="modal-footer" id="DMCFooter">

                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!--===========END Select Semester============-->


                        </div>
                </section> <!-- /.content -->

            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs"> <b>Version</b> 1.0</div>
                <strong>Copyright &copy; 2019 <a href="#">maxtech.edu.pk</a>.</strong> All rights reserved.
            </footer>
        </div> <!-- ./wrapper -->
        <!-- the overlay element -->


        <!=======================Update Student Modal============================!>
        <div class="modal fade" tabindex="-1" id="updateStudent" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="udivName">
                            <label for="ustdName">Enter Name : </label>
                            <input type="hidden"  class="form-control" placeholder="e.g: ALI" id="ustdId">
                            <input type="text" autofocus class="form-control" placeholder="e.g: ALI" id="ustdName">
                        </div>
                        <div class="form-group" id="udivFName">
                            <label for="ustdFName">Enter Father Name : </label>
                            <input type="text" autofocus class="form-control" placeholder="e.g: Khan" id="ustdFName">
                        </div>
                        <div class="form-group" id="udivAddress">
                            <label for="ustdAddress">Enter Address : </label>
                            <input type="text" autofocus class="form-control" placeholder="e.g: Swat" id="ustdAddress">
                        </div>
                        <div class="form-group" id="udivMobile">
                            <label for="ustdContact">Enter COntact : </label>
                            <input type="text" autofocus class="form-control" placeholder="e.g: 03498498567" id="ustdContact">
                        </div>


                        <br><br>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" class="btn btn-success" id="updateButton" style="margin-left: 5px;" onclick="updateStudent2()" value="Update"/>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!=======================END Update Student Modal============================!>
        <!-- ./wrapper -->
        <!-- Start Core Plugins-->
        <?php require_once './footerJavaScript.php'; ?>
        <!-- End Page Lavel Plugins
        =====================================================================-->
        <!-- Start Theme label Script
        =====================================================================-->



        <script>

            $(document).ready(function () {

                $('.addClass').click(function () {
                    $('#stdName').focus();
                });
            });

            function updateStudent(id, name, fname, address, mobile) {

                $("#ustdId").val(id);
                $("#ustdName").val(name);
                $("#ustdFName").val(fname);
                $("#ustdAddress").val(address);
                $("#ustdContact").val(mobile);
                $('#updateStudent').modal('show');
                $('#updateStudent').on('shown.bs.modal', function () {
                    $("#ustdName").focus();
                });


            }
//    
            function updateStudent2() {
                var id = $("#ustdId").val();
                var studentInfo = {
                    "student_name": $("#ustdName").val(),
                    "student_fname": $("#ustdFName").val(),
                    "student_address": $("#ustdAddress").val(),
                    "student_mobile": $("#ustdContact").val(),
                };
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {studentInfo: studentInfo, updateStudentId: id},
                    type: 'POST',
                    success: function (data) {
                        if (data == 2) {
                            swal({
                                title: "Student Updated Successfully.",
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



            function updateDiploma() {
                var refName = $("#ref").val();
                var CNIC = $("#cnic").val();
                var feeId = $("#dmcDiplomaId").val();
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {refName: refName, CNIC: CNIC, feeId: feeId},
                    type: 'POST',
                    success: function (data) {
                        if (data == 7) {
                            window.location.href = window.location.href;
                        }

                    }
                });
            }
            function updateDMC() {
                var refName = $("#refDMC").val();
                var CNIC = $("#cnicDMC").val();
                var feeId = $("#dmcId").val();
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {refName: refName, CNIC: CNIC, feeId: feeId, dmc: 1},
                    type: 'POST',
                    success: function (data) {
                        if (data == 9) {
                            window.location.href = window.location.href;
                        }

                    }
                });
            }

            function checkDuesDMC(id, stdId) {
                var diploma = '<div class="form-group">' +
                        '<input type="hidden" value=' + id + '   id="dmcId">' +
                        '<label for="refDMC">Enter Reference Name : </label>' +
                        '<input type="text" autofocus class="form-control" placeholder="e.g: ALI" id="refDMC">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="cnicDMC">Enter CNIC : </label>' +
                        '<input type="text" autofocus class="form-control" placeholder="e.g: 15606-74874343-1" id="cnicDMC">' +
                        '</div></div>';
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {student_id: stdId},
                    type: 'POST',
                    success: function (data) {
                        if (data) {

                            document.getElementById('DMCModel').innerHTML = data;
                            var f = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button><button type="submit" name="singleFeeSubmit" class="btn btn-success">Submit Fee</button>';
                            document.getElementById('DMCFooter').innerHTML = f;
                        }
                        else {
                            document.getElementById('DMCModel').innerHTML = diploma;
                            var f = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button><button type="button" onclick="updateDMC()" class="btn btn-success">Issue DMC</button>';
                            document.getElementById('DMCFooter').innerHTML = f;


                        }

                    }
                });
            }

            function checkDues(id, stdId) {

                var diploma = '<div class="form-group">' +
                        '<input type="hidden" value=' + id + '   id="dmcDiplomaId">' +
                        '<label for="ref">Enter Reference Name : </label>' +
                        '<input type="text" autofocus class="form-control" placeholder="e.g: ALI" id="ref">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="cnic">Enter CNIC : </label>' +
                        '<input type="text" autofocus class="form-control" placeholder="e.g: 15606-74874343-1" id="cnic">' +
                        '</div></div>';
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {student_id: stdId},
                    type: 'POST',
                    success: function (data) {
                        if (data) {

                            document.getElementById('diplomaModel').innerHTML = data;
                            var f = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button><button type="submit" name="singleFeeSubmit" class="btn btn-success">Submit Fee</button>';
                            document.getElementById('DiplomaFooter').innerHTML = f;
                        }
                        else {

                            document.getElementById('diplomaModel').innerHTML = diploma;
                            var f = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button><button type="button" onclick="updateDiploma()" class="btn btn-success">Issue Diploma</button>';
                            document.getElementById('DiplomaFooter').innerHTML = f;

                        }

                    }
                });
            }

            function updatePromote(id, session_id) {
                var semesterId = $("#semesterOption").val();
                var semesterCheckBoxName = "semesterCheckBox" + id;
                var studentIds = [];
                $.each($('input[name=' + semesterCheckBoxName + ']:checked'), function () {
                    studentIds.push($(this).val());
                });
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {studentIds: studentIds, semesterId: semesterId, sessionId: session_id},
                    type: 'POST',
                    success: function (data) {
                        if (data == 4) {
                            window.location.href = window.location.href;
                        }

                    }
                });
            }


            function updateBatch(id) {
                var session_id = $("#student_batch").val();
                var semesterCheckBoxName = "semesterCheckBox" + id;
                var studentIds = [];
                $.each($('input[name=' + semesterCheckBoxName + ']:checked'), function () {
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

            function deleteStudent(id) {

                swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this imaginary file!",
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
                            data: {deleteStudentId: id},
                            type: 'POST',
                            success: function (data) {
                                if (data == 6) {
//                                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                    window.location.href = window.location.href;
                                } else {
                                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                                }
                            }
                        });
                    }
                });
            }


            function deleteBatch(id) {

                swal({
                    title: "Are you sure to delete batch?",
                    text: "Your will not be able to recover this batch record!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "cancel",
                    closeOnConfirm: true,
                    closeOnCancel: true},
                function (isConfirm) {
                    if (isConfirm) {
                        $("#batch").val(id);
                        $('#modal_login').modal('show');

                    }
                });
            }

            function deleteBatch2() {
                var batch = $("#batch").val();
                var user = $("#user").val();
                var pass = $("#pass").val();
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {batch_id: batch, user_name: user, password: pass},
                    type: 'POST',
                    success: function (data) {
                        if (data == true) {
                            swal({
                                title: "Batch Deleted Successfully.",
                                text: "",
                                icon: "success",
                                type: "success",
                                confirmButtonColor: "#009889",
                                confirmButtonText: "OK"
                            }, function (isConfirm) {
                                window.location.href = "dashboard.php";
                            });
                        } else {
                            swal("Credential Problem", "Batch Not Deleted successfully!", "error");
                        }
                    }
                });

            }





            function updateCardStatus(cardId, sessionId) {

                var semesterCheckBoxName = "semesterCheckBox" + cardId;
                var cardStatusIds = [];
                $.each($('input[name=' + semesterCheckBoxName + ']:checked'), function () {
                    cardStatusIds.push($(this).val());
                });
                $.ajax({
                    url: 'ajaxInsertion.php',
                    data: {cardStatusIds: cardStatusIds, semesterId: cardId, sessionId: sessionId},
                    type: 'POST',
                    success: function (data) {
                        if (data == 3) {
                            window.location.href = window.location.href;
                        }

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

            function closeTable(id) {
                var panel = ".close" + id;
                $(panel).toggle(500);
            }
            function addNewStudent(id) {
                //var batchName = $("#addNewBatchInput").val();
                var std_name = $("#stdName").val();
                var std_fname = $("#stdFName").val();
                var std_address = $("#stdAddress").val();
                var std_mobile = $("#stdContact").val();
                var std_Admission = $("#stdAdmission").val();

                if (std_name == "") {
                    $("#stdName").focus();
                    $("#divName").addClass("has-error");
                }
                else if (std_fname == "") {
                    $("#stdFName").focus();
                    $("#divName").removeClass("has-error");
                    $("#divFName").addClass("has-error");
                } else if (std_address == "") {
                    $("#stdAddress").focus();
                    $("#divName").removeClass("has-error");
                    $("#divFName").removeClass("has-error");
                    $("#divAddress").addClass("has-error");
                } else if (std_mobile == "") {
                    $("#stdContact").focus();
                    $("#divName").removeClass("has-error");
                    $("#divFName").removeClass("has-error");
                    $("#divAddress").removeClass("has-error");
                    $("#divMobile").addClass("has-error");
                } else {
                    var studentInfo = {
                        "student_name": $("#stdName").val(),
                        "student_fname": $("#stdFName").val(),
                        "student_address": $("#stdAddress").val(),
                        "student_mobile": $("#stdContact").val(),
                        "semester_id": 2,
                        "session_id": id,
                    };
                    $.ajax({
                        url: 'ajaxInsertion.php',
                        data: {studentInfo: studentInfo, studentAdmission: std_Admission},
                        type: 'POST',
                        success: function (data) {
                            if (data == 2) {
                                swal({
                                    title: "Student Added Successfully.",
                                    text: "",
                                    icon: "success",
                                    type: "success",
                                    confirmButtonColor: "#009889",
                                    confirmButtonText: "OK"
                                }, function (isConfirm) {
                                    $("#stdName").val("");
                                    $("#stdFName").val("");
                                    $("#stdAddress").val("");
                                    $("#stdContact").val("");
                                    $("#stdAdmission").val("");
                                    // window.location.href = window.location.href;
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