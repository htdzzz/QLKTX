<?php
session_start();
include('connect.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý khi form được gửi đi
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $room = $_POST['room']; // Update: Correct variable name

    // Kiểm tra xem phòng có tồn tại trong cơ sở dữ liệu không
    $check_room_sql = "SELECT * FROM rooms WHERE room_id = '$room'";
    $check_room_result = $conn->query($check_room_sql);
    if ($check_room_result->num_rows == 0) {
        echo "Phòng không tồn tại trong cơ sở dữ liệu!";
        exit();
    }

    // Update thông tin sinh viên vào cơ sở dữ liệu
    $sql = "UPDATE students SET full_name='$name', email='$email', phone_number='$phone', room_id='$room' WHERE student_id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Thông báo cập nhật thành công
        $_SESSION['success_message'] = "Thông tin sinh viên đã được cập nhật thành công!";
        // Redirect back to thongtinsv.php
        header("Location: thongtinsv.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy thông tin sinh viên từ cơ sở dữ liệu
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM students WHERE student_id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['full_name'];
        $email = $row['email'];
        $phone = $row['phone_number'];
        $room = $row['room_id'];
    } else {
        echo "Không tìm thấy sinh viên có ID = " . $id;
        exit();
    }
} else {
    echo "Không có ID sinh viên được cung cấp!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sinh viên</title>
    <style>
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
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chỉnh sửa thông tin sinh viên</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">Tên:</label><br>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>
            <label for="phone">Số điện thoại:</label><br>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"><br><br>
            <label for="room">ID phòng:</label><br>
            <input type="text" id="room" name="room" value="<?php echo $room; ?>"><br><br>
            <input type="submit" value="Cập nhật">
        </form>
    </div>
</body>
</html>
