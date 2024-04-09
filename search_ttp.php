<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem có dữ liệu được gửi từ form không
if (isset($_GET['query'])) {
    // Lấy từ khóa tìm kiếm từ form
    $search_query = $_GET['query'];

    // Truy vấn cơ sở dữ liệu để tìm kiếm thông tin phòng
    $search_query = $conn->real_escape_string($search_query);
    $search_query = '%' . $search_query . '%'; // Thêm dấu % cho phần tìm kiếm phù hợp
    $search_rooms_query = "SELECT * FROM rooms WHERE room_number LIKE '$search_query' OR capacity LIKE '$search_query' OR status LIKE '$search_query'";
    $search_rooms_result = $conn->query($search_rooms_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm - Thông tin Phòng</title>
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
        <!-- Thêm nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Kết quả tìm kiếm:</h2>
        <?php if (isset($search_rooms_result) && $search_rooms_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Số phòng</th>
                    <th>Loại phòng (Người)</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $search_rooms_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["room_id"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td><?php echo $row["capacity"]; ?></td>
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
                <a href="thongtinphong.php" class="btn">Trở về</a>
            </div>
        <?php else: ?>
            <p>Không có kết quả phù hợp</p>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="thongtinphong.php" class="btn">Trở về</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
