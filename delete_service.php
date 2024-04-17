<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý xóa dịch vụ
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    $sql = "DELETE FROM services WHERE service_id='$service_id'";
    if ($conn->query($sql) === TRUE) {
        // Thành công
        header("Location: dichvu_tienich.php");
        exit();
    } else {
        // Lỗi
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Yêu cầu không hợp lệ.";
    exit();
}
?>
