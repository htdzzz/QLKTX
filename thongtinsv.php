<?php
session_start();
include('connect.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Truy vấn cơ sở dữ liệu để lấy thông tin sinh viên
$students_query = "SELECT students.student_id, students.full_name, students.email, students.phone_number, IFNULL(rooms.room_number, 'NULL') AS room_number FROM students LEFT JOIN rooms ON students.room_id = rooms.room_id";
$students_result = $conn->query($students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sinh viên</title>
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
        <h2>Thông tin sinh viên:</h2>
        <!-- Thanh tìm kiếm -->
        <form method="GET" action="search_ttsv.php" class="search-form">
            <input type="text" name="query" placeholder="Nhập từ khóa tìm kiếm">
            <button type="submit" class="btn">Tìm kiếm</button>
        </form>
        <div class="button-container add-buttons">
            <a href="add_student.php" class="btn">Thêm sinh viên</a>
        </div>
        <?php if (isset($students_result) && $students_result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Số phòng</th>
                    <th>Chức năng</th>
                </tr>
                <?php while ($row = $students_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["student_id"]; ?></td>
                        <td><?php echo $row["full_name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["phone_number"]; ?></td>
                        <td><?php echo $row["room_number"]; ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['student_id']; ?>" class="btn">Sửa</a>
                            <a href="delete_student.php?id=<?php echo $row['student_id']; ?>" class="btn" onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <div class="button-container add-buttons">
                <!-- Nút trở về -->
                <a href="dashboard.php" class="btn">Trở về</a>
            </div>
        <?php else: ?>
            <p>Không có sinh viên</p>
        <?php endif; ?>
    </div>
</body>
</html>
