            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="image pull-left">
                            <img src="images/1.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <h4>Welcome</h4>
                            <p>Mr. Junaid Munair</p>
                        </div>
                    </div>

                    <!-- sidebar menu -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="dashBoard.php"><i class="fa fa-hospital-o"></i><span>Dashboard</span>
                            </a>
                        </li>

                        <?php
                        $AllBatch =$db->fetch_all_order('session_tbl','session_id');
                        foreach ($AllBatch as $key) {
                            $id = $key->session_id;
                            ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-user"></i><span><?php echo $key->session_title; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href='<?php echo "allStudentInfo.php?session=$id"; ?>'>All Student Info</a></li>
                                    <li><a href="<?php echo "feeDetails.php?session=$id"; ?>">Fee Details</a></li>
                                    <li><a href="<?php echo "admissionFee.php?session=$id"; ?>">Admission Fee</a></li>

                                </ul>
                            </li>

                            <?php
                        }
                        ?>

                    </ul>
                </div> <!-- /.sidebar -->
            </aside>
            <!-- =============================================== -->
