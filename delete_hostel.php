<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_query = "DELETE FROM hostels WHERE ID=$id";
    
    if ($conn->query($delete_query) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Lỗi: " . $delete_query . "<br>" . $conn->error;
    }
}
?>
