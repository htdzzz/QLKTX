<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['query'])) {
    $search_query = $_GET['query'];
    $events_query = "SELECT * FROM events WHERE event_name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR event_date LIKE '%$search_query%'";
    $events_result = $conn->query($events_query);
} else {
    // Nếu không có từ khóa tìm kiếm, chuyển hướng về trang quản lý sự kiện
    header("Location: quanlysukien.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm sự kiện</title>
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
        <h2>Kết quả tìm kiếm sự kiện</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên sự kiện</th>
                <th>Mô tả</th>
                <th>Ngày diễn ra</th>
            </tr>
            <?php while ($row = $events_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["event_id"]; ?></td>
                    <td><?php echo $row["event_name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["event_date"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="quanlysukien.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
