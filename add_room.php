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
    $price = $_POST['price']; // Lấy giá tiền phòng từ form

    // Thêm phòng mới vào cơ sở dữ liệu
    $sql = "INSERT INTO rooms (room_number, capacity, status, price) VALUES ('$room_number', '$capacity', '$status', '$price')";
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
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url('down-arrow.png') no-repeat right #fff;
            background-size: 20px;
        }

        button[type="submit"],
        .btn {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover,
        .btn:hover {
            background-color: #45a049;
        }

        .btn.logout-button {
            background-color: #f44336;
            margin-right: 10px;
        }

        .btn.logout-button:hover {
            background-color: #d32f2f;
        }

        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm phòng mới</h2>
        <form action="" method="post">
            <label for="room_number">Số phòng:</label><br>
            <input type="text" id="room_number" name="room_number" required><br>
            <label for="capacity">Sức chứa:</label><br>
            <input type="number" id="capacity" name="capacity" required><br>
            <label for="room_price">Giá tiền phòng:</label><br>
            <input type="number" id="price" name="price" min="0" required><br><br>
            <label for="status">Trạng thái:</label><br>
            <select id="status" name="status">
                <option value="Có sẵn">Có sẵn</option>
                <option value="Đã thuê">Đã thuê</option>
                <option value="Bảo trì">Bảo trì</option>
            </select><br>
            <!-- Nút thêm -->
            <button type="submit" class="btn">Thêm phòng</button>
            <!-- Nút trở về -->
            <a href="thongtinphong.php" class="btn">Trở về</a>
        </form>
    </div>
</body>
</html>
