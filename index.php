<?php
session_start();
include "./database/config.php";
include  './importmysql.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <title>Max Tech Computer Institute</title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="images/max tech computer logo png.png" type="image/x-icon">

        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/dist/css/login.css" rel="stylesheet" type="text/css"/>
        <!--===============================================================================================-->
    </head>
    <body>

        <div class="container-login100" style="background-image: url('images/img-01.jpg');">
            <div class="wrap-login100">
                <div class="login100-form-avatar">
                    <img src="images/1.jpg" alt="AVATAR">
                </div>

                <span class="login100-form-title">
                    Junaid Munair
                </span>
                <?php
                if (isset($_POST['username']) && isset($_POST['pass'])) {
                    $username = $_POST['username'];
                    $pass = $_POST['pass'];
                    if (empty($username) || empty($pass)) {
                        ?>
                        <div class="error">
                            username / password may not be empty        
                        </div>
                        <?php
                    } else {
                        $data = array(
                            'admin_username' => $username,
                            'admin_password' => $pass
                        );
                        $s = $db->check_exist('admin_tbl', $data);
                        if ($s == true) {
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $pass;
                            header('Location: dashBoard.php');
                        } else {
                            ?>
                            <div class="error">
                                username / password is incorrect         
                            </div>
                            <?php
                        }
                    }

                    /* insert code for database connexion here */



                    /* The query itself */
                }
                ?>
                <form class="login100-form validate-form" method="POST">


                    <div class="wrap-input100 validate-input" data-validate = "Username is required">
                        <input class="input100" type="text" name="username" placeholder="Username">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                        <input class="input100" type="password" name="pass" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>











                </form>
            </div>
        </div>




        <!--===============================================================================================-->
        <script src="assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/login.js"></script>
        <!--===============================================================================================-->


    </body>
</html>