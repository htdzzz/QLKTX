<?php
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        // Đăng nhập thất bại
        echo "Tên người dùng hoặc mật khẩu không đúng.";
    }
}
?>
