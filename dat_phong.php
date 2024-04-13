<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $user_id = $_SESSION['user_id']; // Lấy user_id của người dùng đang đăng nhập
    $room_id = $_POST['room_id'];

    // Kiểm tra xem phòng đã được đặt hay chưa
    $check_query = "SELECT * FROM students WHERE room_id = $room_id";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        echo "Phòng đã được đặt.";
    } else {
        // Thêm thông tin vào bảng students
        $insert_query = "INSERT INTO students (user_id, room_id) VALUES ('$user_id', '$room_id')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Đặt phòng thành công.";
        } else {
            echo "Lỗi: " . $conn->error;
        }
    }
}

// Truy vấn cơ sở dữ liệu để lấy thông tin về phòng ở
$rooms_query = "SELECT * FROM rooms WHERE status = 'Có sẵn'";
$rooms_result = $conn->query($rooms_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng ở</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-container {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #0056b3;
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
        <h2>Đặt phòng ở</h2>
        <div class="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="room">Chọn phòng:</label>
                    <select name="room_id" id="room">
                        <?php while ($row = $rooms_result->fetch_assoc()): ?>
                            <option value="<?php echo $row["room_id"]; ?>"><?php echo $row["room_number"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Đặt phòng</button>
                </div>
            </form>
        </div>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="menu_user.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
