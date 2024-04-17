<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy số lượng sinh viên và số lượng sự kiện
$students_query = "SELECT COUNT(*) AS total_students FROM students";
$students_result = $conn->query($students_query);
$students_row = $students_result->fetch_assoc();
$total_students = $students_row['total_students'];

$events_query = "SELECT COUNT(*) AS total_events FROM events";
$events_result = $conn->query($events_query);
$events_row = $events_result->fetch_assoc();
$total_events = $events_row['total_events'];

// Truy vấn cơ sở dữ liệu để lấy tổng số tiền đã thanh toán, bao gồm cả tiền phòng
$total_payments_query = "SELECT SUM(p.amount + r.price) AS total_payments 
                         FROM payments p
                         LEFT JOIN students s ON p.student_id = s.student_id
                         LEFT JOIN rooms r ON s.room_id = r.room_id";
$total_payments_result = $conn->query($total_payments_query);
$total_payments_row = $total_payments_result->fetch_assoc();
$total_payments = $total_payments_row['total_payments'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo và thống kê</title>
    <link rel="stylesheet" href="css/report_style.css">
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
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <div class="header">
            <h1>Báo cáo và thống kê</h1>
        </div>
        
        <div class="report">
            <div class="data-card">
                <h2 class="data-title">Tổng số sinh viên</h2>
                <p class="data-value"><?php echo $total_students; ?></p>
            </div>
            <div class="data-card">
                <h2 class="data-title">Tổng số sự kiện</h2>
                <p class="data-value"><?php echo $total_events; ?></p>
            </div>
            <div class="data-card">
                <h2 class="data-title">Tổng số tiền đã thanh toán</h2>
                <p class="data-value"><?php echo number_format($total_payments, 0, ',', '.'); ?> đồng</p>
            </div>
        </div>

        <!-- Nút trở về -->
        <div class="button-container">
            <a href="dashboard.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
