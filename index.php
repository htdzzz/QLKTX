<?php
// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng đến trang khác
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("location: dashboard.php");
    exit;
}

// Nếu không, chuyển hướng đến trang đăng nhập
header("location: login.php");
exit;
?>
