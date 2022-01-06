<?php

session_start();

include "./database/config.php";

if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
    header("Location: index.php");
} else {
    $data = array(
        'admin_username' => $_SESSION['username'],
        'admin_password' => $_SESSION['password']
    );
    $s = $db->check_exist('admin_tbl', $data);
    if ($s == false) {
        header('Location: index.php');
    }
}
?>
