<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Xử lý dữ liệu khi người dùng nhấn nút "Thêm sự kiện"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    // Chuẩn bị câu lệnh SQL để thêm sự kiện vào cơ sở dữ liệu
    $add_event_query = "INSERT INTO events (event_name, description, event_date) VALUES ('$event_name', '$description', '$event_date')";

    // Thực thi câu lệnh SQL
    if ($conn->query($add_event_query) === TRUE) {
        echo "Thêm sự kiện thành công!";
    } else {
        echo "Lỗi: " . $add_event_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sự kiện</title>
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
        <h2>Thêm sự kiện</h2>
        <!-- Form thêm sự kiện -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="add-form">
            <div class="form-group">
                <label for="event_name">Tên sự kiện:</label>
                <input type="text" id="event_name" name="event_name" required>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="event_date">Ngày diễn ra:</label>
                <input type="date" id="event_date" name="event_date" required>
            </div>
            <button type="submit" class="btn">Thêm sự kiện</button>
        </form>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="quanlysukien.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
