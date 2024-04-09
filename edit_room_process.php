<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];

    $sql = "UPDATE rooms SET room_number='$room_number', room_type='$room_type' WHERE ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Chỉnh sửa phòng thành công!";
    } else {
        echo "Đã xảy ra lỗi: " . $conn->error;
    }
}
?>
