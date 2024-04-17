<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy danh sách dịch vụ và tiện ích
$services_query = "SELECT * FROM services";
$services_result = $conn->query($services_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ và Tiện ích</title>
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
        <h2>Dịch vụ và Tiện ích</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search_service.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <!-- Thêm nút Thêm dịch vụ -->
        <div class="button-container add-buttons">
            <a href="add_dichvu.php" class="btn">Thêm dịch vụ</a>
        </div>
        <!-- Hiển thị danh sách dịch vụ và tiện ích -->
        <?php if ($services_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $services_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["service_id"]; ?></td>
                        <td><?php echo $row["service_name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo ($row["status"] == 'active') ? 'Hoạt động' : 'Ngừng hoạt động'; ?></td>
                        <td>
                            <a href="edit_service.php?service_id=<?php echo $row['service_id']; ?>" class="btn">Sửa</a>
                            <a href="delete_service.php?service_id=<?php echo $row['service_id']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có dịch vụ nào.</p>
        <?php endif; ?>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="dashboard.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
