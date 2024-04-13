<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra vai trò của người dùng
if ($_SESSION['role'] !== 'admin') {
    header("Location: unauthorized.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin sinh viên (nếu cần)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Quản Lý Ký Túc Xá</title>
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
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h1>Dashboard - Quản Lý Ký Túc Xá</h1>
        <div class="banner">
            <img src="images/banner.png" alt="Banner" width="1100" height="300">
        </div>
        <div class="button-container-infor">
            <!-- Nút chuyển qua trang thông tin sinh viên -->
            <div class="button-infor">
                <a href="thongtinsv.php" class="btn">
                    <img src="images/man.jpg" alt="Thông tin sinh viên" width="50" height="50">
                    <span>Thông tin sinh viên</span>
                </a>
            </div>
            <!-- Nút chuyển qua trang thông tin phòng -->
            <div class="button-infor">
                <a href="thongtinphong.php" class="btn">
                    <img src="images/man.jpg" alt="Thông tin phòng" width="50" height="50">
                    <span>Thông tin phòng</span>
                </a>
            </div>
            <!-- Nút chuyển qua trang Quản lý Dịch vụ Tiện ích -->
            <div class="button-infor">
                <a href="dichvu_tienich.php" class="btn">
                    <img src="images/man.jpg" alt="Quản lý Dịch vụ Tiện ích" width="50" height="50">
                    <span>Quản lý Dịch vụ Tiện ích</span>
                </a>
            </div>
            <!-- Nút chuyển qua trang Quản lý Thanh toán -->
            <div class="button-infor">
                <a href="payment_management.php" class="btn">
                    <img src="images/man.jpg" alt="Quản lý Thanh toán" width="50" height="50">
                    <span>Quản lý Thanh toán</span>
                </a>
            </div>
            <!-- Nút chuyển qua trang Quản lý Sự kiện và Hoạt động -->
            <div class="button-infor">
                <a href="quanlysukien.php" class="btn">
                    <img src="images/man.jpg" alt="Quản lý Sự kiện và Hoạt động" width="50" height="50">
                    <span>Quản lý Sự kiện và Hoạt động</span>
                </a>
            </div>
            <!-- Nút chuyển qua trang Báo cáo và Thống kê -->
            <div class="button-infor">
                <a href="baocao_thongke.php" class="btn">
                    <img src="images/man.jpg" alt="Báo cáo và Thống kê" width="50" height="50">
                    <span>Báo cáo và Thống kê</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="info">
            <h2>Thông tin liên hệ</h2>
            <p>Địa chỉ: VQ4P+249, Phường Tân Phú, Quận 9, Thành phố Hồ Chí Minh</p>
            <p>Email: example@example.com</p>
            <p>Điện thoại: 0123 456 789</p>
        </div>
    </footer>
</body>
</html>
