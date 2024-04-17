<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $room_number = $_POST['room_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    // Cập nhật thông tin phòng vào cơ sở dữ liệu
    $sql = "UPDATE rooms SET room_number='$room_number', capacity='$capacity', status='$status', price='$price' WHERE room_id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Thông tin phòng đã được cập nhật thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy thông tin phòng từ cơ sở dữ liệu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM rooms WHERE room_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $room_number = $row['room_number'];
        $capacity = $row['capacity'];
        $status = $row['status'];
        $price = $row['price']; // Lấy giá phòng từ cơ sở dữ liệu
    } else {
        echo "Không tìm thấy phòng có ID = " . $id;
        exit();
    }
} else {
    echo "Không có ID phòng được cung cấp!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin phòng</title>
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
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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

        /* Adjustments for form elements */
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Chỉnh sửa thông tin phòng</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="room_number">Số phòng:</label><br>
            <input type="text" id="room_number" name="room_number" value="<?php echo $room_number; ?>"><br>
            <label for="capacity">Sức chứa:</label><br>
            <input type="number" id="capacity" name="capacity" value="<?php echo $capacity; ?>"><br>
            <label for="price">Giá phòng:</label><br>
            <input type="text" id="price" name="price" value="<?php echo $price; ?>"><br> <!-- Hiển thị giá phòng -->
            <label for="status">Trạng thái:</label><br>
            <select id="status" name="status">
                <option value="Có sẵn" <?php if ($status === 'Có sẵn') echo 'selected'; ?>>Có sẵn</option>
                <option value="Đã thuê" <?php if ($status === 'Đã thuê') echo 'selected'; ?>>Đã thuê</option>
                <option value="Bảo trì" <?php if ($status === 'Bảo trì') echo 'selected'; ?>>Bảo trì</option>
            </select><br><br>
            <!-- Nút cập nhật -->
            <button type="submit" class="btn">Cập nhật</button>
            <!-- Nút trở về -->
            <a href="thongtinphong.php" class="btn">Trở về</a>
        </form>
    </div>
</body>
</html>
