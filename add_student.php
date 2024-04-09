<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi người dùng gửi biểu mẫu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $room_id = $_POST['room_id'];

    // Thực hiện truy vấn để thêm sinh viên vào cơ sở dữ liệu
    $insert_query = "INSERT INTO students (full_name, email, phone_number, room_id) VALUES ('$full_name', '$email', '$phone_number', '$room_id')";
    if ($conn->query($insert_query) === TRUE) {
        // Nếu thêm thành công, chuyển hướng về trang dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh viên</title>
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
        <!-- Thêm nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm Sinh viên</h2>
        <!-- Biểu mẫu thêm sinh viên -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="full_name">Họ và tên:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Số điện thoại:</label>
                <input type="text" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="room_id">Số phòng:</label>
                <select id="room_id" name="room_id" required>
                    <option value="">Chọn số phòng</option>
                    <?php
                    // Truy vấn cơ sở dữ liệu để lấy thông tin các phòng
                    $rooms_query = "SELECT * FROM rooms";
                    $rooms_result = $conn->query($rooms_query);
                    if ($rooms_result->num_rows > 0) {
                        while ($row = $rooms_result->fetch_assoc()) {
                            echo "<option value='" . $row['room_id'] . "'>" . $row['room_number'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn">Thêm Sinh viên</button>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="thongtinsv.php" class="btn">Trở về</a>
            </div>
        </form>
    </div>
</body>
</html>
