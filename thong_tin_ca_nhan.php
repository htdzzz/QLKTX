<?php
// Kết nối đến cơ sở dữ liệu bằng cách sử dụng tệp connect.php
include 'connect.php';

// Thực hiện truy vấn để lấy thông tin cá nhân từ cơ sở dữ liệu

// Ví dụ: Lấy thông tin cá nhân từ bảng 'students' với student_id là 1
$student_id = 1; // Đổi student_id tùy theo sinh viên cụ thể

// Thực hiện truy vấn
$query = "SELECT full_name, email, phone_number FROM students WHERE student_id = $student_id";

// Thực hiện truy vấn và lấy kết quả
$result = $conn->query($query);

// Kiểm tra xem có kết quả trả về không
if ($result->num_rows > 0) {
    // Lặp qua các hàng dữ liệu
    while ($row = $result->fetch_assoc()) {
        $full_name = $row['full_name'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
    }
} else {
    echo "Không tìm thấy thông tin cá nhân.";
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <style>
        body {
            background-image: url('css/bg1.jpg');
            background-size: cover; 
            background-position: center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        ul {
            padding: 0;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông tin cá nhân</h2>
        <ul>
            <strong>Họ và tên:</strong> <?php echo $full_name; ?><br>
            <strong>Email:</strong> <?php echo $email; ?><br>
            <strong>Số điện thoại:</strong> <?php echo $phone_number; ?>
        </ul>
    </div>
</body>
</html>


