<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy danh sách các sự kiện
$events_query = "SELECT * FROM events";
$events_result = $conn->query($events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sự kiện</title>
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
        <!-- Nút đăng xuất -->
        <a href="logout.php" class="btn logout-button">Đăng xuất</a>
        <h2>Quản lý sự kiện</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search_event.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <!-- Nút thêm sự kiện -->
        <div class="button-container add-buttons">
            <a href="add_event.php" class="btn">Thêm sự kiện</a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên sự kiện</th>
                <th>Mô tả</th>
                <th>Ngày diễn ra</th>
                <th>Chức năng</th>
            </tr>
            <?php while ($row = $events_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["event_id"]; ?></td>
                    <td><?php echo $row["event_name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["event_date"]; ?></td>
                    <td>
                        <a href="edit_event.php?id=<?php echo $row['event_id']; ?>" class="btn">Sửa</a>
                        <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" class="btn delete-button">Xoá</a>
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
