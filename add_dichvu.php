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
