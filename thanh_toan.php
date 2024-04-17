<?php
session_start();
include('connect.php');

// Kiểm tra xem user_id đã được lưu trong session hay chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu không, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit; // Kết thúc script để ngăn người dùng tiếp tục thực thi các lệnh bên dưới
}

// Lấy user_id từ session
$user_id = $_SESSION['user_id'];

// Truy vấn SQL để lấy thông tin thanh toán cho người dùng có user_id là $user_id
$sql = "SELECT s.full_name AS Tên_sinh_viên, u.username AS Tên_người_dùng, sr.room_number AS Số_phòng, se.service_name AS Dịch_vụ, 
               sr.price AS Giá_tiền_phòng, se.price AS Giá_tiền_dịch_vụ, p.amount AS Số_tiền, p.payment_date AS Ngày_thanh_toán
        FROM payments p
        INNER JOIN students s ON p.student_id = s.student_id
        INNER JOIN users u ON s.user_id = u.user_id
        LEFT JOIN services se ON p.service_id = se.service_id
        LEFT JOIN rooms sr ON s.room_id = sr.room_id
        WHERE s.user_id = $user_id";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thông tin thanh toán</title>
<style>
/* Global Styles */
body {
    background-image: url('css/bg1.jpg');
    background-size: cover;
    background-position: center;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    display: flex;
 
    height: 100vh;
}

.container {
    width: 80%;
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
    padding: 300px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Hover Effect */
tr:hover {
    background-color: #ddd;
}

/* Title Styles */
.title {
    text-align: center;
    font-size: 28px;
    margin-bottom: 20px;
    color: #333;
}
</style>
</head>
<body>

<div class="container">
    <h1 class="title">Thông tin thanh toán</h1>

    <?php
    if ($result->num_rows > 0) {
        // Display data
        echo "<table><tr><th>Tên sinh viên</th><th>Tên người dùng</th><th>Số phòng</th><th>Dịch vụ</th>
                  <th>Giá tiền phòng</th><th>Giá tiền dịch vụ</th><th>Số tiền</th><th>Ngày thanh toán</th></tr>";
        while($row = $result->fetch_assoc()) {
            $total_price = $row["Giá_tiền_phòng"] + $row["Giá_tiền_dịch_vụ"]; // Tính tổng giá tiền
            echo "<tr><td>".$row["Tên_sinh_viên"]."</td><td>".$row["Tên_người_dùng"]."</td><td>".$row["Số_phòng"]."</td><td>".$row["Dịch_vụ"]."</td>
                      <td>".$row["Giá_tiền_phòng"]."</td><td>".$row["Giá_tiền_dịch_vụ"]."</td><td>".$row["Số_tiền"]."</td><td>".$row["Ngày_thanh_toán"]."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Không có kết quả";
    }

    // Close connection
    $conn->close();
    ?>
</div>

</body>
</html>
