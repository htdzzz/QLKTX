<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Khởi tạo biến
$query = "";
$payments = [];

// Kiểm tra nếu biểu mẫu đã được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    // Lấy từ khóa tìm kiếm
    $query = $_GET['query'];

    // Chuẩn bị và thực thi truy vấn SQL để tìm kiếm các khoản thanh toán theo tên sinh viên hoặc ID dịch vụ
    $search_query = "SELECT payments.payment_id, students.full_name AS student_name, payments.service_id, payments.amount, payments.payment_date FROM payments INNER JOIN students ON payments.student_id = students.student_id WHERE students.full_name LIKE '%$query%' OR payments.service_id = '$query'";
    $search_result = $conn->query($search_query);

    // Kiểm tra nếu có kết quả
    if ($search_result->num_rows > 0) {
        // Lấy kết quả vào một mảng
        while ($row = $search_result->fetch_assoc()) {
            $payments[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm Thanh toán</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Thông tin người dùng và nút đăng xuất -->
        <div class="user-info">
            <?php 
                if (isset($_SESSION['username'])) {
                    echo "<p>Xin chào, " . $_SESSION['username'] . "</p>";
                }
            ?>
        </div>
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        
        <!-- Form tìm kiếm -->
        <h2>Tìm kiếm Thanh toán</h2>
        <form method="GET" action="search_payment.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm" value="<?php echo $query; ?>">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        
        <!-- Hiển thị kết quả tìm kiếm -->
        <h3>Kết quả tìm kiếm:</h3>
        <?php if (empty($payments)): ?>
            <p>Không tìm thấy khoản thanh toán nào.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>ID Thanh toán</th>
                    <th>Tên Sinh viên</th>
                    <th>ID Dịch vụ</th>
                    <th>Số tiền</th>
                    <th>Ngày thanh toán</th>
                </tr>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment["payment_id"]; ?></td>
                        <td><?php echo $payment["student_name"]; ?></td>
                        <td><?php echo $payment["service_id"]; ?></td>
                        <td><?php echo $payment["amount"]; ?></td>
                        <td><?php echo $payment["payment_date"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="payment_management.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
