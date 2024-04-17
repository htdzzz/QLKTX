<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra nếu không có ID được truyền vào
if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
    header("Location: payment_management.php");
    exit();
}

// Lấy ID của thanh toán từ URL
$payment_id = $_GET["id"];

// Xóa dữ liệu từ cơ sở dữ liệu
$delete_payment_query = "DELETE FROM payments WHERE payment_id='$payment_id'";
if ($conn->query($delete_payment_query) === TRUE) {
    header("Location: payment_management.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
