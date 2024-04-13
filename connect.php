<?php
// Thông tin kết nối đến cơ sở dữ liệu
$servername = "localhost"; // Thay đổi thành tên máy chủ MySQL của bạn
$username = "root"; // Thay đổi thành tên người dùng MySQL của bạn
$password = ""; // Thay đổi thành mật khẩu MySQL của bạn
$database = "QLKTX1"; // Thay đổi thành tên cơ sở dữ liệu của bạn

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
