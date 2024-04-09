<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    // Thêm phòng mới vào cơ sở dữ liệu
    $sql = "INSERT INTO rooms (room_number, capacity, status) VALUES ('$room_number', '$capacity', '$status')";

    if ($conn->query($sql) === TRUE) {
        header("Location: thongtinphong.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phòng</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm phòng</h2>
        <!-- Form thêm phòng -->
        <form action="" method="post">
            <label for="room_number">Số phòng:</label><br>
            <input type="text" id="room_number" name="room_number" required><br>
            <label for="capacity">Sức chứa:</label><br>
            <input type="number" id="capacity" name="capacity" required><br>
            <label for="status">Trạng thái:</label><br>
            <select id="status" name="status">
                <option value="Có sẵn">Có sẵn</option>
                <option value="Đã thuê">Đã thuê</option>
                <option value="Bảo trì">Bảo trì</option>
            </select><br><br>
            <button type="submit" class="btn">Thêm</button>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="thongtinphong.php" class="btn">Trở về</a>
            </div>
        </form>
    </div>
</body>
</html>