<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    // Trước hết, xóa tất cả sinh viên trong phòng
    $delete_students_sql = "DELETE FROM students WHERE room_id = '$room_id'";
    if ($conn->query($delete_students_sql) === TRUE) {
        // Tiếp theo, sau khi đã xóa tất cả sinh viên trong phòng, bạn có thể xóa phòng
        $delete_room_sql = "DELETE FROM rooms WHERE room_id = '$room_id'";
        if ($conn->query($delete_room_sql) === TRUE) {
            $_SESSION['success_message'] = "Phòng đã được xóa thành công!";
            header("Location: thongtinphong.php");
            exit();
        } else {
            echo "Lỗi khi xóa phòng: " . $conn->error;
        }
    } else {
        echo "Lỗi khi xóa sinh viên: " . $conn->error;
    }
} else {
    echo "Không có ID phòng được cung cấp!";
    exit();
}
?>