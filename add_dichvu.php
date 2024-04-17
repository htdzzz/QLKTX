<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi form được gửi đi (Thêm dịch vụ mới)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $sql = "INSERT INTO services (service_name, price, status) VALUES ('$service_name', '$price', '$status')";

    if ($conn->query($sql) === TRUE) {
        // Thành công
        header("Location: dichvu_tienich.php");
        exit();
    } else {
        // Lỗi
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm dịch vụ</title>
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

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
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
    </style>
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
        <h2>Thêm dịch vụ</h2>
        <!-- Form thêm dịch vụ -->
        <form action="" method="post">
            <label for="service_name">Tên Dịch vụ:</label><br>
            <input type="text" id="service_name" name="service_name" required><br>
            <label for="price">Giá:</label><br>
            <input type="number" id="price" name="price" required><br>
            <label for="status">Trạng thái:</label><br>
            <select id="status" name="status">
                <option value="active">Hoạt động</option>
                <option value="inactive">Ngừng hoạt động</option>
            </select><br><br>
            <button type="submit" class="btn">Thêm</button>
            <!-- Nút trở về -->
            <a href="dichvu_tienich.php" class="btn">Trở về</a>
        </form>
    </div>
</body>
</html>
