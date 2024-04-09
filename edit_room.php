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

    // Cập nhật thông tin phòng vào cơ sở dữ liệu
    $sql = "UPDATE rooms SET room_number='$room_number', capacity='$capacity', status='$status' WHERE room_id='$id'";

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
    <link rel="stylesheet" href="css/style.css">
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
