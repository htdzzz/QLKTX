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
$sql = "SELECT s.full_name AS Tên_sinh_viên, u.username AS Tên_người_dùng, sr.room_number AS Số_phòng, se.service_name AS Dịch_vụ, p.amount AS Số_tiền, p.payment_date AS Ngày_thanh_toán
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
/* Style cho container */
.container {
  width: 80%;
  margin: auto;
}

/* Style cho bảng */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

/* Style cho tiêu đề cột */
th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
  padding: 10px;
}

/* Style cho dòng lẻ */
tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Style cho dòng chẵn */
tr:nth-child(odd) {
  background-color: #ffffff;
}

/* Style cho ô */
td, th {
  padding: 8px;
  border: 1px solid #ddd;
}

/* Hover over row */
tr:hover {
  background-color: #ddd;
}

/* Style cho tiêu đề */
.title {
  text-align: center;
  font-size: 24px;
  margin-bottom: 20px;
}
</style>
</head>
<body>

<div class="container">
  <h1 class="title">Thông tin thanh toán</h1>

  <?php
  if ($result->num_rows > 0) {
      // Hiển thị dữ liệu
      echo "<table><tr><th>Tên sinh viên</th><th>Tên người dùng</th><th>Số phòng</th><th>Dịch vụ</th><th>Số tiền</th><th>Ngày thanh toán</th></tr>";
      while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["Tên_sinh_viên"]."</td><td>".$row["Tên_người_dùng"]."</td><td>".$row["Số_phòng"]."</td><td>".$row["Dịch_vụ"]."</td><td>".$row["Số_tiền"]."</td><td>".$row["Ngày_thanh_toán"]."</td></tr>";
      }
      echo "</table>";
  } else {
      echo "Không có kết quả";
  }

  // Đóng kết nối
  $conn->close();
  ?>
</div>

</body>
</html>
