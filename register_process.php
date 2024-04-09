<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu đã nhập lại có khớp với mật khẩu ban đầu hay không
    if ($password !== $confirm_password) {
        echo "Mật khẩu không khớp. Vui lòng nhập lại mật khẩu.";
        exit(); // Dừng việc thực thi script nếu mật khẩu không khớp
    }

    // Sử dụng prepared statement để thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password); // "ss" đại diện cho kiểu dữ liệu của hai trường username và password là string
    if ($stmt->execute()) {
        echo "Đăng ký thành công!";
    } else {
        echo "Đã xảy ra lỗi: " . $stmt->error;
    }
    $stmt->close(); // Đóng prepared statement sau khi sử dụng
}
?>
