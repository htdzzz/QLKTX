<?php
session_start();
include('connect.php');

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Lấy user_id của người dùng đăng nhập
$username = $_SESSION['username'];
$user_id_query = "SELECT user_id FROM users WHERE username = '$username'";
$user_id_result = $conn->query($user_id_query);
$user_id_row = $user_id_result->fetch_assoc();
$user_id = $user_id_row['user_id'];

// Truy vấn cơ sở dữ liệu để lấy thông tin về sinh viên và phòng ở dựa trên user_id
$query = "SELECT students.student_id, students.full_name, students.email, students.phone_number, rooms.room_number, rooms.capacity, rooms.status
          FROM students
          INNER JOIN rooms ON students.room_id = rooms.room_id
          INNER JOIN users ON students.user_id = users.user_id
          WHERE students.user_id = $user_id"; // Chỉ lấy thông tin của người dùng đang đăng nhập
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng ở</title>
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
        <h2>Danh sách sinh viên và phòng ở của bạn</h2>
        <table>
            <tr>
                <th>ID Sinh viên</th>
                <th>Họ và tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Số phòng</th>
                <th>Sức chứa</th>
                <th>Tình trạng</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["student_id"]; ?></td>
                    <td><?php echo $row["full_name"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["phone_number"]; ?></td>
                    <td><?php echo $row["room_number"]; ?></td>
                    <td><?php echo $row["capacity"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <!-- Nút trở về -->
        <div class="button-container add-buttons">
            <a href="menu_user.php" class="btn">Trở về</a>
        </div>
    </div>
</body>
</html>
