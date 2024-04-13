<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    // Truy vấn cơ sở dữ liệu để lấy thông tin sự kiện
    $event_query = "SELECT * FROM events WHERE event_id = $event_id";
    $event_result = $conn->query($event_query);
    $event = $event_result->fetch_assoc();
} else {
    // Nếu không có ID sự kiện, chuyển hướng về trang quản lý sự kiện
    header("Location: quanlysukien.php");
    exit();
}

// Xử lý cập nhật thông tin sự kiện
if (isset($_POST['update'])) {
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    
    $update_query = "UPDATE events SET event_name = '$event_name', description = '$description', event_date = '$event_date' WHERE event_id = $event_id";
    
    if ($conn->query($update_query) === TRUE) {
        header("Location: quanlysukien.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sự kiện</title>
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
        <h2>Sửa sự kiện</h2>
        <form method="POST" action="">
            <label for="event_name">Tên sự kiện:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>"><br><br>
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description"><?php echo $event['description']; ?></textarea><br><br>
            <label for="event_date">Ngày diễn ra:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>"><br><br>
            <button type="submit" class="btn" name="update">Cập nhật</button>
        </form>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="quanlysukien.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
