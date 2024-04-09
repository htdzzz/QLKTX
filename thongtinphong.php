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
</head>
<body>
    <div class="container">
        <!-- Thêm nút đăng xuất -->
        <form method="POST" action="">
            <button type="submit" name="logout" class="btn logout-button">Đăng xuất</button>
        </form>
        <h2>Thông tin phòng:</h2>
        <div class="button-container add-buttons">
            <a href="add_room.php" class="btn">Thêm phòng</a>
        </div>
        <?php if (isset($rooms_result) && $rooms_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Số phòng</th>
                    <th>Loại phòng</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $rooms_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td><?php echo $row["room_type"]; ?></td>
                        <td>
                            <a href="edit_room.php?id=<?php echo $row['ID']; ?>" class="btn">Sửa</a>
                            <a href="delete_room.php?id=<?php echo $row['ID']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có phòng</p>
        <?php endif; ?>
    </div>
</body>
</html>
