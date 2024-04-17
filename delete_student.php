<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Xóa sinh viên khỏi cơ sở dữ liệu
    $sql = "DELETE FROM students WHERE student_id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Sinh viên đã được xóa thành công!";
        // Chuyển hướng người dùng đến trang thông tin sinh viên sau khi xóa thành công
        header("Location: thongtinsv.php");
        exit(); // Kết thúc script sau khi chuyển hướng
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Không có ID sinh viên được cung cấp!";
    exit();
}
?>