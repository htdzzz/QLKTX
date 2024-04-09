<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin ký túc xá
$hostels_query = "SELECT * FROM hostels";
$hostels_result = $conn->query($hostels_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Ký túc xá</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <!-- Thêm nút đăng xuất -->
        <form method="POST" action="">
            <button type="submit" name="logout" class="btn logout-button">Đăng xuất</button>
        </form>
        <h2>Thông tin ký túc xá:</h2>
        <div class="button-container add-buttons">
            <a href="add_hostel.php" class="btn">Thêm ký túc xá</a>
        </div>
        <?php if (isset($hostels_result) && $hostels_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Địa chỉ</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $hostels_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["ID"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>
                        <td>
                            <a href="edit_hostel.php?id=<?php echo $row['ID']; ?>" class="btn">Sửa</a>
                            <a href="delete_hostel.php?id=<?php echo $row['ID']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa ký túc xá này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Không có ký túc xá</p>
        <?php endif; ?>
    </div>
</body>
</html>
