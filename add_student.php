<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $insert_query = "INSERT INTO students (name, email, phone) VALUES ('$name', '$email', '$phone')";
    
    if ($conn->query($insert_query) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Lỗi: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
</head>
<body>
    <h2>Thêm sinh viên</h2>
    <form action="" method="post">
        <label for="name">Tên:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Số điện thoại:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>
        <input type="submit" value="Thêm">
    </form>
</body>
</html>
