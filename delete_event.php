<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    // Xóa sự kiện khỏi cơ sở dữ liệu
    $delete_query = "DELETE FROM events WHERE event_id = $event_id";
    
    if ($conn->query($delete_query) === TRUE) {
        header("Location: quanlysukien.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    // Nếu không có ID sự kiện, chuyển hướng về trang quản lý sự kiện
    header("Location: quanlysukien.php");
    exit();
}
?>
