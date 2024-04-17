<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin phòng
$rooms_query = "SELECT * FROM rooms";
$rooms_result = $conn->query($rooms_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Phòng</title>
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
        <!-- Thêm nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Thông tin phòng:</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search_ttp.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <div class="button-container add-buttons">
            <a href="add_room.php" class="btn">Thêm phòng</a>
        </div>
        <?php if (isset($rooms_result) && $rooms_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Số phòng</th>
                    <th>Loại phòng (Người)</th>
                    <th>Giá Tiền Phòng</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $rooms_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["room_id"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td><?php echo $row["capacity"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td>
                            <a href="edit_room.php?id=<?php echo $row['room_id']; ?>" class="btn">Sửa</a>
                            <a href="delete_room.php?id=<?php echo $row['room_id']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="dashboard.php" class="btn">Trở về</a>
            </div>
        <?php else: ?>
            <p>Không có phòng</p>
        <?php endif; ?>
    </div>
</body>
</html>