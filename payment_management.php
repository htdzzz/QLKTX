<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin thanh toán, tên sinh viên và tên dịch vụ
$payments_query = "SELECT payments.payment_id, students.full_name AS student_name, services.service_name, payments.amount, payments.payment_date 
                  FROM payments 
                  INNER JOIN students ON payments.student_id = students.student_id
                  INNER JOIN services ON payments.service_id = services.service_id";
$payments_result = $conn->query($payments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thanh toán</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-image: url('css/bg1.jpg');
            background-size: cover; /* Đảm bảo hình nền được phủ toàn bộ kích thước của body */
            background-position: center;
            margin: 0;
            padding: 0;
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
        <h2>Quản lý thanh toán</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search_payment.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <!-- Nút thêm sự kiện -->
        <div class="button-container add-buttons">
            <a href="add_payment.php" class="btn">Thêm thanh toán</a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên Sinh viên</th>
                <th>Tên Dịch vụ</th>
                <th>Số tiền</th>
                <th>Ngày thanh toán</th>
                <th>Chức năng</th>
            </tr>
            <?php while ($row = $payments_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["payment_id"]; ?></td>
                    <td><?php echo $row["student_name"]; ?></td>
                    <td><?php echo $row["service_name"]; ?></td>
                    <td><?php echo $row["amount"]; ?></td>
                    <td><?php echo $row["payment_date"]; ?></td>
                    <td>
                        <a href="edit_payment.php?id=<?php echo $row["payment_id"]; ?>" class="btn btn-edit">Sửa</a>
                        <a href="delete_payment.php?id=<?php echo $row["payment_id"]; ?>" class="btn btn-delete">Xoá</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="dashboard.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
