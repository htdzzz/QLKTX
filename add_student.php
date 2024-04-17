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
        input[type="email"],
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
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thêm Sinh viên</h2>
        <!-- Biểu mẫu thêm sinh viên -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="add-form">
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
